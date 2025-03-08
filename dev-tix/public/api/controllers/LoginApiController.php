<?php
require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();
        $account = $this->getAccount($data);

        // Guard caluse.
        if (empty($account)) {
            return ApiMessage::authAccountError($data, 'register');
        }

        $passwordHash = hash('sha256', $data['password']);
        if ($account['password'] === $passwordHash) {
            // Set session variable.
            Session::set('active', true);
            Session::set('user_id', $account['user_id']);
            Session::set('role_id', $account['role_id']);

            // If login was successful.
            return ApiMessage::authAttempt($data, true, '/dashboard');
        }

        // Lastly, if credentials are invalid.
        return ApiMessage::authAttempt($data, false);
    }

    private function getAccount(array $data)
    {
        $query = '
            SELECT * FROM users 
            WHERE username = :username;
        ';

        return Session::getDbInstance()->executePreparedStatement(
            $query, [':username' => $data['username']]
        )->getQueryResult();
    }
}
