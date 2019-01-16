<?php
/**
 * User: hanxiaolong
 * Date: 2019/1/16
 */
date_default_timezone_set('Asia/shanghai');

require_once '../autoload.php';
require_once '../loadConfig.php';

$key = gameStatus;
$redis = clsRedis::getInstance();
if (null === $redis) {
    echo 'fail!!';
    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
    return;
}

$valueArr = [
    1 => 1,
    18 => 1,
    20 => 1,
    21 => 1,

    49 => 1,
    52 => 1,
    97 => 1,
    98 => 1,

    161 => 1,
    162 => 1,
    321 => 3,
    350 => 1,

    351 => 1,
    352 => 2
];

$redis->hMset($key, $valueArr);

echo 'success!!';


