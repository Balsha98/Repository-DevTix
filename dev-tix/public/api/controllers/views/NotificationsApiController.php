<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class NotificationsApiController extends AbsApiController
{
    public function get()
    {
        $userID = $this->getId();
        $roleID = (int) Session::get('role_id');

        $notifications = $this->getAllNotifications($userID, $roleID);

        $return['notifications'] = [];
        if (!isset($notifications['notification_id'])) {
            foreach ($notifications as $notification) {
                $return['notifications'][] = $this->extractNotificationData($notification);
            }

            $return['total_unread'] = $this->getTotalUnread($userID, $roleID);

            return ApiMessage::dataFetchAttempt($return);
        }

        $return = [
            'notifications' => $this->extractNotificationData($notifications),
            'total_unread' => $this->getTotalUnread($userID, $roleID)
        ];

        return ApiMessage::dataFetchAttempt($return);
    }

    public function put()
    {
        $data = $this->getData();
        $action = $data['action'];

        // Update all notifications.
        if ($action === 'mark/all') {
            $userID = $this->getId();
            $roleID = (int) $this->getClientRoleID($userID);

            // Guard clause: process fails.
            if (isset($this->markAllAsRead($data, $userID, $roleID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        // Update single notification.
        if ($action === 'mark/one') {
            $notificationID = $this->getId();
            $isRead = (int) $data['is_read'];

            // Guard clause: process fails.
            if (isset($this->markNotificationAsRead($notificationID, $isRead)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        return ApiMessage::alertDataAlterAttempt(true);
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

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getClientRoleID(int $clientID)
    {
        $query = 'SELECT role_id FROM users WHERE user_id = :user_id';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $clientID]
        )->getQueryResult()['role_id'];
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

    private function getTotalUnread(int $userID, int $roleID)
    {
        if (Session::get('user_id') === $userID && $roleID === 1) {
            $query = 'SELECT COUNT(notification_id) AS total FROM notifications WHERE is_read = :is_read;';
            return Session::getDbInstance()->executeQuery(
                $query, [':is_read' => 0]
            )->getQueryResult()['total'];
        }

        $query = 'SELECT COUNT(notification_id) AS total FROM notifications WHERE user_id = :user_id AND is_read = :is_read;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID, ':is_read' => 0]
        )->getQueryResult()['total'];
    }

    private function markAllAsRead(array $data, int $userID, int $roleID)
    {
        if (Session::get('user_id') === $userID && $roleID === 1) {
            $query = 'UPDATE notifications SET is_read = :is_read WHERE is_read = :unread;';
            return Session::getDbInstance()->executeQuery(
                $query, [':is_read' => $data['is_read'], ':unread' => 0]
            )->getQueryResult();
        }

        $query = 'UPDATE notifications SET is_read = :is_read WHERE user_id = :user_id AND is_read = :unread;';
        return Session::getDbInstance()->executeQuery($query, [
            ':is_read' => $data['is_read'], ':user_id' => $userID, ':unread' => 0
        ])->getQueryResult();
    }

    private function markNotificationAsRead(int $notificationID, int $isRead)
    {
        $query = 'UPDATE notifications SET is_read = :is_read WHERE notification_id = :notification_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':is_read' => $isRead, ':notification_id' => $notificationID
        ])->getQueryResult();
    }
}
