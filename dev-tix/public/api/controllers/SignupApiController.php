<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class SignupApiController extends AbsApiController
{
    public function post()
    {
        $query = '
            SELECT 
                * 
            FROM 
                users 
            WHERE 
                username = :username;      
        ';

        $data = $this->getData();
        $result = Session::getDbInstance()->executePreparedStatement($query, [
            ':username' => $data['username']
        ])->getQueryResult();

        if (!empty($result)) {
            return ApiMessage::accountNotUnique();
        }

        $query = '
            INSERT INTO users (
                role_id, first_name, last_name, 
                email, username, password, joined_at
            ) VALUES (
                :role_id, :first_name, :last_name, 
                :email, :username, :password, :joined_at
            );
        ';

        $result = Session::getDbInstance()->executePreparedStatement($query, [
            ':role_id' => (int) $data['role'], ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'], ':email' => $data['email'], ':username' => $data['username'],
            ':password' => hash('sha256', $data['password']), ':joined_at' => time()
        ])->getQueryResult();

        return $result;
    }
}
