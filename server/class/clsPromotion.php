<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 推广管理
 */
class clsPromotion {
    /**
     * 推广玩家 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionUserGet($param, &$data) {
        return daoPromotion::promotionUserGet($param, $data);
    }

    /**
     * 推广报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportGet($param, &$data) {
        return daoPromotion::promotionReportGet($param, $data);
    }

    /**
     * 推广报表 - 查看(上级/下级)
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportView($param, &$data) {
        return daoPromotion::promotionReportView($param, $data);
    }

    /**
     * 推广返利 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionRebateGet($param, &$data) {
        return daoPromotion::promotionRebateGet($param, $data);
    }

    /**
     * 返利设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsGet($param, &$data) {
        return daoPromotion::rebateSettingsGet($param, $data);
    }

    /**
     * 返利设置 - 新增
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsAdd($param, &$data) {
        return daoPromotion::rebateSettingsAdd($param, $data);
    }

    /**
     * 返利设置 - 返利经验设置
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsExpSet($param, &$data) {
        return daoPromotion::rebateSettingsExpSet($param, $data);
    }

    /**
     * 返利设置 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsEdit($param, &$data) {
        return daoPromotion::rebateSettingsEdit($param, $data);
    }

    /**
     * 站内消息 - 查看收件人
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageViewRecipient($param, &$data) {
        return daoPromotion::stationMessageViewRecipient($param, $data);
    }
}