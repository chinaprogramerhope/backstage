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

    /**
     * 推广账号 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountGet($param, &$data) {
        return daoPromotion::promotionAccountGet($param, $data);
    }

    /**
     * 推广账号 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountAdd($param, &$data) {
        return daoPromotion::promotionAccountAdd($param, $data);
    }

    /**
     * 推广账号 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountEdit($param, &$data) {
        return daoPromotion::promotionAccountEdit($param, $data);
    }
    /**
     * 推广账号 - 获取操作日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountOperationLogGet($param, &$data) {
        return daoPromotion::promotionAccountOperationLogGet($param, $data);
    }

    /**
     * 推广账号 - 获取收入统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountIncomeGet($param, &$data) {
        return daoPromotion::promotionAccountIncomeGet($param, $data);
    }

    /**
     * 推广信用金日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionBalanceLogGet($param, &$data) {
        return daoPromotion::promotionBalanceLogGet($param, $data);
    }

    /**
     * 推广统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsGet($param, &$data) {
        return daoPromotion::promotionStatisticsGet($param, $data);
    }

    /**
     * 推广统计 - 统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneGet($param, &$data) {
        return daoPromotion::promotionStatisticsOneGet($param, $data);
    }

    /**
     * 推广统计 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneQuery($param, &$data) {
        return daoPromotion::promotionStatisticsOneQuery($param, $data);
    }

    /**
     * 推广ID修正 - 获取用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetId($param, &$data) {
        return daoPromotion::promotionCorrectionGetId($param, $data);
    }

    /**
     * 推广ID修正 - 修正用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionUpdate($param, &$data) {
        return daoPromotion::promotionCorrectionUpdate($param, $data);
    }

    /**
     * 推广ID修正 - 获取修正日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetLog($param, &$data) {
        return daoPromotion::promotionCorrectionGetLog($param, $data);
    }
}