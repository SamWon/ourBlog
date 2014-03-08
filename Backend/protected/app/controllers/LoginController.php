<?php defined("BASE_PATH") or exit("Access Denied");

class LoginController extends OurController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function daqiantai()
    {
        $url = "/index.php/admin";
        header("Location: $url ");
    }
}
