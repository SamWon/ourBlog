<?php defined("BASE_PATH") or exit("Access Denied");

class TypeModel extends OurModel
{
    private $_tablename = "type";
    public function __construct()
    {
        parent::__construct();
    }

    //取得所有的分类
    public function  get_all_type()
    {
        return $this->get($this->_tablename);
    }

    public function get_type_array()
    {
        $tmp = $this->get_all_type();
        $array = array();
        //var_dump($tmp);exit;
        foreach($tmp as $arr)
        {
            $array[$arr->tid] = $arr->name;
        }
        return $array;
    }
}
