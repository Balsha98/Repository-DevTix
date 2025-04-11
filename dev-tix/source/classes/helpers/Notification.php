<?php

class Notification
{
    private const REQUEST_STATUS = [
        'unassigned' => 'Posted',
        'pending' => 'Claimed',
        'cancelled' => 'Cancelled',
        'resolved' => 'Resolved'
    ];

    private const PRIVATE_TYPES = [
        'signup' => [
            'title' => 'Welcome To DevTix',
            'message' => 'You have successfully made an account.'
        ],
        'profile' => [
            'title' => 'Profile Updated',
            'message' => 'You have updated your profile.'
        ],
        'league' => [
            'title' => 'League Update Alert',
            'message' => 'You have moved up the ranks.'
        ]
    ];

    public static function sendPrivateNotification(int $userID, string $type)
    {
        $title = self::PRIVATE_TYPES[$type]['title'];
        $message = self::PRIVATE_TYPES[$type]['message'];

        $query = 'INSERT INTO notifications (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $userID, ':type' => $type, ':title' => $title, ':message' => $message
        ])->getQueryResult();
    }

    private static function getRequestNotificationData(int $ticketID, string $username, string $status)
    {
        $ticketAction = self::REQUEST_STATUS[$status];

        return [
            'title' => "{$username} {$ticketAction} Req. #{$ticketID}",
            'message' => "{$username} successfully {$ticketAction} a request."
        ];
    }

    public static function sendRequestNotification(int $ticketID, int $userID, string $status = 'unassigned')
    {
        $query = 'INSERT INTO notifications (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';

        $allUserIDs = [];
        if (!isset(self::getAllUserIDs()['user_id'])) {
            foreach (self::getAllUserIDs() as $id) {
                $allUserIDs[] = $id['user_id'];
            }
        } else {
            $allUserIDs = self::getAllUserIDs();
        }

        $result = [];
        foreach ($allUserIDs as $id) {
            $username = $id === $userID ? 'You' : self::getUsernameByUserId($userID);
            $title = self::getRequestNotificationData($ticketID, $username, $status)['title'];
            $message = self::getRequestNotificationData($ticketID, $username, $status)['message'];

            $result = Session::getDbInstance()->executeQuery($query, [
                ':user_id' => $id, ':type' => 'request', ':title' => $title, ':message' => $message
            ])->getQueryResult();

            if (isset($result['error'])) {
                return $result;
            }
        }

        return $result;
    }

    private static function getResponseNotificationData(int $ticketID, string $username)
    {
        return [
            'title' => "{$username} Responded To Req. #{$ticketID}",
            'message' => "{$username} responded to the request."
        ];
    }

    public static function sendResponseNotification(int $ticketID, int $currUserID, int $userID)
    {
        $username = $userID === $currUserID ? 'You' : self::getUsernameByUserId($currUserID);
        $title = self::getResponseNotificationData($ticketID, $username)['title'];
        $message = self::getResponseNotificationData($ticketID, $username)['message'];

        $query = 'INSERT INTO notifications (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $userID, ':type' => 'response', ':title' => $title, ':message' => $message
        ])->getQueryResult();
    }

    private static function getAllUserIDs()
    {
        $query = 'SELECT user_id FROM users WHERE role_id != :role_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':role_id' => 1]
        )->getQueryResult();
    }

    private static function getUsernameByUserId(int $userID)
    {
        $query = 'SELECT username FROM users WHERE user_id = :user_id';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['username'];
    }
}
