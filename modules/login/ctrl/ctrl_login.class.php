<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'modules/login/model/DAO_login.php');
include_once($path . 'modules/login/model/validator_register.php');
include_once ($path . 'views/inc/jwt.php');
@session_start();

switch($_GET['op']) {
    case "list_login";
        if ($_GET['log']==='0') {
            include_once("modules/login/view/login.html");
            echo json_encode("login");
        }else{
            include_once("modules/login/view/login.html");
        }
        break;
    case "list_register";
        include_once("modules/login/view/register.html");
        break;

    case "logout";
        $_SESSION['type'] = "";
        echo json_encode('Done');
        break;
    case "login";
        $dao_login = new DAO_login();
        $user = $dao_login -> select_user($_POST['username']);

        //$jwt = parse_ini_file("model/jwt.ini");
        //$header = $jwt['header'];
        //$secret = $jwt['secret'];
        
        $header = '{"typ":"JWT", "alg":"HS256"}';
        $secret = 'maytheforcebewithyou';
        $payload = '{"iat":"'.time().'",
                    "exp":"'.time().'",
                    "name":"'.$user["username"].'"}';

        if (password_verify($_POST['password'],$user['password'])) {
            $JWT = new JWT;
            $token = $JWT->encode($header, $payload, $secret);
            $_SESSION['type'] = $user['type'];
            echo json_encode($token);
            exit;
        }else {
            echo json_encode("error");
            exit;
        }
           
        break;
    
    case "register";
        $validar = validate($_POST['email']);
        $validar1 = validate_passw($_POST['password'],$_POST['password1']); 
        if (($validar) && ($validar1)){ 
            $dao_login = new DAO_login();
            $user = $dao_login -> insert_user($_POST['username'], $_POST['email'], $_POST['password'], $_POST['avatar']);
            
            if ($user) {
            echo json_encode("USUARIO_REGISTER");
            }
            else {
                echo json_encode("erroruser");
            }
            
        }else if (($validar) && (!$validar1)) { 
            echo json_encode("errorpassw");
            exit;
        }else if ((!$validar) && ($validar1)) {
            echo json_encode("errormail");
        }else {
            echo json_encode('error');
        }
        break;
    
    case "user_menu";
        //$jwt = parse_ini_file("jwt.ini");
        //$secret = $jwt['secret'];
        $secret = 'maytheforcebewithyou';
        $token = $_POST['token'];

        $JWT = new JWT;
        $json = $JWT->decode($token, $secret);
        $json = json_decode($json, TRUE);

        $dao_login = new DAO_login();
        $user = $dao_login -> select_data($json['name']);
        echo json_encode($user);
        break;

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
}
?>