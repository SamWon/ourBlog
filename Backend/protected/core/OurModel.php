<?php defined('BASE_PATH') or exit('Access Denied');

/*
 * 封装了mysql操作的类 
 * 文件名了和类名一样，表名首字母大写加上Model
 *
 * */

class OurModel
{
    private $APP;
    //private $_tableName;这是自动获取表名 
    private $conn;

    public function __construct()
    {
        $this->APP = OurBlog::getInstance();
        $this->db = $this->APP->db;
        //$this->_tableName = strtolower(substr(get_class($this), 0 , -5));//将最后5个截掉
    }


    /*插入数据*/
    public function insert($table_name ="", $info = array())
    {
        if(empty($info) || !is_array($info) || $table_name == "") 
           return false;
        $field = "";
        $value = "";// 这样做可以在foreach中加一个判断，使得第一个$field or $value 前面没有逗号
        
        foreach ($info as $k => $v)
        {
            if($field)
                $field .= ",$k";
            else
                $field  = "$k" ;
            if($value)
                $value .= ",$v";
            else
                $value  = "$v" ;
        }

        $sql = "insert into {$table_name}({$field}) values({$value})";
        return $this->db->query($sql);
        
    }

    /*删除数据*/
    public function delete($table_name ="", $info = array())
    {
        if(empty($info) || !is_array($info) || $table_name == "" || count($info) > 1) 
           return false;
        $field = "";
        $value = "";
        foreach($info as $k => $v) 
        {
            $field = $k;
            $value = $v;
        }

        $sql = "delete from {$table_name} where {$field} = {$value}";
        return $this->db->query($sql);
         
    }

    /*查找数据*/
    public function get($table_name, $offset="" , $lines="")
    {
        if(empty($table_name))
            die("Please input the tablename");
        if($offset && $lines)
            $sql = "select * from {$table_name} limit {$offset},{$lines}";
        elseif($offset == null && $lines == null)
            $sql = "select * from {$table_name}";
        else
            die("Params error.");

        $result = $this->db->query($sql);
        return $this->make_result($result);
    }

    public function get_where($table_name, $info = array() ,$offset="" , $lines="")
    {
        foreach($info as $k => $v)
        {
            $field = $k;
            $value = $v;
        }

        if($offset && $lines)
            $sql = "select * from {$table_name} limit {$offset},{$lines} where {$field}={$value}";
        elseif($offset =="" && $lines == "")
            $sql = "select * from {$table_name} where {$field}={$value}";
        else
            die("Params error.");

        $result = $this->db->query($sql);
        return $this->make_result($result);
    }

    /*更新数据*/
    public function update($table_name, $info = array(), $data = array())
    {
        foreach($info as $k => $v)
        {
            $info_f = $k;
            $info_v = $v;
        }

        $data_str = "";
        foreach($data as $key => $val)
        {
            if($data_str)
                $data_str .= ",$key=$val";
            else
                $data_str .= "$key=$val";
        }

        $sql = "update {$table_name} set {$data_str} where {$info_f}={$info_v}";
        return $this->db->query($sql);
    }

    /*工具函数：生成结果数组*/
    public function make_result($result)
    {
        while($row = $result->fetch_object())                
            $data_array[] = $row;
        return $data_array;
    }
}
