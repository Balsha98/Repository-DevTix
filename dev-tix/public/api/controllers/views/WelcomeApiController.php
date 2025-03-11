<?php
require_once __DIR__ . '/../../classes/AbsApiController.php';
require_once __DIR__ . '/../data/WelcomeInputRules.php';

class WelcomeApiController extends AbsApiController
{
    public function post()
    {
        $data = $this->getData();

        if (!empty(Validate::validateInputs($data, WelcomeInputRules::RULES))) {
            return Validate::getValidationResult();
        }
    }
}
