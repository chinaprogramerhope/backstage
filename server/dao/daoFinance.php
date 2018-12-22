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
}