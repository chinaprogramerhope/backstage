<?php
/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * todo php5.4 不能直接const []
 */


/**
 * 游戏管理
 */

// 游戏分组
const gameGroup = [ // 分组id => 分组名
    1 => '捕鱼游戏',
    2 => '棋牌游戏',
    3 => '电玩游戏',
];

// 游戏类型 - 游戏底分
const gameType = [
//    1 => '下注类',
//    2 => '捕鱼类',
//    3 => '对战类'
    1 => '0.01 / 1',
    2 => '1 / 18',
    3 => '5 / 120',

    4 => '1 / 50',
    5 => '5 / 250',
    6 => '10 / 500',

    7 => '5 / 200',
    8 => '50 / 2000',

    9 => '5 / 400',
    10 => '10 / 1000'

];

// 游戏状态
const gameStatus = [
    1 => '正常',
    2 => '禁用',
    3 => '维护中'
];

// 投注记录表
const gameHistoryTables = [
    "1" => "CASINOGAMERECORD_TexasPoker_", // 游戏id => 表
    "5" => "CASINOGAMERECORD_BaiRenTexasPoker_",
    "17" => "CASINOGAMERECORD_NiuNiuQiangZhuang_",
    "20" => "CASINOGAMERECORD_NiuNiuSeenCardQZ_",
    "21" => "CASINOGAMERECORD_BaiRenNiuNiu_",
    "23" => "CASINOGAMERECORD_NiuNiuMalai_",
    "24" => "CASINOGAMERECORD_SG_",
    "49" => "CASINOGAMERECORD_ZJH_",
    "52" => "CASINOGAMERECORD_BaiRenZhaJinHua_",
    "54" => "CASINOGAMERECORD_BaiRenZhaJinHuaRB_",
    "97" => "CASINOGAMERECORD_DDZ_",
    "98" => "CASINOGAMERECORD_DDZHUANLE_",
    "101" => "CASINOGAMERECORD_DDZLAIZI_"
];
