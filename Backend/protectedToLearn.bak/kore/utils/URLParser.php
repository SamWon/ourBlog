<?php defined('BASE_PATH') or exit('Access Denied');

class URLParser {
	private $uri = '';
	private $className = '';
	private $params = array();	
	private $illegal = false;
	private $action = 'index';

	public function __construct($uri = '')
	{
		$parsed_uri = parse_url(preg_replace('/\s+/', '', urldecode($uri)));
		$parsed_uri = preg_replace('/\/index.php/', '', $parsed_uri['path'], 1);
		$this->uri = $parsed_uri;
	}

	public function parse($config)
	{
		$token = '/';
		$this->className = (strtok($this->uri, $token));
		if($this->className === false)
			$this->className = ucfirst($config['defaultController']) . 'Controller';
		else
			$this->className = ucfirst($this->className) . 'Controller';
		if(! preg_match('/^[\w_-]+$/', $this->className))
			$this->illegal = true;
		$action = strtok($token);

		$paramsArray = array();
		while(($tmp = strtok($token)) !== false)
		{
			$paramsArray[] = preg_replace('/\s+/', '', $tmp);
		}	
		$this->params = $paramsArray;

		if($action !== false)
			$this->action = strtolower($action);
		return array(
			'uri' => $this->uri,
			'className' => $this->className,
			'params' => $this->params,	
			'illegal' => $this->illegal,
			'action' =>  $this->action
		);
	}
}
