<?php

class search_DAO {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function list_type($db) {
        $sql = "SELECT type_name
        FROM type";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_model($db) {
        $sql = "SELECT model_name
        FROM model";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_type_model($db, $type) {
        $sql = "SELECT DISTINCT m.model_name
        FROM model m
        INNER JOIN cars c
        ON c.cod_model = m.cod_model
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        WHERE  t.type_name='$type'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_auto_type($db, $complete, $type) {
        $sql = "SELECT c.city
        FROM cars c
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        WHERE t.type_name = '$type'
        AND c.city LIKE '$complete%'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_auto_type_model($db, $complete, $type, $model) {
        $sql = "SELECT c.city
        FROM cars c
        INNER JOIN type t
        ON t.cod_type = c.cod_type
        INNER JOIN model m
        ON c.cod_model = m.cod_model
        WHERE t.type_name = '$type'
        AND m.model_name = '$model'
        AND c.city LIKE '$complete%' ";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_auto_model($db, $model, $complete) {
        $sql = "SELECT c.city
        FROM cars c
        INNER JOIN model m
        ON c.cod_model = m.cod_model
        WHERE m.model_name = '$model'
        AND c.city LIKE '$complete%'  ";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function list_autocomplete($db, $complete) {
        $sql = "SELECT city
        FROM cars
        WHERE city LIKE '$complete%'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function list_search($db, $search) {
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
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

}


?>