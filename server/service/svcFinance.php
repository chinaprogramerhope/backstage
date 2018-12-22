<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 财务管理
 */
class svcFinance {
    /**
     * 人工存提
     * @param $param
     * @param $data
     * @return int
     */
    public function manualOperate($param, &$data) {
        return clsFinance::manualOperate($param, $data);
    }

    /**
     * 官方支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function officialChargeGet($param, &$data) {
        return clsFinance::officialChargeGet($param, $data);
    }

    /**
     * 线上支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function onlinePayGet($param, &$data) {
        return clsFinance::onlinePayGet($param, $data);
    }

    /**
     * 支付宝出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayAuditGet($param, &$data) {
        return clsFinance::aliPayAuditGet($param, $data);
    }

    /**
     * 银行卡出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function bankCardAuditGet($param, &$data) {
        return clsFinance::bankCardAuditGet($param, $data);
    }

    /**
     * 自动出款交易记录
     * @param $param
     * @param $data
     * @return int
     */
    public function autoPayTradeRecordGet($param, &$data) {
        return clsFinance::autoPayTradeRecordGet($param, $data);
    }

    /**
     * 出入款配置
     * @param $param
     * @param $data
     * @return int
     */
    public function financeConfig($param, &$data) {
        return clsFinance::financeConfig($param, $data);
    }
}