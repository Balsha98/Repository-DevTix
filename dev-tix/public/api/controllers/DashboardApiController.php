<?php

require_once __DIR__ . '/../classes/AbsApiController.php';

class DashboardApiController extends AbsApiController
{
    public function get()
    {
        return ['status' => 'success', 'tickets' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];
    }
}
