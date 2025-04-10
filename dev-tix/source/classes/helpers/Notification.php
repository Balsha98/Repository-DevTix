<?php

class Notification
{
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
        $query = 'INSERT INTO notifications (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $userID, ':type' => $type, ':title' => self::PRIVATE_TYPES[$type]['title'],
            ':message' => self::PRIVATE_TYPES[$type]['message']
        ])->getQueryResult();
    }
}
