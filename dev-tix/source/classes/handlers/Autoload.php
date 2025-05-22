<?php
require_once __DIR__ . '/../helpers/Encode.php';

class Autoload
{
    public static function autoloadClassesPerRequest(string $type, string $script)
    {
        $json = $type === 'view' ? 'handler' : 'api';
        $filePath = __DIR__ . '/../../../public/core/assets/json/' . $json . '-dependencies.json';
        $dependencies = Encode::fromJSON(file_get_contents($filePath));

        foreach ($dependencies as $dependency) {
            if (array_key_exists($script, $dependency)) {
                $handlers = $dependency[$script]['php'];

                if (!empty($handlers)) {
                    foreach ($handlers as $handler) {
                        require_once __DIR__ . $handler;
                    }
                }
            }
        }
    }
}
