<?php

class Request
{
    // Attributes.
    private int $id;
    private int $patronID;
    private int $assistantID;
    private string $type;
    private string $subject;
    private string $question;
    private string $postedAt;
    private string $status;
    private int $turnID;
    private array $images = [];
    private array $responseIDs = [];
    private Database $database;

    /**
     * Class constructor.
     * @param int $id - ticket id.
     * @param Database $database - database object.
     */
    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getRequestData();
    }

    /**
     * Get ticket-related data.
     * @return array data - ticket data.
     */
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

    /**
     * Get ticket id.
     * @return int $id - ticket id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get patron id.
     * @return int $patronID - patron id.
     */
    public function getPatronId()
    {
        return $this->patronID;
    }

    /**
     * Get assistant id.
     * @return int $assistantID - assistant id.
     */
    public function getAssistantId()
    {
        return $this->assistantID;
    }

    /**
     * Get ticket type.
     * @return string $type - ticket type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get ticket subject.
     * @return string $subject - ticket subject.
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get ticket question.
     * @return string $question - ticket question.
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Get postedAt timestamp.
     * @return string $postedAt - postedAt timestamp.
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * Get ticket status.
     * @return string $status - ticket status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get ticket turn id.
     * @return int $turnID - turn id.
     */
    public function getTurnId()
    {
        return $this->turnID;
    }

    /**
     * Get responses related to the ticket.
     * @return array data - array of response ids.
     */
    public function getResponseIDs()
    {
        if (empty($this->responseIDs)) {
            $query = 'SELECT response_id FROM ticket_responses WHERE request_id = :request_id;';

            $result = $this->database->executeQuery(
                $query, [':request_id' => $this->id]
            )->getQueryResult();

            if (!empty($result)) {
                if (count($result) > 1) {
                    foreach ($result as $item) {
                        $this->responseIDs[] = $item['response_id'];
                    }
                } else {
                    $this->responseIDs[] = $result['response_id'];
                }
            }
        }

        return $this->responseIDs;
    }

    /**
     * Get ticket snippet images.
     * @return array data - snippet images.
     */
    public function getImages(): array
    {
        if (empty($this->images)) {
            $query = 'SELECT request_image, request_image_type FROM request_images WHERE request_id = :request_id;';

            $result = $this->database->executeQuery(
                $query, [':request_id' => $this->id]
            )->getQueryResult();

            if (!empty($result)) {
                if (!isset($result['request_image'])) {
                    foreach ($result as $item) {
                        $this->images[] = [
                            'request_image' => base64_encode($item['request_image']),
                            'request_image_type' => $item['request_image_type'],
                        ];
                    }
                } else {
                    $this->images[] = [
                        'request_image' => base64_encode($result['request_image']),
                        'request_image_type' => $result['request_image_type'],
                    ];;
                }
            }
        }

        return $this->images;
    }
}
