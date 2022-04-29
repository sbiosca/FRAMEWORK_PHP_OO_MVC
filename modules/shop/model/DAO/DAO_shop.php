<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'model/config.php');
class DAO_shop {
    function list_all_cars($items, $total) {
        $sql = " SELECT m.model_name, b.brand_name, c.exchange, c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lon, c.lat, b.brand_img
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        ORDER BY  c.count DESC
        LIMIT $items, $total";
        $connection = connect::conn_bioscar();
        $shop = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
        foreach ($shop as $row) {
            array_push($shoppage, $row);
        }
        return $shoppage;
    }
    function list_one_car($id) {
        $sql = "SELECT m.model_name, b.brand_name, c.exchange, c.enrolment, c.color, t.type_name, c.km, ca.category_name, c.car_img, c.price, c.doors, c.city, c.lon, c.lat, b.brand_img, i.img
        FROM cars c
        INNER JOIN img_cars i
        ON i.cod_model = c.cod_model
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        WHERE c.enrolment='$id'";
        $connection = connect::conn_bioscar();
        $shop = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($shop as $row) {
                array_push($shoppage, $row);
        }
        return $shoppage;
    }
    function list_one_car_like($id) {
        $sql = "SELECT m.model_name, b.brand_name, c.exchange, c.enrolment, c.color, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.doors, c.city, c.lon, c.lat, b.brand_img, i.img
        FROM cars c
        INNER JOIN img_cars i
        ON i.cod_model = c.cod_model
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        INNER JOIN likes l
        ON l.enrolment = c.enrolment
        WHERE c.enrolment='$id'";
        $connection = connect::conn_bioscar();
        $shop = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($shop as $row) {
                array_push($shoppage, $row);
        }
        return $shoppage;
    }
    function filters() {
        $sql = " SELECT b.brand_name, m.model_name, c.exchange, c.color,  c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lon, c.lat
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        RIGHT JOIN brand b
        ON b.cod_brand = m.cod_brand";
        $connection = connect::conn_bioscar();
        $filt = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($filt as $row) {
                array_push($shoppage, $row);
            }
        return $shoppage;
    }
    function load_filters($search) {
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
    function load_count($id) {
        $sql = "UPDATE cars
        SET count = 1 + count
        WHERE enrolment= '$id'";
        $connection = connect::conn_bioscar();
        mysqli_query($connection, $sql);
        mysqli_close($connection);
    }
    function count_pagination(){
        $sql = "SELECT COUNT(*) AS cars FROM cars";
        $connection = connect::conn_bioscar();
        $pag = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($pag as $row) {
                array_push($shoppage, $row);
            }
        return $shoppage;
    }
    function count_filters($filters){
        $sql = "SELECT COUNT(*) AS cars 
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        $filters";
        $connection = connect::conn_bioscar();
        $filt = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($filt as $row) {
                array_push($shoppage, $row);
            }
        return $shoppage;
    }
    function more_cars($category, $type, $car){
        $sql = "SELECT m.model_name, b.brand_name, c.exchange, c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lon, c.lat, b.brand_img
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        INNER JOIN brand b
        ON b.cod_brand = m.cod_brand
        WHERE ca.category_name LIKE '%$category%'
        AND t.type_name LIKE '%$type%'
        AND c.enrolment <> '$car'";
        $connection = connect::conn_bioscar();
        $car = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $shoppage = array();
            foreach ($car as $row) {
                array_push($shoppage, $row);
            }
        return $shoppage;
    }

    function like_car($user,$id) {
        $sql = "INSERT INTO likes 
        (username, enrolment) 
        VALUES ('$user', '$id')";
        $connection = connect::conn_bioscar();
        $like = mysqli_query($connection, $sql);
        mysqli_close($connection);
        return $like;
    }
    function dislike_car($user,$id) {
        $sql = "DELETE FROM likes
        WHERE username='$user' AND enrolment='$id'";
        $connection = connect::conn_bioscar();
        $like = mysqli_query($connection, $sql);
        mysqli_close($connection);
        return $like;
    }
    function read_likes($user,$id) {
        $sql = "SELECT enrolment,username 
        FROM likes 
        WHERE username='$user' AND enrolment='$id'
        ";
        $connection = connect::conn_bioscar();
        $like = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $likepage = array();
            foreach ($like as $row) {
                array_push($likepage, $row);
            }
        return $likepage;
    }
    function count_likes($user,$id) {
        $sql = "SELECT enrolment,username
        FROM likes
        WHERE enrolment='$id' AND username='$user'
        ";
        $connection = connect::conn_bioscar();
        $like = mysqli_query($connection, $sql)->fetch_object();
        mysqli_close($connection);
        return $like;
    }
}
?>
