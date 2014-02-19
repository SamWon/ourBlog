<?php
    define('BASE_PATH',dirname(__FILE__))
    define('APP_PATH',dirname(__FILE__).'/app') 
    define('SYS_LIB_PATH', dirname(__FILE__).'/lib');
    define('APP_LIB_PATH', APP_PATH.'/lib');
    define('CORE_PATH', dirname(__FILE__).'/core');
    define('CONTROLLER_PATH', APP_PATH.'/controller');
    define('MODEL_PATH', APP_PATH.'/model');
    define('VIEW_PATH', APP_PATH.'/view');
    define('LOG_PATH', APP_PATH.'/error/');

    require dirname(__FILE__).'/system/app.php';//引入系统的驱动器类
    require dirname(__FILE__).'/config/config.php';//引入配置文件

    Application::run($CONFIG);
