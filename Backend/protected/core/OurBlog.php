<?php defined('BASE_PATH') or exit('Access Denied');

require_once(CORE_PATH. '/utils/URLParser.php');
require_once(CORE_PATH. '/utils/DB.php');
require_once(CORE_PATH. '/OurController.php');
require_once(CORE_PATH. '/OurModel.php');
require_once(CORE_PATH. '/OurException.php');
//require_once(CORE_PATH. '/LogModel.php');  //???这里可以在common.php里弄一个load_class()


class OurBlog
{
    private static $ourInstance;
    private static  $loaded = array();
    private $params = array();
    public  $config = array();
    public  $db              ;
    public  $isAjaxRequest = false;
    public  $isAdmin= false;
    public  $conn;

    private function __construct()
    {
        $requestURI = $_SERVER['REQUEST_URI'];              //REQUEST_URI是要访问的
        $parser     = new URLParser($requestURI);           //parse uri
        $this->config = include(CONFIG_PATH.'/config.php'); //return the array of the config
        $this->params = $parser->parse($this->config);
        $this->isAjaxRequest = call_user_func(function(){
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
                return true;
            if(isset($_REQUEST['ajax']))
                return true;
            return false;
        });
        $this->JSONP = isset($_REQUEST['jsonp']) ? $_REQUEST['jsonp'] : null;
    }

    /*返回类的实例*/
    public static function &getInstance()
    {
        if(empty(self::$ourInstance)) 
        {
            self::$ourInstance = new OurBlog();
            self::$loaded[] = self::$ourInstance;
            return self::$ourInstance;
        }elseif(in_array(self::$ourInstance,self::$loaded))
        {
            return self::$ourInstance;
        }
    }

    /* index.php 里运行的开始
     *==>connect数据库，检查登陆，处理请求，日志记录<==
     *
     *
     * */
    public function run()
    {
        ob_start(); //打开输出缓冲区
        try
        {
            $this->db=DB::getInstance()->connectDB();//Connect to  the database
            //$this->isAdmin = $this->loginCheck();
            //if($this->params['illegal'] !== false) 
            //{
                $this->handleRequest($this->params['className']);
                //$this->log("request class {$this->params['className']} with the action {$this->params['action']}", 'log');
            //}
            //else
            //{
                //$this->show_404();
            //}
        }
        catch(OurException $e)//如果没有catch到自定义异常，那么就用内置异常类处理
        {
            $this->errorHandler($e);
        }
        catch(Exception $e)
        {
            $this->errorHandler($e);
        }

    }


    /*处理请求的页面
     *==>就是实例化给定的类，然后调用方法，同时给出参数<==
     *
     * */
    private function handleRequest($className)
    {
        $tempClassName = ucfirst($className);
        //var_dump($tempClassName);exit;
        $this->loadClass(APP_PATH. '/controllers/'. $tempClassName. '.php');//include the file
        //var_dump($tmpClassName);exit;
        if(strpos($tempClassName, '/') >= 0 && strpos($tempClassName, '/') !== false )//判断是不是带目录的class
        {
            $tmp = explode('/', $tempClassName );
            $tempClassName = $tmp[1];
        }
        $class = new $tempClassName();
        $method = $this->params['action'];
        call_user_func_array(array($class, $method), $this->params['params']);//array的第一个参数是类的实例，第二个参数就是类的方法
    }


    /*404页面*/
    public function show_404()
    {
        header('Status: 404 Not Found', true, '404');
        //The 404 page 
        echo 'Error: 404 Page Not Found';
        exit;
    }
    

    /*调用参数中给定的地址的类文件*/
    public function loadClass($classLocation)
    {
        if(file_exists($classLocation))
            include($classLocation);
        else
            throw new OurException('class Not Found', 0);
    }

    /*发送一个错误请求的头文件，然后打印错误*/
    public function errorHandler($e)
    {
        ob_clean();//清除缓冲区的内容，也就是只有单独的错误页面
        $http = array(
                '404'  => 'HTTP/1.1 Not Found',
                '400'  => 'HTTP/1.1 400 Bad Request'
        );

        if(get_class($e) === 'OurException')//如果是自定义的异常
        {
            $n = $e->code;

            switch($n)
            {
                case 0:
                    header($http['404'], true, '404');
                    break;
                case 404:
                    header($http['404'], true, '404');
                    break;
                case 400:
                    header($http['400'], true, '400');
                    break;
                default:
                    header($http['404'], true, '404');
                    break;
            }

            echo $e->message;
        }
        else
        {
            var_dump($e);
            header($http['404']);
            echo 'Unknown Error';
        }

        exit;
    }

    /*
    public function log($msg, $level)
    {
        $log = $_SERVER;
        $log['msg'] = $msg;
        $log['level'] = $level;

        $logModel = new LogModel();
        $logModel->initWithData(array(log));
        $logModel->save();
    }
     */
    /*
    private function loginCheck()
    {
        if(isset($_COOKIE['sessionid']))
        {
            $sessionid = $_COOKIE['sessionid'];

            $user = $this->db->ouruser->findOne(array(
                    'sessoinid'  => $sessionid
                ));
            if(! empty($user))
            {
                if($user['expires'] <= time())
                {
                    return false;
                }
                else
                {
                    $this->updateSession($user);
                    return true;
                }
            }
        }
        return false;
    }
    */

    
}
