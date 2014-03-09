<?php defined("BASE_PATH") or exit("Access Denied");

class LoginController extends OurController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($loginname, $loginpwd)
    {
        session_start();
        $_SESSION['loginname'] = $loginname;
        $_SESSION['loginpwd']  = $loginpwd;
        header("Location: /index.php/admin/back");
    }
}
