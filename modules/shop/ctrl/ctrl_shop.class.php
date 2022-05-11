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
    function read_likes() {
        echo json_encode(common::load_models('shop_model', 'get_read_likes', [$_POST['id'], $_POST['user']]));
    }
    function load_likes() {
        echo json_encode(common::load_models('shop_model', 'get_load_likes', [$_POST['id'], $_POST['user']]));
    }


}

?>