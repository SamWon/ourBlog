<?php defined("BASE_PATH") or exit("Access Denied");

class DetailController extends OurController
{
   public $time_array = array();
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

   public function index($aid)
   {
       $this->data['article'] = $this->article->get_by_id($aid);
       $this->data['t_array'] = $this->type->get_type_array();//get type from id
       $this->data['types'] = $this->type->get_all_type();
       $this->loadView('detail',$this->data);
   }
}
