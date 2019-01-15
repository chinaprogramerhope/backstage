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
const maxQueryNum = 30; // 最大查询数量

/**
 * 公共常量
 */
const daySeconds = 86400; // 1天秒数
const monthSeconds = 2592000; // 30天秒数

/**
 * 支付相关
 */

// 支付平台 todo 名字转换
const PAY_PLATFORM_JUBAOYUN = 3; // 聚宝云
const PAY_PLATFORM_HUIONE = 4; // 汇旺
const PAY_PLATFORM_YUFU = 5; // 裕付
const PAY_PLATFORM_CHANGFU = 6; // 畅付云
define('PAY_PLATFORM_PINFU', 11);	// 品付
define('PAY_PLATFORM_ZFB_LUOKE', 12);	// 支付宝洛客
define('PAY_PLATFORM_CAIHONG', 13);	// 彩虹
define('PAY_PLATFORM_ZFB_JUNYING', 14);	// 支付宝君赢
define('PAY_PLATFORM_ZFB_ZHIHUI', 15);	// 支付宝智慧
define('PAY_PLATFORM_TMPAY', 16);	// TMPay
define('PAY_PLATFORM_ABPAY', 17);	// 爱贝
define('PAY_PLATFORM_YUFU_CARD', 18);	// 裕付卡支付
define('PAY_PLATFORM_ZFB_QIANKUN', 19);	// 支付宝乾坤
define('PAY_PLATFORM_ZFB_TRANSFER', 20);	// 支付宝转账
define('PAY_PLATFORM_ZFB_TRANSFER_WEB', 21);	// 支付宝web转账
define('PAY_PLATFORM_CHANGFU_CARD', 22);	// 畅付卡支付
define('PAY_PLATFORM_ZFB_ZGY', 23);	// 支付宝众根源
define('PAY_PLATFORM_ZFB_YD', 24);	// 支付宝勇度
define('PAY_PLATFORM_ZFB_LEIZ', 25);	// 支付宝雷正
define('PAY_PLATFORM_ZFB_LONGZ', 26);	// 支付宝龙泽
define('PAY_PLATFORM_ZFB_MYW', 27);	// 支付宝蚂蚁王
define('PAY_PLATFORM_ZFB_SHDKJ', 28);	// 支付宝盛恒达科技
define('PAY_PLATFORM_ZFB_SKLKJ', 29);	// 支付宝顺科利科技
define('PAY_PLATFORM_JMPAY', 30);	// 聚米支付
define('PAY_PLATFORM_WEIPAY', 31);	// 微派支付
define('PAY_PLATFORM_KAIXIN', 32); // 凯新支付
define('PAY_PLATFORM_ZHONGTIETONG',33);  // 中铁通付
define('PAY_PLATFORM_ZHONGTIETONG_QQ',34);  // 中铁通付qq
define('PAY_PLATFORM_FANQIE',35);  // 番茄支付
define('PAY_PLATFORM_LUYI', 36); //路易支付
define('PAY_PLATFORM_CHANGCHENGYUN',37);//长城云支付
define('PAY_PLATFORM_ZFB_HYXXKJ',38); //支付宝汇亿信息科技
define('PAY_PLATFORM_ZFB_HCWLKJ',39); //支付宝宏潮网络科技
define('PAY_PLATFORM_ZFB_PXWLKJ',40); //支付宝鹏兴网络科技
define('PAY_PLATFORM_ZFB_XWWLKJ',41); //支付宝兴旺网络科技
define('PAY_PLATFORM_ZFB_XQXXKJ',42); //支付宝星祺信息科技
define('PAY_PLATFORM_ZFB_CYXXKJ',43); //支付宝长远信息科技
define('PAY_PLATFORM_ZFB_TSWLKJ',44); //支付宝天胜网络科技
define('PAY_PLATFORM_ZFB_JKWLKJ',45); //支付宝吉凯网络科技
define('PAY_PLATFORM_ZFB_XHWLKJ',46); //支付宝星瀚网络科技
define('PAY_PLATFORM_JUHE',47);//聚合支付
define('PAY_PLATFORM_HUIYI',48);//汇亿支付
define('PAY_PLATFORM_LUYI_QQWAP',49);//路易QQWAP
define('PAY_PLATFORM_ZFB_CSXXKJ',50);//支付宝常胜信息科技
define('PAY_PLATFORM_CHANGCHENGQQH5',51);//长城QQ钱包
define('PAY_PLATFORM_HAIFUPAY',52); //海富支付
define('PAY_PLATFORM_ZFB_CHWLKJ',53);//支付宝晨海网络科技
define('PAY_PLATFORM_ZFB_HYWLKJ',54); //支付宝红英网络科技
define('PAY_PLATFORM_ZFB_FBWLKJ',55); //支付宝风暴网络科技
define('PAY_PLATFORM_ZFB_MYWLKJ',56); //支付宝明月网络科技
define('PAY_PLATFORM_ZFB_WXWLKJ',57); //支付宝温馨网络科技
define('PAY_PLATFORM_HUICHAO_ALI',58); //汇潮支付
define('PAY_PLATFORM_DUODEBAO_ALI',59); //多得宝支付
define('PAY_PLATFORM_WEIQQ', 60);	// 微派QQ钱包
define('PAY_PLATFORM_ZFB_DETXXKJ', 61);	// 支付宝达尔特信息科技
define('PAY_PLATFORM_ZFB_KSYLWLKJ', 62);	// 支付宝凯盛亚利网络科技
define('PAY_PLATFORM_ZFB_OTGYWLKJ', 63);	// 支付宝欧特格雅网络科技
define('PAY_PLATFORM_LUYI_QQ99', 64);	// 路易QQ99
define('PAY_PLATFORM_LUYI_JD155', 65);	// 路易JD155
define('PAY_PLATFORM_CHANGCHENGYUN_JD', 66);	//长城云京东
define('PAY_PLATFORM_CHANGCHENGYUN_WX', 67);	//长城云微信
define('PAY_PLATFORM_YISHENG_JD', 68);	//易生京东
define('PAY_PLATFORM_ZFB_MJXXKJ',69); //支付宝淼吉信息科技
define('PAY_PLATFORM_ZFB_YYWLKJ',70); //支付宝盈悦网络科技
define('PAY_PLATFORM_ZFB_XSWLKJ',71); //支付宝晓胜网络科技
define('PAY_PLATFORM_JFT',72); //竣付通
define('PAY_PLATFORM_CHANGCHENGYUN_BANK', 73);	//长城云银联
define('PAY_PLATFORM_WEIPAY_5', 74);	// 微派支付
define('PAY_PLATFORM_ZFB_LGWLKJ',75); 	//广州流光网络科技有限公司
define('PAY_PLATFORM_DSPAY',76); 	//得仕支付
define('PAY_PLATFORM_ZFB_MENJUNWLKJ',77); // 梦君网络科技
define('PAY_PLATFORM_ZHIHUIFU',79); // 智汇付
define('PAY_PLATFORM_JUHENEW', 80);// 新聚合支付
define('PAY_PLATFORM_GUANGDA', 81);// 光大支付
define('PAY_PLATFORM_OFDSC', 82);// OF商城
define('PAY_PLATFORM_WEIJD', 83);	// 微派京东
define('PAY_PLATFORM_ZHJH', 84);	// 兆行聚合
define('PAY_PLATFORM_IMPAY', 85);	// im支付
define('PAY_PLATFORM_JMWXPAY', 86);	// 聚米微信
define('PAY_PLATFORM_PAIPAY', 87);	// 派支付
define('PAY_PLATFORM_PFWXSM', 88);	// 品付微信扫码
define('PAY_PLATFORM_WEENPAY', 89);	// ween支付
define('PAY_PLATFORM_ZFB_GZJXXXJS', 90); // 广州爵星信息技术有限公司
define('PAY_PLATFORM_RONGYINPAY', 91);	// 蓉银支付
define('PAY_PLATFORM_JKWLKJ', 92);	//会昶支付
define('PAY_PLATFORM_BLKYJF', 93);	//80卡云计费
define('PAY_PLATFORM_GXZF', 94);	//广讯支付
define('PAY_PLATFORM_BLKYJF_QQ', 95);	//80卡云计费QQ
define('PAY_PLATFORM_JSF_ZFB', 96);	//及时付支付宝
define('PAY_PLATFORM_JSF_BANK', 97);	//及时付银联
define('PAY_PLATFORM_HFT_ZFB', 98);	//合付通支付宝
define('PAY_PLATFORM_PROMOTION', 99);	//推广代理充值
define('PAY_PLATFORM_JHT_ZFB', 100);	//金汇通
define('PAY_PLATFORM_YUNBEI_ZFB', 101);	//云贝支付宝
define('PAY_PLATFORM_MOSHANG_ZFB', 102);	//陌上支付宝
define('PAY_PLATFORM_YBNEW_ZFB', 103);	//云贝新支付
define('PAY_PLATFORM_WEEN_ZFB', 104);	//WEEN支付宝
define('PAY_PLATFORM_YR_ZFB', 105);	// 永仁支付宝
define('PAY_PLATFORM_521JB_ZFB', 106);	// 521jb支付宝

