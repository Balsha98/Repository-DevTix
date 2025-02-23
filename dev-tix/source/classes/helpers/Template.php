<?php

class Template
{
    public static function buildTitle(string $page)
    {
        if (str_contains($page, '-')) {
            $page = array_map(function ($part) {
                if ($part !== 'admin') {
                    return ucfirst($part);
                }
            }, explode('-', $page));
        } else {
            $page = ucfirst($page);
        }

        return is_array($page) ? implode(' ', $page) : trim($page);
    }

    public static function buildModuleDependencies(string $page)
    {
        $controller = __DIR__ . "/../../../public/core/assets/js/controllers/{$page}Controller.js";
        if (file_exists($controller)) {
            $return = "
                <script 
                    type='module' 
                    src='" . SERVER_PATH . "/core/assets/js/controllers/{$page}Controller.js'
                ></script>
            ";
        }

        return $return ?? '<!-- NONE -->';
    }

    public static function buildStyleDependencies(string $page)
    {
        $stylesheet = __DIR__ . "/../../../public/core/assets/css/views/{$page}.css";
        if (file_exists($stylesheet)) {
            $return = "
                <link 
                    rel='stylesheet' 
                    href='" . SERVER_PATH . "/core/assets/css/views/{$page}.css'
                >
            ";
        }

        return $return ?? '';
    }
}
