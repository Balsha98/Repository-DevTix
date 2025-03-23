<?php
require_once __DIR__ . '/UserDetails.php';

class User
{
    private int $id;
    private int $viewAsUserID;
    private int $roleID;
    private int $viewAsRoleID;
    private string $roleName;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $joinedAt;
    private string $lastActive;
    private array $requestIDs = [];
    private UserDetails $details;
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
            $this->viewAsUserID = (int) $result['view_as_user_id'];
            $this->roleID = (int) $result['role_id'];
            $this->viewAsRoleID = (int) $result['view_as_role_id'];
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

    public function getViewAsUserId()
    {
        return $this->viewAsUserID;
    }

    public function getRoleId()
    {
        return $this->roleID;
    }

    public function getViewAsRoleId()
    {
        return $this->viewAsRoleID;
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

            $result = $this->database->executeQuery(
                $query, [':patron_id' => $this->viewAsUserID, ':assistant_id' => $this->viewAsUserID]
            )->getQueryResult();

            if (!empty($result)) {
                if (count($result) > 1) {
                    foreach ($result as $request) {
                        $this->requestIDs[] = $request['request_id'];
                    }
                } else {
                    $this->requestIDs[] = $result['request_id'];
                }
            }
        }

        return $this->requestIDs;
    }

    // public function getNotificationIDs()
    // {
    //     if (empty($this->allNotificationIDs)) {
    //         $isAdmin = $this->id === $this->viewAsUserID && $this->roleID === 1;
    //         $query = 'SELECT notification_id FROM notifications' . ($isAdmin ? ';' : ' WHERE user_id = :user_id;');
    //         $params = $isAdmin ? [] : [':user_id' => $this->viewAsUserID];

    //         $result = $this->database->executeQuery($query, $params)->getQueryResult();

    //         if (!empty($result)) {
    //             if (count($result) > 1) {
    //                 foreach ($result as $request) {
    //                     $this->allNotificationIDs[] = $request['notification_id'];
    //                 }
    //             } else {
    //                 $this->allNotificationIDs[] = $result['notification_id'];
    //             }
    //         }
    //     }

    //     return $this->allNotificationIDs;
    // }
}
