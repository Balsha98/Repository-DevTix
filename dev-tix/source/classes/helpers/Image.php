<?php

class Image
{
    public static function renderTicketUserImage(User $user)
    {
        if ($user->getImage()) {
            return "
                <div class='div-image-container div-tickets-user-image-container'>
                    <img src='" . self::encode($user->getImage()) . "' alt='User Image'>
                </div>
            ";
        }

        return "
            <div class='div-initials-container flex-center'>
                <span>" . $user->getInitials() . '</span>
            </div>
        ';
    }

    private static function encode(string $imageBlob)
    {
        return base64_encode($imageBlob);
    }
}
