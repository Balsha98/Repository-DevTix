<?php

class Request
{
    private int $id;
    private int $patronID;
    private int $assistantID;
    private string $type;
    private string $subject;
    private string $question;
    private string $postedAt;
    private string $status;
    private int $turnID;
    private array $responseIDs;
    private Database $database;

    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getRequestData();
    }

    private function getRequestData()
    {
        $query = '
            SELECT * FROM ticket_requests 
            WHERE request_id = :request_id;
        ';

        $result = $this->database->executeQuery(
            $query, [':request_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->patronID = (int) $result['patron_id'];
            $this->assistantID = (int) $result['assistant_id'];
            $this->type = $result['type'];
            $this->subject = $result['subject'];
            $this->question = $result['question'];
            $this->postedAt = $result['posted_at'];
            $this->status = $result['status'];
            $this->turnID = (int) $result['turn_id'];
        }

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPatronId()
    {
        return $this->patronID;
    }

    public function getAssistantId()
    {
        return $this->assistantID;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function getPostedAt()
    {
        return $this->postedAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTurnId()
    {
        return $this->turnID;
    }

    public function getResponseIDs()
    {
        if (empty($this->responseIDs)) {
            $query = 'SELECT response_id FROM ticket_responses WHERE request_id = :request_id;';

            $this->responseIDs = $this->database->executeQuery(
                $query, [':request_id' => $this->id]
            )->getQueryResult();
        }

        return $this->responseIDs;
    }
}
