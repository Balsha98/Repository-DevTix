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
                $return['users'][] = $user;
            }

            return ApiMessage::dataFetchAttempt($return);
        }

        $return['users'][] = $data;

        return ApiMessage::dataFetchAttempt($return);
    }

    private function getUserData(int $userID)
    {
        $query = 'SELECT * FROM users JOIN user_details ON users.user_id = user_details.user_id WHERE users.user_id != :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }
}
