<?php

class UserDetails
{
    private int $id;
    private int $userID;
    private string $bio;
    private int $age;
    private string $gender;
    private string $profession;
    private string $image;
    private string $imageType;
    private string $country;
    private string $city;
    private string $zip;
    private Database $database;

    public function __construct(int $userID, Database $database)
    {
        $this->userID = $userID;
        $this->database = $database;

        $this->getDetailsData();
    }

    private function getDetailsData()
    {
        $query = 'SELECT * FROM user_details WHERE user_id = :user_id;';

        $result = $this->database->executeQuery(
            $query, [':user_id' => $this->userID]
        )->getQueryResult();

        if (!empty($result)) {
            $this->id = (int) $result['details_id'];
            $this->bio = $result['bio'] ?? '';
            $this->age = (int) $result['age'] ?? '';
            $this->gender = $result['gender'] ?? '';
            $this->profession = $result['profession'] ?? '';
            $this->image = $result['user_image'] ?? '';
            $this->imageType = $result['user_image_type'] ?? '';
            $this->country = $result['country'] ?? '';
            $this->city = $result['city'] ?? '';
            $this->zip = $result['zip'] ?? '';
        }

        return $result;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getProfession()
    {
        return $this->profession;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getImageType()
    {
        return $this->imageType;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZip()
    {
        return $this->zip;
    }
}
