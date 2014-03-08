<?php defined("BASE_PATH") or exit("Access Denied");

class HomeController extends OurController
{
    public $time_array = array();
    public $is_ajax = array();
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('article');
        $this->loadModel('type');
        $this->data['time_array'] = array(
            '01' => '一月',
            '02' => '二月',
            '03' => '三月',
            '04' => '四月',
            '05' => '五月',
            '06' => '六月',
            '07' => '七月',
            '08' => '八月',
            '09' => '九月',
            '10' => '十月',
            '11' => '十一月',
            '12' => '十二月'
        );


    }

    /*当$type_id为0的时候是有wrap的，为1是所有，其它的是目录页面*/
    public function index($type_id = -1)
    {
        if($this->APP->isAjaxRequest)
        {
            $this->is_ajax[0] = $this->APP->isAjaxRequest;
            $this->is_ajax[1] = $_REQUEST['number'];
            $this->is_ajax[2] = 5; //the articles per request
            $this->is_ajax[3] = $this->type->get_all_type();
        }
        //var_dump($this->is_ajax);
        $type_id = (int)$type_id;
        $this->data['t_array'] = $this->type->get_type_array();//get type from id
        $this->data['types'] = $this->type->get_all_type();
        /*首次加载的内容*/
        if($type_id === -1)//带wrap全部
        {
            if($is_ajax[0])
            {
                $this->data['articles'] = $this->article->get_all_article($this->is_ajax);
            }else{
                $this->data['articles'] = $this->article->get_all_article($this->is_ajax);
                if(empty($this->data['articles']))  
                {
                    $this->data["error"] = "抱歉,没有找到相关内容=,.=";
                    $this->loadView('noresult',$this->data);
                }else{
                    $this->loadView('home',$this->data);
                }
            }
        }elseif($type_id ===(int)0){//不带wrap全部
            if($this->is_ajax[0])
            {
                $this->data['articles'] = $this->article->get_all_article($this->is_ajax);
            }else{
                $this->data['articles'] = $this->article->get_all_article($this->is_ajax);
                if(empty($this->data['articles']))  
                {
                    var_dump($this->data['articles']);
                    $this->data["error"] = "抱歉,没有找到相关内容=,.=";
                    $this->loadView('noresult',$this->data);
                }else{
                    $this->loadView('category',$this->data);
                }
            }
        }else {
            //$this->is_ajax = array(true, 1, 5) ;
            if($this->is_ajax[0])
            {
                $this->data['articles'] = $this->article->get_by_type($type_id,$this->is_ajax);
                //$this->loadView('category',$this->data);
            } else{
                $this->data['articles'] = $this->article->get_by_type($type_id,$this->is_ajax);
                if(empty($this->data['articles']))  
                {
                    $this->data["error"] = "抱歉,没有找到相关内容=,.=";
                    $this->loadView('noresult',$this->data);
                }else{
                    $this->loadView('category',$this->data);
                }
            }
        }
    }
    
    public function search()
    {
        $key = $this->_filter($_POST['search']);
        $this->data['t_array'] = $this->type->get_type_array();//get type from id
        $this->data['types'] = $this->type->get_all_type();
        $this->data['articles'] = $this->article->get_by_search($key,$this->is_ajax);
            if(empty($this->data['articles']))  
            {
                $this->data["error"] = "抱歉,没有找到相关内容=,.=";
                $this->loadView('noresult',$this->data);
            }else{
                $this->loadView('search',$this->data);
            }

        
    }
    private function _filter($content)
    {
        $content = preg_replace('/\s+/','',$content);
        $content = addslashes($content);
        $content = htmlspecialchars($content);
        return $content;
    }

    private function _get_cn_month($num)
    {
        return $this->time_array[$num];
    }
}


