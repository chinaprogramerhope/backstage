<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 财务管理
 */
class daoFinance {
    /**
     * 人工存提
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualOperate($param, &$data) {
        return ERR_OK;
    }

    /**
     * 官方支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function officialChargeGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 线上支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlinePayGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 支付宝出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayAuditGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 银行卡出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bankCardAuditGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 自动出款交易记录
     * @param $param
     * @param $data
     * @return int
     */
    public static function autoPayTradeRecordGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 出入款配置
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeConfig($param, &$data) {
        return ERR_OK;
    }

    /**
     * 财务统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 财务统计 - 更新昨日充值数据
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsUpdate($param, &$data) {
        return ERR_OK;
    }

    /**
     * 支付统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payStatisticsGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 提现总额统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function withdrawalTotalGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 运营统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 对账统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function reconciliationReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付账号管理 - 创建新账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageCreate($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付订单管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付订单管理 - 更新派支付提款单状态
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageUpdate($param, &$data) {
        return ERR_OK;
    }
}