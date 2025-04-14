<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();
        $account = $this->getAccount($data);

        // GuaSrd clause.
        if (empty($account)) {
            return ApiMessage::alertAuthAccountError($data, 'register');
        }

        $passwordHash = hash('sha256', $data['password']);
        if ($account['password'] === $passwordHash) {
            $userID = $account['user_id'];

            Session::set('active', true);
            Session::set('user_id', $userID);
            Session::set('role_id', $account['role_id']);

            // Guard clause: log process error.
            if (isset(Log::saveAuthLog($userID, 'login')['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

            // If login was successful.
            return ApiMessage::alertAuthAttempt($data, true, '/dashboard');
        }

        // Lastly, if credentials are invalid.
        return ApiMessage::alertAuthAttempt($data, false);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function getAccount(array $data)
    {
        $query = 'SELECT * FROM users WHERE username = :username;';
        return Session::getDbInstance()->executeQuery(
            $query, [':username' => $data['username']]
        )->getQueryResult();
    }
}
