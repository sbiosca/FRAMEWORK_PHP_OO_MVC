<?php
    class search_model {
        private $BLL;
        static $_instance;
        
        function __construct() {
            $this -> BLL = search_BLL::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_type() {
            return $this -> BLL -> get_type_BLL();
        }
        public function get_model($args) {
            return $this -> BLL -> get_model_BLL($args);
        }
        public function get_auto($args) {
            return $this -> BLL -> get_auto_BLL($args);
        }
        public function get_search($args) {
            return $this -> BLL -> get_search_BLL($args);
        }
      
    }
?>