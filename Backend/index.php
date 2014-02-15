<?php
    /*
     *-----configure of some constants -----
     *$domain: website domain
     *$protected: source code path
     *ALL THE PATHS HAVE NO SLASH TRAILLING
     *
     */
$domain = "http://www.o.com";
$protected = "/protected";

define('BASE_PATH', pathinfo(__FILE__, PATHINFO_DIRNAME).$protected);
if( !is_dir(BASEPATH)) exit('Protected path not found');

define('APP_PATH', BASEPATH.'/app');
define('CORE_PATH', BASEPATH.'/core');
define('LIB_PATH', BASEPATH.'/lib');
define('CONFIG_PATH', BASEPATH.'/config');
define('BASE_URL', $domain.'/index.php');
define('DOMAIN_URL', $domain);

require_once CORE_PATH.'/OurBlog.php';

OurBlog::getInstance()->run();
