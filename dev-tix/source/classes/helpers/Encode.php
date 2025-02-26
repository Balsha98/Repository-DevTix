<?php

class Encode
{
    /**
     * Encode array into JSON.
     * @param array $data - data to be encoded.
     * @return bool|string - false if format is off; JSON in case it's ok.
     */
    public static function toJSON(array $data)
    {
        return json_encode($data);
    }

    /**
     * Decode JSON string.
     * @param string $json - JSON being passed.
     * @param bool $isAssoc - will data be associative.
     * @return mixed - associative data by default.
     */
    public static function fromJSON(string $json, bool $isAssoc = true)
    {
        return json_decode($json, $isAssoc);
    }
}
