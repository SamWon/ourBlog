<?php defined("BASE_PATH") or exit("Access Denied");

class ArticleModel extends OurModel
{
    private $_tablename = "article";
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_article()
    {
         return $this->get($this->_tablename);
    }

    public function get_by_type($type_id)
    {
        if(!is_integer($type_id))
            $type_id = (int)$type_id;
        $info = array('tid' => $type_id);
        return $this->get_where($this->_tablename, $info );
    }

    public function get_by_id($aid)
    {
        if(!is_integer($aid))
            $aid = (int)$aid;
        $info = array('aid' => $aid);
        return $this->get_where($this->_tablename, $info);
    }

}
