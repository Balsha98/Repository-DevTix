<?php

class Response
{
    private int $id;
    private int $requestID;
    private int $userID;
    private string $response;
    private string $postedAt;
    private Database $database;

    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getResponseData();
    }

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

    public function getId()
    {
        return $this->id;
    }

    public function getRequestId()
    {
        return $this->requestID;
    }

    public function getUserId()
    {
        return $this->userID;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getPostedAt()
    {
        return $this->postedAt;
    }
}
