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
}