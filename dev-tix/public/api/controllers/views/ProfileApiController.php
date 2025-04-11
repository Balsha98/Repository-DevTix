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

        // Guard clause: validate inputs.
        if (!empty(Validate::validateInputs($data, ProfileInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        if ($action === 'create/user') {
            // Guard clause: invalid user insert.
            if (isset($this->insertNewUserData($data)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // Guard clause: invalid user insert.
            if (isset($this->insertNewUserDetailsData($data)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            $userID = $this->getLastInsertId();

            // Guard clause: notification process error.
            if (isset(Notification::sendPrivateNotification($userID, 'signup')['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            return ApiMessage::alertDataAlterAttempt(true, "/profile/{$userID}");
        }

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
        if (!empty(Validate::validateInputs($data, ProfileInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        // Guard clause: invalid user update.
        if (isset($this->updateUserData($userID, $data)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        // Guard clause: invalid user details update.
        if (isset($this->updateUserDetailsData($userID, $data)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        // Guard clause: notification process error.
        if (isset(Notification::sendPrivateNotification($userID, 'profile')['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    public function delete()
    {
        $userID = $this->getId();
        $roleID = $this->getUserRoleId($userID);

        if ($roleID === 2) {
            // Guard clause: unable to process request.
            if (isset($this->setTicketsAsUnassigned($userID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }
        }

        // Guard clause: unable to process request.
        if (isset($this->deleteUserData($userID)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true, '/users');
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

    private function insertNewUserData(array $data)
    {
        $query = '
            INSERT INTO users (
                view_as_user_id, role_id, view_as_role_id, first_name, 
                last_name, email, username, password, joined_at
            ) VALUES (
                :view_as_user_id, :role_id, :view_as_role_id, :first_name, 
                :last_name, :email, :username, :password, :joined_at
            );
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':view_as_user_id' => $this->getLastInsertId() + 1, ':role_id' => $data['role_id'], ':view_as_role_id' => $data['role_id'],
            ':first_name' => $data['first_name'], ':last_name' => $data['last_name'], ':email' => $data['email'],
            ':username' => $data['username'], ':password' => hash('sha256', $data['password']), ':joined_at' => time()
        ])->getQueryResult();
    }

    private function updateUserData(int $userID, array $data)
    {
        $query = '
            UPDATE users SET 
                first_name = :first_name, last_name = :last_name, email = :email, 
                username = :username' . (isset($data['password']) ? ', password = :password' : '') . '
            WHERE user_id = :user_id;
        ';

        $params = [];
        $paramNames = ['first_name', 'last_name', 'email', 'username', 'password', 'user_id'];
        foreach ($paramNames as $paramName) {
            if (isset($data[$paramName])) {
                $params[":{$paramName}"] = $data[$paramName];
            } else if ($paramName === 'user_id') {
                $params[":{$paramName}"] = $userID;
            }
        }

        return Session::getDbInstance()->executeQuery(
            $query, $params
        )->getQueryResult();
    }

    private function insertNewUserDetailsData(array $data)
    {
        $query = '
            INSERT INTO user_details (
                user_id, bio, age, gender, 
                profession, country, city, zip
            ) VALUES (
                :user_id, :bio, :age, :gender, 
                :profession, :country, :city, :zip
            );
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $this->getLastInsertId(), ':bio' => $data['bio'], ':age' => $data['age'], ':gender' => $data['gender'],
            ':profession' => $data['profession'], ':country' => $data['country'], ':city' => $data['city'], ':zip' => $data['zip']
        ])->getQueryResult();
    }

    private function updateUserDetailsData(int $userID, array $data)
    {
        $query = '
            UPDATE user_details SET 
                bio = :bio, age = :age, gender = :gender, profession = :profession, 
                country = :country, city = :city, zip = :zip 
            WHERE user_id = :user_id;
        ';

        return Session::getDbInstance()->executeQuery($query, [
            ':bio' => $data['bio'], ':age' => $data['age'], ':gender' => $data['gender'], ':profession' => $data['profession'],
            ':country' => $data['country'], ':city' => $data['city'], ':zip' => $data['zip'], ':user_id' => $userID
        ])->getQueryResult();
    }

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

    private function deleteUserData(int $userID)
    {
        $query = 'DELETE FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult();
    }

    private function getUserRoleId(int $userID)
    {
        $query = 'SELECT role_id FROM users WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery(
            $query, [':user_id' => $userID]
        )->getQueryResult()['role_id'];
    }

    private function setTicketsAsUnassigned(int $userID)
    {
        $query = 'UPDATE ticket_requests SET status = :status WHERE assistant_id = :assistant_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':status' => 'unassigned', ':assistant_id' => $userID
        ])->getQueryResult();
    }

    private function getLastInsertId()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(user_id) AS id FROM users;'
        )->getQueryResult()['id'];
    }
}
