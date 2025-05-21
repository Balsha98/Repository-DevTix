<?php

class Log
{
    // Constants.
    private const REQUEST_STATUS = [
        'unassigned' => 'posted',
        'pending' => 'claimed',
        'cancelled' => 'cancelled',
        'resolved' => 'resolved'
    ];

    private static function getAuthLogData(string $type, string $username)
    {
        return match ($type) {
            'signup' => [
                'title' => 'User Signup Alert',
                'message' => "{$username} signed up successfully."
            ],
            'login' => [
                'title' => 'User Login Alert',
                'message' => "{$username} logged in successfully."
            ]
        };
    }

    public static function saveAuthLog(int $userID, string $type)
    {
        $username = self::getUsernameByUserID($userID);
        $logData = self::getAuthLogData($type, $username);

        self::insertNewLog($userID, $type, $logData);
    }

    private static function getRequestLogData(int $ticketID, string $username, string $status)
    {
        return [
            'title' => 'Request Action Alert',
            'message' => "{$username} {$status} req. #{$ticketID} successfully."
        ];
    }

    public static function saveTicketRequestLog(int $ticketID, int $userID, string $status = 'unassigned')
    {
        $username = self::getUsernameByUserID($userID);
        $logData = self::getRequestLogData($ticketID, $username, self::REQUEST_STATUS[$status]);

        self::insertNewLog($userID, 'request', $logData);
    }

    private static function getResponseLogData(int $ticketID, string $username)
    {
        return [
            'title' => 'Response Post Alert',
            'message' => "{$username} posted a response to req. #{$ticketID}."
        ];
    }

    public static function saveTicketResponseLog(int $ticketID, int $userID)
    {
        $username = self::getUsernameByUserID($userID);
        $logData = self::getResponseLogData($ticketID, $username);

        self::insertNewLog($userID, 'response', $logData);
    }

    private static function getUserLogData(string $type, string $username)
    {
        return match ($type) {
            'profile' => [
                'title' => 'Profile Update Alert',
                'message' => "{$username} updated profile successfully."
            ],
            'client' => [
                'title' => 'Client View Alert',
                'message' => "{$username} switched to a different client."
            ],
        };
    }

    public static function saveUserLog(int $userID, string $type)
    {
        $username = self::getUsernameByUserID($userID);
        $logData = self::getUserLogData($type, $username);

        self::insertNewLog($userID, $type, $logData);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private static function getUsernameByUserID(int $userID)
    {
        $query = 'SELECT username FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['username'];
    }

    private static function insertNewLog(int $userID, string $type, array $data)
    {
        $query = 'INSERT INTO logs (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $userID, ':type' => $type, ':title' => $data['title'], ':message' => $data['message']
        ])->getQueryResult();
    }
}
