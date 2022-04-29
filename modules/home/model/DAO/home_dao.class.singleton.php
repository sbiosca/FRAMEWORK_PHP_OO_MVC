<?php
 //require("model/db.class.singleton.php");
class home_dao {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function list_brands($db) {
        $sql = "SELECT * FROM brand LIMIT 0, 12";
        //$sql = "SELECT * FROM brand LIMIT $loaded, $items";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function list_categ($db) {
        $sql = "SELECT * FROM category";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function list_type($db) {
        $sql = "SELECT * FROM type";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function load_more($db) {
        $sql = "SELECT COUNT(*) AS count FROM brand";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
}


?>