<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class NotificationsApiController extends AbsApiController
{
    public function get()
    {
        $userID = $this->getId();
        $roleID = Session::get('role_id');

        $notifications = $this->getAllNotifications($userID, $roleID);

        $return = [];
        if (!isset($notifications['notification_id'])) {
            foreach ($notifications as $notification) {
                $return['notifications'][] = $this->extractNotificationData($notification);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        $return['notifications'] = $this->extractNotificationData($notifications);

        return ApiMessage::dataFetchAttempt($return);
    }

    public function put()
    {
        // TODO: Mark notifications as read...
    }

    private function extractNotificationData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type'],
            'notification_id' => $data['notification_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'is_read' => $data['is_read'],
            'sent_at' => $data['sent_at']
        ];
    }

    private function getAllNotifications(int $userID, int $roleID)
    {
        if (Session::get('user_id') === $userID && $roleID === 1) {
            $query = '
                SELECT * FROM notifications 
                JOIN users ON notifications.user_id = users.user_id 
                JOIN user_details ON users.user_id = user_details.user_id;
            ';

            return Session::getDbInstance()->executeQuery($query)->getQueryResult();
        }

        $query = '
            SELECT * FROM notifications 
            JOIN users ON notifications.user_id = users.user_id 
            JOIN user_details ON users.user_id = user_details.user_id 
            WHERE notifications.user_id = :user_id;
        ';

        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
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
