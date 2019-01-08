<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 */
class clsFinance {
    /**
     * 人工存提
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualOperate($param, &$data) {
        return daoFinance::manualOperate($param, $data);
    }

    /**
     * 官方支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function officialChargeGet($param, &$data) {
        return daoFinance::officialChargeGet($param, $data);
    }

    /**
     * 线上支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlinePayGet($param, &$data) {
        return daoFinance::onlinePayGet($param, $data);
    }

    /**
     * 支付宝出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayAuditGet($param, &$data) {
        return daoFinance::aliPayAuditGet($param, $data);
    }

    /**
     * 银行卡出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bankCardAuditGet($param, &$data) {
        return daoFinance::bankCardAuditGet($param, $data);
    }

    /**
     * 自动出款交易记录
     * @param $param
     * @param $data
     * @return int
     */
    public static function autoPayTradeRecordGet($param, &$data) {
        return daoFinance::autoPayTradeRecordGet($param, $data);
    }

    /**
     * 出入款配置
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeConfig($param, &$data) {
        return daoFinance::financeConfig($param, $data);
    }

    /**
     * 财务统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsGet($param, &$data) {
        return daoFinance::finStatisticsGet($param, $data);
    }

    /**
     * 财务统计 - 更新昨日充值数据
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsUpdate($param, &$data) {
        return daoFinance::finStatisticsUpdate($param, $data);
    }

    /**
     * 支付统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payStatisticsGet($param, &$data) {
        return daoFinance::payStatisticsGet($param, $data);
    }

    /**
     * 提现总额统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function withdrawalTotalGet($param, &$data) {
        return daoFinance::withdrawalTotalGet($param, $data);
    }

    /**
     * 运营统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeReportGet($param, &$data) {
        return daoFinance::financeReportGet($param, $data);
    }

    /**
     * 对账统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function reconciliationReportGet($param, &$data) {
        return daoFinance::reconciliationReportGet($param, $data);
    }

    /**
     * 代付账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageGet($param, &$data) {
        return daoFinance::payAccountManageGet($param, $data);
    }

    /**
     * 代付账号管理 - 创建新账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageCreate($param, &$data) {
        return daoFinance::payAccountManageCreate($param, $data);
    }

    /**
     * 代付订单管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageGet($param, &$data) {
        return daoFinance::payOrderManageGet($param, $data);
    }

    /**
     * 代付订单管理 - 更新派支付提款单状态
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageUpdate($param, &$data) {
        return daoFinance::payOrderManageUpdate($param, $data);
    }
}