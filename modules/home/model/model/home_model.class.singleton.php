<?php
    //require("modules/home/model/BLL/home_bll.class.singleton.php");
    class home_model {
        private $BLL;
        static $_instance;
        
        function __construct() {
            $this -> BLL = home_BLL::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_carousel() {
            return $this -> BLL -> get_carousel_BLL();
        }

        public function get_categoria() {
            return $this -> BLL -> get_categoria_BLL();
        }

        public function get_type() {
            return $this -> BLL -> get_type_BLL();
        }

        public function get_load_more() {
            return $this -> BLL -> get_load_more_BLL();
        }

    }
?>