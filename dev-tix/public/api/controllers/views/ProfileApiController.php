<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/ProfileInputRules.php';

class ProfileApiController extends AbsApiController
{
    public function get()
    {
        $userID = $this->getId();
        $data = $this->getProfileData($userID);

        // Guard clause: empty data.
        if (empty($data)) {
            return ApiMessage::dataFetchAttempt($data);
        }

        return ApiMessage::dataFetchAttempt($data);
    }

    public function post()
    {
        $data = $this->getData();
        $action = $data['action'];

        // Upload/Update profile image.
        if (preg_match('#image#', $action)) {
            if (isset($_FILES['image'])) {
                $isUpload = preg_match('#upload#', $action);
                $userID = $isUpload ? $this->getLastInsertId() : Session::get('record_id');
                $file = $_FILES['image'];

                $imageData = [
                    'image' => base64_encode(file_get_contents($file['tmp_name'])),
                    'type' => explode('/', $file['type'])[1]
                ];

                $this->uploadProfileImage($isUpload, $userID, $imageData);
            }
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    public function put()
    {
        $userID = $this->getId();
        $data = $this->getData();

        // Guard clause: validate inputs.
        // if (!empty(Validate::validateInputs($data, ProfileInputRules::RULES))) {
        //     return Validate::getValidationResult();
        // }

        return ApiMessage::alertDataAlterAttempt(true);
    }

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

    private function updateUserData(array $data) {}

    private function updateUserDetailsData(array $data) {}

    private function uploadProfileImage(bool $isUpload, int $userID, array $imageData)
    {
        if ($isUpload) {
            $query = 'INSERT INTO user_details (user_id, user_image, user_image_type) VALUES (:user_id, :user_image, :user_image_type);';
            return Session::getDbInstance()->executeQuery($query, [
                ':user_id' => $userID, ':user_image' => $imageData['image'], ':user_image_type' => $imageData['type']
            ])->getQueryResult();
        }

        $query = 'UPDATE user_details SET user_image = :user_image, user_image_type = :user_image_type WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_image' => $imageData['image'], ':user_image_type' => $imageData['type'], ':user_id' => $userID
        ])->getQueryResult();
    }

    private function getLastInsertId()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(user_id) as id FROM users;'
        )->getQueryResult()['id'];
    }
}
