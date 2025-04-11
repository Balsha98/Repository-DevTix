<?php

class Response
{
    // Attributes.
    private int $id;
    private int $requestID;
    private int $userID;
    private string $response;
    private string $postedAt;
    private Database $database;

    /**
     * Class constructor.
     * @param int $id - response id.
     * @param Database $database - database object.
     */
    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getResponseData();
    }

    /**
     * Get response-related data.
     * @return array data - response data.
     */
    private function getResponseData()
    {
        $query = '
            SELECT * FROM ticket_responses 
            WHERE response_id = :response_id;
        ';

        $result = $this->database->executeQuery(
            $query, [':response_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->requestID = $result['request_id'];
            $this->userID = $result['user_id'];
            $this->response = $result['response'];
            $this->postedAt = $result['posted_at'];
        }

        return $result;
    }

    /**
     * Get response id.
     * @return int $id - response id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get ticket id.
     * @return int $requestID - ticket id.
     */
    public function getRequestId()
    {
        return $this->requestID;
    }

    /**
     * Get user id.
     * @return int $userID - user id.
     */
    public function getUserId()
    {
        return $this->userID;
    }

    /**
     * Get response text.
     * @return string $response - response text.
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get postedAt timestamp.
     * @return string $postedAt - postedAt timestamp.
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }
}
