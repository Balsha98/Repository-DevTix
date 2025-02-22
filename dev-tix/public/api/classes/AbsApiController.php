<?php

abstract class AbsApiController
{
    // API attributes.
    private int $id;
    private array $data;

    /**
     * Existing record id.
     * @return int - id number.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Data sent via AJAX
     * @return array - new/existing record data.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * API method for GET requests.
     */
    public function get() {}

    /**
     * API method for POST requests.
     */
    public function post() {}

    /**
     * API method for PUT requests.
     */
    public function put() {}

    /**
     * API method for DELETE requests.
     */
    public function delete() {}
}
