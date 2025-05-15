<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';

class LogoutApiController extends AbsApiController
{
    public function put()
    {
        $userID = $this->getId();
        $data = $this->getData();

        // Guard clause: activity update error.
        if (isset($this->updateUserActivity($userID, $data['is_active'])['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true, 'logout');
    }

    private function updateUserActivity(int $userID, int $isActive)
    {
        $query = 'UPDATE users SET last_active = :last_active, is_active = :is_active WHERE user_id = :user_id;';
        return Session::getDbInstance()->executeQuery($query, [
            ':last_active' => date('Y-m-d H:i:s'), 'is_active' => $isActive, ':user_id' => $userID
        ])->getQueryResult();
    }
}
