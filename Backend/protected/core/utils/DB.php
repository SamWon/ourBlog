<?php defined('BASE_PATH') or exit('Access Denied');

class DB
{
    
    /*这个类主要负责连接数据库*/
    private static $instance;
    private $conn;
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
        $this->conn = mysql_connect($this->hostname, $this->username, $this->password) or die("DB connection error".mysql_error());
        mysql_select_db($this->database, $this->conn) or die("Cannot choose the database");
    }

    /*返回类的实例 */
    public static function getInstance()
    {
        if(empty($this->instance))
            $this->instance = new DB();
        return $this->instance;
        //return self::$instance;
    }
    
    /* 关闭数据库连接 */ 
    public function closeDB()
    {
        mysql_close($this->conn);
    }
    
}
