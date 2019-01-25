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

$ret = 'https://widget.paytrust88.com/widget/open/1c6be92897fdf3b0c8aeebf49356ae4a?bank=9';
header('location: ' . $ret);