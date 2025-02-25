<?php

class ApiMessage
{
    // ***** INVALID API ACCESS ***** //

    public static function apiError(string $type)
    {
        return ['error' => match ($type) {
            'route' => 'Invalid API route.',
            'input' => 'Record ID not specified.',
            'id' => "Input data can't be empty."
        }];
    }

    // ***** USER AUTHENTICATION (LOGIN & SIGNUP) ***** //

    public static function authAttempt(string $type, bool $isValid)
    {
        return [
            'status' => $isValid ? 'success' : 'error',
            'response' => [
                'heading' => ($isValid ? 'Successfull ' : 'Unsuccessful ') . ucfirst($type),
                'message' => $isValid ? "Your {$type} was successful!" : 'Invalid credentials provided.'
            ]
        ];
    }

    public static function authAccountIssues(string $type, string $issue)
    {
        return [
            'status' => 'error',
            'response' => [
                'heading' => 'Unsuccessful ' . ucfirst($type),
                'message' => match ($issue) {
                    'register' => "You don't have a registered account.",
                    'unique' => 'The username you chose is already taken.'
                }
            ]
        ];
    }
}
