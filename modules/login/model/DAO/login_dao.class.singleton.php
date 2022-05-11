<?php

class login_DAO {
    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function select_user($db, $username) {
        $sql = "SELECT * FROM users 
        WHERE username='$username'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }

    public function update_token($db, $token_jwt, $email) {
        $sql = "UPDATE users SET id= '$token_jwt' WHERE email = '$email'";
        $db->execute($sql);
        return "done!";
    }
    public function select_email($db, $email) {
        $sql = "SELECT email FROM users WHERE email='$email'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function insert_user($db, $username, $email, $passw, $avatar, $token, $token_uuid) {
        $sql = "INSERT INTO users (ID, username, password, email, type, avatar, token_email, activate)
        VALUES ('$token_uuid', '$username', '$passw', '$email', 'cliente', '$avatar', '$token', 'false')";
        return $db->execute($sql);
    }
    public function select_verified_email($db, $token) {
        $sql = "SELECT token_email FROM users WHERE token_email = '$token'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function update_verified_email($db, $token, $new_token){
        $sql = "UPDATE users SET activate= 'true', token_email= '$new_token' WHERE token_email = '$token'";
        $db->execute($sql);
        return "done!";
    }
    public function select_data($db, $token) {
        $sql = "SELECT * FROM users 
        WHERE ID='$token'";
        $stmt = $db->execute($sql);
        return $db->list($stmt);
    }
    public function insert_social_login($db, $username, $id, $avatar) {
        $sql = "INSERT INTO users (ID, username, password, email, type, avatar, token_email, activate)
        VALUES ('$id', '$username', '', '$username', 'cliente', '$avatar', '', 'true')";
        return $db->execute($sql);
    }
    public function update_recover_password($db, $email, $token){
        $sql = "UPDATE users SET token_email = '$token' WHERE email = '$email'";
        $db->execute($sql);
        return "done!";
    }
    public function update_new_passwd($db, $token, $password, $new_token){
        $sql = "UPDATE users SET password= '$password', token_email= '$new_token' WHERE token_email = '$token'";
        $db->execute($sql);
        return "done!";
    }
}


?>