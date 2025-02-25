<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $query = '
            SELECT password FROM users 
            WHERE username = :username;
        ';

        $result = Session::getDbInstance()->executePreparedStatement($query, [
            ':username' => $this->getData()['username']
        ])->getQueryResult();

        // Guard caluse.
        if (empty($result)) {
            return ApiMessage::authAccountIssues('login', 'register');
        }

        $passwordHash = hash('sha256', $this->getData()['password']);
        if ($result['password'] === $passwordHash) {
            return ApiMessage::authAttempt('login', true);
        }

        // Lastly, if credentials are invalid.
        return ApiMessage::authAttempt('login', false);
    }
}
