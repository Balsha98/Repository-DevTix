<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();

        // Guard caluse.
        if (empty($this->getAccount($data))) {
            return ApiMessage::authAccountIssues('login', 'register');
        }

        $passwordHash = hash('sha256', $data['password']);
        if ($this->getAccount($data)['password'] === $passwordHash) {
            return ApiMessage::authAttempt('login', true);
        }

        // Lastly, if credentials are invalid.
        return ApiMessage::authAttempt('login', false);
    }

    private function getAccount($data)
    {
        $query = '
            SELECT password FROM users 
            WHERE username = :username;
        ';

        return Session::getDbInstance()->executePreparedStatement(
            $query, [':username' => $data['username']]
        )->getQueryResult();
    }
}
