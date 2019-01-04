<?php
/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * todo php5.4 不能直接const []
 */

/**
 * mysql 相关
 */
const maxQueryNum = 1000; // 最大查询数量


/**
 * 游戏管理
 */

const texasPokerPuTong = 1; // 德州扑克
const niuNiuQiangZhuang = 18; // 抢庄牛牛
const niuNiuSeenCardQZ = 20; // 看牌牛牛
const niuNiuBaiRen = 21; // 百人牛牛
const zhaJinHua = 49; // 炸金花
const redBlack = 52; // 红黑大战
const douDiZhu = 97; // 经典斗地主
const douDiZhuHuanLe = 98; // 欢乐斗地主
const shiSanZhang = 161; // 十三水
const shiSanZhang_5 = 162; // 十三水_5色
const paoDeKuai = 321; // 跑得快
const benChiBaoMa = 350; // 奔驰宝马
const dragonTiger = 351; // 龙虎斗
const baiJiaLe = 352; // 百家乐


const gameIdName = [ // 游戏id => 游戏名
    texasPokerPuTong => '德州扑克',
    niuNiuQiangZhuang => '抢庄牛牛',
    niuNiuSeenCardQZ => '看牌牛牛',
    niuNiuBaiRen => '百人牛牛',
    zhaJinHua => '炸金花',
    redBlack => '红黑大战',
    douDiZhu => '经典斗地主',
    douDiZhuHuanLe => '欢乐斗地主',
    shiSanZhang => '十三水',
    shiSanZhang_5 => '十三水_5色',
    paoDeKuai => '跑得快',
    benChiBaoMa => '奔驰宝马',
    dragonTiger => '龙虎斗',
    baiJiaLe => '百家乐',
];


const gameIdLimit = [ // 游戏id => [场次id => '底分 / 准入']
    1 => [
        1 => '1.00 / 50.00',
        2 => '5.00 / 200.00',
        3 => '50.00 / 2000.00'
    ],
    18 => [
        1 => '1.00 / 50.00',
        2 => '5.00 / 250.00',
        3 => '10.00 / 500.00'
    ],
    20 => [
        1 => '1.00 / 50.00',
        2 => '5.00 / 250.00',
        3 => '10.00 / 500.00'
    ],
    21 => [
        0 => '1.00 / 50.00',
    ],
    49 => [
        1 => '1.00 / 50.00',
        2 => '5.00 / 300.00',
        3 => '10.00 / 600.00'
    ],
    52 => [
        0 => '1.00 / 50.00',
    ],
    97 => [
        1 => '0.01 / 1.00',
        2 => '1.00 / 18.00',
        3 => '5.00 / 120.00'
    ],
    98 => [
        1 => '0.01 / 1.00',
        2 => '1.00 / 24.00',
        3 => '5.00 / 120.00'
    ],
    161 => [
        1 => '1.00 / 50.00',
        2 => '5.00 / 400.00',
        3 => '10.00 / 1000.00'
    ],
    162 => [
        0 => '1.00 / 50.00',
    ],
    321 => [
        0 => '1.00 / 50.00',
    ],
    350 => [
        0 => '1.00 / 50.00',
    ],
    351 => [
        0 => '1.00 / 50.00',
    ],
    352 => [
        0 => '1.00 / 50.00',
    ],
];

const fieldIdName = [ // 场名
    0 => '',
    1 => '小资场',
    2 => '老板场',
    3 => '土豪场'
];


// 游戏分组
const gameGroup = [ // 分组id => 分组名
    1 => '捕鱼游戏',
    2 => '棋牌游戏',
    3 => '电玩游戏',
];

// 游戏类型 - 游戏底分
const gameType = [
    1 => '0.01 / 1.00', // 经典斗地主 - 小资场
    2 => '1.00 / 18.00', // 经典斗地主 - 老板场
    3 => '5.00 / 120.00', // 经典斗地主 - 土豪场

    4 => '0.01 / 1.00', // 欢乐斗地主 - 小资场
    5 => '1.00 / 24.00', // 欢乐斗地主 - 老板场
    6 => '5.00 / 120.00', // 欢乐斗地主 - 土豪场

    7 => '0.01 / 1.00', // 癞子斗地主 - 小资场
    8 => '1.00 / 18.00', // 癞子斗地主 - 老板场
    9 => '5.00 / 120.00', // 癞子斗地主 - 土豪场

    10 => '1 / 50.00', // 炸金花 - 小资场
    11 => '5.00 / 300.00', // 炸金花 - 老板场
    12 => '10.00 / 600.00', // 炸金花 - 土豪场

    13 => '1.00 / 50.00', // 抢庄牛牛 - 小资场
    14 => '5.00 / 300.00', // 抢庄牛牛 - 老板场
    15 => '10.00 / 500.00', // 抢庄牛牛 - 土豪场

    16 => '1.00 / 50.00', // 看牌牛牛 - 小资场
    17 => '5.00 / 250.00', // 看牌牛牛 - 老板场
    18 => '10.00 / 500.00', // 看牌牛牛 - 土豪场

    19 => '1.00 / 50.00', // 德州扑克 - 小资场
    20 => '5.00 / 200.00', // 德州扑克 - 老板场
    21 => '50.00 / 2000.00', // 德州扑克 - 土豪场

    22 => '1.00 / 50.00', // 十三水 - 小资场
    23 => '5.00 / 400.00', // 十三水 - 老板场
    24 => '10.00 / 1000.00', // 十三水 - 土豪场

    25 => '1.00 / 50.00', // 龙虎斗

    26 => '1.00 / 50.00', // 红黑大战

    27 => '1.00 / 50.00', // 百人牛牛

    28 => '1.00 / 50.00', // 奔驰宝马

    29 => '1.00 / 50.00', // 百家乐
];

// 游戏状态
const gameStatus = [
    1 => '正常',
    2 => '禁用',
    3 => '维护中'
];

//// 投注记录表
//const gameHistoryTables = [
//    "1" => "CASINOGAMERECORD_TexasPoker_", // 游戏id => 表
//    "5" => "CASINOGAMERECORD_BaiRenTexasPoker_",
//    "17" => "CASINOGAMERECORD_NiuNiuQiangZhuang_",
//    "20" => "CASINOGAMERECORD_NiuNiuSeenCardQZ_",
//    "21" => "CASINOGAMERECORD_BaiRenNiuNiu_",
//    "23" => "CASINOGAMERECORD_NiuNiuMalai_",
//    "24" => "CASINOGAMERECORD_SG_",
//    "49" => "CASINOGAMERECORD_ZJH_",
//    "52" => "CASINOGAMERECORD_BaiRenZhaJinHua_",
//    "54" => "CASINOGAMERECORD_BaiRenZhaJinHuaRB_",
//    "97" => "CASINOGAMERECORD_DDZ_",
//    "98" => "CASINOGAMERECORD_DDZHUANLE_",
//    "101" => "CASINOGAMERECORD_DDZLAIZI_"
//];

// 投注记录表, 游戏id => 表
const gameHistoryTables = [
    1 => 'casinogamerecord_texaspoker_',
    18 => 'casinogamerecord_niuniuqiangzhuang_',
    20 => '',
    21 =>'casinogamerecord_bairenniuniu_',
    49 => 'casinogamerecord_zjh_',
    52 => '',
    97 => 'casinogamerecord_ddz_',
    98 => 'casinogamerecord_ddzhuanle_',
    161 => '',
    162 => '',
    321 => '',
    350 => '',
    351 => '',
    352 => ''
];
