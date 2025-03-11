<?php

class Notification
{
    private int $id;
    private int $userID;
    private string $type;
    private string $title;
    private string $message;
    private int $isRead;
    private string $sentAt;
    private Database $database;

    public function __construct(int $id, $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getNotificationData();
    }

    private function getNotificationData()
    {
        $query = '
            SELECT * FROM notifications 
            WHERE notification_id = :notification_id;
        ';

        $result = $this->database->executeQuery(
            $query, [':notification_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->userID = $result['user_id'];
            $this->type = $result['type'];
            $this->title = $result['title'];
            $this->message = $result['message'];
            $this->isRead = $result['is_read'];
            $this->sentAt = $result['sent_at'];
        }

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userID;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getIsRead()
    {
        return $this->isRead;
    }

    public function getSentAt()
    {
        return $this->sentAt;
    }
}
