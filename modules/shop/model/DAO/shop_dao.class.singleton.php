<?php

class shop_DAO {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function filters($db) {
        $sql = "SELECT b.brand_name, m.model_name, c.exchange, c.color,  c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lon, c.lat
        FROM cars c
        INNER JOIN category ca
        ON c.cod_category = ca.cod_category
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON m.cod_model = c.cod_model
        RIGHT JOIN brand b
        ON b.cod_brand = m.cod_brand";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function list_all_cars($db, $items, $total) {
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
        ORDER BY  c.count DESC
        LIMIT $items, $total";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function count_pagination($db) {
        $sql = "SELECT COUNT(*) AS cars FROM cars";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function list_one_car($db, $id) {
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
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function more_cars($db, $categ, $type, $car) {
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
        WHERE ca.category_name LIKE '%$categ%'
        AND t.type_name LIKE '%$type%'
        AND c.enrolment <> '$car'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function load_count($db, $id) {
        $sql = "UPDATE cars
        SET count = 1 + count
        WHERE enrolment= '$id'";
        $stmt = $db->execute($sql);
    }

    public function load_filters($db, $search) {
        $sql = "SELECT m.model_name,  b.brand_name, c.exchange, c.color,  c.enrolment, t.type_name, c.km, c.date, ca.category_name, c.car_img, c.price, c.city, c.lat, c.lon
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
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function count_filters($db, $search) {
        $sql = " SELECT COUNT(*) AS cars 
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
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function read_likes($db, $user, $id) {
        $sql = "SELECT enrolment,username 
        FROM likes 
        WHERE username='$user' AND enrolment='$id'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function count_likes($db, $user, $id) {
        $sql = "SELECT enrolment,username
        FROM likes
        WHERE enrolment='$id' AND username='$user'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function like($db, $user, $id) {
        $sql = "INSERT INTO likes 
        (username, enrolment) 
        VALUES ('$user', '$id')";
        $db->execute($sql);
        return "done";
    }
    public function dislike($db, $user, $id) {
        $sql = "DELETE FROM likes
        WHERE username='$user' AND enrolment='$id'";
        $db->execute($sql);
        return "done";
    }
    

}


?>