// 渠道
const channelList = [
    1 => ['channelId' => 1, 'tag' => 'com.liuliugame1.fageqipai1', 'name' => '发哥游戏Ios', 'url' => 'ur1'],
    2 => ['channelId' => 2, 'tag' => 'com.liuliugame1.kuruiyouxi', 'name' => '酷锐游戏Ios', 'url' => 'ur13'],
];

// 支付方式
const payTypeAli = 1;
const payTypeWeChat = 2;
const payTypeCard = 3;
const payTypeQQ = 4;
const payTypeJd = 5;

const payType = [
    payTypeAli => '支付宝',
    payTypeWeChat => '微信',
    payTypeCard => '卡支付',
    payTypeQQ => 'QQ钱包',
    payTypeJd => '京东钱包'
];

const payPlatform = [ // add_time, pay_success_time
    PAY_PLATFORM_JUBAOYUN=>'pay_success_time',// 3 聚宝云
    PAY_PLATFORM_HUIONE=>'add_time',// 4 汇旺
    PAY_PLATFORM_YUFU=>'add_time',// 5 裕付
    PAY_PLATFORM_CHANGFU=>'add_time',// 6 畅付云
    PAY_PLATFORM_PINFU=>'add_time',// 11 品付
    PAY_PLATFORM_ZFB_LUOKE=>'pay_success_time',// 12 支付宝洛客
    PAY_PLATFORM_CAIHONG=>'add_time',// 13 彩虹
    PAY_PLATFORM_ZFB_JUNYING=>'pay_success_time',// 14 支付宝君赢
    PAY_PLATFORM_ZFB_ZHIHUI=>'pay_success_time',// 15 支付宝智慧
    PAY_PLATFORM_TMPAY=>'add_time',// 16 TMPay
    PAY_PLATFORM_ABPAY=>'add_time',// 17 爱贝
    PAY_PLATFORM_YUFU_CARD=>'add_time',// 18 裕付卡支付
    PAY_PLATFORM_ZFB_QIANKUN=>'pay_success_time',// 19 支付宝乾坤
    PAY_PLATFORM_ZFB_TRANSFER=>'add_time',// 20 支付宝转账
    PAY_PLATFORM_ZFB_TRANSFER_WEB=>'pay_success_time',// 21 支付宝web转账
    PAY_PLATFORM_CHANGFU_CARD=>'add_time',// 22 畅付卡支付
    PAY_PLATFORM_ZFB_ZGY=>'pay_success_time',// 23 支付宝众根源
    PAY_PLATFORM_ZFB_YD=>'pay_success_time',// 24 支付宝勇度
    PAY_PLATFORM_ZFB_LEIZ=>'pay_success_time',// 25 支付宝雷正
    PAY_PLATFORM_ZFB_LONGZ=>'pay_success_time',// 26 支付宝龙泽
    PAY_PLATFORM_ZFB_MYW=>'pay_success_time',// 27 支付宝蚂蚁王
    PAY_PLATFORM_ZFB_SHDKJ=>'pay_success_time',// 28 支付宝盛恒达科技
    PAY_PLATFORM_ZFB_SKLKJ=>'pay_success_time',// 29 支付宝顺科利科技
    PAY_PLATFORM_JMPAY=>'add_time',// 30 聚米支付
    PAY_PLATFORM_WEIPAY=>'pay_success_time',//31 微派支付-到帐时间
    PAY_PLATFORM_KAIXIN=>'add_time',// 32 凯新支付
    PAY_PLATFORM_ZHONGTIETONG=>'add_time',// 33 中铁通付
    PAY_PLATFORM_ZHONGTIETONG_QQ=>'add_time',// 34 中铁通付qq
    PAY_PLATFORM_FANQIE=>'pay_success_time',// 35 番茄支付-到帐时间
    PAY_PLATFORM_LUYI=>'pay_success_time',// 36 路易支付
    PAY_PLATFORM_CHANGCHENGYUN=>'add_time',// 37 长城云支付
    PAY_PLATFORM_ZFB_HYXXKJ=>'pay_success_time',// 38 支付宝汇亿信息科技
    PAY_PLATFORM_ZFB_HCWLKJ=>'pay_success_time',// 39 支付宝宏潮网络科技
    PAY_PLATFORM_ZFB_PXWLKJ=>'pay_success_time',// 40 支付宝鹏兴网络科技
    PAY_PLATFORM_ZFB_XWWLKJ=>'pay_success_time',// 41 支付宝兴旺网络科技
    PAY_PLATFORM_ZFB_XQXXKJ=>'pay_success_time',// 42 支付宝星祺信息科技
    PAY_PLATFORM_ZFB_CYXXKJ=>'pay_success_time',// 43 支付宝长远信息科技
    PAY_PLATFORM_ZFB_TSWLKJ=>'pay_success_time',// 44 支付宝天胜网络科技
    PAY_PLATFORM_ZFB_JKWLKJ=>'pay_success_time',// 45 支付宝吉凯网络科技
    PAY_PLATFORM_ZFB_XHWLKJ=>'pay_success_time',// 46 支付宝星瀚网络科技
    PAY_PLATFORM_JUHE=>'pay_success_time',// 47聚合
    PAY_PLATFORM_HUIYI=>'pay_success_time',// 48汇亿
    PAY_PLATFORM_LUYI_QQWAP=>'pay_success_time',// 49路易QQWAP
    PAY_PLATFORM_ZFB_CSXXKJ=>'pay_success_time',// 50支付宝常胜信息科技
    PAY_PLATFORM_CHANGCHENGQQH5=>'add_time',// 51 长城QQ钱包
    PAY_PLATFORM_HAIFUPAY=>'add_time',//52 海富支付
    PAY_PLATFORM_ZFB_CHWLKJ=>'pay_success_time',//53 支付宝晨海网络科技
    PAY_PLATFORM_ZFB_HYWLKJ=>'pay_success_time',//54 支付宝红英网络科技
    PAY_PLATFORM_ZFB_FBWLKJ=>'pay_success_time',//55 支付宝风暴网络科技
    PAY_PLATFORM_ZFB_MYWLKJ=>'pay_success_time',//56 支付宝明月网络科技
    PAY_PLATFORM_ZFB_WXWLKJ=>'pay_success_time',//57 支付宝温馨网络科技
    PAY_PLATFORM_LUYI_QQ99=>'pay_success_time',//路易QQ99
    PAY_PLATFORM_WEIQQ=>'pay_success_time',// 60 微派QQ
    99=>'add_time',
    100=>'add_time',
];

