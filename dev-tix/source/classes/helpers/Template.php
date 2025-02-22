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
            $return = '
                <script src="' . SERVER_PATH . '/core/assets/js/lib/jQuery.js"></script>
                <script type="module" src="' . SERVER_PATH . '/core/assets/js/controllers/' . $page . 'Controller.js"></script>
            ';
        }

        return $return ?? '<!-- NONE -->';
    }
}
