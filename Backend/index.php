<?php
    /*
     *-----configure of some constants -----
     *$domain: website domain
     *$protected: source code path
     *ALL THE PATHS HAVE NO SLASH TRAILLING
     *
     */
$domain = "http://www.our.com";
$protected = "/protected";

define('BASE_PATH', pathinfo(__FILE__, PATHINFO_DIRNAME).$protected);
if( !is_dir(BASE_PATH)) exit('Protected path not found');

//define('FRONT_PATH', dirname(__FILE__));
define('APP_PATH', BASE_PATH.'/app');
define('CORE_PATH', BASE_PATH.'/core');
define('LIB_PATH', BASE_PATH.'/lib');
define('CONFIG_PATH', BASE_PATH.'/config');
define('BASE_URL', $domain.'/index.php');
define('DOMAIN_URL', $domain);

require_once CORE_PATH.'/OurBlog.php';

OurBlog::getInstance()->run();