const payTimeDelay = [];

const ownPay = [
    PAY_PLATFORM_IMPAY => 'im支付',
    PAY_PLATFORM_PROMOTION => '推广代理充值',
];

const ylPay = [
    PAY_PLATFORM_HAIFUPAY => '海富支付',
    PAY_PLATFORM_CHANGCHENGYUN_BANK => '长城云银联',
    PAY_PLATFORM_JUBAOYUN => '聚宝云',
    PAY_PLATFORM_WEENPAY => 'ween支付',
    PAY_PLATFORM_JSF_BANK => '及时付银联',
];

const jdPay = [
    PAY_PLATFORM_LUYI_JD155 => '路易JD155',
    PAY_PLATFORM_CHANGCHENGYUN_JD => '长城云京东',
    PAY_PLATFORM_PINFU => '品付',
    PAY_PLATFORM_YISHENG_JD => '易生京东',
    PAY_PLATFORM_WEIJD => '微派京东',
];

const qqPay = [
    PAY_PLATFORM_WEENPAY => 'ween支付',
    PAY_PLATFORM_BLKYJF_QQ => '80卡云计费QQ',
    PAY_PLATFORM_LUYI_QQWAP => '路易QQWAP',
    PAY_PLATFORM_CHANGCHENGQQH5=>'长城QQ钱包',
    PAY_PLATFORM_WEIQQ=>'微派QQ钱包',
    PAY_PLATFORM_LUYI_QQ99 => '路易QQ99',
    PAY_PLATFORM_PINFU => '品付',
    PAY_PLATFORM_JUBAOYUN => '聚宝云',
];

