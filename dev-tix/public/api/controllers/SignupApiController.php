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
                
        ';

        $query = '
            INSERT INTO 
                users 
            SET 
                first_name = :frist_name, 
                last_name = :last_name, 
                email = :email, 
                username = :username, 
                password = :password;
        ';

        return ApiMessage::attemptedLogin(true);
    }
}
