<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class NavigationApiController extends AbsApiController
{
    public function get()
    {
        $roleID = Session::get('role_id');

        $return = [];
        if ($roleID === 1) {
            $adminID = Session::get('user_id');
            $allClients = $this->getAllClients($adminID, $roleID);
            $totalClients = isset($allClients['user_id']) ? 1 : count($allClients);

            $return['clients'] = [
                'clients_list' => $allClients,
                'total_clients' => $totalClients
            ];
        }

        $unreadNotifications = $this->getUnreadNotifications($this->getId(), $roleID);
        $totalUnread = isset($unreadNotifications['notification_id']) ? 1 : count($unreadNotifications);

        $return['notifications'] = [
            'notifications_list' => $unreadNotifications,
            'total_unread' => $totalUnread
        ];

        return ApiMessage::dataFetchAttempt($return);
    }

    public function put()
    {
        $data = $this->getData();
        $action = $data['action'];
        $userID = $this->getId();

        // Reverting view_as_user_id.
        if ($action === 'revert/client') {
            $roleID = Session::get('role_id');

            // Guard clause: request error.
            if (isset($this->updateViewAsUserData($userID, $userID, $roleID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // Save user-related log.
            Log::saveUserLog($userID, 'client');

            return ApiMessage::alertDataAlterAttempt(true, '/dashboard');
        }

        // Updating view_as_user_id column.
        if ($action === 'update/client') {
            $clientID = $data['client_id'];
            $clientRoleID = $this->getClientRoleID($clientID);

            // Guard clause: request error.
            if (isset($this->updateViewAsUserData($userID, $clientID, $clientRoleID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // Save user-related log.
            Log::saveUserLog($userID, 'client');

            return ApiMessage::alertDataAlterAttempt(true, '/dashboard');
        }

        // Marking all notifications as read.
        if ($action === 'mark/all') {
            $roleID = Session::get('role_id');

            // Guard clause: request error.
            if (isset($this->markAllAsRead($data, $userID, $roleID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true);
        }

        // Marking one notification as read.
        if ($action === 'mark/one') {
            $notificationID = $this->getId();
            $isRead = $data['is_read'];

            // Guard clause: request error.
            if (isset($this->markNotificationAsRead($notificationID, $isRead)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true);
        }
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getAllClients(int $userID, int $roleID)
    {
        $query = 'SELECT * FROM users WHERE user_id != :user_id OR role_id != :role_id ORDER BY role_id ASC, username ASC;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':role_id' => $roleID]
        )->getQueryResult();
    }

    private function getClientRoleID(int $clientID)
    {
        $query = 'SELECT role_id FROM users WHERE user_id = :user_id';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $clientID]
        )->getQueryResult()['role_id'];
    }

    private function updateViewAsUserData(int $userID, int $viewAsUserID, int $viewAsRoleID)
    {
        $query = '
            UPDATE users SET 
            view_as_user_id = :view_as_user_id, 
            view_as_role_id = :view_as_role_id 
            WHERE user_id = :user_id;
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':view_as_user_id' => $viewAsUserID, ':view_as_role_id' => $viewAsRoleID, ':user_id' => $userID
        ])->getQueryResult();
    }

    private function getUnreadNotifications(int $userID, int $roleID)
    {
        if (Session::get('user_id') === $userID && $roleID === 1) {
            $query = 'SELECT * FROM notifications WHERE is_read = :is_read;';
            return Session::getDbInstance()->executeQuery(
                $query, [':is_read' => 0]
            )->getQueryResult();
        }

        $query = 'SELECT * FROM notifications WHERE user_id = :user_id AND is_read = :is_read;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':is_read' => 0]
        )->getQueryResult();
    }

    private function markAllAsRead(array $data, int $userID, int $roleID)
    {
        if (Session::get('user_id') === $userID && $roleID === 1) {
            $query = 'UPDATE notifications SET is_read = :is_read;';
            return Session::getDbInstance()->executeQuery(
                $query, [':is_read' => $data['is_read']]
            )->getQueryResult();
        }

        $query = 'UPDATE notifications SET is_read = :is_read WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':is_read' => $data['is_read'], ':user_id' => $userID]
        )->getQueryResult();
    }

    private function markNotificationAsRead(int $notificationID, int $isRead)
    {
        $query = 'UPDATE notifications SET is_read = :is_read WHERE notification_id = :notification_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':is_read' => $isRead, ':notification_id' => $notificationID
        ])->getQueryResult();
    }
}
