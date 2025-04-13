<?php

class Notification
{
    // Constants.
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

    /**
     * Send user-specific notification.
     * @param int $userID - user id.
     * @param string $type - type of notification.
     * @return array data - either successful or failed.
     */
    public static function sendPrivateNotification(int $userID, string $type)
    {
        return self::insertNewNotification($userID, $type, self::PRIVATE_TYPES[$type]);
    }

    /**
     * Generate request notification data.
     * @param int $ticketID - request id.
     * @param string $username - user's username.
     * @param string $status - request status.
     * @return array data - request notification data.
     */
    private static function getRequestNotificationData(int $ticketID, string $username, string $status)
    {
        $ticketAction = self::REQUEST_STATUS[$status];

        return [
            'title' => "{$username} {$ticketAction} Req. #{$ticketID}",
            'message' => "{$username} successfully {$ticketAction} a request."
        ];
    }

    /**
     * Send request-related notification publicly.
     * @param int $ticketID - request id.
     * @param int $userID - user id.
     * @param string $status - request status.
     * @return array data - either successful or failed.
     */
    public static function sendRequestNotification(int $ticketID, int $userID, string $status = 'unassigned')
    {
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
            $requestData = self::getRequestNotificationData($ticketID, $username, $status);
            $result = self::insertNewNotification($id, 'request', $requestData);

            if (isset($result['error'])) {
                return $result;
            }
        }

        return $result;
    }

    /**
     * Generate response notification data.
     * @param int $ticketID - request id.
     * @param string $username - user's username.
     * @return array data - response notification data.
     */
    private static function getResponseNotificationData(int $ticketID, string $username)
    {
        return [
            'title' => "{$username} Responded To Req. #{$ticketID}",
            'message' => "{$username} responded to the request."
        ];
    }

    /**
     * Send response-related notification privately.
     * @param int $ticketID - request id.
     * @param int $currUserID - user sending the response.
     * @param int $userID - id used for comparison.
     * @return array data - either successful or failed.
     */
    public static function sendResponseNotification(int $ticketID, int $currUserID, int $userID)
    {
        $username = $userID === $currUserID ? 'You' : self::getUsernameByUserId($currUserID);
        $responseData = self::getResponseNotificationData($ticketID, $username);
        return self::insertNewNotification($userID, 'response', $responseData);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

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

    private static function insertNewNotification(int $userID, string $type, array $data)
    {
        $query = 'INSERT INTO notifications (user_id, type, title, message) VALUES (:user_id, :type, :title, :message);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $userID, ':type' => $type, ':title' => $data['title'], ':message' => $data['message']
        ])->getQueryResult();
    }
}
