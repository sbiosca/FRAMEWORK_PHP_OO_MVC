<?php
	class search_BLL {
		private $DAO;
		private $db;
		static $_instance;

		function __construct() {
			$this -> DAO = search_DAO::getInstance();
			$this-> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_type_BLL() {
			return $this -> DAO -> list_type($this->db);
		}
		public function get_model_BLL($args) {
			if(empty($args)){
				return $this -> DAO -> list_model($this->db);
			}else{
				return $this -> DAO -> list_type_model($this->db, $args);
			}
		}
		public function get_auto_BLL($args) {
			//complete 2, type 0, model 1
			if (!empty($args[0]) && empty($args[1])){
				return $this -> DAO -> list_auto_type($this->db, $args[2], $args[0]);
				//$auto = $dao_search->list_auto_type($_POST['complete'], $_POST['type']);
			}else if(!empty($args[0]) && !empty($args[1])){
				return $this -> DAO -> list_auto_type_model($this->db, $args[2], $args[0], $args[1]);
				//$auto = $dao_search->list_auto_type_model($_POST['complete'], $_POST['type'], $_POST['model']);
			}else if(empty($args[0]) && !empty($args[1])){
				return $this -> DAO -> list_auto_model($this->db, $args[1], $args[2]);
				//$auto = $dao_search->list_auto_model($_POST['model'], $_POST['complete']);
			}else {
				return $this -> DAO -> list_autocomplete($this->db, $args[2]);
				//$auto = $dao_search->list_autocomplete($_POST['complete']);
			}
		}
		public function get_search_BLL($args) {
			return $this -> DAO -> list_search($this->db, $args);
		}
	}
?>