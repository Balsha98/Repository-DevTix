<?php

class Image
{
    /**
     * Display user image.
     * @param User $user - object of User class.
     * @param string $type - type of image expected.
     * @return string markup - HTML markup of the data.
     */
    public static function renderListItemUserImage(User $user, string $type)
    {
        $userDetails = $user->getDetails();

        if ($userDetails->getImage()) {
            $imageType = $userDetails->getImageType();
            $userID = $user->getId();

            return "
                <div class='div-image-container div-{$type}-user-image-container'>
                    <img src='" . IMAGE_PATH . "/users/{$userID}/user-{$userID}.{$imageType}' alt='User Image'>
                </div>
            ";
        }

        return "
            <div class='div-initials-container flex-center'>
                <span>{$user->getInitials()}</span>
            </div>
        ";
    }

    /**
     * Saving copies of user images locally.
     * @param int $userID - user id.
     * @param string $imageName - image file name.
     * @param string $image - image data.
     * @return void saves the image locally.
     */
    public static function saveUserProfileImage(int $userID, string $imageName, string $image)
    {
        // Set image file related data.
        $imageRoot = ROOT_PATH . '/core/assets/media/images/users/' . $userID;
        $imageFullPath = $imageRoot . '/' . $imageName;

        // Check if folder exists: create once.
        if (!file_exists($imageRoot)) {
            mkdir($imageRoot);
        }

        // Rewrite image each time: it might change.
        file_put_contents($imageFullPath, base64_decode($image));
    }

    /**
     * Save copies of ticket images locally.
     * @param int $requestID - request id.
     * @param string $imageName - image file name.
     * @param string $image - image data.
     * @return void saves the image locally.
     */
    public static function saveTicketSnippetImage(int $requestID, string $imageName, string $image)
    {
        // Set image file related data.
        $imageRoot = ROOT_PATH . '/core/assets/media/images/requests/' . $requestID;
        $imageFullPath = $imageRoot . '/' . $imageName;

        // Check folder structure.
        if (!file_exists($imageFullPath)) {
            if (!file_exists($imageRoot)) {
                mkdir($imageRoot);
            }

            file_put_contents($imageFullPath, base64_decode($image));
        }
    }
}
