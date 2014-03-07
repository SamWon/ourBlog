<?php defined("BASE_PATH") or exit("Access Denied");

public function get_cn_month($num)
{

    $time_array = array(
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
    return $time_array[$num];
}
