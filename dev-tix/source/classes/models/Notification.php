<?php

class Notification
{
    // Attributes.
    private int $id;
    private int $userID;
    private string $type;
    private string $title;
    private string $message;
    private int $isRead;
    private string $sentAt;
    private Database $database;

    /**
     * Class constructor.
     * @param int $id - notification id.
     * @param mixed $database - database object.
     */
    public function __construct(int $id, $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getNotificationData();
    }

    /**
     * Get notification data.
     * @return array data - notification data.
     */
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

    /**
     * Get notification id.
     * @return int $id - notification id.
     */
    public function getId()
    {
        return $this->id;
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
     * Get notification type.
     * @return string $type - notification type.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get notification title.
     * @return string $title - notification title.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get notification message.
     * @return string $message - notification message.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get notification isRead value.
     * @return int $isRead - isRead value.
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Get sentAt timestamp
     * @return string $sentAt - sentAt timestamp.
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }
}
