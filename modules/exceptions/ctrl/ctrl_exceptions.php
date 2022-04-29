<?php

$path = $_SERVER['DOCUMENT_ROOT'] . '/BIOSCAR_PHP_OO_MVC_JQUERY/';
include_once($path . 'modules/exceptions/model/DAO_exceptions.php');

switch($_GET['err']) {
    case "404";
        echo "ERROR 404";
        echo "<img src=\"views/images/Error-404.jpg\">";
        $dao_exceptions = new DAO_exceptions();
        $dao_exceptions -> insert_error_404();
        break;
    case "503";
        echo "ERROR 503";
        echo "<img src=\"views/images/Error-503.jpg\">";
        $dao_exceptions = new DAO_exceptions();
        $dao_exceptions -> insert_error_503();
        break;

}


?>

