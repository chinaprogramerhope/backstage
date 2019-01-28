<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-7
 * Time: 下午4:27
 */

require_once '../autoload.php';
require_once '../loadConfig.php';


$adminName = 'admin';
$salt = 888;
$pass = '111111';
$pass = crypt($pass, $salt);

echo $pass;