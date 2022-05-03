<?php

class ctrl_shop {
    function view() {
        common::load_view('top_page_shop.php', VIEW_PATH_SHOP . 'shop.html');
    }
    function filters() {
        echo json_encode(common::load_models('shop_model', 'get_filters'));
    }
    function list_cars() {
        echo json_encode(common::load_models('shop_model', 'get_cars', [$_POST['items'], $_POST['total']]));
    }
    function count_pagination() {
        echo json_encode(common::load_models('shop_model', 'get_pagi'));
    }
    function list_one_cars() {
        echo json_encode(common::load_models('shop_model', 'get_onecar', $_POST['id']));
    }
    function more_related() {
        echo json_encode(common::load_models('shop_model', 'get_more', [$_POST['categ'], $_POST['type'], $_POST['car']]));
    }
    function count() {
        common::load_models('shop_model', 'get_count', $_POST['id']);
    }
    function load_filters() {
        echo json_encode(common::load_models('shop_model', 'get_load_filter', $_POST['search']));
    }
    function count_filters() {
        echo json_encode(common::load_models('shop_model', 'get_count_filter', $_POST['search']));
    }


}

/*
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'modules/shop/model/DAO_shop.php');
include_once ($path . 'views/inc/jwt.php');
@session_start();

if (isset($_SESSION["tiempo"])) {  
    $_SESSION["tiempo"] = time(); //Devuelve la fecha actual
}

switch($_POST['op']) {
    case "read_likes";
        $secret = 'maytheforcebewithyou';
        $token = $_POST['user'];

        $JWT = new JWT;
        $json = $JWT->decode($token, $secret);
        $json = json_decode($json, TRUE);

        $dao_shop = new DAO_shop();
        $like = $dao_shop->read_likes($json['name'],$_POST['id']);
        echo json_encode($like);
        break;
    case "load_likes";
        $secret = 'maytheforcebewithyou';
        $token = $_POST['user'];

        $JWT = new JWT;
        $json = $JWT->decode($token, $secret);
        $json = json_decode($json, TRUE);

        $dao_shop = new DAO_shop();
        $like = $dao_shop->count_likes($json['name'],$_POST['id']);
       
        if ($like) {
            $dao_shop = new DAO_shop();
            $like = $dao_shop->dislike_car($json['name'],$_POST['id']);
            echo json_encode("DISLIKE");
        }else {
            $dao_shop = new DAO_shop();
            $like = $dao_shop->like_car($json['name'],$_POST['id']);
            echo json_encode("LIKE");
        }

        

        //echo json_encode($like);
        break;
}*/
?>