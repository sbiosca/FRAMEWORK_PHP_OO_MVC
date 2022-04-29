<?php

class ctrl_search {
    function load_type() {
        echo json_encode(common::load_models('search_model', 'get_type'));
    }
    function load_model() {
        echo json_encode(common::load_models('search_model', 'get_model', $_POST['type']));
    }
    function autocomplete() {
        echo json_encode(common::load_models('search_model', 'get_auto', [$_POST['type'], $_POST['model'], $_POST['complete']]));
    }
    function search() {
        echo json_encode(common::load_models('search_model', 'get_search', $_POST['search']));
    }
}

/*$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'modules/search/model/DAO_search.php');

switch($_GET['op']) {
    case "autocomplete";
        $dao_search = new DAO_search();
        if (!empty($_POST['type']) && empty($_POST['model'])){
            $auto = $dao_search->list_auto_type($_POST['complete'], $_POST['type']);
        }else if(!empty($_POST['type']) && !empty($_POST['model'])){
            $auto = $dao_search->list_auto_type_model($_POST['complete'], $_POST['type'], $_POST['model']);
        }else if(empty($_POST['type']) && !empty($_POST['model'])){
            $auto = $dao_search->list_auto_model($_POST['model'], $_POST['complete']);
        }else {
            $auto = $dao_search->list_autocomplete($_POST['complete']);
        }
        echo json_encode($auto);
        break;
    case "search";
        $dao_search = new DAO_search();
        $search = $dao_search -> list_search($_GET['search']);
        echo json_encode($search);
        break;
}
*/
?>