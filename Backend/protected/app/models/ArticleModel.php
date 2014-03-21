<?php defined("BASE_PATH") or exit("Access Denied");

class ArticleModel extends OurModel
{
    private $_tablename = "article";
    public  $json_array = array();
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_article( $is_ajax = array(), $normal="")
    {
        $all_count = $this->_get_all_count($info);
        $remain_count = $all_count - ($is_ajax[1] * $is_ajax[2]);
        if($is_ajax[0])
        {
            if($remain_count <= 0) //如果没有后续的话,那么返回null
            {
                $this->json_array['data']   = '';
                $this->json_array['result'] = 'false';
            } else {
                $offset = $is_ajax[2] * $is_ajax[1];
                $tmp = $this->get($this->_tablename, $offset, $is_ajax[2]);
                $tmp = $this->_make_ajax_result($tmp, $is_ajax[3]);//向结果数组加入链接
                $this->json_array['data'] = $tmp;
                $this->json_array['result'] = 'true';
            }
            header('Content-Type:text/html;charset=utf-8');
            echo json_encode($this->json_array);
        }elseif(!empty($normal)){
            return $this->get($this->_tablename);
        }else
        {
            //return $this->get($this->_tablename, 0, 5);
            $tmp = $this->get($this->_tablename, 0, 5);
            return $this->_find_img($tmp);
        }
    }

    public function get_by_type($type_id, $is_ajax = array())
    {
        //$is_ajax[1] : 请求第几次   $is_ajax[2]: 每次请求多少个
        if(!is_integer($type_id))
            $type_id = (int)$type_id;
        $info = array('tid' => $type_id);//condition
        $all_count = $this->_get_all_count($info);
        $remain_count = $all_count - ($is_ajax[1] * $is_ajax[2]);
        if($is_ajax[0])
        {
            if($remain_count <= 0) //如果没有后续的话,那么返回null
            {
                $this->json_array['data']   = '';
                $this->json_array['result'] = 'false';
            } else {
                $offset = $is_ajax[2] * $is_ajax[1];
                $tmp = $this->get_where($this->_tablename, $info, $offset, $is_ajax[2]);
                $tmp = $this->_make_ajax_result($tmp, $is_ajax[3]);//向结果数组加入链接
                $this->json_array['data'] = $tmp;
                $this->json_array['result'] = 'true';
            }
            header('Content-Type:text/html;charset=utf-8');
            echo json_encode($this->json_array);
        }else{
            $tmp = $this->get_where($this->_tablename, $info, 0, 5);
            return $this->_find_img($tmp);
        }
    }

    public function get_by_id($aid)
    {
        if(!is_integer($aid))
            $aid = (int)$aid;
        $info = array('aid' => $aid);
        return $this->get_where($this->_tablename, $info);
    }

    public function get_by_search($key, $is_ajax = array())
    {
        //return $this->search($this->_tablename, $key);
        $all_count = $this->_get_all_count($info ,$key);
        $remain_count = $all_count - ($is_ajax[1] * $is_ajax[2]);
        if($is_ajax[0])
        {
            //var_dump($key);exit;
            if($remain_count <= 0) //如果没有后续的话,那么返回null
            {
                $this->json_array['data']   = '';
                $this->json_array['result'] = 'false';
            } else {
                $offset = $is_ajax[2] * $is_ajax[1];
                //$tmp = $this->get_where($this->_tablename, $info, $offset, $is_ajax[2]);
                $tmp = $this->search($this->_tablename, $key, $offset, $is_ajax[2]);
                $tmp = $this->_make_ajax_result($tmp, $is_ajax[3]);//向结果数组加入链接
                $this->json_array['data'] = $tmp;
                $this->json_array['result'] = 'true';
            }
            header('Content-Type:text/html;charset=utf-8');
            echo json_encode($this->json_array);
        }else{
            $tmp = $this->search($this->_tablename, $key, 0, 5);
            return $this->_find_img($tmp);
        }
    }

    public function delete_article( $aid )
    {
        $info = array('aid' => $aid);
        $result = $this->delete($this->_tablename, $info);
        return $result;
    }

    public function insert_article( $info )
    {
       $result = $this->insert( $this->_tablename, $info );
       return $result;
    }

    public function update_article($aid, $data = array())
    {
        $info = array('aid' => $aid);
        $result = $this->update($this->_tablename, $info , $data);
        return $result;
    }

    private function _get_all_count($info = array(),$key="")
    {
       return $this->get_count($this->_tablename, $info, $key);
    }

    private function _make_ajax_result($b_result , $type_array)
    {
        foreach($b_result as $b)
        {
            $b->type = $type_array[$b->tid];
            $b->link = '/index.php/detail/index/'.$b->aid;
            $b->time = substr($b->time,0,10);
        }
        $this->_find_img($b_result);
        //var_dump($b_result);exit;
        return $b_result;
    }

    private function _find_img( $content )
    {
            //preg_match('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$match);
            if($content )
            {
                foreach($content as $c)
                {
                    if($tmp = preg_match('/<img \s*[^>]*>/i',substr($c->content,0,200), $match))
                    {
                        //$c->img = $match[0];
                        $tmp    = preg_replace('/<img \s*[^>]*>/i', '', $c->content );   
                        $c->content = $match[0] . $this->_cutstr($tmp, 100, 'utf-8', "......");   //将img的标签放在内容里
                    }
                }
            }
            
            return $content;
    }
/*可以保证截取&nbsp；到一半就没有的的方法*/
    private function  _cutstr($string, $length, $charset, $dot = '...') 
    {
        if(strlen($string) <= $length) {
        return $string;
    }

        $pre = chr(1);
        $end = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

        $strcut = '';
        if(strtolower($charset) == 'utf-8') {

            $n = $tn = $noc = 0;
            while($n < strlen($string)) {

                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }

                if($noc >= $length) {
                    break;
                }

            }
            if($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr($string, 0, $n);

        } else {
            for($i = 0; $i < $length; $i++) {
                $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
            }
        }

        $strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

        $pos = strrpos($strcut, chr(1));
        if($pos !== false) {
            $strcut = substr($strcut,0,$pos);
        }
        return $strcut.$dot;
        }


}
