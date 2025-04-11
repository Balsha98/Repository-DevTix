<?php

class Date
{
    /**
     * Calculate time age.
     * @param string $datetime - passed timestamp.
     * @return string data - time passed displayed nicely.
     */
    public static function getTimeAgo(string $datetime)
    {
        $today = new DateTime();
        $past = new DateTime($datetime);

        // Calculate time difference.
        $difference = $today->diff($past);

        return self::setTimeAgo($difference);
    }

    /**
     * Set time passed as string.
     * @param DateInterval $difference - calculated difference.
     * @return string data - time passed displayed nicely.
     */
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
