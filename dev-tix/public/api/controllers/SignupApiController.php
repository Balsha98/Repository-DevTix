<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class SignupApiController extends AbsApiController
{
    public function post()
    {
        return $this->getData();
    }
}
