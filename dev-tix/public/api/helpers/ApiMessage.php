<?php

class ApiMessage
{
    // ***** INVALID API ACCESS ***** //

    public static function apiError(string $type)
    {
        return ['error' => match ($type) {
            'route' => 'Invalid API route.',
            'input' => "Input data can't be empty.",
            'id' => 'Record ID not specified.'
        }];
    }

    // ***** USER AUTHENTICATION (LOGIN & SIGNUP) ***** //

    public static function authAttempt(array $data, bool $isValid, string $redirect = 'this')
    {
        return [
            'status' => $isValid ? 'success' : 'error',
            'response' => [
                'heading' => ($isValid ? 'Successfull ' : 'Unsuccessful ') . ucfirst($data['page']),
                'message' => $isValid ? "Your {$data['page']} was successful!" : 'Invalid credentials provided.'
            ],
            'redirect' => $redirect
        ];
    }

    public static function authAccountError(array $data, string $issue)
    {
        return [
            'status' => 'error',
            'response' => [
                'heading' => 'Unsuccessful ' . ucfirst($data['page']),
                'message' => match ($issue) {
                    'register' => "You don't have a registered account.",
                    'unique' => 'The username you chose is already taken.'
                }
            ]
        ];
    }

    // ***** TICKET REQUESTS & RESPONSES ***** //

    public static function ticketsFetchAttempt(array $data)
    {
        $isEmpty = empty($data);

        return [
            'status' => $isEmpty ? 'error' : 'success',
            'response' => [
                'message' => 'Data retrieval was ' . ($isEmpty ? 'unsuccessful' : 'successful') . '.',
                'data' => $data
            ]
        ];
    }
}
