<?php

class UserDetails
{
    // Attributes.
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

    /**
     * Class constructor.
     * @param int $userID - user id.
     * @param Database $database - database object.
     */
    public function __construct(int $userID, Database $database)
    {
        $this->userID = $userID;
        $this->database = $database;

        $this->getDetailsData();
    }

    /**
     * Get user-related details data.
     * @return array data - user details data.
     */
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

    /**
     * Get details id.
     * @return int $id - details id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get user id.
     * @return int $userID - user id.
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Get user bio.
     * @return string $bio - user bio.
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Get user age.
     * @return int $age - user age.
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Get user gender.
     * @return string $gender - user gender.
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get user profession.
     * @return string $profession - user profession.
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Get user image.
     * @return string $image - user image.
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get image type.
     * @return string $imageType - image type.
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /**
     * Get country name.
     * @return string $country - country name.
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get city name.
     * @return string $city - city name.
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get zip code.
     * @return string $zip - zip code.
     */
    public function getZip()
    {
        return $this->zip;
    }
}
