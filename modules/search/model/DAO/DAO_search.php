<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'model/config.php');

class DAO_search {

    function list_type() {
        $sql = " SELECT type_name
        FROM type ";
        $connection = connect::conn_bioscar();
        $type = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $typesearch = array();
        foreach ($type as $row) {
            array_push($typesearch, $row);
        }
        return $typesearch;
    }

    function list_model() {
        $sql = " SELECT model_name
        FROM model ";
        $connection = connect::conn_bioscar();
        $model = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $modelsearch = array();
        foreach ($model as $row) {
            array_push($modelsearch, $row);
        }

        return $modelsearch;
    }

    function list_type_model($type) {
        $sql = " SELECT DISTINCT m.model_name
        FROM model m
        INNER JOIN cars c
        ON c.cod_model = m.cod_model
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        WHERE  t.type_name='$type'";
        $connection = connect::conn_bioscar();
        $type_model = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $type_modelsearch = array();
        foreach ($type_model as $row) {
            array_push($type_modelsearch, $row);
        }

        return $type_modelsearch;
    }

    function list_autocomplete($complete) {
        $sql = " SELECT city
        FROM cars
        WHERE city LIKE '$complete%'";
        $connection = connect::conn_bioscar();
        $auto = mysqli_query($connection, $sql);
        mysqli_close($connection);
    
        $autosearch = array();
        foreach ($auto as $row) {
            array_push($autosearch, $row);
        }
        return $autosearch;
    }

    function list_auto_type($complete, $type) {
        $sql = " SELECT c.city
        FROM cars c
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        WHERE t.type_name = '$type'
        AND c.city LIKE '$complete%'";
        $connection = connect::conn_bioscar();
        $auto_type = mysqli_query($connection, $sql);
        mysqli_close($connection);
    
        $autosearch = array();
        foreach ($auto_type as $row) {
            array_push($autosearch, $row);
        }

        return $autosearch;

    }

    function list_auto_type_model($complete, $type, $model) {
        $sql = " SELECT c.city
        FROM cars c
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON c.cod_model = m.cod_model
        WHERE t.type_name = '$type'
        AND m.model_name = '$model'
        AND c.city LIKE '$complete%' ";
        $connection = connect::conn_bioscar();
        $auto_type_model = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $autosearch = array();
        foreach ($auto_type_model as $row) {
            array_push($autosearch, $row);
        }

        return $autosearch;
        
    }
    
    function list_auto_model($model, $complete) {
        $sql = " SELECT c.city
        FROM cars c
        INNER JOIN model m
        ON c.cod_model = m.cod_model
        WHERE m.model_name = '$model'
        AND c.city LIKE '$complete%' ";
        $connection = connect::conn_bioscar();
        $auto_model = mysqli_query($connection, $sql);
        mysqli_close($connection);
    
        $autosearch = array();
        foreach ($auto_model as $row) {
            array_push($autosearch, $row);
        }

        return $autosearch;
        
    }

    function list_search($search) {
        $sql = " SELECT m.model_name,  b.brand_name, c.exchange, c.color,  c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lat, c.lon
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        $search";
        $connection = connect::conn_bioscar();
        $filt = mysqli_query($connection, $sql);
        mysqli_close($connection);
        
        $shoppage = array();
            foreach ($filt as $row) {
                array_push($shoppage, $row);
            }

        return $shoppage;
        
    }
}

?>