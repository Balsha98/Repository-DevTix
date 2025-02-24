<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class LoginApiController extends AbsApiController
{
    public function post()
    {
        $query = 'SELECT password FROM users WHERE username = :username;';

        print_r(Session::getDbInstance()->executePreparedStatement($query, [':username' => 'Admin'])->getQueryResult());
    }
}
