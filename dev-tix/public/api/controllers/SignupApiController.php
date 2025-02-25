<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class SignupApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();

        // If username exists.
        if (!empty($this->getAccount($data))) {
            return ApiMessage::authAccountIssues($data['page'], 'unique');
        }

        // Any issues inserting the user.
        if (isset($this->insertUser($data)['error'])) {
            return ApiMessage::authAttempt($data['page'], false);
        }

        // Any issues inserting the user details.
        if (isset($this->insertUserDetails($data)['error'])) {
            return ApiMessage::authAttempt($data['page'], false);
        }

        // If signup was successful.
        return ApiMessage::authAttempt($data['page'], true);
    }

    private function getAccount($data)
    {
        $query = '
            SELECT * FROM users 
            WHERE username = :username;      
        ';

        return Session::getDbInstance()->executePreparedStatement(
            $query, [':username' => $data['username']]
        )->getQueryResult();
    }

    private function insertUser($data)
    {
        $query = '
            INSERT INTO users (
                role_id, first_name, last_name, 
                email, username, password, joined_at
            ) VALUES (
                :role_id, :first_name, :last_name, 
                :email, :username, :password, :joined_at
            );
        ';

        return Session::getDbInstance()->executePreparedStatement($query, [
            ':role_id' => (int) $data['role'], ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'], ':email' => $data['email'], ':username' => $data['username'],
            ':password' => hash('sha256', $data['password']), ':joined_at' => time()
        ])->getQueryResult();
    }

    private function getLastInsertID()
    {
        $query = 'SELECT MAX(user_id) as id FROM users;';
        return Session::getDbInstance()->executePreparedStatement(
            $query, []
        )->getQueryResult();
    }

    private function insertUserDetails($data)
    {
        $query = '
            INSERT INTO user_details (
                user_id, age, gender
            ) VALUES (
                :user_id, :age, :gender
            );
        ';

        return Session::getDbInstance()->executePreparedStatement($query, [
            ':user_id' => $this->getLastInsertID()['id'], ':age' => $data['age'], ':gender' => $data['gender']
        ])->getQueryResult();
    }
}
