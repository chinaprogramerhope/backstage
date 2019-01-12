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
//
//clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
//return ERR_MYSQL_EXCEPTION;

//$pass = '111111';
//$salt = '888';
//$pass1 = crypt($pass, $salt);
//echo $pass1; // 88.h3CWSFO.yw

//$datetime1 = new DateTime('2009-10-11');
//$datetime2 = new DateTime('2009-10-15');
//echo  $datetime1->diff($datetime2)->d;

function haha($b) {
    $b = 100;
}

$bb = 1;
haha($bb);
echo $bb;