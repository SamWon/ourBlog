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
         $result = $this->get($this->_tablename);
         return $result->fetch_assoc();
    }

    public function get_by_type($typenum)
    {
        $info = array('tid' => $typenum);
        $result =  $this->get_where($this->_tablename, $info );
        return $result->fetch_assoc();
    }
}