const wxPay = [
    PAY_PLATFORM_CHANGFU => '畅付',
    PAY_PLATFORM_PINFU => '品付',
    PAY_PLATFORM_JUBAOYUN => '聚宝云',
    PAY_PLATFORM_CHANGCHENGYUN_WX => '长城云微信',
    PAY_PLATFORM_DSPAY => '得仕支付',
    PAY_PLATFORM_ZHIHUIFU => '智汇付',
    PAY_PLATFORM_JUHENEW => '新聚合支付',
    PAY_PLATFORM_PFWXSM => '品付微信扫码',
    PAY_PLATFORM_OFDSC => 'OF商城',
];

const aliPayPay = [
    PAY_PLATFORM_CHANGCHENGYUN => '长城云',
    PAY_PLATFORM_PAIPAY=>'派支付',
    PAY_PLATFORM_RONGYINPAY => '蓉银支付',
    PAY_PLATFORM_HFT_ZFB => '合付通支付宝',
    PAY_PLATFORM_MOSHANG_ZFB => '陌上支付宝',
    PAY_PLATFORM_YUNBEI_ZFB => '云贝支付宝',
    PAY_PLATFORM_YBNEW_ZFB => '云贝新支付',
    PAY_PLATFORM_WEEN_ZFB => 'WEEN支付宝',
    PAY_PLATFORM_YR_ZFB => '永仁支付宝',
    PAY_PLATFORM_521JB_ZFB => '521jb支付宝',
    PAY_PLATFORM_JKWLKJ => '会昶支付',
    PAY_PLATFORM_BLKYJF => '80卡云计费',
    PAY_PLATFORM_JSF_ZFB => '及时付支付宝',
    PAY_PLATFORM_GXZF => '广讯支付',
    PAY_PLATFORM_PINFU => '品付',
    PAY_PLATFORM_ABPAY => '爱贝',
    PAY_PLATFORM_JUBAOYUN => '聚宝云',
    PAY_PLATFORM_WEIPAY => '微派',
    PAY_PLATFORM_ZHONGTIETONG => '中铁通',
    PAY_PLATFORM_LUYI => '路易支付',
    PAY_PLATFORM_ZFB_TRANSFER=>'支付宝转账',
    PAY_PLATFORM_ZFB_TRANSFER_WEB=>'支付宝web转账',
    PAY_PLATFORM_HAIFUPAY => '海富支付',
    PAY_PLATFORM_JFT => '竣付通',
    PAY_PLATFORM_WEIPAY_5 => '微派（5点）',
    PAY_PLATFORM_ZHJH=>'兆行聚合',
];

