<?php defined('BASE_PATH') or exit('Accesss Denied');

class FakeController
{
	public function __construct()
	{
		$this->APP = FakeGeek::getInstance();
		$this->db = $this->APP->db;
	}

	//render view
	public function render($viewName, $dataArray = array())
	{

		// if($this->APP->isAjaxRequest)
		// {
		// 	$data = json_encode($dataArray);
		// 	if($this->APP->JSONP)
		// 		$data = $this->APP->JSONP . '(' . $data . ')';
		// 	echo $data;
		// 	return;
		// }

		$viewPath = APP_PATH . '/views/' . $viewName . '.php';
		
		if(empty($viewName) || ! file_exists($viewPath))	
		{
			throw new FakeException('view not found', 0);
		}
		else
		{
			extract($dataArray);
			include($viewPath);
		}
	}

	public function loadModel($modelName)
	{
		$modelName = ucfirst($modelName);
		$modelPath = APP_PATH . '/models/' . $modelName . 'Model.php';

		if(empty($modelName) || ! file_exists($modelPath))
		{
			exit('Model File Not Found.');
		}
		else
		{
			include($modelPath);
		}
	}

	public function loadLibrary($libName)
	{
		$libName = ucfirst($libName);
		$libPath = LIB_PATH . '/' . $libName . '.php';
		if(empty($libName) || ! file_exists($libPath))
		{
			exit('Library File Not Found.');
		}
		else
		{
			include($libPath);
		}
	}

	public function __call($method, $args)
	{
		// if(method_exists($this->APP, $method))
		// {
		// 	call_user_func_array(array($this->APP, $method), $args);
		// }
		// else
		// {
			throw new FakeException('method not found', 404);
		// }
	}

	public function redirect($url, $num = 200)
	{
		static $http = array (
			100 => "HTTP/1.1 100 Continue",
			101 => "HTTP/1.1 101 Switching Protocols",
			200 => "HTTP/1.1 200 OK",
			201 => "HTTP/1.1 201 Created",
			202 => "HTTP/1.1 202 Accepted",
			203 => "HTTP/1.1 203 Non-Authoritative Information",
			204 => "HTTP/1.1 204 No Content",
			205 => "HTTP/1.1 205 Reset Content",
			206 => "HTTP/1.1 206 Partial Content",
			300 => "HTTP/1.1 300 Multiple Choices",
			301 => "HTTP/1.1 301 Moved Permanently",
			302 => "HTTP/1.1 302 Found",
			303 => "HTTP/1.1 303 See Other",
			304 => "HTTP/1.1 304 Not Modified",
			305 => "HTTP/1.1 305 Use Proxy",
			307 => "HTTP/1.1 307 Temporary Redirect",
			400 => "HTTP/1.1 400 Bad Request",
			401 => "HTTP/1.1 401 Unauthorized",
			402 => "HTTP/1.1 402 Payment Required",
			403 => "HTTP/1.1 403 Forbidden",
			404 => "HTTP/1.1 404 Not Found",
			405 => "HTTP/1.1 405 Method Not Allowed",
			406 => "HTTP/1.1 406 Not Acceptable",
			407 => "HTTP/1.1 407 Proxy Authentication Required",
			408 => "HTTP/1.1 408 Request Time-out",
			409 => "HTTP/1.1 409 Conflict",
			410 => "HTTP/1.1 410 Gone",
			411 => "HTTP/1.1 411 Length Required",
			412 => "HTTP/1.1 412 Precondition Failed",
			413 => "HTTP/1.1 413 Request Entity Too Large",
			414 => "HTTP/1.1 414 Request-URI Too Large",
			415 => "HTTP/1.1 415 Unsupported Media Type",
			416 => "HTTP/1.1 416 Requested range not satisfiable",
			417 => "HTTP/1.1 417 Expectation Failed",
			500 => "HTTP/1.1 500 Internal Server Error",
			501 => "HTTP/1.1 501 Not Implemented",
			502 => "HTTP/1.1 502 Bad Gateway",
			503 => "HTTP/1.1 503 Service Unavailable",
			504 => "HTTP/1.1 504 Gateway Time-out"
			);
		header($http[$num]);
		header ("Location: $url");
	}

	public function renderWidgets()
	{
		
	}

	public function renderPartial($viewName, $dataArray = array())
	{


	}

	public function requireLogin()
	{
		if(! $this->APP->isAdmin)
		{
			throw new FakeException('Authentication failure' , '0');
		}
	}
}
