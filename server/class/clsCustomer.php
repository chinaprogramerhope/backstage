<?php

/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */
class clsCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGet($param, &$data) {
        return daoCustomer::userDetailGet($param, $data);
    }

    /**
     * 用户信息管理 - 金豆+保险箱最大的
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGetMax($param, &$data) {
        return daoCustomer::userDetailGetMax($param, $data);
    }

    /**
     * 用户注册列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userRegisterListGet($param, &$data) {
        return daoCustomer::userRegisterListGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistGet($param, &$data) {
        return daoCustomer::blacklistGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封批操作
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchDeBlock($param, &$data) {
        return daoCustomer::blacklistBatchDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封单个
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistDeBlock($param, &$data) {
        return daoCustomer::blacklistDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量踢出相关用户id
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlock($param, &$data) {
        return daoCustomer::blacklistBatchBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量封用户id-恶劣密码
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlockPass($param, &$data) {
        return daoCustomer::blacklistBatchBlockPass($param, $data);
    }

    /**
     * 玩家游戏记录 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameLogGet($param, &$data) {
        return daoCustomer::gameLogGet($param, $data);
    }

    /**
     * 玩家游戏记录 - 查询游戏次数
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameLogGetTimes($param, &$data) {
        return daoCustomer::gameLogGetTimes($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLogGet($param, &$data) {
        return daoCustomer::goldLogGet($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 导出
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLogExport($param, &$data) {
        return daoCustomer::goldLogExport($param, $data);
    }

    /**
     * 玩家金豆变化(24小时内)
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLog24Get($param, &$data) {
        return daoCustomer::goldLog24Get($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function orderInfoGet($param, &$data) {
        return daoCustomer::orderInfoGet($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取延时订单
     * @param $param
     * @param $data
     * @return int
     */
    public static function orderInfoGetDelay($param, &$data) {
        return daoCustomer::orderInfoGetDelay($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 获取支付宝转账订单
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckGet($param, &$data) {
        return daoCustomer::aliPayTransferCheckGet($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 确认转账成功
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckConfirm($param, &$data) {
        return daoCustomer::aliPayTransferCheckConfirm($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 修改金额
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckModify($param, &$data) {
        return daoCustomer::aliPayTransferCheckModify($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 关闭订单
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckClose($param, &$data) {
        return daoCustomer::aliPayTransferCheckClose($param, $data);
    }

    /**
     * 支付宝转账卡号卡密 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCardGet($param, &$data) {
        return daoCustomer::aliPayTransferCardGet($param, $data);
    }

    /**
     * 客户端缺陷工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugGet($param, &$data) {
        return daoCustomer::clientBugGet($param, $data);
    }

    /**
     * 客户端缺陷工单 - 批量处理关闭
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugBatchClose($param, &$data) {
        return daoCustomer::clientBugBatchClose($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 创建
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneCreate($param, &$data) {
        return daoCustomer::clientBugOneCreate($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneGet($param, &$data) {
        return daoCustomer::clientBugOneGet($param, $data);
    }

    /**
     *  客户端缺陷工单 - 单个工单 - 关闭
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneUpdate($param, &$data) {
        return daoCustomer::clientBugOneUpdate($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneDel($param, &$data) {
        return daoCustomer::clientBugOneDel($param, $data);
    }

    /**
     * 举报管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportGet($param, &$data) {
        return daoCustomer::userReportGet($param, $data);
    }

    /**
     * 举报管理 - 回放
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportPlayback($param, &$data) {
        return daoCustomer::userReportPlayback($param, $data);
    }

    /**
     * 举报管理 - 回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportReply($param, &$data) {
        return daoCustomer::userReportReply($param, $data);
    }

    /**
     * 在线客服 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineGet($param, &$data) {
        return daoCustomer::onlineGet($param, $data);
    }

    /**
     * 在线客服 - 添加快捷回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineQuickReplyAdd($param, &$data) {
        return daoCustomer::onlineQuickReplyAdd($param, $data);
    }

    /**
     * 在线客服 - 获取快捷回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineQuickReplyGet($param, &$data) {
        return daoCustomer::onlineQuickReplyGet($param, $data);
    }

    /**
     * 在线客服 - 禁言
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineForbidWord($param, &$data) {
        return daoCustomer::onlineForbidWord($param, $data);
    }

    /**
     * 在线客服 - 关闭并受理
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineCloseAndAccept($param, &$data) {
        return daoCustomer::onlineCloseAndAccept($param, $data);
    }

    /**
     * 在线客服 - 回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineReply($param, &$data) {
        return daoCustomer::onlineReply($param, $data);
    }

    /**
     * 在线客服 - 回复并查看下一条
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineReplyAndNext($param, &$data) {
        return daoCustomer::onlineReplyAndNext($param, $data);
    }

    /**
     * 在线客服 - 批量转客服
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineBatchTransfer($param, &$data) {
        return daoCustomer::onlineBatchTransfer($param, $data);
    }

    /**
     * 在线客服 - 设置紧急回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineGetUrgentReplyAdd($param, &$data) {
        return daoCustomer::onlineGetUrgentReplyAdd($param, $data);
    }

    /**
     * 在线客服 - 开启人工充值
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineManualRechargeOpen($param, &$data) {
        return daoCustomer::onlineManualRechargeOpen($param, $data);
    }

    /**
     * 在线客服 - 设置在线
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineSetOnline($param, &$data) {
        return daoCustomer::onlineSetOnline($param, $data);
    }

    /**
     * 在线客服 - 转给其他客服
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineTransfer($param, &$data) {
        return daoCustomer::onlineTransfer($param, $data);
    }

    /**
     * 在线客服 - 客服结束
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineFinish($param, &$data) {
        return daoCustomer::onlineFinish($param, $data);
    }

    /**
     * 在线客服 - 取消禁言
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineCancelForbidWord($param, &$data) {
        return daoCustomer::onlineCancelForbidWord($param, $data);
    }

    /**
     * 提现支付宝管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageGet($param, &$data) {
        return daoCustomer::aliPayCashManageGet($param, $data);
    }

    /**
     * 提现支付宝管理 - 开启总闸
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageOpen($param, &$data) {
        return daoCustomer::aliPayCashManageOpen($param, $data);
    }

    /**
     * 提现支付宝管理 - 关闭总闸
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageClose($param, &$data) {
        return daoCustomer::aliPayCashManageClose($param, $data);
    }

    /**
     * 提现支付宝管理 - 添加新支付宝
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageAddAliPay($param, &$data) {
        return daoCustomer::aliPayCashManageAddAliPay($param, $data);
    }

    /**
     * 提现支付宝管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageForbid($param, &$data) {
        return daoCustomer::aliPayCashManageForbid($param, $data);
    }

    /**
     * 提现支付宝管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageDel($param, &$data) {
        return daoCustomer::aliPayCashManageDel($param, $data);
    }

    /**
     * 客服代理充值注册 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterGet($param, &$data) {
        return daoCustomer::agentRechargeRegisterGet($param, $data);
    }

    /**
     * 客服代理充值注册 - 创建新账户
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterCreate($param, &$data) {
        return daoCustomer::agentRechargeRegisterCreate($param, $data);
    }

    /**
     * 客服代理充值注册 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterDel($param, &$data) {
        return daoCustomer::agentRechargeRegisterDel($param, $data);
    }

    /**
     * 客服手工充值查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualRechargeInfoGet($param, &$data) {
        return daoCustomer::manualRechargeInfoGet($param, $data);
    }

    /**
     * 客服手工充值 - 人工充值
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualRecharge($param, &$data) {
        return daoCustomer::manualRecharge($param, $data);
    }

    /**
     * 游戏代理查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameAgentGet($param, &$data) {
        return daoCustomer::gameAgentGet($param, $data);
    }

    /**
     * 游戏代理查询 - 批处理为 待审核|通过|驳回
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameAgentBatchProcess($param, &$data) {
        return daoCustomer::gameAgentBatchProcess($param, $data);
    }

    /**
     * 自动回复设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyGet($param, &$data) {
        return daoCustomer::chatAutoReplyGet($param, $data);
    }

    /**
     * 自动回复设置 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyAdd($param, &$data) {
        return daoCustomer::chatAutoReplyAdd($param, $data);
    }

    /**
     * 自动回复设置 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyModify($param, &$data) {
        return daoCustomer::chatAutoReplyModify($param, $data);
    }

    /**
     * 自动回复设置 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyDel($param, &$data) {
        return daoCustomer::chatAutoReplyDel($param, $data);
    }

    /**
     * 支付宝黑名单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistGet($param, &$data) {
        return daoCustomer::aliPayBlacklistGet($param, $data);
    }

    /**
     * 支付宝黑名单 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistAdd($param, &$data) {
        return daoCustomer::aliPayBlacklistAdd($param, $data);
    }

    /**
     * 支付宝黑名单 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistDel($param, &$data) {
        return daoCustomer::aliPayBlacklistDel($param, $data);
    }

    /**
     * 支付宝黑名单 - 清空
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistDelAll($param, &$data) {
        return daoCustomer::aliPayBlacklistDelAll($param, $data);
    }
}