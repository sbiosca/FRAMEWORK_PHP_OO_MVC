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
?>