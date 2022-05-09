<?php

    class ctrl_login {
        function list_login() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'login.html');
        }
        function list_register() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'register.html');
        }
        function login() {
            echo json_encode(common::load_models('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
        }
        function social_login() {
            echo json_encode(common::load_models('login_model', 'get_social_login', [$_POST['user'], $_POST['id'], $_POST['avatar']]));
        }
        function register() {
            echo json_encode(common::load_models('login_model', 'get_register', [$_POST['username'], $_POST['password'], $_POST['email'], $_POST['password1'], $_POST['avatar']]));
            //echo json_encode(common::load_models('login_model', 'get_register'));
        }
        function verify_email() {
            echo json_encode(common::load_models('login_model', 'get_verify_email', $_POST['token_email']));
        }
        function user_menu() {
            echo json_encode(common::load_models('login_model', 'get_user_menu', $_POST['token']));
        }
        function logout() {
            echo json_encode('Done');
        }
        function send_recover_email() {
            echo json_encode(common::load_models('login_model', 'get_recover', $_POST['email']));
        }
        function verify_token() {
            echo json_encode(common::load_models('login_model', 'get_token', $_POST['token']));
        }
        function new_password() {
            echo json_encode(common::load_models('login_model', 'get_new_password', [$_POST['token'], $_POST['passwd']]));
        }
    }

/*
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'modules/login/model/DAO_login.php');
include_once($path . 'modules/login/model/validator_register.php');
include_once ($path . 'views/inc/jwt.php');
@session_start();

switch($_GET['op']) {
    case "activity";
        if (!isset($_SESSION["tiempo"])) {
            echo time() - $_SESSION["tiempo"];
            echo "inactivo";
        } else {
            if ((time() - $_SESSION["tiempo"]) >= 1800) {  // 1800 segundos - 30 minutos fuera
                //echo time() - $_SESSION["tiempo"];
                echo "inactivo";
                exit;
            } else {
                echo time() - $_SESSION["tiempo"];
                echo "activo";
                exit;
            }
        }
        break;
    
    case "controluser";
    //echo $_SESSION['type'];
        if (!isset ($_SESSION['type'])||($_SESSION['type'])!='admin'){
            if(isset ($_SESSION['type'])&&($_SESSION['type'])!='admin'){
                echo 'type';
                exit;
            }else {
            echo '!type';
            exit;
            }
            
        }
        break;
    
    case "refresh_token";
        //tornar a generar token
        $header = '{"typ":"JWT", "alg":"HS256"}';
        $secret = 'maytheforcebewithyou';
        $payload = '{"iat":"'.time().'",
                    "exp":"'.time().'",
                    "name":"'.$_POST["username"].'"}';
        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        echo json_encode($token);
        break;
    case "refresh_cookies";
        //refrescar cookies
        session_regenerate_id();
        $id_refresh=session_id();
        echo json_encode($id_refresh);
        break;
}*/
?>