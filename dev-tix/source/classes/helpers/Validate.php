<?php

require_once __DIR__ . '/Sanitize.php';

class Validate
{
    private static array $result;

    private const PATTERNS = [
        'only_letters' => '#[^a-zA-Z]#',
        'no_symbols' => '#[^a-zA-Z0-9]#'
    ];

    public static function getValidationResult()
    {
        return self::$result;
    }

    public static function validateInputs(array $data, array $rules)
    {
        foreach ($data as $id => $value) {
            if (isset($rules[$id])) {
                $keyRules = $rules[$id];
                $sanitizedValue = Sanitize::sanitizeString($value);

                // Validate emails.
                if ($keyRules['type'] === 'email') {
                    if (!filter_var($sanitizedValue, FILTER_VALIDATE_EMAIL)) {
                        return self::$result = self::buildErrorResponse(
                            $id, 'email', $keyRules
                        );
                    }

                    continue;
                }

                // Validate numbers.
                if ($keyRules['type'] === 'int') {
                    ['min' => $min, 'max' => $max] = $keyRules['length'];

                    if (!empty($sanitizedValue)) {
                        if ((int) $sanitizedValue < $min || (int) $sanitizedValue > $max) {
                            return self::$result = self::buildErrorResponse(
                                $id, 'length', $keyRules, 'int'
                            );
                        }
                    }

                    continue;
                }

                // Validate string format.
                $pattern = self::PATTERNS[$keyRules['pattern']];
                if (preg_match($pattern, $sanitizedValue)) {
                    return self::$result = self::buildErrorResponse(
                        $id, 'pattern', $keyRules
                    );
                }

                // Validate string length.
                $strLen = strlen($sanitizedValue);
                ['min' => $min, 'max' => $max] = $keyRules['length'];
                if ($strLen < $min || $strLen > $max) {
                    return self::$result = self::buildErrorResponse(
                        $id, 'length', $keyRules
                    );
                }
            }
        }

        return [];
    }

    private static function buildErrorResponse(string $id, string $key, array $rules, string $dataType = 'str')
    {
        $capitalized = self::capitalizeName($id);
        $lengthCase = $dataType === 'str' ? 'characters' : 'inclusively';

        return [
            'status' => 'error',
            'response' => [
                'heading' => "Invalid {$capitalized}",
                'message' => match ($key) {
                    'pattern' => match ($rules[$key]) {
                        'only_letters' => "{$capitalized} can contain only letters.",
                        'no_symbols' => "{$capitalized} cannot contain special characters."
                    },
                    'length' => "{$capitalized} must be between {$rules[$key]['min']} & {$rules[$key]['max']} {$lengthCase}.",
                    'email' => "{$capitalized} is of the wrong format."
                }
            ],
            'input_id' => $id,
        ];
    }

    private static function capitalizeName(string $id)
    {
        if (str_contains($id, '_')) {
            return implode(' ', array_map(
                function ($part) {
                    return ucfirst($part);
                }, explode('_', $id)
            ));
        }

        return ucfirst($id);
    }
}