const officialAliPayPay = [
    PAY_PLATFORM_ZFB_FBWLKJ => '支付宝风暴网络科技',
    PAY_PLATFORM_ZFB_MYWLKJ => '支付宝明月网络科技',
    PAY_PLATFORM_ZFB_WXWLKJ => '支付宝温馨网络科技',
    PAY_PLATFORM_ZFB_MJXXKJ => '支付宝淼吉信息科技',
    PAY_PLATFORM_ZFB_YYWLKJ => '支付宝盈悦网络科技',
    PAY_PLATFORM_ZFB_XSWLKJ => '支付宝晓胜网络科技',
    PAY_PLATFORM_ZFB_OTGYWLKJ=>'支付宝欧特格雅网络科技',
    PAY_PLATFORM_ZFB_LGWLKJ => '支付宝流光网络科技',
    PAY_PLATFORM_ZFB_MENJUNWLKJ => '支付宝梦君网络科技',
    PAY_PLATFORM_ZFB_GZJXXXJS => '支付宝爵星信息技术',
];

const noChannelList = [
    //	49=>'全民玩德扑Ios',
    //	1049=>'全民玩德扑Android',
    //	54 => '月月电玩城Ios',
    //	1054 => '月月电玩城Android'
];

// 提现订单状态
const cashOrderStatusNew = 0; // 新订单
const cashOrderStatusSuccess = 1; // 提现成功
const cashOrderStatusFail = 2; // 提现失败
const cashOrderStatusWaitReview = 3; // 等待审核
const cashOrderStatusReviewPass = 4; // 审核通过
const cashOrderStatusUnknown = 5; // 未知状态
const cashOrderStatusDealing = 6; // 处理中
const cashOrderStatusNotComplete = 100; // 未完成(包含0, 3, 4, 5, 6)

