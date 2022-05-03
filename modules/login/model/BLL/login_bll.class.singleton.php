<?php
   
	class login_BLL {
		private $DAO;
		private $db;
		static $_instance;

		function __construct() {
			$this -> DAO = login_DAO::getInstance();
			$this-> db = db::getInstance();
		}

		public static function getInstance() {
			if (!(self::$_instance instanceof self)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function get_login_BLL($args) {
			$user = $this -> DAO -> select_user($this->db, $args[0]);
			if (password_verify($user[0]['password'],$args[1])) {
				$jwt = jwt::encode($user[0]['username']);
				$this -> dao -> update_token($this->db, $jwt, $user[0]['email']);
				return json_encode($jwt);
			}else {
				return "error";
			}

		}
		public function get_register_BLL($args) {
			//$args[0]--username $args[1]--passw  $args[2]--email $args[3]--passw1 $args[4]--avatar
			$email = $this -> DAO -> select_email($this->db, $args[2]);
			if (($email) && ($args[1]==$args[3])) {
				$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
				$token = common::generate_token(20);
				$token_uuid = common::generate_token(4);
				$register = $this -> dao -> insert_user($this->db, $args[0], $args[2], $hashed_pass, $args[4], $token, $token_uuid);
				if ($register) {
					/*$mesage = [ 'type' => 'validate', 
                                'token' => $token, 
                                'toEmail' => $args[2]];
                	$email = json_decode(mail::send_email($mesage), true);*/
				}else {
					return "error";
				}
			}else {
				return "error";
			}
		}
		public function get_verify_email_BLL($args) {
			$email = $this -> DAO -> select_verified_email($this->db, $args);
			if ($email) {
				$new_token = common::generate_token(20);
				$this -> dao -> update_verified_email($this->db, $args, $new_token);
			}
		}
	}
?>