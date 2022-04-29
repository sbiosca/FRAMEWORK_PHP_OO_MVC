<?php

    function validate($email){
        $dao = new DAO_login();
        if($dao->select_email($email)){
            $check=false;
        }else {
            $check=true;
        }
        return $check;
    }

    function validate_passw($passw, $passw1){
        if ($passw == $passw1){
            $check=true;
        }else{
            $check=false;
        }
        return $check;
    }

?>