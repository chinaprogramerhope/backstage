<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-7
 * Time: 下午4:27
 */

require_once '../autoload.php';
require_once '../loadConfig.php';

//$url = 'https://api.xsolla.com/merchant/v2/merchants/73075/token';
//$param = [
//    'svc' => 'svcAdmin',
//    'func' => 'getAdminInfo',
//    'param' => [
//        'token' => 'admin',
//        'password' => 111111
//    ]
//];
//
//echo clsHttp::curlPost($url, $param);



//$pass = '111111';
//$salt = '888';
//$pass1 = crypt($pass, $salt);
//echo $pass1; // 88.h3CWSFO.yw

$url = 'http://47.244.177.7:8090';
$param = [
    'cmd' => '8',
    'param' => [
    ]
];

echo clsHttp::curlPost($url, $param);