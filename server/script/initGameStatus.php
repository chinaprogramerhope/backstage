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
    1 => 1, // 德州扑克
    18 => 1, // 抢庄牛牛
    20 => 1, // 看牌牛牛
    21 => 1, // 百人牛牛

    49 => 1, // 炸金花
    52 => 1, // 红黑大战
    97 => 1, // 经典斗地主
    98 => 1, // 欢乐斗地主

    161 => 1, // 十三水
    162 => 4, // 十三水_5色
    321 => 4, // 跑得快
    350 => 1, // 奔驰宝马

    351 => 1, // 龙虎斗
    352 => 1, // 百家乐
    8888 => 4, // 二八杠
    8889 => 4, // 三公
];

$redis->hMset($key, $valueArr);

echo 'success!!';


