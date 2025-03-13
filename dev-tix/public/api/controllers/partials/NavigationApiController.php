<?php

require_once __DIR__ . '/../../classes/AbsApiController.php';

class NavigationApiController extends AbsApiController
{
    public function get()
    {
        $userID = Session::get('user_id');
        $roleID = Session::get('role_id');

        return ApiMessage::dataFetchAttempt([
            'notifications' => $this->getNotifications($userID, $roleID),
            'total_unread' => $this->getTotalUnreadNotifications($userID, $roleID)
        ]);
    }

    public function post()
    {
        $data = $this->getData();
        $authToken = $data['csrf_token'];

        // Guard clause.
        if ($authToken !== Session::get('csrf_token') ||
                ((time() - Session::get('csrf_token_set_at')) / 60) > 5) {
            return ApiMessage::apiError('token');
        }

        $userID = Session::get('user_id');
        $roleID = Session::get('role_id');

        // Guard clause.
        if (isset($this->markNotificationsAsRead($data, $userID, $roleID)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    private function getNotifications(int $userID, int $roleID)
    {
        if ($roleID === 1) {
            return Session::getDbInstance()->executeQuery(
                'SELECT * FROM notifications;'
            )->getQueryResult();
        }

        $query = 'SELECT * FROM notifications WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }

    private function getTotalUnreadNotifications(int $userID, int $roleID)
    {
        if ($roleID === 1) {
            $query = 'SELECT COUNT(notification_id) as total FROM notifications WHERE is_read = :is_read;';
            return Session::getDbInstance()->executeQuery(
                $query, [':is_read' => 0]
            )->getQueryResult();
        }

        $query = 'SELECT COUNT(notification_id) as total FROM notifications WHERE user_id = :user_id AND is_read = :is_read;';
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
