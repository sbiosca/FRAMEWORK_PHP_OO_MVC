<?php
    require 'autoload.php';

    ob_start();
    session_start();
    
    
    class router {
        private $urimodule;
        private $namemodule;
        private $urifunction;
        static $_instance;

        public static function getinstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();   
            }
            return self::$_instance;
        }
        
        function __construct() {
            if (isset($_GET['modules'])) {
                $this -> urimodule = $_GET['modules'];                
            }else {
                $this -> urimodule = 'home';
                
            }
            if (isset($_GET['op'])) {
                $this -> urifunction = ($_GET['op'] === "") ? 'view' : $_GET['op'];
                
            }else {
                $this -> urifunction = 'view';
                
            }            
        }

        function routeStart() {
            try {
                call_user_func(array($this -> loadmodule(), $this -> loadfunction()));
            }catch(Exception $error) {

            }
        }

        private function loadmodule() {
            if (file_exists('resources/modules.xml')) {
                $module = simplexml_load_file('resources/modules.xml');
                foreach ($module as $res) {
                    if (in_array($this -> urimodule, (Array) $res -> uri)) {
                        $path_res = MODULE_PATH . $res -> name . '/ctrl/ctrl_' . (String) $res -> name . '.class.php';
                        if (file_exists($path_res)) {
                            require_once($path_res);
                            $controller_class= 'ctrl_' . (String) $res -> name;
                            $this -> namemodule = (String) $res -> name;
                            return new $controller_class;
                        }
                    }
                }
            }
            throw new Exception('Not module found.');
        }

        private function loadfunction() {
            $path_res = MODULE_PATH . $this -> namemodule . '/resources/function.xml'; 
            if (file_exists($path_res)) {
                $function = simplexml_load_file($path_res);
                foreach ($function as $res) {
                    if (in_array($this -> urifunction, (Array) $res -> uri)) {
                        return (String) $res -> name;
                    }
                }
            }
            throw new Exception('Not Function found.');
        }
    }
    router::getinstance() -> routeStart();
?>