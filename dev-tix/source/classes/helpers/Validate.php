<?php

class Validate
{
    private static array $response;

    private const PATTERNS = [
        'only_letters' => '#[^a-zA-Z]#',
        'no_symbols' => '#[^a-zA-Z0-9]#'
    ];

    public static function getResponse()
    {
        return self::$response;
    }

    public static function validateInputs(array $data, array $rules)
    {
        foreach ($data as $key => $value) {
            if (isset($rules[$key])) {
                $keyRules = $rules[$key];
                $dataType = $keyRules['type'];

                if ($dataType === 'email') {  // Validate emails.
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return self::$response = self::buildErrorResponse($key, 'email', $keyRules);
                    }

                    continue;
                }

                if ($dataType === 'num') {  // Validate numbers.
                    ['min' => $min, 'max' => $max] = $keyRules['length'];

                    if (!empty($value)) {
                        if ((int) $value < $min || (int) $value > $max) {  // Validate number size.
                            return self::$response = self::buildErrorResponse($key, 'length', $keyRules, $dataType);
                        }
                    }

                    continue;
                }

                // Validate strings.
                $pattern = self::PATTERNS[$keyRules['pattern']];
                if (preg_match($pattern, $value)) {  // Validate string format.
                    return self::$response = self::buildErrorResponse($key, 'pattern', $keyRules);
                }

                $strLen = strlen($value);
                ['min' => $min, 'max' => $max] = $keyRules['length'];
                if ($strLen < $min || $strLen > $max) {  // Validate string length.
                    return self::$response = self::buildErrorResponse($key, 'length', $keyRules);
                }
            }
        }

        return [];
    }

    private static function buildErrorResponse(string $name, string $key, array $rules, string $dataType = 'str')
    {
        $ruleValues = $rules[$key];
        $capitalized = self::capitalizeName($name);
        $lengthCase = $dataType === 'str' ? 'characters' : 'inclusively';

        return [
            'status' => 'error',
            'response' => [
                'heading' => "Invalid {$capitalized}",
                'message' => match ($key) {
                    'pattern' => match ($ruleValues) {
                        'only_letters' => "{$capitalized} can contain only letters.",
                        'no_symbols' => "{$capitalized} cannot contain special characters."
                    },
                    'length' => "{$capitalized} must be between {$ruleValues['min']} & {$ruleValues['max']} {$lengthCase}.",
                    'email' => "{$capitalized} is of the wrong format."
                }
            ]
        ];
    }

    private static function capitalizeName(string $name)
    {
        if (str_contains($name, '_')) {
            return implode(' ', array_map(
                function ($part) {
                    return ucfirst($part);
                }, explode('_', $name)
            ));
        }

        return ucfirst($name);
    }
}
