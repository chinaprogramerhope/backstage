<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 推广管理
 */
class daoPromotion {
    /**
     * 推广玩家 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionUserGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广报表 - 查看(上级/下级)
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportView($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广返利 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionRebateGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 新增
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsAdd($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 返利经验设置
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsExpSet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsEdit($param, &$data) {
        return ERR_OK;
    }

    /**
     * 站内消息 - 查看收件人
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageViewRecipient($param, &$data) {
        return ERR_OK;
    }
}