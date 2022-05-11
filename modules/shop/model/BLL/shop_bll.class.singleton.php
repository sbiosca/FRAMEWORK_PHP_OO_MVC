<?php
 
	class shop_BLL {
		private $DAO;
		private $db;
		static $_instance;

		function __construct() {
			$this -> DAO = shop_DAO::getInstance();
			$this-> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_filters_BLL() {
			return $this -> DAO -> filters($this->db);
		}
		public function get_cars_BLL($args) {
			return $this -> DAO -> list_all_cars($this->db, $args[0], $args[1]);
		}
		public function get_pagi_BLL() {
			return $this -> DAO -> count_pagination($this->db);
		}
		public function get_onecar_BLL($args) {
			return $this -> DAO -> list_one_car($this->db, $args);
		}
		public function get_more_BLL($args) {
			return $this -> DAO -> more_cars($this->db, $args[0], $args[1], $args[2]);
		}
		public function get_count_BLL($args) {
			return $this -> DAO -> load_count($this->db, $args);
		}
		public function get_load_filter_BLL($args) {
			return $this -> DAO -> load_filters($this->db, $args);
		}
		public function get_count_filter_BLL($args) {
			return $this -> DAO -> count_filters($this->db, $args);
		}
		public function get_read_likes_BLL($args) {
			$jwt = jwt_process::decode($args[1]);
			$jwt = json_decode($jwt, TRUE);
			return $this -> DAO -> read_likes($this->db, $jwt['name'], $args[0]);
		}
		public function get_load_likes_BLL($args) {
			$jwt = jwt_process::decode($args[1]);
			$jwt = json_decode($jwt, TRUE);
			$likes = $this -> DAO -> count_likes($this->db, $jwt['name'], $args[0]);
			
			if ($likes) {
				$this -> DAO -> dislike($this->db, $jwt['name'], $args[0]);
				return "DISLIKE";
			}else {
				$this -> DAO -> like($this->db, $jwt['name'], $args[0]);
				return "LIKE";
			}
		}
	}
?>