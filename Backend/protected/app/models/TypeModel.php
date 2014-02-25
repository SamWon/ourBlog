<?php defined("BASE_PATH") or exit(Access Denied);

class TypeModel extends OurModel
{
    private $_tablename = "type";
    public function __construct()
    {
        parent::__construct();
    }

    public function  get_all_type()
    {
        $result = $this->get($this->_tablename);
        return $result->fetch_assoc();
    }
}
