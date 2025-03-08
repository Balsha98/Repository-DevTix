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
    private Database $database;

    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->getUserData();
    }

    private function getUserData()
    {
        $query = '
            SELECT * FROM users JOIN roles 
            ON users.role_id = roles.role_id 
            WHERE user_id = :user_id;
        ';

        $result = $this->database->executePreparedStatement(
            $query, [':user_id' => $this->id]
        )->getQueryResult();

        if (!empty($result)) {
            $this->roleId = (int) $result['role_id'];
            $this->roleName = $result['role_name'];
            $this->firstName = $result['first_name'];
            $this->lastName = $result['last_name'];
            $this->email = $result['email'];
            $this->username = $result['username'];
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
}
