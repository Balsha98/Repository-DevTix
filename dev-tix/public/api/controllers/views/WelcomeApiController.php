<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/WelcomeInputRules.php';

class WelcomeApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();
        $email = $data['email'];

        if (!empty(Validate::validateInputs($data, WelcomeInputRules::RULES))) {
            return Validate::getValidationResult();
        }

        // Guard clause: newsletter process error.
        if (isset($this->insertNewNewsletterUser($email)['error'])) {
            return ApiMessage::alertDataAlterAttempt(false);
        }

        return ApiMessage::alertDataAlterAttempt(true);
    }

    // ***** HELPER DATABASE FUNCTIONS ***** //

    private function insertNewNewsletterUser(string $email)
    {
        $query = 'INSERT INTO newsletters (email) VALUES (:email);';
        return Session::getDbInstance()->executeQuery(
            $query, [':email' => $email]
        )->getQueryResult();
    }
}
