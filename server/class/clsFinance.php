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
}