<?php
    class login_model {
        private $BLL;
        static $_instance;
        
        function __construct() {
            $this -> BLL = login_BLL::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_login($args) {
            return $this -> BLL -> get_login_BLL($args);
        }
        public function get_register($args) {
            return $this -> BLL -> get_register_BLL($args);
        }
        public function get_verify_email($args) {
            return $this -> BLL -> get_verify_email_BLL($args);
        }
        public function get_user_menu($args) {
            return $this -> BLL -> get_user_menu_BLL($args);
        }
    }
?>