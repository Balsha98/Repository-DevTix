<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        return ['success' => 'LOGIN CONTROLLER'];
    }
}
