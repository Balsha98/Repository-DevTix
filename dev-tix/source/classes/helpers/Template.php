<?php

class Template
{
    /**
     * Set page title.
     * @param string $page - name of page.
     * @return string - formatted title.
     */
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

    /**
     * Render page-related JS module.
     * @param string $page - name of page.
     * @return string - module if true; message if false.
     */
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

        return $return ?? '<!-- END -->';
    }

    /**
     * Render page-related CSS file.
     * @param string $page - name of page.
     * @return string - file if true; nothing if false.
     */
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
