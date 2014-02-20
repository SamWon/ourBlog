<?php defined('BASE_PATH') or exit('Access Denied');

class DB
{
    
    private static $Instance;
    private $connection;
    private $db;

    private function __construct()
    {
        $this->APP = OurBlog::getInstance();
        $hostname  = $this->APP->config['hostname'];
        $username  = $this->APP->config['username'];
        $password  = $this->APP->config['password'];
        $database  = $this->APP->config['database'];

    }
}
