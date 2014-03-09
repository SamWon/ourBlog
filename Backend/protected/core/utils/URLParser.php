<?php defined('BASE_PATH') or exit('Access Denied');

class URLParser
{
    private $uri = '';
    private $className = '';
    private $params = array();
    private $illegal = false;
    private $action = 'index';

    public function __construct($uri = '')
    {
        //解析uri，巧妙之处：其实正常的只有路径没有参数，但自己强行将路径当成参数了
        $parsed_uri = parse_url(preg_replace('/\s+/', '', urldecode($uri)));
        $parsed_uri = preg_replace('/\/index.php/', '', $parsed_uri['path']);
        $this->uri = $parsed_uri;
    }

    public function parse( $config )
    {
        //将uri中的class & method 抽丝剥茧出来
        $apart = '/';
        $this->className = strtok( $this->uri, $apart );
        //加上可能有目录的情况
        $tmpName = $this->className;
        $is_dir =APP_PATH."/controllers/".$this->className;
        if(is_dir($is_dir) && $is_dir != APP_PATH."/controllers/")
        {
            $this->className = ucfirst(strtok( $apart ));
            $this->className = $tmpName.'/'.$this->className;
            //var_dump($this->className);
            $this->className = (explode('/' , $this->className)[1] == false) 
                               ? $this->className . 'BackController'
                               : $this->className . 'Controller';
        }else{
            $this->className = ($this->className == false) 
                               ? ucfirst($config['defaultController']) . 'Controller'
                               : ucfirst($this->className) . 'Controller';
        }

        //$this->illegal   = (preg_match('/^[\w_-]+$/' , $this->className )) ? true : false ; //???
        $temp = (strtolower( strtok($apart) ));
        $this->action    = $temp ? $temp : "index";

        $paramArray      = array();
        
        //通过while将本是“路径”的参数抽出来
        while( ($tmp = strtok($apart)) != "")
        {
            $paramArray[] = $tmp;
        }
        $this->params = $paramArray;

        return array (
            'uri' => $this->uri,
            'className' => $this->className,
            'params' => $this->params,
            'illegal' => $this->illegal,
            'action' => $this->action
        );
    }
}
