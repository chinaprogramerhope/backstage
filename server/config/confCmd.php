<?php
/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 接口cmd
 */
const cmdArr = [
    // 首页 1 - 50
    1 => ['svc' => 'svcHomepage', 'func' => 'getHead'], // 首页 - 获取头部信息
    2 => ['svc' => 'svcHomepage', 'func' => 'getNum'], // 首页 - 获取笔数/人数
    3 => ['svc' => 'svcHomepage', 'func' => 'getCharge'], // 首页 - 获取充提
    4 => ['svc' => 'svcHomepage', 'func' => 'getProfit'], // 首页 - 获取盈亏
    5 => ['svc' => 'svcHomepage', 'func' => 'getOnlineNum'], // 首页 - 获取在线人数
    6 => ['svc' => 'svcAdmin', 'func' => 'login'], // 登录 - 获取管理员信息
    7 => ['svc' => 'svcAdmin', 'func' => 'register'], // 注册
    8 => ['svc' => 'svcAdmin', 'func' => 'createVerifyCode'], // 获取注册验证码


    // 会员管理 51 - 100
    51 => ['svc' => 'svcMember', 'func' => 'getList'], // 获取会员列表

    52 => ['svc' => 'svcMember', 'func' => 'getLoginLog'], // 获取登陆日志

    53 => ['svc' => 'svcMember', 'func' => 'getLabel'], // 获取标签
    54 => ['svc' => 'svcMember', 'func' => 'addLabel'], // 添加标签
    55 => ['svc' => 'svcMember', 'func' => 'editLabel'], // 编辑标签
    56 => ['svc' => 'svcMember', 'func' => 'delLabel'], // 删除标签

    57 => ['svc' => 'svcMember', 'func' => 'getLv'], // 获取等级
    58 => ['svc' => 'svcMember', 'func' => 'addLv'], // 新增等级
    59 => ['svc' => 'svcMember', 'func' => 'editLv'], // 编辑等级
    60 => ['svc' => 'svcMember', 'func' => 'delLv'], // 删除等级

    // 游戏管理 101 - 150
    101 => ['svc' => 'svcGame', 'func' => 'listGet'], // 游戏列表 - 获取游戏列表
    102 => ['svc' => 'svcGame', 'func' => 'listChangeStatus'], // 游戏列表 - 编辑(更改游戏状态) - 废弃
    103 => ['svc' => 'svcGame', 'func' => 'roomGet'], // 游戏列表 - 获取游戏房间
    104 => ['svc' => 'svcGame', 'func' => 'roomChangeTaxRatio'], // 游戏列表 - 游戏房间 - 更改税收比例
    105 => ['svc' => 'svcGame', 'func' => 'roomClose'], // 游戏列表 - 游戏房间 - 禁用 - 废弃
    106 => ['svc' => 'svcGame', 'func' => 'groupGet'], // 游戏分组 - 获取游戏分组
    107 => ['svc' => 'svcGame', 'func' => 'groupGetGames'], // 游戏分组 - 获取分组内的游戏
    108 => ['svc' => 'svcGame', 'func' => 'groupStick'], // 游戏分组 - 设为置顶
    109 => ['svc' => 'svcGame', 'func' => 'groupCancelPopular'], // 游戏分组 - 取消热门
    110 => ['svc' => 'svcGame', 'func' => 'betRecordGet'], // 投注记录 - 获取
    111 => ['svc' => 'svcGame', 'func' => 'betRecordGetDetail'], // 投注记录 - 获取详细

    // 财务管理 151 - 200
    151 => ['svc' => 'svcFinance', 'func' => 'manualOperate'], // 人工存提
    152 => ['svc' => 'svcFinance', 'func' => 'officialChargeGet'], // 官方支付 - 获取
    153 => ['svc' => 'svcFinance', 'func' => 'onlinePayGet'], // 线上支付 - 获取
    154 => ['svc' => 'svcFinance', 'func' => 'aliPayAuditGet'], // 支付宝出款审核 - 获取
    155 => ['svc' => 'svcFinance', 'func' => 'bankCardAuditGet'], // 银行卡出款审核 - 获取
    156 => ['svc' => 'svcFinance', 'func' => 'autoPayTradeRecordGet'], // 自动出款交易记录
    157 => ['svc' => 'svcFinance', 'func' => 'financeConfig'], // 出入款配置 todo 这个标签页接口挺多

    158 => ['svc' => 'svcFinance', 'func' => 'finStatisticsGet'], // 财务统计 - 获取
    159 => ['svc' => 'svcFinance', 'func' => 'finStatisticsUpdate'], // 财务统计 - 更新昨日充值数据
    160 => ['svc' => 'svcFinance', 'func' => 'payStatisticsGet'], // 支付统计 - 获取
    161 => ['svc' => 'svcFinance', 'func' => 'withdrawalTotalGet'], // 提现总额统计 - 获取
    162 => ['svc' => 'svcFinance', 'func' => 'financeReportGet'], // 运营统计 - 获取
    163 => ['svc' => 'svcFinance', 'func' => 'reconciliationReportGet'], // 对账统计 - 获取
    164 => ['svc' => 'svcFinance', 'func' => 'payAccountManageGet'], // 代付账号管理 - 获取
    165 => ['svc' => 'svcFinance', 'func' => 'payAccountManageCreate'], // 代付账号管理 - 创建新账号
    166 => ['svc' => 'svcFinance', 'func' => 'payOrderManageGet'], // 代付订单管理 - 获取
    167 => ['svc' => 'svcFinance', 'func' => 'payOrderManageUpdate'], // 代付订单管理 - 更新派支付提款单状态
    168 => ['svc' => 'svcFinance', 'func' => 'payAccountManageCashWithdrawal'], // 代付账号管理 - 提现

    // 公告管理 201 - 250
    201 => ['svc' => 'svcMessage', 'func' => 'announceListGet'], // 公告列表 - 获取
    202 => ['svc' => 'svcMessage', 'func' => 'announceListAdd'], // 公告列表 - 添加
    203 => ['svc' => 'svcMessage', 'func' => 'announceListEdit'], // 公告列表 - 编辑
    204 => ['svc' => 'svcMessage', 'func' => 'announceListDel'], // 公告列表 - 删除
    205 => ['svc' => 'svcMessage', 'func' => 'stationMessageGet'], // 站内消息 - 获取
    206 => ['svc' => 'svcMessage', 'func' => 'stationMessageSend'], // 站内消息 - 发新消息
    207 => ['svc' => 'svcMessage', 'func' => 'stationMessageViewMsg'], // 站内消息 - 查看消息
    208 => ['svc' => 'svcMessage', 'func' => 'stationMessageViewRecipient'], // 站内消息 - 查看收件人

    // 推广管理 251 - 300
    251 => ['svc' => 'svcPromotion', 'func' => 'promotionUserGet'], // 推广玩家 - 获取
    252 => ['svc' => 'svcPromotion', 'func' => 'promotionReportGet'], // 推广报表 - 获取
    253 => ['svc' => 'svcPromotion', 'func' => 'promotionReportView'], // 推广报表 - 查看(上级/下级)
    254 => ['svc' => 'svcPromotion', 'func' => 'promotionRebateGet'], // 推广返利 - 获取
    255 => ['svc' => 'svcPromotion', 'func' => 'rebateSettingsGet'], // 返利设置 - 获取
    256 => ['svc' => 'svcPromotion', 'func' => 'rebateSettingsAdd'], // 返利设置 - 新增
    257 => ['svc' => 'svcPromotion', 'func' => 'rebateSettingsExpSet'], // 返利设置 - 返利经验设置
    258 => ['svc' => 'svcPromotion', 'func' => 'rebateSettingsEdit'], // 返利设置 - 编辑
    259 => ['svc' => 'svcPromotion', 'func' => 'stationMessageViewRecipient'], // 站内消息 - 查看收件人

    260 => ['svc' => 'svcPromotion', 'func' => 'promotionAccountGet'], // 推广账号 - 获取
    261 => ['svc' => 'svcPromotion', 'func' => 'promotionAccountAdd'], // 推广账号 - 添加
    262 => ['svc' => 'svcPromotion', 'func' => 'promotionAccountEdit'], // 推广账号 - 修改
    263 => ['svc' => 'svcPromotion', 'func' => 'promotionAccountOperationLogGet'], // 推广账号 - 获取操作日志
    264 => ['svc' => 'svcPromotion', 'func' => 'promotionAccountIncomeGet'], // 推广账号 - 获取收入统计

    265 => ['svc' => 'svcPromotion', 'func' => 'promotionBalanceLogGet'], // 推广信用金日志 - 获取

    266 => ['svc' => 'svcPromotion', 'func' => 'promotionStatisticsGet'], // 推广统计 - 获取
    267 => ['svc' => 'svcPromotion', 'func' => 'promotionStatisticsOneGet'], // 推广统计 - 统计
    268 => ['svc' => 'svcPromotion', 'func' => 'promotionStatisticsOneQuery'], // 推广统计 - 查询

    269 => ['svc' => 'svcPromotion', 'func' => 'promotionCorrectionGetId'], // 推广ID修正 - 修正推广链id - 查询
    270 => ['svc' => 'svcPromotion', 'func' => 'promotionCorrectionUpdate'], // 推广ID修正 - 修正推广链id - 提交
    271 => ['svc' => 'svcPromotion', 'func' => 'promotionCorrectionGetLog'], // 推广ID修正 - 获取修正日志


    // 系统设置 301 - 350
    301 => ['svc' => 'svcSystem', 'func' => 'subAccountGet'], // 厅主子账号管理 - 获取
    302 => ['svc' => 'svcSystem', 'func' => 'subAccountAdd'], // 厅主子账号管理 - 添加
    303 => ['svc' => 'svcSystem', 'func' => 'subAccountEdit'], // 厅主子账号管理 - 编辑
    304 => ['svc' => 'svcSystem', 'func' => 'subAccountForbid'], // 厅主子账号管理 - 禁用

    305 => ['svc' => 'svcSystem', 'func' => 'globalParamSave'], // 全局参数 - 保存
    306 => ['svc' => 'svcSystem', 'func' => 'subAccountUpload'], // 全局参数 - 上传
    307 => ['svc' => 'svcSystem', 'func' => 'subAccountReset'], // 全局参数 - 重置

    308 => ['svc' => 'svcSystem', 'func' => 'userProfileGet'], // 个人资料设置 - 获取
    309 => ['svc' => 'svcSystem', 'func' => 'userProfileSaveName'], // 个人资料设置 - 保存姓名
    310 => ['svc' => 'svcSystem', 'func' => 'userProfileBindGoogle'], // 个人资料设置 - 绑定google身份验证器
    311 => ['svc' => 'svcSystem', 'func' => 'userProfileBindPhone'], // 个人资料设置 - 绑定手机
    312 => ['svc' => 'svcSystem', 'func' => 'userProfileChangePass'], // 个人资料设置 - 修改密码
    313 => ['svc' => 'svcSystem', 'func' => 'userProfileTwoStepVerify'], // 个人资料设置 - 两步验证 (未启用/启用)

    314 => ['svc' => 'svcSystem', 'func' => 'operateLogGet'], // 操作日志 - 获取

    315 => ['svc' => 'svcSystem', 'func' => 'downloadConfGet'], // 下载设置 - 获取
    316 => ['svc' => 'svcSystem', 'func' => 'downloadConfEdit'], // 下载设置 - 编辑 - 保存
    317 => ['svc' => 'svcSystem', 'func' => 'downloadConfUpload'], // 下载设置 - 编辑 - 上传
    318 => ['svc' => 'svcSystem', 'func' => 'downloadConfDelUpload'], // 下载设置 - 编辑 - 删除已上传

    319 => ['svc' => 'svcSystem', 'func' => 'roleManageGet'], // 角色管理 - 获取
    320 => ['svc' => 'svcSystem', 'func' => 'roleManageAdd'], // 角色管理 - 添加
    321 => ['svc' => 'svcSystem', 'func' => 'roleManageEdit'], // 角色管理 - 编辑
    322 => ['svc' => 'svcSystem', 'func' => 'roleManageForbid'], // 角色管理 - 禁用
    323 => ['svc' => 'svcSystem', 'func' => 'roleManageDel'], // 角色管理 - 删除
    324 => ['svc' => 'svcSystem', 'func' => 'roleManageSave'], // 角色管理 - 权限控制 - 保存

    // 运营管理 351 - 400
    351 => ['svc' => 'svcOperation', 'func' => 'gameReportGet'], // 游戏报表 - 获取

    352 => ['svc' => 'svcOperation', 'func' => 'moneyReportGet'], // 资金帐变 - 获取

    353 => ['svc' => 'svcOperation', 'func' => 'systemProfitGet'], // 系统利润 - 获取

    // 活动管理 401 - 450
    401 => ['svc' => 'svcActivity', 'func' => 'activityReportGet'], // 活动报表 - 获取

    402 => ['svc' => 'svcActivity', 'func' => 'activityListGet'], // 活动列表 - 获取

    403 => ['svc' => 'svcActivity', 'func' => 'commonActivitySave'], // 常规活动 - 保存

    // 网站管理 451 - 500
    451 => ['svc' => 'svcWebsite', 'func' => 'bannerSettingGet'], // 轮播图设置 - 获取
    452 => ['svc' => 'svcWebsite', 'func' => 'bannerSettingUpload'], // 轮播图设置 - 上传
    453 => ['svc' => 'svcWebsite', 'func' => 'bannerSettingSave'], // 轮播图设置 - 保存

    454 => ['svc' => 'svcWebsite', 'func' => 'adSettingUpload'], // 广告图设置 - 上传
    455 => ['svc' => 'svcWebsite', 'func' => 'adSettingSave'], // 广告图设置 - 保存
];