<?php

require_once __DIR__ . '/../../classes/AbsApiController.php';

class ProfileApiController extends AbsApiController
{
    public function get()
    {
        $userID = $this->getId();
        $profileData = $this->getProfileData($userID);

        // Guard clause: empty data.
        if (empty($profileData)) {
            return ApiMessage::dataFetchAttempt($profileData);
        }

        return ApiMessage::dataFetchAttempt($profileData);
    }

    public function put() {}

    private function getProfileData(int $userID)
    {
        $query = '
            SELECT 
                users.role_id, users.first_name, users.last_name, users.email,
                users.username, user_details.bio, user_details.age, user_details.gender, 
                user_details.profession, user_details.country, user_details.city, user_details.zip 
            FROM users JOIN user_details 
            ON users.user_id = user_details.user_id 
            WHERE users.user_id = :user_id;
        ';

        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }

    private function updateProfile($data) {}
}
