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
			// $args[0] -- username $args[1] -- password
			$user = $this -> DAO -> select_user($this->db, $args[0]);
			if (password_verify($args[1],$user[0]['password'])) {
				$jwt = jwt_process::encode($user[0]['username']);
				$this -> DAO -> update_token($this->db, $jwt, $user[0]['email']);
				return json_encode($jwt);
			}else {
				return "error";
			}

		}
		public function get_social_login_BLL($args) {
			// $args[0] -- user $args[1] -- id -- $args[2] avatar
			$user = $this -> DAO -> select_user($this->db, $args[0]);
			if ($user) {
				return json_encode($user[0]['ID']);
			}else {
				$this -> DAO -> insert_social_login($this->db, $args[0], $args[1], $args[2]);
				return json_encode($args[1]);
				
			}

		}
		public function get_register_BLL($args) {
			//$args[0]--username $args[1]--passw  $args[2]--email $args[3]--passw1 $args[4]--avatar
			$email = $this -> DAO -> select_email($this->db, $args[2]);
			if ((!$email) && ($args[1]==$args[3])) {
				$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
				$token = common::generate_token(20);
				$token_uuid = common::generate_token(4);
				$register = $this -> DAO -> insert_user($this->db, $args[0], $args[2], $hashed_pass, $args[4], $token, $token_uuid);
				if ($register) {
					$mesage = [ 'type' => 'validate', 
                                'token' => $token, 
                                'toEmail' => $args[2]];
                	$email = json_decode(mail::send_email($mesage), true);
					//return $email;
					if ($email) {
						return "REGISTRADO";
					} else {
						return "error";
					}
					
				}else {
					return "error";
				}
			}else {
				return "error_mail";
			}
		}
		public function get_verify_email_BLL($args) {
			$email = $this -> DAO -> select_verified_email($this->db, $args);
			if ($email) {
				$new_token = common::generate_token(20);
				$this -> DAO -> update_verified_email($this->db, $args, $new_token);
				return "done";
			}
			return "fail";
		}
		public function get_user_menu_BLL($args) {
			//$jwt = jwt_process::decode($args);
			//$jwt = json_decode($jwt, TRUE);
			return $this -> DAO -> select_data($this->db, $args);
		}
		
		public function get_recover_BLL($args) {
			$email = $this -> DAO -> select_email($this->db, $args);
			$token = common::generate_token(20);
			if ($email) {
				$this -> DAO -> update_recover_password($this->db, $args, $token);
				$mesage = [ 'type' => 'recover', 
                            	'token' => $token, 
                            	'toEmail' => $args];
                $email = json_decode(mail::send_email($mesage), true);
				if ($email) {
					return "DOne!";
				} else {
					return "error";
				}
			}else {
				return "error";
			}
		}
		public function get_token_BLL($args) {
			$token = $this -> DAO -> select_verified_email($this->db, $args);
			if($token){
				return 'verify';
			}else {
				return $token;
			}
		}
		public function get_new_password_BLL($args) {
			$hashed_pass = password_hash($args[1], PASSWORD_DEFAULT, ['cost' => 12]);
			$new_token = common::generate_token(20);
			$passwd = $this -> DAO -> update_new_passwd($this->db, $args[0], $hashed_pass, $new_token);
			if ($passwd) {
				
				return 'done';
			}else {
				return 'error';
			}
		}
		public function get_activity_BLL() {
			if (!isset($_SESSION["tiempo"])) {
				return time() - $_SESSION["tiempo"];
				return "inactivo";
			} else {
				if ((time() - $_SESSION["tiempo"]) >= 1800) {  // 1800 segundos - 30 minutos fuera
					//echo time() - $_SESSION["tiempo"];
					return "inactivo";
					exit;
				} else {
					return time() - $_SESSION["tiempo"];
					return "activo";
					exit;
				}
			}
		}
		public function get_control_BLL() {
			if (!isset ($_SESSION['type'])||($_SESSION['type'])!='admin'){
				if(isset ($_SESSION['type'])&&($_SESSION['type'])!='admin'){
					return 'type';
				}else {
				return '!type';
				}
				
			}
		}
		public function get_refresh_BLL($args) {
			$token = jwt_process::encode($args);
			return $token;

		}
	}
?>