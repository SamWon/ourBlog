<?php defined('BASE_PATH') or exit('Access Denied');

class DB
{
	private static $INSTANCE;
	private $connection;	
	private $db;

	private function __construct()
	{
		$this->APP = ($APP = FakeGeek::getInstance());
		$host = $APP->config['host'];
		$port = $APP->config['port'];
		$dbName = $APP->config['dbName'];
		$dbUser = $APP->config['dbUser'];
		$dbPwd = $APP->config['dbPwd'];

		$this->connection = new MongoClient('mongodb://' . $host . ':' . $port);
		
		$this->db = $this->connection->selectDB($dbName);
		$this->auth($dbUser, $dbPwd);
	}

	public static function getInstance()
	{
		if(empty(self::$INSTANCE))
			self::$INSTANCE = new DB();
		return self::$INSTANCE;
	}

	public function getDb()
	{
		return $this->db;
	}

	private function auth($usr, $pwd)
	{
		$result = $this->db->authenticate($usr, $pwd);
		if($result['ok'] !== 1)
		{
			throw new FakeException($result['errmsg'], '0');
		}
		return $result['ok'];
	}
	
}
