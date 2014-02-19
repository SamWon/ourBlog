<?php
/*数据库配置*/
$CONFIG['system']['db'] = array(
    'db_host'         => 'localhost',
    'db_user'         => 'root',
    'db_password'     => 'fuckyou',
    'db_database'     => 'ourblog',
    'db_table_prefix' => 'our'
);

/*类配置文件*/
$CONFIG['system']['lib'] = array(
    'prefix'          =>'my'
);

/*路由配置文件*/
$CONFIG['system']['route'] = array(
    'default_controller' => 'home',
    'default_action'     => 'index',
    'url_type'           => '1'   //1为普通模式，2是斜线模式
);

/*缓存配置文件*/
$CONFIG['system']['cache'] = array(
    'cache_dir'         => 'cache',  //缓存路径，相对于根目录
    'cache_prefix'      => 'cache_', //前缀
    'cache_time'        => '1800',   //默认缓存时间
    'cache_mode'        => '2'     //缓存模式，1为序列化模式，2为保存为可执行文件
);

