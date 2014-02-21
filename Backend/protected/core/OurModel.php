<?php defined('BASE_PATH') or exit('Access Denied');

/*封装了mysql的类 */
class OurModel
{
    private $APP;
    public function __construct()
    {
        $this->APP = OurBlog::getInstance();
    }

}
