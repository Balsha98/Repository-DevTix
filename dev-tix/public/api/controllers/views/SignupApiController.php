<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/SignupInputRules.php';

class SignupApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();

        // Validate inputs, one by one.
        if (!empty(Validate::validateInputs($data, SignupInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        // If username exists.
        if (!empty($this->getAccount($data))) {
            return ApiMessage::alertAuthAccountError($data, 'unique');
        }

        // Any issues inserting the user.
        if (isset($this->insertNewUser($data)['error'])) {
            return ApiMessage::alertAuthAttempt($data, false);
        }

        // Any issues inserting the user details.
        if (isset($this->insertNewUserDetails($data)['error'])) {
            return ApiMessage::alertAuthAttempt($data, false);
        }

        // Get newly signed up user.
        $newAccount = $this->getAccount($data);

        // Set session variable.
        Session::set('active', true);
        Session::set('user_id', $newAccount['user_id']);
        Session::set('role_id', $newAccount['role_id']);

        // Send signup notification.
        Notification::sendPrivateNotification($newAccount['user_id'], 'signup');

        // If signup was successful.
        return ApiMessage::alertAuthAttempt($data, true, '/dashboard');
    }

    private function getAccount($data)
    {
        $query = 'SELECT * FROM users WHERE username = :username;';
        return Session::getDbInstance()->executeQuery(
            $query, [':username' => $data['username']]
        )->getQueryResult();
    }

    private function insertNewUser($data)
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
            ':view_as_user_id' => $this->getLastInsertID() + 1, ':role_id' => $data['role'], ':view_as_role_id' => $data['role'],
            ':first_name' => $data['first_name'], ':last_name' => $data['last_name'], ':email' => $data['email'],
            ':username' => $data['username'], ':password' => hash('sha256', $data['password']), ':joined_at' => time()
        ])->getQueryResult()['id'];
    }

    private function getLastInsertID()
    {
        return Session::getDbInstance()->executeQuery(
            'SELECT MAX(user_id) as id FROM users;',
        )->getQueryResult();
    }

    private function insertNewUserDetails($data)
    {
        $query = 'INSERT INTO user_details (user_id, age, gender) VALUES (:user_id, :age, :gender);';
        return Session::getDbInstance()->executeQuery($query, [
            ':user_id' => $this->getLastInsertID(), ':age' => $data['age'], ':gender' => $data['gender']
        ])->getQueryResult();
    }
}
