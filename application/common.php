<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * http请求
 * @param $url
 * @param string $methods
 * @param string $data
 * @return mixed|string
 */
function curl_http($url, $methods = 'GET', $data = '') {
    $curl = curl_init(); //初始化
    curl_setopt($curl, CURLOPT_URL, $url); //设置抓取的url
    curl_setopt($curl, CURLOPT_HEADER, 0); //设置为0不返回请求头信息
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 跳过https请求 不验证证书和hosts
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if($methods === 'POST') {
        curl_setopt($curl, CURLOPT_POST, 1); //设置post方式提交
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //设置post数据，
    }
    $data = curl_exec($curl); //执行命令
    curl_close($curl); //关闭URL请求
    return $data; //返回获得的数据
}


/**
 * 随机生成长度字符串
 * @param $length
 * @return null|string
 */
function getRandChar($length) {
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) - 1;

    for($i = 0; $i < $length; $i++) {
        $str .= $strPol[rand(0, $max)];
    }

    return $str;
}