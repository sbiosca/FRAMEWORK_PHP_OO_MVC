<?php
    class db {
        private $server;
        private $user;
        private $password;
        private $database;
        private $link;
        private $stmt;
        private $array;
        static $_instance;

        private function __construct() {
            $this->setConexion();
            $this->connect();
        }
        
        private function setConexion() {
            require_once 'conf.class.singleton.php';
            $conf = Conf::getInstance();
            
            $this->server = $conf->getHostDB();
            $this->database = $conf->getDB();
            $this->user = $conf->getUserDB();
            $this->password = $conf->getPassDB();
        }

        private function __clone() {

        }

        public static function getInstance() {
            if (!(self::$_instance instanceof self))
                self::$_instance = new self();
            return self::$_instance;
        }

        private function connect() {
            $this->link = new mysqli($this->server, $this->user, $this->password);
            $this->link->select_db($this->database);
        }

        public function execute($sql) {
            $this->stmt = $this->link->query($sql);
            return $this->stmt;
        }
        
        public function list($stmt) {
            $this->array = array();
            while ($row = $stmt->fetch_array(MYSQLI_ASSOC)) {
                array_push($this->array, $row);
            }
            return $this->array;
        }

    }
