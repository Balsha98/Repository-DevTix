<?php
require_once __DIR__ . '/../helpers/Encode.php';

class Autoload
{
    public static function autoloadClassesPerView(string $page)
    {
        $filePath = __DIR__ . '/../../../public/core/assets/json/handler-dependencies.json';
        $dependencies = Encode::fromJSON(file_get_contents($filePath));

        foreach ($dependencies as $dependency) {
            if (array_key_exists($page, $dependency)) {
                $handlers = $dependency[$page]['php'];

                if (!empty($handlers)) {
                    foreach ($handlers as $handler) {
                        require_once __DIR__ . $handler;
                    }
                }
            }
        }
    }
}
