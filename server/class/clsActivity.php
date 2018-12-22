<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 活动管理
 */
class clsActivity {
    /**
     * 活动报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function activityReportGet($param, &$data) {
        return daoActivity::activityReportGet($param, $data);
    }

    /**
     * 活动列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function activityListGet($param, &$data) {
        return daoActivity::activityListGet($param, $data);
    }

    /**
     * 常规活动 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function commonActivitySave($param, &$data) {
        return daoActivity::commonActivitySave($param, $data);
    }
}