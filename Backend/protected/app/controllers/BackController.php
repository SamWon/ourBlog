<?php defined("BASE_PATH") or exit("Access Denied");

class BackController extends OurController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->loadview('newarticle');
    }

}

