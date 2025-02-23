<?php

require_once __DIR__ . '/IApiController.php';

abstract class AbsApiController implements IApiController
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
     * Setting record id.
     * @param int - record id.
     */
    public function setId(int $id)
    {
        $this->id = $id;
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
     * Setting input data.
     * @param array - API resources.
     */
    public function setData(array $data)
    {
        $this->data = $data;
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
