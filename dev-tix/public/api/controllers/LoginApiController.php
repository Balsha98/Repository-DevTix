<?php
require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();

        // Guard caluse.
        if (empty($this->getAccount($data))) {
            return ApiMessage::authAccountError($data, 'register');
        }

        $passwordHash = hash('sha256', $data['password']);
        if ($this->getAccount($data)['password'] === $passwordHash) {
            // Set session variable.
            Session::set('active', true);

            // If login was successful.
            return ApiMessage::authAttempt($data, true, '/dashboard');
        }

        // Lastly, if credentials are invalid.
        return ApiMessage::authAttempt($data, false);
    }

    private function getAccount(array $data)
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
