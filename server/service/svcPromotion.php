<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 推广管理
 */
class svcPromotion {
    /**
     * 推广玩家 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionUserGet($param, &$data) {
        return clsPromotion::promotionUserGet($param, $data);
    }

    /**
     * 推广报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionReportGet($param, &$data) {
        return clsPromotion::promotionReportGet($param, $data);
    }

    /**
     * 推广报表 - 查看(上级/下级)
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionReportView($param, &$data) {
        return clsPromotion::promotionReportView($param, $data);
    }

    /**
     * 推广返利 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionRebateGet($param, &$data) {
        return clsPromotion::promotionRebateGet($param, $data);
    }

    /**
     * 返利设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function rebateSettingsGet($param, &$data) {
        return clsPromotion::rebateSettingsGet($param, $data);
    }

    /**
     * 返利设置 - 新增
     * @param $param
     * @param $data
     * @return int
     */
    public function rebateSettingsAdd($param, &$data) {
        return clsPromotion::rebateSettingsAdd($param, $data);
    }

    /**
     * 返利设置 - 返利经验设置
     * @param $param
     * @param $data
     * @return int
     */
    public function rebateSettingsExpSet($param, &$data) {
        return clsPromotion::rebateSettingsExpSet($param, $data);
    }

    /**
     * 返利设置 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function rebateSettingsEdit($param, &$data) {
        return clsPromotion::rebateSettingsEdit($param, $data);
    }

    /**
     * 站内消息 - 查看收件人
     * @param $param
     * @param $data
     * @return int
     */
    public function stationMessageViewRecipient($param, &$data) {
        return clsPromotion::stationMessageViewRecipient($param, $data);
    }

    /**
     * 推广账号 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionAccountGet($param, &$data) {
        return clsPromotion::promotionAccountGet($param, $data);
    }

    /**
     * 推广账号 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionAccountAdd($param, &$data) {
        return clsPromotion::promotionAccountAdd($param, $data);
    }

    /**
     * 推广账号 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionAccountEdit($param, &$data) {
        return clsPromotion::promotionAccountEdit($param, $data);
    }
    /**
     * 推广账号 - 获取操作日志
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionAccountOperationLogGet($param, &$data) {
        return clsPromotion::promotionAccountOperationLogGet($param, $data);
    }

    /**
     * 推广账号 - 获取收入统计
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionAccountIncomeGet($param, &$data) {
        return clsPromotion::promotionAccountIncomeGet($param, $data);
    }

    /**
     * 推广信用金日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionBalanceLogGet($param, &$data) {
        return clsPromotion::promotionBalanceLogGet($param, $data);
    }

    /**
     * 推广统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionStatisticsGet($param, &$data) {
        return clsPromotion::promotionStatisticsGet($param, $data);
    }

    /**
     * 推广统计 - 统计
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionStatisticsOneGet($param, &$data) {
        return clsPromotion::promotionStatisticsOneGet($param, $data);
    }

    /**
     * 推广统计 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionStatisticsOneQuery($param, &$data) {
        return clsPromotion::promotionStatisticsOneQuery($param, $data);
    }

    /**
     * 推广ID修正 - 获取用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionCorrectionGetId($param, &$data) {
        return clsPromotion::promotionCorrectionGetId($param, $data);
    }

    /**
     * 推广ID修正 - 修正用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionCorrectionUpdate($param, &$data) {
        return clsPromotion::promotionCorrectionUpdate($param, $data);
    }

    /**
     * 推广ID修正 - 获取修正日志
     * @param $param
     * @param $data
     * @return int
     */
    public function promotionCorrectionGetLog($param, &$data) {
        return clsPromotion::promotionCorrectionGetLog($param, $data);
    }
}