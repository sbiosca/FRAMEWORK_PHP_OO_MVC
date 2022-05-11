<?php

    class ctrl_login {
        function list_login() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'login.html');
        }
        function list_register() {
            common::load_view('top_page_login.php', VIEW_PATH_LOGIN . 'register.html');
        }
        function login() {
            echo json_encode(common::load_models('login_model', 'get_login', [$_POST['username'], $_POST['password']]));
        }
        function social_login() {
            echo json_encode(common::load_models('login_model', 'get_social_login', [$_POST['user'], $_POST['id'], $_POST['avatar']]));
        }
        function register() {
            echo json_encode(common::load_models('login_model', 'get_register', [$_POST['username'], $_POST['password'], $_POST['email'], $_POST['password1'], $_POST['avatar']]));
        }
        function verify_email() {
            echo json_encode(common::load_models('login_model', 'get_verify_email', $_POST['token']));
        }
        function user_menu() {
            echo json_encode(common::load_models('login_model', 'get_user_menu', $_POST['token']));
        }
        function logout() {
            echo json_encode('Done');
        }
        function send_recover_email() {
            echo json_encode(common::load_models('login_model', 'get_recover', $_POST['email']));
        }
        function verify_token() {
            echo json_encode(common::load_models('login_model', 'get_token', $_POST['token']));
        }
        function new_password() {
            echo json_encode(common::load_models('login_model', 'get_new_password', [$_POST['token'], $_POST['passwd']]));
        }
        function activity() {
            echo json_encode(common::load_models('login_model', 'get_activity'));
        }
        function controluser() {
            echo json_encode(common::load_models('login_model', 'get_control'));
        }
        function refresh_token(){
            echo json_encode(common::load_models('login_model', 'get_refresh', $_POST['username']));
        }
        function refresh_cookies() {
            session_regenerate_id();
            $id_refresh=session_id();
            echo json_encode($id_refresh);
        }
    }

?>