<?php defined("BASE_PATH") or exit("Access Denied");

class HomeController extends OurController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('article');
    }

    public function index()
    {
        $info = $this->article->get_all_article();
        $this->loadView('home', $info);
    }
}


