<?php

class Image
{
    public static function renderTicketPatronImage(User $user)
    {
        if ($user->getImage()) {
            return "
                <div class='div-image-container div-tickets-patron-image-container'>
                    <img src='" . $user->getImage() . "' alt='User Image'>
                </div>
            ";
        }

        return "
            <div class='div-initials-container flex-center'>
                <span>" . $user->getInitials() . '</span>
            </div>
        ';
    }
}
