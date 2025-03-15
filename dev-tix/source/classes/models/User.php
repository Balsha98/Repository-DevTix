<?php

class User
{
    private int $id;
    private int $roleId;
    private string $roleName;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $image;
    private string $joinedAt;
    private string $lastActive;
    private array $requestIDs;
    private Database $database;

    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getUserData();
    }

    private function getUserData()
    {
        $query = 'SELECT * FROM users JOIN roles ON users.role_id = roles.role_id WHERE user_id = :user_id;';

        $result = $this->database->executeQuery(
            $query, [':user_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->roleId = (int) $result['role_id'];
            $this->roleName = $result['role_name'];
            $this->firstName = $result['first_name'];
            $this->lastName = $result['last_name'];
            $this->email = $result['email'];
            $this->username = $result['username'];
            $this->image = '';  // TODO: Check for the image.
            $this->joinedAt = $result['joined_at'];
            $this->last_active = $result['last_active'];
        }

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function getRoleName()
    {
        return $this->roleName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFullName()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getInitials()
    {
        return implode(array_map(function ($part) {
            return ucfirst($part[0]);
        }, explode(' ', $this->getFullName())));
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getImage()
    {
        // TODO: Check image!
        return $this->image;
    }

    public function getJoinedAt()
    {
        return $this->joinedAt;
    }

    public function getLastActive()
    {
        return $this->lastActive;
    }

    public function getRequestIDs()
    {
        if (empty($this->requestIDs)) {
            $query = 'SELECT request_id FROM ticket_requests WHERE patron_id = :patron_id OR assistant_id = :assistant_id;';

            $this->requestIDs = $this->database->executeQuery(
                $query, [':patron_id' => $this->id, ':assistant_id' => $this->id]
            )->getQueryResult();
        }

        return $this->requestIDs;
    }
}
