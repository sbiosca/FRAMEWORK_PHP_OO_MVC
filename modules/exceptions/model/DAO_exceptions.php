<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'model/config.php');
class DAO_exceptions {

    function insert_error_404() {
        $sql = "INSERT INTO exceptions VALUES ('ERROR 404', '');";
        $connection = connect::conn_bioscar();
        mysqli_query($connection, $sql);
        mysqli_close($connection);
    }

    function insert_error_503() {
        $sql = "INSERT INTO exceptions VALUES ('', 'ERROR 503');";
        $connection = connect::conn_bioscar();
        mysqli_query($connection, $sql);
        mysqli_close($connection);
    }
}

?>