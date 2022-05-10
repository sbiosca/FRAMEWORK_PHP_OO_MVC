<?php

class common {
    
    public static function error() {
        //require_once(top_page)
        //require_once(header)
        //require_once(footer)
        //require_once(error404)
    }

    public static function load_view($top_page, $view) {
        $top_page = VIEW_INC . $top_page;
            if ((file_exists($top_page)) && (file_exists($view))) {
                require_once ($top_page);
                require_once (VIEW_INC . 'header.html');
                require_once ($view);
                //require_once (VIEW_INC . 'footer.html');
            }else {
                self::error();
            }

    }

    public static function load_models($model, $function = null, $args = null) {
        $dir = explode('_', $model);
        $path = constant('MODEL_' . strtoupper($dir[0])) .  $model . '.class.singleton.php';
        if (file_exists($path)) {
            require_once($path);
            if (method_exists($model, $function)) {
                $obj = $model::getInstance();
                if ($args != null) {
                    return call_user_func(array($obj, $function), $args);
                }
                return call_user_func(array($obj, $function));
            }
        }
        throw new Exception("ERROR LOAD_MODEL");
    }

    public static function generate_token($int) {
        if ($int < 4) {
            $int = 4;
        }
        return bin2hex(openssl_random_pseudo_bytes(($int - ($int % 2)) / 2));
        
    }
     
}

?>