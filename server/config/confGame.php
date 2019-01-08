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


// 游戏id
const gameIdTexasPokerPuTong = 1; // 德州扑克
const gameIdNiuNiuQiangZhuang = 18; // 抢庄牛牛
const gameIdNiuNiuSeenCardQZ = 20; // 看牌牛牛
const gameIdNiuNiuBaiRen = 21; // 百人牛牛
const gameIdZhaJinHua = 49; // 炸金花
const gameIdRedBlack = 52; // 红黑大战
const gameIdDouDiZhu = 97; // 经典斗地主
const gameIdDouDiZhuHuanLe = 98; // 欢乐斗地主
const gameIdShiSanZhang = 161; // 十三水
const gameIdShiSanZhang_5 = 162; // 十三水_5色
const gameIdPaoDeKuai = 321; // 跑得快
const gameIdBenChiBaoMa = 350; // 奔驰宝马
const gameIdDragonTiger = 351; // 龙虎斗
const gameIdBaiJiaLe = 352; // 百家乐


// 游戏id => 游戏名
const gameIdName = [
    gameIdTexasPokerPuTong => '德州扑克',
    gameIdNiuNiuQiangZhuang => '抢庄牛牛',
    gameIdNiuNiuSeenCardQZ => '看牌牛牛',
    gameIdNiuNiuBaiRen => '百人牛牛',
    gameIdZhaJinHua => '炸金花',
    gameIdRedBlack => '红黑大战',
    gameIdDouDiZhu => '经典斗地主',
    gameIdDouDiZhuHuanLe => '欢乐斗地主',
    gameIdShiSanZhang => '十三水',
    gameIdShiSanZhang_5 => '十三水_5色',
    gameIdPaoDeKuai => '跑得快',
    gameIdBenChiBaoMa => '奔驰宝马',
    gameIdDragonTiger => '龙虎斗',
    gameIdBaiJiaLe => '百家乐',
];


// 游戏房间id (需要注意有的游戏数据库中roomId是6,7,8)
const roomIdXiaoZi = 0; // 小资场
const roomIdLaoBan = 1; // 老板场
const roomIdTuHao = 2; // 土豪场
const roomIdXiaoZi2 = 6; // 小资场
const roomIdLaoBan2 = 7; // 老板场
const roomIdTuHao2 = 8; // 土豪场
const rooIdUnknown = 100; // 未知


// 游戏房间id => 游戏房间名
const roomIdName = [
    roomIdXiaoZi => '小资场',
    roomIdLaoBan => '老板场',
    roomIdTuHao => '土豪场',
    roomIdXiaoZi2 => '小资场',
    roomIdLaoBan2 => '老板场',
    roomIdTuHao2 => '土豪场',
    rooIdUnknown => '',
];



// 游戏状态
const gameStatusNormal = 1; // 正常
const gameStatusClose = 2; // 禁用
const gameStatusMaintain = 3; // 维护中


// 游戏状态 => 状态名
const gameStatusName = [
    gameStatusNormal => '正常',
    gameStatusClose => '禁用',
    gameStatusMaintain => '维护中'
];


// 游戏id => [场次id => '底分 / 准入']
const gameIdLimit = [
    gameIdTexasPokerPuTong => [
        roomIdXiaoZi => '1.00 / 50.00',
        roomIdLaoBan => '5.00 / 200.00',
        roomIdTuHao => '50.00 / 2000.00'
    ],
    gameIdNiuNiuQiangZhuang => [
        roomIdXiaoZi => '1.00 / 50.00',
        roomIdLaoBan => '5.00 / 250.00',
        roomIdTuHao => '10.00 / 500.00'
    ],
    gameIdNiuNiuSeenCardQZ => [
        roomIdXiaoZi => '1.00 / 50.00',
        roomIdLaoBan => '5.00 / 250.00',
        roomIdTuHao => '10.00 / 500.00'
    ],
    gameIdNiuNiuBaiRen => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdZhaJinHua => [
        roomIdXiaoZi => '1.00 / 50.00',
        roomIdLaoBan => '5.00 / 300.00',
        roomIdTuHao => '10.00 / 600.00'
    ],
    gameIdRedBlack => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdDouDiZhu => [
        roomIdXiaoZi => '0.01 / 1.00',
        roomIdLaoBan => '1.00 / 18.00',
        roomIdTuHao => '5.00 / 120.00'
    ],
    gameIdDouDiZhuHuanLe => [
        roomIdXiaoZi => '0.01 / 1.00',
        roomIdLaoBan => '1.00 / 24.00',
        roomIdTuHao => '5.00 / 120.00'
    ],
    gameIdShiSanZhang => [
        roomIdXiaoZi => '1.00 / 50.00',
        roomIdLaoBan => '5.00 / 400.00',
        roomIdTuHao => '10.00 / 1000.00'
    ],
    gameIdShiSanZhang_5 => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdPaoDeKuai => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdBenChiBaoMa => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdDragonTiger => [
        rooIdUnknown => '1.00 / 50.00',
    ],
    gameIdBaiJiaLe => [
        rooIdUnknown => '1.00 / 50.00',
    ],
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
