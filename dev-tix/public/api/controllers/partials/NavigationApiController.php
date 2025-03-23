<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class NavigationApiController extends AbsApiController
{
    public function get()
    {
        $roleID = Session::get('role_id');

        $return = [];
        if ($roleID === 1) {
            $allClients = $this->getAllClients(Session::get('user_id'), $roleID);

            $return['clients'] = [
                'clients_list' => $allClients,
                'total_clients' => isset($allClients['user_id']) ? 1 : count($allClients)
            ];
        }

        $unreadNotifications = $this->getUnreadNotifications($this->getId(), $roleID);

        $return['notifications'] = [
            'notifications_list' => $unreadNotifications,
            'total_unread' => isset($unreadNotifications['notification_id']) ? 1 : count($unreadNotifications)
        ];

        return ApiMessage::dataFetchAttempt($return);
    }

    public function put()
    {
        $data = $this->getData();
        $action = $data['action'];
        $userID = $this->getId();

        // Updating view_as_user_id column.
        if ($action === 'update/client') {
            // Guard clause: request error.
            if (isset($this->updateViewAsUserId($userID, $data['client_id'])['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true, '/dashboard');
        }

        // Marking notifications as read.
        if ($action === 'mark/notification') {
            $roleID = Session::get('role_id');

            // Guard clause: request error.
            if (isset($this->markNotificationsAsRead($data, $userID, $roleID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true);
        }
    }

    private function getAllClients(int $userID, int $roleID)
    {
        $query = 'SELECT * FROM users WHERE user_id != :user_id OR role_id != :role_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':role_id' => $roleID]
        )->getQueryResult();
    }

    private function updateViewAsUserId(int $userID, int $viewAsUserID)
    {
        $query = 'UPDATE users SET view_as_user_id = :view_as_user_id WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':view_as_user_id' => $viewAsUserID, ':user_id' => $userID]
        )->getQueryResult();
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

    private function markNotificationsAsRead(array $data, int $userID, int $roleID)
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
}
