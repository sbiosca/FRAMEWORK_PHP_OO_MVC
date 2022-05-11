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
        public function get_social_login($args) {
            return $this -> BLL -> get_social_login_BLL($args);
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
        public function get_recover($args) {
            return $this -> BLL -> get_recover_BLL($args);
        }
        public function get_token($args) {
            return $this -> BLL -> get_token_BLL($args);
        }
        public function get_new_password($args) {
            return $this -> BLL -> get_new_password_BLL($args);
        }
        public function get_activity() {
            return $this -> BLL -> get_activity_BLL();
        }
        public function get_control() {
            return $this -> BLL -> get_control_BLL();
        }
        public function get_refresh($args) {
            return $this -> BLL -> get_refresh_BLL($args);
        }
    }
?>