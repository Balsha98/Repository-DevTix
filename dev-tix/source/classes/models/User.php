<?php
require_once __DIR__ . '/UserDetails.php';

class User
{
    // Attributes.
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

    /**
     * Class constructor.
     * @param int $id - user id.
     * @param Database $database - database object.
     */
    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;

        $this->details = new UserDetails($id, $database);

        $this->getUserData();
    }

    /**
     * Get user-related data.
     * @return array data - user data.
     */
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

    /**
     * Get user id.
     * @return int $id - user id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get view-as-user id.
     * @return int $viewAsUserID - view-as-user id.
     */
    public function getViewAsUserId()
    {
        return $this->viewAsUserID;
    }

    /**
     * Get role id.
     * @return int $roleID - role id.
     */
    public function getRoleId()
    {
        return $this->roleID;
    }

    /**
     * Get view-as-role id.
     * @return int $viewAsRoleID - view-as-role id.
     */
    public function getViewAsRoleId()
    {
        return $this->viewAsRoleID;
    }

    /**
     * Get role name.
     * @return string $roleName - role name.
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Get first name.
     * @return string $firstName - first name.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Get last name.
     * @return string $lastName - last name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get full name.
     * @return string $fullName - full name.
     */
    public function getFullName()
    {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * Get user initials.
     * @return string initials - user initials.
     */
    public function getInitials()
    {
        return implode(array_map(function ($part) {
            return ucfirst($part[0]);
        }, explode(' ', $this->getFullName())));
    }

    /**
     * Get user email.
     * @return string $email - user email.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get username.
     * @return string $username - username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get joinedAt timestamp.
     * @return string $joinedAt - joinedAt timestamp.
     */
    public function getJoinedAt()
    {
        return $this->joinedAt;
    }

    /**
     * Get lastActive timestamp.
     * @return string $lastActive - lastActive timestamp.
     */
    public function getLastActive()
    {
        return $this->lastActive;
    }

    /**
     * Get user-related request ids.
     * @return array data - request ids.
     */
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

    /**
     * Get user details object.
     * @return UserDetails $details - user details object.
     */
    public function getDetails()
    {
        return $this->details;
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
