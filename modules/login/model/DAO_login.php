<?php
$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'model/config.php');
class DAO_login {
    function select_user($username) {
        $sql = "SELECT username, password, email, type, avatar FROM users 
            WHERE username='$username'";
        $connection = connect::conn_bioscar();
        $user = mysqli_query($connection, $sql)->fetch_object();
        mysqli_close($connection);
        $value = get_object_vars($user);
        return $value;
    }
    function insert_user($username, $email, $password,$avatar) {
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        //$hashavatar = md5(strtolower(trim($email))); 
        //$avatar = "https://robohash.org/$hashavatar";
        $type = "cliente";
        $sql ="INSERT INTO users (username, password, email, type, avatar)
        VALUES ('$username', '$hashed_pass', '$email', '$type', '$avatar')";

        $connection = connect::conn_bioscar();
        $user = mysqli_query($connection, $sql);
        mysqli_close($connection);
        return $user;
    }
    function select_email($email){
        $sql = "SELECT email FROM users WHERE email='$email'";
        $connection = connect::conn_bioscar();
        $user = mysqli_query($connection, $sql)->fetch_object();
        mysqli_close($connection);
        return $user;
    }
    function select_data($username) {
        $sql = "SELECT username, email, type, avatar FROM users 
            WHERE username='$username'";
        $connection = connect::conn_bioscar();
        $user = mysqli_query($connection, $sql)->fetch_object();
        mysqli_close($connection);
        return $user;
    }

}
?>