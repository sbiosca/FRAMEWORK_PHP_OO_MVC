<?php
    class mail {
        public static function send_email($email) {
            switch ($email['type']) {
                case 'contact';
                    $email['toEmail'] = 'bioscar.soporte@gmail.com';
                    break;
                case 'validate';
                    $email['fromEmail'] = 'bioscar.soporte@gmail.com';
                    $email['inputEmail'] = 'bioscar.soporte@gmail.com';
                    $email['inputMatter'] = 'Email verification';
                    $email['inputMessage'] = 'VERIFICATION';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href = 'http://localhost/FRAMEWORK_PHP_OO_MVC/login/list_login/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['fromEmail'] = 'bioscar.soporte@gmail.com';
                    $email['inputEmail'] = 'bioscar.soporte@gmail.com';
                    $email['inputMatter'] = 'Recover password';
                    $email['inputMessage'] = "<a href = 'http://localhost/FRAMEWORK_PHP_OO_MVC/login/list_login/recover/$email[token]'>Click here for recover your password.</a>";
                    break;
            }
            return self::send_mailgun($email);
        }

        public static function send_mailgun($data){
            $mailgun = parse_ini_file(UTILS . "mailgun.ini");
            $api_key = $mailgun['api_key'];
            $api_url = $mailgun['api_url'];

            $config = array();
            $config['api_key'] = $api_key; //API Key  $api_key
            $config['api_url'] = $api_url; //API Base URL  $api_url
    
            $message = array();
            $message['from'] = $data['fromEmail'];
            $message['to'] = $data['toEmail'];
            $message['h:Reply-To'] = $data['inputEmail'];
            $message['subject'] = $data['inputMatter'];
            $message['html'] = $data['inputMessage'];
         
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $config['api_url']);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_POST, true); 
            curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }


?>