<?php

class Image
{
    public static function renderTicketUserImage(User $user, string $type)
    {
        $userDetails = $user->getDetails();

        if ($userDetails->getImage()) {
            $imageType = $userDetails->getImageType();

            return "
                <div class='div-image-container div-{$type}-user-image-container'>
                    <img src='" . IMAGE_PATH . "/users/user-{$user->getId()}.{$imageType}' alt='User Image'>
                </div>
            ";
        }

        return "
            <div class='div-initials-container flex-center'>
                <span>{$user->getInitials()}</span>
            </div>
        ";
    }

    public static function saveUserProfileImage(string $imageName, string $image)
    {
        // Set image file related data.
        $imageFullPath = ROOT_PATH . '/core/assets/media/images/' . $imageName;

        // Check folder structure.
        if (!file_exists($imageFullPath)) {
            file_put_contents($imageFullPath, base64_decode($image));
        }
    }

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
