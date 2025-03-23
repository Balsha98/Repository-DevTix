<?php

class Date
{
    public static function getTimeAgo(string $datetime)
    {
        $today = new DateTime();
        $past = new DateTime($datetime);

        // Calculate time difference.
        $difference = $today->diff($past);

        return self::setTimeAgo($difference);
    }

    private static function setTimeAgo(DateInterval $difference)
    {
        $properties = [
            'y' => 'Year',
            'm' => 'Month',
            'd' => 'Day',
            'h' => 'Hour',
            'i' => 'Minute',
            's' => 'Second',
        ];

        foreach ($properties as $periodKey => $periodName) {
            $periodValue = $difference->$periodKey;

            if ($periodValue !== 0) {
                $return = "{$periodValue} {$periodName}";

                if ($periodValue !== 1) {
                    $return .= 's';
                }

                break;
            }
        }

        return "{$return} Ago";
    }
}
