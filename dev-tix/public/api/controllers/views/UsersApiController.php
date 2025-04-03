<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class UsersApiController extends AbsApiController
{
    public function get()
    {
        $userID = $this->getId();
        $data = $this->getUserData($userID);
        $return = [];

        // Get all present tickets.
        if (!isset($data['user_id'])) {
            foreach ($data as $user) {
                $return['users'][] = $this->extractUserData($user);
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        $return['users'][] = $this->extractUserData($data);

        return ApiMessage::dataFetchAttempt($return);
    }

    private function extractUserData(array $data)
    {
        return [
            'user_id' => $data['user_id'],
            'role_id' => $data['role_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'user_image' => $data['user_image'],
            'user_image_type' => $data['user_image_type'],
            'last_active' => $data['last_active']
        ];
    }

    private function getUserData(int $userID)
    {
        $query = '
            SELECT * FROM users JOIN user_details 
            ON users.user_id = user_details.user_id 
            WHERE users.user_id != :user_id
            ORDER BY users.role_id ASC, users.username ASC;
        ';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }
}
