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

    public function get_by_id($tid)
    {
        $info = array('tid' => $tid);
        return $this->get_where($this->_tablename, $info);
    }

    public function insert_type($info = array())
    {
       $result = $this->insert( $this->_tablename, $info );
       return $result;
    }

    public function update_type( $tid , $name)
    {
        $info = array('tid' => $tid);
        $data = array('name' => $name);
        $result = $this->update($this->_tablename, $info, $data);
        return $result;
    }

    public function delete_type( $tid )
    {
        $info = array('tid' => $tid);
        $result = $this->delete($this->_tablename, $info);
        return $result;
    }

}
