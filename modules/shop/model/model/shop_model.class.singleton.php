<?php

    class shop_model {
        private $BLL;
        static $_instance;
        
        function __construct() {
            $this -> BLL = shop_BLL::getInstance();
        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function get_filters() {
            return $this -> BLL -> get_filters_BLL();
        }
        public function get_cars($args) {
            return $this -> BLL -> get_cars_BLL($args);
        }
        public function get_pagi() {
            return $this -> BLL -> get_pagi_BLL();
        }
        public function get_onecar($args) {
            return $this -> BLL -> get_onecar_BLL($args);
        }
        public function get_more($args) {
            return $this -> BLL -> get_more_BLL($args);
        }
        public function get_count($args) {
            return $this -> BLL -> get_count_BLL($args);
        }
        public function get_load_filter($args) {
            return $this -> BLL -> get_load_filter_BLL($args);
        }
        public function get_count_filter($args) {
            return $this -> BLL -> get_count_filter_BLL($args);
        }
        public function get_read_likes($args) {
            return $this -> BLL -> get_read_likes_BLL($args);
        }
        public function get_load_likes($args) {
            return $this -> BLL -> get_load_likes_BLL($args);
        }
    }
?>