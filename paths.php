<?php
    //PROJECT
    define('PROJECT', '/FRAMEWORK_PHP_OO_MVC/');
    
    //ROOT_PROJECT
    define('SITE_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . PROJECT);

    //SITE_PATH
    define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . PROJECT);

    //PRODUCTION
    define('PRODUCTION', true);

    //MODEL
    define('MODEL_PATH', SITE_DOC_ROOT . 'model/');

    //MODULES
    define('MODULE_PATH', SITE_DOC_ROOT . 'modules/');

    //RESOURCES
    define('RESOURCES', SITE_DOC_ROOT . 'resources/');

    //UTILS
    define('UTILS', SITE_DOC_ROOT . 'utils/');
    
    //LOAD_VIEW_INC
    define('VIEW_INC', SITE_DOC_ROOT . 'views/inc/');

    //LOAD_VIEW_JS
    define('VIEW_JS', SITE_DOC_ROOT . 'views/js/');

    //LOAD_VIEW_CSS
    define('VIEW_CSS', SITE_DOC_ROOT . 'views/css/');

    //LOAD_VIEW_IMG
    define('VIEW_IMG', SITE_DOC_ROOT . 'views/images/');

    //LOAD_VIEW_LANG
    define('VIEW_LANG', SITE_DOC_ROOT . 'views/lang/');

    //MODEL_HOME
    define('UTILS_HOME', SITE_DOC_ROOT . 'modules/home/utils/');
    define('DAO_HOME', SITE_DOC_ROOT . 'modules/home/model/DAO/');
    define('BLL_HOME', SITE_DOC_ROOT . 'modules/home/model/BLL/');
    define('MODEL_HOME', SITE_DOC_ROOT . 'modules/home/model/model/');
    define('JS_VIEW_HOME', SITE_PATH . 'modules/home/view/js/');
    define ('VIEW_PATH_HOME', SITE_DOC_ROOT . 'modules/home/view/');

    //MODEL_SHOP
    define('UTILS_SHOP', SITE_DOC_ROOT . 'modules/shop/utils/');
    define('DAO_SHOP', SITE_DOC_ROOT . 'modules/shop/model/DAO/');
    define('BLL_SHOP', SITE_DOC_ROOT . 'modules/shop/model/BLL/');
    define('MODEL_SHOP', SITE_DOC_ROOT . 'modules/shop/model/model/');
    define('JS_VIEW_SHOP', SITE_PATH . 'modules/shop/view/js/');
    define ('VIEW_PATH_SHOP', SITE_DOC_ROOT . 'modules/shop/view/');

    //MODEL_LOGIN
    define('UTILS_LOGIN', SITE_DOC_ROOT . 'modules/login/utils/');
    define('DAO_LOGIN', SITE_DOC_ROOT . 'modules/login/model/DAO/');
    define('BLL_LOGIN', SITE_DOC_ROOT . 'modules/login/model/BLL/');
    define('MODEL_LOGIN', SITE_DOC_ROOT . 'modules/login/model/model/');
    define('JS_VIEW_LOGIN', SITE_PATH . 'modules/login/view/js/');
    define ('VIEW_PATH_LOGIN', SITE_DOC_ROOT . 'modules/login/view/');

    //MODEL_SEARCH
    define('UTILS_SEARCH', SITE_DOC_ROOT . 'modules/search/utils/');
    define('DAO_SEARCH', SITE_DOC_ROOT . 'modules/search/model/DAO/');
    define('BLL_SEARCH', SITE_DOC_ROOT . 'modules/search/model/BLL/');
    define('MODEL_SEARCH', SITE_DOC_ROOT . 'modules/search/model/model/');
    define('JS_VIEW_SEARCH', SITE_PATH . 'modules/search/view/js/');

    //MODEL_CONTACT
    define('MODEL_CONTACT', SITE_DOC_ROOT . 'modules/contact/model/model/');
    define('JS_VIEW_CONTACT', SITE_PATH . 'modules/contact/view/js/');
    define ('VIEW_PATH_CONTACT', SITE_DOC_ROOT . 'modules/contact/view/');



?>