<?php defined("BASE_PATH") or exit("Access Denied");

class BackController extends OurController
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        date_default_timezone_set('Asia/Shanghai');
        $this->config = include(CONFIG_PATH.'/config.php');
        if(!isset($_SESSION['loginname']) || $_SESSION['loginname'] != $this->config['loginname'])
        {
            header("Location: /index.php/home");
        }
        $this->loadModel('article');
        $this->loadModel('type');
    }
    
    public function index()
    {
        //var_dump(date("Y-m-d H:i:s"));exit;
        $this->data['articles'] = $this->article->get_all_article(array(),1);
        $this->data['t_array'] = $this->type->get_type_array();//get type from id
        $this->loadview('articlelist',$this->data);
    }

    public function typeList()
    {
        $this->data['t_array'] = $this->type->get_type_array();//get type from id
        $this->data['types'] = $this->type->get_all_type();
        $this->loadView('typeList',$this->data);
    }


    public function newArticle($aid = "")
    {
        $this->data['types'] = $this->type->get_all_type();
        if($aid !== "")//edit
        {
            //$this->data['t_array'] = $this->type->get_type_array();//get type from id
            $this->data['article'] = $this->article->get_by_id($aid);
            $this->loadView('newArticle', $this->data);
        }else{
            $this->loadView('newArticle', $this->data);
        }
    }


    public function newType($tid = "") // new || edit
    {
        if($tid !== "")//edit
        {
            $this->data['type'] = $this->type->get_by_id($tid);
            $this->loadView('newType', $this->data);
        }else{          //new
            $this->loadView('newType', $this->data);
        }
    }

    public function deleteArticle($aid = "")
    {
        $url = '/index.php/admin/back/index';
        if(is_integer($aid))
            $aid = (int)$aid;
        $result = $this->article->delete_article( $aid );
        if(!$result)
            $this->warning('删除失败,5555');
        header("Location: $url"); 
    }

    public function deleteType($tid = "")
    {
        $url = '/index.php/admin/back/typeList';
        if(is_integer($tid))
            $tid = (int)$tid;
        $result = $this->type->delete_type( $tid );
        if(!$result)
            $this->warning('删除失败,5555');
        header("Location: $url"); 

            

    }

    public function addType($tid = "") //new || edit
    {
        $url = '/index.php/admin/back/typeList';
        if($tid !== "")
        {

            $t_name = $_POST['t_name'];
            if($t_name === "")
                $this->warning("好歹输入个标签名吧=。=");
            $result = $this->type->update_type( $tid, $t_name);
            if(!$result)
                $this->warning("更新失败，5555");
            header("Location: $url"); 
        }else{
            $t_name = $_POST['t_name'];
            $info = array('name' => $t_name);
            $result = $this->type->insert_type($info);
            if(!$result)
                $this->warning("标签插入失败,5555");
            header("Location: $url"); 
        }
    }

    public function addArticle( $aid = "")
    {
        $url = '/index.php/admin/back/index';

        //var_dump($aid);exit;
        if($aid !== "") //edit
        {
            $data = array(
                'title'   =>trim(htmlspecialchars($_POST['title'])), 
                'content' =>$_POST['content'],
                'tid'     =>$_POST['type_id'],
                'time'    =>date('Y-m-d H:i:s')
            );
            if($data['title'] === "")
                $this->warning("好歹输入个标题吧=。=");
            $result = $this->article->update_article( $aid, $data);
            if(!$result)
                $this->warning("更新失败,5555");
            header("Location: $url"); 
        }else{          //new
            $data = array(
                'title'   =>trim(htmlspecialchars($_POST['title'])), 
                'content' =>$_POST['content'],
                'tid'     =>$_POST['type_id'],
                'time'    =>date('Y-m-d H:i:s')
            );
            if($data['title'] === "")
                $this->warning("好歹输入个标题吧=。=");
            $result = $this->article->insert_article($data);
            if(!$result)
                $this->warning("文章插入失败,5555");
            header("Location: $url"); 
        }

    }

}

