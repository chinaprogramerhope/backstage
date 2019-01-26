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

    61 => ['svc' => 'svcMember', 'func' => 'getDetail'], // 用户详情 - 获取用户详细信息
    62 => ['svc' => 'svcMember', 'func' => 'updateDetail'], // 用户详情 - 更新用户详细信息

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
    112 => ['svc' => 'svcGame', 'func' => 'betRecordGetBaseScore'], // 投注记录 - 获取某游戏的底分

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

    354 => ['svc' => 'svcOperation', 'func' => 'systemMaintenanceSwitch'], // 系统维护 - 游戏开关

    355 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeGetGameList'], // 整包升级服务器管理 - 获取游戏包列表
    356 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeGet'], // 整包升级服务器管理 - 获取
    357 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeAdd'], // 整包升级服务器管理 - 添加游戏版本
    358 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeRefresh'], // 整包升级服务器管理 - 刷新redis
    359 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeDel'], // 整包升级服务器管理 - 删除
    360 => ['svc' => 'svcOperation', 'func' => 'packageUpgradeChangeStatus'], // 整包升级服务器管理 - 上线/下线

    361 => ['svc' => 'svcOperation', 'func' => 'moduleUpgradeGet'], // 模块升级服务器管理 - 获取
    362 => ['svc' => 'svcOperation', 'func' => 'moduleUpgradeModify'], // 模块升级服务器管理 - 修改

    363 => ['svc' => 'svcOperation', 'func' => 'gameSwitchGet'], // 游戏开关管理 - 获取
    364 => ['svc' => 'svcOperation', 'func' => 'gameSwitchEdit'], // 游戏开关管理 - 编辑

    365 => ['svc' => 'svcOperation', 'func' => 'aliPayTransferGet'], // 转账支付宝管理 - 获取
    366 => ['svc' => 'svcOperation', 'func' => 'aliPayTransferModifyTime'], // 转账支付宝管理 - 修改开关时间
    367 => ['svc' => 'svcOperation', 'func' => 'aliPayTransferModifyStatus'], // 转账支付宝管理 - 打开/关闭账号

    368 => ['svc' => 'svcOperation', 'func' => 'paymentSwitch'], // 支付管理 - 支付总开关
    369 => ['svc' => 'svcOperation', 'func' => 'paymentAliPayThird'], // 支付管理 - 支付宝第三方
    370 => ['svc' => 'svcOperation', 'func' => 'paymentAliPayOfficial'], // 支付管理 - 支付宝官方
    371 => ['svc' => 'svcOperation', 'func' => 'paymentWeChatThird'], // 支付管理 - 微信第三方
    372 => ['svc' => 'svcOperation', 'func' => 'paymentQqThird'], // 支付管理 - qq第三方
    373 => ['svc' => 'svcOperation', 'func' => 'paymentJdThird'], // 支付管理 - 京东钱包第三方
    374 => ['svc' => 'svcOperation', 'func' => 'paymentYlThird'], // 支付管理 - 银联快捷支付
    375 => ['svc' => 'svcOperation', 'func' => 'paymentConfig'], // 支付管理 - 配置支付渠道参数

    376 => ['svc' => 'svcOperation', 'func' => 'proxyIpGet'], // Proxy Ip管理 - 获取
    377 => ['svc' => 'svcOperation', 'func' => 'proxyIpSave'], // Proxy Ip管理 - 保存
    378 => ['svc' => 'svcOperation', 'func' => 'proxyIpRedisSync'], // Proxy Ip管理 - 同步到redis

    379 => ['svc' => 'svcOperation', 'func' => 'agentAccountGet'], // 代理账号管理 - 获取
    380 => ['svc' => 'svcOperation', 'func' => 'agentAccountAdd'], // 代理账号管理 - 添加
    381 => ['svc' => 'svcOperation', 'func' => 'agentAccountEdit'], // 代理账号管理 - 修改
    382 => ['svc' => 'svcOperation', 'func' => 'agentAccountDel'], // 代理账号管理 - 删除

    383 => ['svc' => 'svcOperation', 'func' => 'stopServer'], // 紧急停服

    384 => ['svc' => 'svcOperation', 'func' => 'goldAddLogGet'], // 增加金币记录 - 获取

    385 => ['svc' => 'svcOperation', 'func' => 'bindPhoneLogGet'], // 绑定手机记录 - 获取

    386 => ['svc' => 'svcOperation', 'func' => 'bindAliPayLogGet'], // 绑定支付宝记录 - 获取

    387 => ['svc' => 'svcOperation', 'func' => 'payLimitGet'], // 禁止支付管理 - 获取
    388 => ['svc' => 'svcOperation', 'func' => 'payLimitBlackAdd'], // 禁止支付管理 - 添加充值黑名单
    389 => ['svc' => 'svcOperation', 'func' => 'payLimitBlackRedisSync'], // 禁止支付管理 - 同步黑名单到redis
    390 => ['svc' => 'svcOperation', 'func' => 'payLimitDel'], // 禁止支付管理 - 删除

    391 => ['svc' => 'svcOperation', 'func' => 'rechargeLogGet'], // 账号及充值查询 - 获取

    392 => ['svc' => 'svcOperation', 'func' => 'chongLingSwitchEditPay'], // 充领开关 - 修改充
    393 => ['svc' => 'svcOperation', 'func' => 'chongLingSwitchEditTake'], // 充领开关 - 修改领


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

    // 客服管理 501 - 550
    501 => ['svc' => 'svcCustomer', 'func' => 'userDetailGet'], // 用户信息管理 - 获取用户详细信息
    502 => ['svc' => 'svcCustomer', 'func' => 'userDetailGetMax'], // 用户信息管理 - 金豆+保险箱最大的
    503 => ['svc' => 'svcCustomer', 'func' => 'userDetailUpdate'], // 用户信息管理 - 更新操作

    504 => ['svc' => 'svcCustomer', 'func' => 'userRegisterListGet'], // 用户注册列表 - 获取

    505 => ['svc' => 'svcCustomer', 'func' => 'blacklistGet'], // 黑名单信息管理 - 获取
    506 => ['svc' => 'svcCustomer', 'func' => 'blacklistBatchDeBlock'], // 黑名单信息管理 - 解封批操作
    507 => ['svc' => 'svcCustomer', 'func' => 'blacklistDeBlock'], // 黑名单信息管理 - 解封单个
    508 => ['svc' => 'svcCustomer', 'func' => 'blacklistBatchBlock'], // 黑名单信息管理 - 批量踢出相关用户id
    509 => ['svc' => 'svcCustomer', 'func' => 'blacklistBatchBlockPass'], // 黑名单信息管理 - 批量封用户id-恶劣密码

    510 => ['svc' => 'svcCustomer', 'func' => 'gameLogGet'], // 玩家游戏记录(就是投注记录) - 查询
    511 => ['svc' => 'svcCustomer', 'func' => 'gameLogGetTimes'], // 玩家游戏记录(就是投注记录) - 查询游戏次数

    512 => ['svc' => 'svcCustomer', 'func' => 'goldLogGet'], // 玩家金豆变化记录 - 获取
    513 => ['svc' => 'svcCustomer', 'func' => 'goldLogExport'], // 玩家金豆变化记录 - 导出excel

    514 => ['svc' => 'svcCustomer', 'func' => 'goldLog24Get'], // 玩家金豆变化(24小时内)

    515 => ['svc' => 'svcCustomer', 'func' => 'orderInfoGet'], // 玩家订单查询 - 获取
    516 => ['svc' => 'svcCustomer', 'func' => 'orderInfoGetDelay'], // 玩家订单查询 - 获取延时订单

    517 => ['svc' => 'svcCustomer', 'func' => 'aliPayTransferCheckGet'], // 支付宝转账订单审核 - 获取支付宝转账订单
    518 => ['svc' => 'svcCustomer', 'func' => 'aliPayTransferCheckConfirm'], // 支付宝转账订单审核 - 确认转账成功
    519 => ['svc' => 'svcCustomer', 'func' => 'aliPayTransferCheckModify'], // 支付宝转账订单审核 - 修改金额
    520 => ['svc' => 'svcCustomer', 'func' => 'aliPayTransferCheckClose'], // 支付宝转账订单审核 - 关闭订单

    521 => ['svc' => 'svcCustomer', 'func' => 'aliPayTransferCardGet'], // 支付宝转账卡号卡密 - 获取

    522 => ['svc' => 'svcCustomer', 'func' => 'clientBugGet'], // 客户端缺陷工单 - 获取
    523 => ['svc' => 'svcCustomer', 'func' => 'clientBugBatchClose'], // 客户端缺陷工单 - 批量处理关闭
    524 => ['svc' => 'svcCustomer', 'func' => 'clientBugOneCreate'], // 客户端缺陷工单 - 单个工单 - 创建
    525 => ['svc' => 'svcCustomer', 'func' => 'clientBugOneGet'], // 客户端缺陷工单 - 单个工单 - 查看
    526 => ['svc' => 'svcCustomer', 'func' => 'clientBugOneUpdate'], // 客户端缺陷工单 - 单个工单 - 关闭
    527 => ['svc' => 'svcCustomer', 'func' => 'clientBugOneDel'], // 客户端缺陷工单 - 单个工单 - 删除

    528 => ['svc' => 'svcCustomer', 'func' => 'userReportGet'], // 举报管理 - 获取
    529 => ['svc' => 'svcCustomer', 'func' => 'userReportPlayback'], // 举报管理 - 回放
    530 => ['svc' => 'svcCustomer', 'func' => 'userReportReply'], // 举报管理 - 回复

    531 => ['svc' => 'svcCustomer', 'func' => 'onlineGet'], // 在线客服 - 获取
    532 => ['svc' => 'svcCustomer', 'func' => 'onlineQuickReplyAdd'], // 在线客服 - 添加快捷回复
    533 => ['svc' => 'svcCustomer', 'func' => 'onlineQuickReplyGet'], // 在线客服 - 获取快捷回复
    534 => ['svc' => 'svcCustomer', 'func' => 'onlineForbidWord'], // 在线客服 - 禁言
    535 => ['svc' => 'svcCustomer', 'func' => 'onlineCloseAndAccept'], // 在线客服 - 关闭并受理
    536 => ['svc' => 'svcCustomer', 'func' => 'onlineReply'], // 在线客服 - 回复
    537 => ['svc' => 'svcCustomer', 'func' => 'onlineReplyAndNext'], // 在线客服 - 回复并查看下一条
    538 => ['svc' => 'svcCustomer', 'func' => 'onlineBatchTransfer'], // 在线客服 - 批量转客服
    539 => ['svc' => 'svcCustomer', 'func' => 'onlineGetUrgentReplyAdd'], // 在线客服 - 设置紧急回复
    540 => ['svc' => 'svcCustomer', 'func' => 'onlineManualRechargeOpen'], // 在线客服 - 开启人工充值
    541 => ['svc' => 'svcCustomer', 'func' => 'onlineSetOnline'], // 在线客服 - 设置在线
    542 => ['svc' => 'svcCustomer', 'func' => 'onlineTransfer'], // 在线客服 - 转给其他客服
    543 => ['svc' => 'svcCustomer', 'func' => 'onlineFinish'], // 在线客服 - 客服结束
    544 => ['svc' => 'svcCustomer', 'func' => 'onlineCancelForbidWord'], // 在线客服 - 取消禁言

    545 => ['svc' => 'svcCustomer', 'func' => 'aliPayCashManageGet'], // 提现支付宝管理 - 获取
    546 => ['svc' => 'svcCustomer', 'func' => 'aliPayCashManageSwitch'], // 提现支付宝管理 - 开启/关闭总闸
    548 => ['svc' => 'svcCustomer', 'func' => 'aliPayCashManageAddAliPay'], // 提现支付宝管理 - 添加新支付宝 todo admin页面
    549 => ['svc' => 'svcCustomer', 'func' => 'aliPayCashManageForbid'], // 提现支付宝管理 - 禁用 todo admin页面
    550 => ['svc' => 'svcCustomer', 'func' => 'aliPayCashManageDel'], // 提现支付宝管理 - 删除 todo admin页面

    551 => ['svc' => 'svcCustomer', 'func' => 'agentRechargeRegisterGet'], // 客服代理充值注册 - 获取
    552 => ['svc' => 'svcCustomer', 'func' => 'agentRechargeRegisterCreate'], // 客服代理充值注册 - 创建新账户
    553 => ['svc' => 'svcCustomer', 'func' => 'agentRechargeRegisterDel'], // 客服代理充值注册 - 删除

    554 => ['svc' => 'svcCustomer', 'func' => 'manualRechargeInfoGet'], // 客服手工充值查询 - 获取

    555 => ['svc' => 'svcCustomer', 'func' => 'manualRecharge'], // 客服手工充值 - 人工充值

    556 => ['svc' => 'svcCustomer', 'func' => 'gameAgentGet'], // 游戏代理查询 - 获取
    557 => ['svc' => 'svcCustomer', 'func' => 'gameAgentBatchProcess'], // 游戏代理查询 - 批处理为 待审核|通过|驳回

    558 => ['svc' => 'svcCustomer', 'func' => 'chatAutoReplyGet'], // 自动回复设置 - 获取
    559 => ['svc' => 'svcCustomer', 'func' => 'chatAutoReplyAdd'], // 自动回复设置 - 添加
    560 => ['svc' => 'svcCustomer', 'func' => 'chatAutoReplyModify'], // 自动回复设置 - 修改
    561 => ['svc' => 'svcCustomer', 'func' => 'chatAutoReplyDel'], // 自动回复设置 - 删除

    562 => ['svc' => 'svcCustomer', 'func' => 'aliPayBlacklistGet'], // 支付宝黑名单 - 获取
    563 => ['svc' => 'svcCustomer', 'func' => 'aliPayBlacklistAdd'], // 支付宝黑名单 - 添加
    564 => ['svc' => 'svcCustomer', 'func' => 'aliPayBlacklistDel'], // 支付宝黑名单 - 删除
    565 => ['svc' => 'svcCustomer', 'func' => 'aliPayBlacklistClear'], // 支付宝黑名单 - 清空

    566 => ['svc' => 'svcCustomer', 'func' => 'cashOrderGet'], // 提现订单 - 获取
    567 => ['svc' => 'svcCustomer', 'func' => 'cashOrderBatchFinish'], // 提现订单 - 批量处理完成
    568 => ['svc' => 'svcCustomer', 'func' => 'cashOrderBatchAgain'], // 提现订单 - 批量重新处理
    569 => ['svc' => 'svcCustomer', 'func' => 'cashOrderBatchSuccess'], // 提现订单 - 批量处理成功
    570 => ['svc' => 'svcCustomer', 'func' => 'aliPayBlacklistClear'], // 提现订单 - 操作 | 退款, 重新处理, 审核通过, 转账成功; 人工提现 | 查看提现截图, 人工提现

    // 运维管理 601 - 650
    601 => ['svc' => 'svcAdmin', 'func' => 'adminListGet'], // 管理员列表 - 获取
    602 => ['svc' => 'svcAdmin', 'func' => 'adminListAdd'], // 管理员列表 - 添加
    603 => ['svc' => 'svcAdmin', 'func' => 'adminListEdit'], // 管理员列表 - 修改
    604 => ['svc' => 'svcAdmin', 'func' => 'adminListDel'], // 管理员列表 - 删除

    605 => ['svc' => 'svcAdmin', 'func' => 'roleListGet'], // 角色列表 - 获取
    606 => ['svc' => 'svcAdmin', 'func' => 'roleListAdd'], // 角色列表 - 添加
    607 => ['svc' => 'svcAdmin', 'func' => 'roleListEdit'], // 角色列表 - 修改

    608 => ['svc' => 'svcAdmin', 'func' => 'adminLoginLogGet'], // 管理员登录日志 - 获取
];