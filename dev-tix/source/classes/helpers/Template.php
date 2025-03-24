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
        if (preg_match('#[-]#', $page)) {
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
     * Render page-related CSS file.
     * @param string $page - name of page.
     * @return string - file if true; nothing if false.
     */
    public static function buildPageStyleSheet(string $page)
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

    public static function buildPagePartialStyleSheets(string $page)
    {
        $filePath = SERVER_PATH . '/core/assets/json/dependencies.json';
        $dependencies = Encode::fromJSON(file_get_contents($filePath));

        $return = '';
        foreach ($dependencies as $dependency) {
            if (array_key_exists($page, $dependency)) {
                $styleSheets = $dependency[$page]['css'];

                if (!empty($styleSheets)) {
                    foreach ($styleSheets as $sheet) {
                        $return .= "
                            <link 
                                rel='stylesheet' 
                                href='" . SERVER_PATH . "/core/assets/{$sheet}.css'
                            >";
                    }
                }
            }
        }

        return $return ?? '<!-- END -->';
    }

    /**
     * Render page-related JS module.
     * @param string $page - name of page.
     * @return string - module if true; message if false.
     */
    public static function buildPageModule(string $page)
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
}
