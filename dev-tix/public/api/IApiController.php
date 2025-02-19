<?php

interface IApiController
{
    /**
     * API method for GET requests.
     */
    public function get();

    /**
     * API method for POST requests.
     */
    public function post();

    /**
     * API method for PUT requests.
     */
    public function put();

    /**
     * API method for DELETE requests.
     */
    public function delete();
}
