<?php

class Encode
{
    public static function toJSON(array $data)
    {
        return json_encode($data);
    }

    public static function fromJSON(string $json, bool $isAssoc = true)
    {
        return json_decode($json, $isAssoc);
    }
}