// 代付订单状态
const payOrderStatus = [
    "0" => '待处理',
    "10000" => '打款成功',
    "10001" => '转账处理中',
    "10002" => '转账失败',
    "10003" => '转账取消',
    "10004" => '余额查询成功',
    "10005" => '查无此交易',
    "10101" => '单笔金额超出支付上限',
    "10102" => '总金额超出支付上限',
    "10103" => '余额不足',
    "10201" => '请求参数不正确',
    "10301" => 'sign 签名不正确',
    "10302" => 'key 值不存在或未开通',
    "10303" => 'appid 错误',
    "10304" => '打款记录已经存在',
    "10401" => '请求异常',
    "10500" => '未知错误',
];


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


/**
 * 公告管理
 */

// 公告状态
const messageStatusOpen = 1;
const messageStatusClose = 2;
const messageStatus = [
    messageStatusOpen => '启用',
    messageStatusClose => '禁用',
];

// 是否轮播
const messageCarouselYes = 1;
const messageCarouselNo = 2;
const messageCarousel = [
    messageCarouselYes => '是',
    messageCarouselNo => '否'
];

// 发送区域
const messageAreaAll = -1;
const messageAreaInbox = 1;
const messageAreaRidingLantern = 2;
const messageArea = [
    messageAreaAll => '全部',
    messageAreaInbox => '收件箱',
    messageAreaRidingLantern => '走马灯'
];

// 使用终端
const messageTerminalAll = -1;
const messageTerminalPc = 1;
const messageTerminalMobile = 2;
const messageTerminal = [
    messageTerminalAll => '全部',
    messageTerminalPc => '电脑端',
    messageTerminalMobile => '移动端'
];

// 渠道
const messageChannel1 = 1;
const messageChannel2 = 2;
const messageChannel3 = 3;
const messageChannel = [
    messageChannel1 => '渠道1',
    messageChannel2 => '渠道2',
    messageChannel3 => '渠道3',
];

/**
 * 用户管理
 */
