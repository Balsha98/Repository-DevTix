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

            // Guard clause: activity process error.
            if (isset($this->updateUserActivity($userID)['error'])) {
                return ApiMessage::alertDataAlterAttempt(false);
            }

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

    private function updateUserActivity(int $userID)
    {
        $query = 'UPDATE users SET last_active = :last_active, is_active = :is_active WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':last_active' => date('Y-m-d H:i:s'), 'is_active' => 1, ':user_id' => $userID
        ])->getQueryResult();
    }
}
