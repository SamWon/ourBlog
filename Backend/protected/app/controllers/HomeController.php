<?php defined("BASE_PATH") or exit("Access Denied");

class HomeController extends OurController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->loadView('home');
    }
}


