<?php defined('BASE_PATH') or exit('Access Denied');

class OurException extends Exception
{
    public $message;
    public $code   ;

    public function __construct($errorMsg = ' ', $errorCode = 0)
    {
        $this->message = $errorMsg;
        $this->code    = $errorCode;
        parent::__construct($errorMsg, $errorCode);
    }

    public function __toString()
    {
        return __CLASS__.":[{$this->code }]: {$this->message}\n";
    }
}
