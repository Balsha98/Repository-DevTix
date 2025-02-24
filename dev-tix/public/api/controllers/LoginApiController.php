<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $query = '
            SELECT 
                password 
            FROM 
                users 
            WHERE 
                username = :username;
        ';

        $result = Session::getDbInstance()->executePreparedStatement($query, [
            ':username' => $this->getData()['username']
        ])->getQueryResult();

        // Guard caluse.
        if (empty($result)) {
            return ['error' => "It seems you don't have a registered account."];
        }

        $passwordHash = hash('sha256', $this->getData()['password']);
        if ($result['password'] === $passwordHash) {
            return ['success' => 'Your login was successful!'];
        }

        // Lastly, if credentials are invalid.
        return ['error' => 'Invalid credentials provided.'];
    }
}
