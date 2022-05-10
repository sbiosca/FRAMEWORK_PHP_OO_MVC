<?php
class jwt_process {
    public static function encode($user) {
        $jwt = parse_ini_file(UTILS . "jwt.ini");
        $header = $jwt['header'];
        $secret = $jwt['secret'];
        $payload = json_encode(['iat' => time(), 'exp' => time() , 'name' => $user]);
        $JWT = new JWT();
        return $JWT -> encode($header, $payload, $secret);
    }

    public static function decode($token) {
        $jwt = parse_ini_file(UTILS . "jwt.ini");
        $JWT = new JWT();
        return $JWT -> decode($token, $jwt['secret']);
    }
}
?>