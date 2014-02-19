<?php defined('BASE_PATH') or exit('Access Denied');

class FakeException extends Exception
{

	public $message;
	public $code;

	public function __construct($errorMsg, $errorCode)
	{
		$this->message = $errorMsg;
		$this->code = $errorCode;
		parent::__construct();
	}
	//todo

	public function __toString()
	{

	}

}
