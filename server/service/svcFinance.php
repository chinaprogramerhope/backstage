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

    /**
     * 财务统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function finStatisticsGet($param, &$data) {
        return clsFinance::finStatisticsGet($param, $data);
    }

    /**
     * 财务统计 - 更新昨日充值数据
     * @param $param
     * @param $data
     * @return int
     */
    public function finStatisticsUpdate($param, &$data) {
        return clsFinance::finStatisticsUpdate($param, $data);
    }

    /**
     * 支付统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function payStatisticsGet($param, &$data) {
        return clsFinance::payStatisticsGet($param, $data);
    }

    /**
     * 提现总额统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function withdrawalTotalGet($param, &$data) {
        return clsFinance::withdrawalTotalGet($param, $data);
    }

    /**
     * 运营统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function financeReportGet($param, &$data) {
        return clsFinance::financeReportGet($param, $data);
    }

    /**
     * 对账统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function reconciliationReportGet($param, &$data) {
        return clsFinance::reconciliationReportGet($param, $data);
    }

    /**
     * 代付账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function payAccountManageGet($param, &$data) {
        return clsFinance::payAccountManageGet($param, $data);
    }

    /**
     * 代付账号管理 - 创建新账号
     * @param $param
     * @param $data
     * @return int
     */
    public function payAccountManageCreate($param, &$data) {
        return clsFinance::payAccountManageCreate($param, $data);
    }

    /**
     * 代付订单管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function payOrderManageGet($param, &$data) {
        return clsFinance::payOrderManageGet($param, $data);
    }

    /**
     * 代付订单管理 - 更新派支付提款单状态
     * @param $param
     * @param $data
     * @return int
     */
    public function payOrderManageUpdate($param, &$data) {
        return clsFinance::payOrderManageUpdate($param, $data);
    }
}