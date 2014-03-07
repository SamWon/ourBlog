<?php defined("BASE_PATH") or exit("Access Denied");

class ArticleModel extends OurModel
{
    private $_tablename = "article";
    public  $json_array = array();
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_article($is_ajax)
    {
         return $this->get($this->_tablename);
    }

    public function get_by_type($type_id, $is_ajax)
    {
        //$is_ajax[1] : 请求第几次   $is_ajax[2]: 每次请求多少个
        $info = array('tid' => $type_id);//condition
        $all_count = $this->_get_all_count($info);
        $remain_count = $all_count - ($is_ajax[1] * $is_ajax[2]);
        if(!is_integer($type_id))
            $type_id = (int)$type_id;
        if($is_ajax[0])
        {
            if($remain_count <= 0) //如果没有后续的话,那么返回null
            {
                $this->json_array['data']   = '';
                $this->json_array['result'] = 'false';
            }
            else
            {
                $offset = $is_ajax[2] * $is_ajax[1];
                $tmp = $this->get_where($this->_tablename, $info, $offset, $is_ajax[2]);
                $tmp = _make_ajax_result($tmp, $is_ajax[3]);//向结果数组加入链接
                $this->json_array['data'] = $tmp;
                $this->json_array['result'] = 'true';
            }
            echo json_encode($this->json_array);
        }else{
            return $this->get_where($this->_tablename, $info, 0, 5);
        }
    }

    public function get_by_id($aid)
    {
        if(!is_integer($aid))
            $aid = (int)$aid;
        $info = array('aid' => $aid);
        return $this->get_where($this->_tablename, $info);
    }

    public function get_by_search($key, $is_ajax)
    {
        return $this->search($this->_tablename, $key);
    }

    private function _get_all_count($info)
    {
       return $this->get_count($this->_tablename, $info);
    }

    private function _make_ajax_result($b_result , $type_array)
    {
        foreach($b_result as $b)
        {
            $b->type = $type_array[$b->tid];
            $b->link = 'index.php/detail/index/'.$b->aid;
            $b->time = substr($b->time,0,10);
        }
        //var_dump($b_result);exit;
        return $b_result;
    }

}
