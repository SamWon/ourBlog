<?php defined('BASE_PATH') or exit('Access Denied');

class LogModel extends fakeModel
{
	protected function init()
	{
		$this->description = array(
			'msg' => 'required',
			'level' => 'required'
			);
		self::$collection = DB::getInstance()->getDb()->log;
	}
}
