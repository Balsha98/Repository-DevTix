<?php

// REMINDER: Objects of this class will be able to pull
// every response that is related to them.
// REMINDER: Request data will probably be loaded in advance
// similarly to EZ lazy_load() functionality.

class Request
{
    private int $id;
    private int $patronID;
    private int $assistantID;
    private string $type;
    private string $subject;
    private string $question;
    private string $postedAt;
    private string $updatedAt;
    private string $status;
    private int $turnID;
    private Database $database;

    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;
    }

    private function getRequestData()
    {
        $query = '
            SELECT * FROM ticket_requests 
            WHERE request_id = :request_id;
        ';

        $result = $this->database->executePreparedStatement(
            $query, [':request_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->patronID = $result['patron_id'];
            $this->assistantID = $result['assistant_id'];
            $this->type = $result['type'];
            $this->subject = $result['subject'];
            $this->question = $result['question'];
            $this->postedAt = $result['posted_at'];
            $this->updatedAt = $result['updated_at'];
            $this->status = $result['status'];
            $this->turnID = $result['turn_id'];
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

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTurnId()
    {
        return $this->turnID;
    }
}
