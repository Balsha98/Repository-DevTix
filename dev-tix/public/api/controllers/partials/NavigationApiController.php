<?php

require_once __DIR__ . '/../../classes/AbsApiController.php';

class NavigationApiController extends AbsApiController
{
    public function get()
    {
        $userID = Session::get('user_id');
        $roleID = Session::get('role_id');

        return ApiMessage::dataFetchAttempt([
            'notifications' => $this->getNotifications($roleID, $userID),
            'total_unread' => $this->getTotalUnreadNotifications()
        ]);
    }

    private function getNotifications(int $roleID, int $userID)
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT * FROM notifications' . ($roleID === 1 ? ';' : " WHERE user_id = {$userID};"),
        )->getQueryResult();
    }

    private function getTotalUnreadNotifications()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT COUNT(notification_id) as total FROM notifications WHERE is_read = 0;',
        )->getQueryResult();
    }
}
