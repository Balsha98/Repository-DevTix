<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class NavigationApiController extends AbsApiController
{
    public function get()
    {
        $userID = Session::get('user_id');
        $roleID = Session::get('role_id');

        $return = [];
        if ($roleID === 1) {
            $allClients = $this->getAllClients($userID, $roleID);

            $return['clients'] = [
                'clients_list' => $allClients,
                'total_clients' => count($allClients)
            ];
        }

        $unreadNotifications = $this->getUnreadNotifications($userID, $roleID);

        $return['notifications'] = [
            'notifications_list' => $unreadNotifications,
            'total_unread' => count($unreadNotifications)
        ];

        return ApiMessage::dataFetchAttempt($return);
    }

    public function put()
    {
        $data = $this->getData();
        $authToken = $data['csrf_token'];

        // Guard clause: verify token.
        if ($authToken !== Session::get('csrf_token') ||
                ((time() - Session::get('csrf_token_set_at')) / 60) > 5) {
            return ApiMessage::apiError('token');
        }

        $userID = $this->getId();

        // Guard clause: view as client.
        if (isset($data['client_id'])) {
            // TODO: Change db value.
            Session::set('view_as_user_id', $data['client_id']);
            return ApiMessage::alertDataAlterAttempt(true, '/dashboard');
        }

        $roleID = Session::get('role_id');

        // Guard clause: request error.
        if (isset($this->markNotificationsAsRead($data, $userID, $roleID)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    private function getAllClients(int $userID, int $roleID)
    {
        $query = 'SELECT * FROM users WHERE user_id != :user_id OR role_id != :role_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':role_id' => $roleID]
        )->getQueryResult();
    }

    private function getUnreadNotifications(int $userID, int $roleID)
    {
        if ($roleID === 1) {
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
        if ($roleID === 1) {
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
