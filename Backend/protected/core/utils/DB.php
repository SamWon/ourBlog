<?php defined('BASE_PATH') or exit('Access Denied');

class DB
{
    
    /*这个类主要负责连接数据库*/
    private static $instance;
    private $db;
    private $hostname;
    private $username;
    private $password;
    private $database;

    private function __construct()
    {
        $this->APP = OurBlog::getInstance();
        $this->hostname  = $this->APP->config['hostname'];
        $this->username  = $this->APP->config['username'];
        $this->password  = $this->APP->config['password'];
        $this->database  = $this->APP->config['database'];
        //self::$instance  = & $this;
    }


    /*连接数据库*/
    public function connectDB()
    {
        $this->db = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if($this->db->connect_errno)
            die("Connected failed: ". $this->db->connect_error);
        return $this->db;
    }

    /* 关闭数据库连接 */ 
    public function closeDB()
    {
        $this->db->close();
    }
    
    /*返回类的实例 */
    public static function getInstance()
    {
        if(empty(self::$instance))
            self::$instance = new DB();
        return self::$instance;
    }
    
}
