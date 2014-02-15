<?php defined('BASE_PATH') or exit('Access Denied');

require(CORE_PATH . '/utils/URLParser.php');
require(CORE_PATH . '/fakeController.php');
require(CORE_PATH . '/utils/DB.php');
require(CORE_PATH . '/fakeModel.php');
require(CORE_PATH . '/fakeException.php');
require(CORE_PATH . '/LogModel.php');

function p(&$variable, $default = null)
{

	if (isset($variable)) {
        $tmp = $variable;
        if(is_object($variable) && get_class($variable) === 'MongoId')
        	$tmp = $variable->{'$id'};
    } else {
        $tmp = $default;
    }
    echo $tmp;
}

class FakeGeek {
	private static $fakeInstance;
	private $params = array();
	public $config = array(); 
	public $db;
	public $isAjaxRequest = false;
	public $JSONP = null;
	public $isAdmin = false;

	private function __construct()
	{
		$requestURI = $_SERVER['REQUEST_URI'];
 		$parser =  new URLParser($requestURI);
		$this->config = include(CONFIG_PATH . '/config.php');
		$this->params = $parser->parse($this->config);
		$this->isAjaxRequest = call_user_func((function(){
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest')
				return true;
			if(isset($_REQUEST['ajax']))
				return true;
			return false;
		}));
		$this->JSONP = isset($_REQUEST['jsonp']) ? $_REQUEST['jsonp'] : null;
		
	}

	public static function getInstance()
	{
		if(empty(self::$fakeInstance))
			self::$fakeInstance = new FakeGeek();
		return self::$fakeInstance;	
	}

	public function run()
	{
		ob_start();
		try
		{
			$this->db = DB::getInstance()->getDb();
			$this->isAdmin = $this->loginCheck();
			if($this->params['illegal'] == false)
			{
				$this->handleRequest($this->params['className']);
				$this->log("request class {$this->params['className']} with the action {$this->params['action']}", 'log');
			}
			else
			{
				$this->show_404();
			}
		}
		catch(FakeException $e)
		{
			$this->errorHandler($e);
		}
		catch(Exception $e)
		{
			$this->errorHandler($e);
		}
		

	}

	public function show_404()
	{
		header('Status: 404 Not Found', true, '404');
		// require 404 page here;
		echo 'Error: 404 NOT FOUND';
		exit;	
	}

	private function handleRequest($className)
	{
		$this->loadClass(APP_PATH . '/controllers/' . $className . '.php');
		$class = new $className();
		$method = $this->params['action'];
		call_user_func_array(array($class, $method), $this->params['params']);
	}

	public function loadClass($classLocation)
	{
		if(file_exists($classLocation))
			include($classLocation);				
		else
			throw new FakeException('class Not Found', 0);
	}

	private function errorHandler($e)
	{
		ob_clean();
		$http = array(
				'404' => 'HTTP/1.1 404 Not Found',
				'400' => '400 => "HTTP/1.1 400 Bad Request'
			);
		if(get_class($e) === 'FakeException')
		{	
			$n = $e->code;

			

			switch($n)
			{
				case 0:
					header($http['404'], true, '404');
					break;
				case 404:
					header($http['404'], true, '404');
					break;
				default:
					header($http['404'], true, '404');
					break;
			}

			echo $e->message;
		}
		else
		{
			var_dump($e);
			header($http['404']);
			echo 'Unknown Error';
		}
		
		exit;
	}

	public function log($msg, $level){
		$log = $_SERVER;
		$log['msg'] = $msg;
		$log['level'] = $level;

		$logModel = new LogModel();
		$logModel->initWithData(array($log));
		$logModel->save();
	}

	private function loginCheck()
	{
		if(isset($_COOKIE['sessionid']))
		{
			$sessionid = $_COOKIE['sessionid'];

			$user = $this->db->fakeuser->findOne(array(
				'sessionid' => $sessionid
				));
			if(! empty($user))
			{
				if($user['expires'] <= time())
				{
					return false;
				}
				else{
					$this->updateSession($user);
					return true;		
				}
			}
		}
		return false;
	}

	public function updateSession($user = array())
	{
		if(empty($user))
		{
			throw new FakeException('user is empty', 0);
		}
		$id = $this->generateSessionId();

		$t = time() + 3600;
		
		setcookie('sessionid', $id, $t, '/');
		$updatedUser = $user;
		$updatedUser['sessionid'] = $id;
		$updatedUser['expires'] = $t;
		
		$this->db->fakeuser->update($user, $updatedUser);
	}

	public function generateSessionId()
	{
		$id = new MongoId();
		$id = $id->{'$id'};
		$id = sha1($id);
		return $id;
	}

}


