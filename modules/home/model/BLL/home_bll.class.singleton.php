<?php
    //require("modules/home/model/DAO/home_dao.class.singleton.php");
    //require("model/db.class.singleton.php");
	class home_BLL {
		private $DAO;
		private $db;
		static $_instance;

		function __construct() {
			$this -> DAO = home_DAO::getInstance();
			$this-> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_carousel_BLL() {
			return $this -> DAO -> list_brands($this->db);
		}

		public function get_categoria_BLL() {
			return $this -> DAO -> list_categ($this->db);
		}

		public function get_type_BLL() {
			return $this -> DAO -> list_type($this->db);
		}

		public function get_load_more_BLL() {
			return $this -> DAO -> load_more($this->db);
		}

	}
?>