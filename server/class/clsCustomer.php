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
     * 客户端缺陷工单 - 创建缺陷工单
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugBatchCreate($param, &$data) {
        return daoCustomer::clientBugBatchCreate($param, $data);
    }

    /**
     * 客户端缺陷工单 - 操作 - 处理
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOperationHandle($param, &$data) {
        return daoCustomer::clientBugOperationHandle($param, $data);
    }

    /**
     *  客户端缺陷工单 - 操作 - 查看
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOperationGet($param, &$data) {
        return daoCustomer::clientBugOperationGet($param, $data);
    }
}