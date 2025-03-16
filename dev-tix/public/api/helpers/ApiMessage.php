<?php

class ApiMessage
{
    // ***** INVALID API ACCESS ***** //

    public static function apiError(string $type)
    {
        return ['error' => match ($type) {
            'route' => 'Invalid API route.',
            'method' => 'Invalid request method.',
            'token' => 'Invalid authorization token.',
            'input' => "Input data can't be empty.",
            'id' => 'Record ID not specified.'
        }];
    }

    // ***** USER AUTHENTICATION (LOGIN & SIGNUP) ***** //

    public static function alertAuthAttempt(array $data, bool $isValid, string $redirect = 'this')
    {
        $script = explode('/', $data['route'])[1];

        return [
            'status' => $isValid ? 'success' : 'error',
            'response' => [
                'heading' => ($isValid ? 'Successful ' : 'Unsuccessful ') . ucfirst($script),
                'message' => $isValid ? "Your {$script} was successful!" : 'Invalid credentials provided.'
            ],
            'redirect' => $redirect
        ];
    }

    public static function alertAuthAccountError(array $data, string $issue)
    {
        $script = explode('/', $data['route'])[1];

        return [
            'status' => 'error',
            'response' => [
                'heading' => 'Unsuccessful ' . ucfirst($script),
                'message' => match ($issue) {
                    'register' => "You don't have a registered account.",
                    'unique' => 'The username you chose is already taken.'
                }
            ]
        ];
    }

    // ***** DATA FETCHING (REQUESTS, RESPONSES, NOTIFICATIONS) ***** //

    public static function dataFetchAttempt(array $data)
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

    public static function alertDataAlterAttempt(bool $isValid, string $redirect = 'this')
    {
        return [
            'status' => $isValid ? 'success' : 'error',
            'response' => [
                'heading' => 'Data Updated ' . ($isValid ? 'Successfully' : 'Unsuccessfully'),
                'message' => match ($isValid) {
                    true => 'Your request was processed successfully.',
                    false => 'Your request could not be processed.'
                }
            ],
            'redirect' => $redirect
        ];
    }
}
