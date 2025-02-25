<?php

class ApiMessage
{
    // ***** INVALID API ACCESS ***** //

    public static function invalidRoute()
    {
        return ['error' => 'Invalid API route.'];
    }

    public static function invalidId()
    {
        return ['error' => "Record ID isn't specified."];
    }

    public static function invalidData()
    {
        return ['error' => 'Input data cannot be empty.'];
    }

    // ***** USER AUTHENTICATION (LOGIN) ***** //

    public static function attemptedLogin(bool $isValid)
    {
        return [
            'status' => $isValid ? 'success' : 'error',
            'response' => [
                'heading' => ($isValid ? 'Successfull' : 'Unsuccessful') . ' Login',
                'message' => $isValid ? 'Your login was successful!' : 'Invalid credentials provided.'
            ]
        ];
    }

    public static function unregisteredAccount()
    {
        return [
            'status' => 'error',
            'response' => [
                'heading' => 'Unsuccessful Login',
                'message' => "It seems you don't have a registered account."
            ]
        ];
    }

    // ***** USER AUTHENTICATION (SIGNUP) ***** //

    public static function accountNotUnique()
    {
        return [
            'status' => 'error',
            'response' => [
                'heading' => 'Unsuccessful Signup',
                'message' => 'The username you chose is already taken.'
            ]
        ];
    }
}
