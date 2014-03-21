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
            {
                if(is_string($value))
                    $value .= ",'$v'";
                else
                    $value .= ",$v";
            }
            else
            {
                if(is_string($value))
                    $value .= "'$v'";
                else
                    $value .= "$v";
            }
        }

        $sql = "insert into {$table_name}({$field}) values({$value})";//字符串插入加引号 
        //$result = $this->db->query($sql);
        $result = mysql_query( $sql );
        return $result;
        
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
        //$result = $this->db->query($sql);
        $result = mysql_query( $sql );
        return $result;
         
    }

    /*查找数据*/
    public function get($table_name, $offset="" , $lines="")
    {
        if(empty($table_name))
            die("Please input the tablename");
        if(!($offset === "") && !empty($lines))
            $sql = "select * from {$table_name} order by time DESC limit {$offset},{$lines}";
        elseif(empty($offset)&& empty($lines))
            $sql = "select * from {$table_name}";
        else
            die("Params error.");

       // $result = $this->db->query($sql);
        $result = mysql_query( $sql );
        return $this->make_result($result);
    }

    public function get_where($table_name, $info = array() ,$offset="" , $lines="")
    {
        if(!is_integer($offset) || !is_integer($lines))
        {
            $offset = (int)$offset;
            $lines  = (int)$lines;
        }
        foreach($info as $k => $v)
        {
            $field = $k;
            $value = $v;
        }
        if(!($offset === "") && !empty($lines))
            $sql = "select * from {$table_name} where {$field}={$value}  order by time DESC limit {$offset},{$lines} ";
        elseif(empty($offset)  && empty($lines) )
            $sql = "select * from {$table_name} where {$field}={$value}";
        else
            die("Params error.");
        //$result = $this->db->query($sql);
        $result = mysql_query( $sql );
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
            {
                if(is_string($val))
                    $data_str .= ",$key='$val'";
                else
                    $data_str .= ",$key=$val";
            }
            else
            {
                if(is_string($val))
                    $data_str .= "$key='$val'";
                else
                    $data_str .= "$key=$val";
            }
        }

        $sql = "update {$table_name} set {$data_str} where {$info_f}={$info_v}";
        //$result =  $this->db->query($sql);
        $result = mysql_query( $sql );
        return $result;
    }

    public function search($table_name, $key , $offset="", $lines="")
    {
        //$sql = "SELECT * FROM {$table_name} WHERE UPPER(title) LIKE BINARY CONCAT('%',UPPER({$key}),'%') OR UPPER(content) LIKE BINARY CONCAT('%',UPPER({$key}),'%')";
        if(!($offset === "") && !empty($lines))
            $sql = "select * from {$table_name} where title like  '%{$key}%' or content like '%{$key}%' order by time desc limit {$offset},{$lines}";
            //$sql = "select * from {$table_name} where {$field}={$value} limit {$offset},{$lines} ";
        elseif(empty($offset)  && empty($lines) )
            $sql = "select * from {$table_name} where title like  '%{$key}%' or content like '%{$key}%'";
            //$sql = "select * from {$table_name} where {$field}={$value}";
        else
            die("Params error.");
        //$result =  $this->db->query($sql);
        $result = mysql_query( $sql );
        return $this->make_result($result);
    }

    /*工具函数：生成结果数组*/
    public function make_result($result)
    {
        //while($row = $result->fetch_object())                
        while( $row = mysql_fetch_object( $result ))
            $data_array[] = $row;
        return $data_array;
    }

    /*返回数据的行数*/
    public function get_count($table_name, $info = array(), $key="")
    {
        if(!empty($info))
        {
            foreach($info as $k => $v)
            {
                $field = $k;
                $value = $v;
            }
            $sql = "select * from {$table_name} where {$field}={$value}";
        }elseif(!empty($key)){
            $sql = "select * from {$table_name} where title like  '%{$key}%' or content like '%{$key}%'";
        }else{
            $sql = "select * from {$table_name}";
        }
        //$result = $this->db->query($sql);
        $result = mysql_query( $sql );
        //return $result->num_rows;
        return mysql_num_rows( $result );
    }
}
