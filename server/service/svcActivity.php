<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 活动管理
 */
class svcActivity {
    /**
     * 活动报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function activityReportGet($param, &$data) {
        return clsActivity::activityReportGet($param, $data);
    }

    /**
     * 活动列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function activityListGet($param, &$data) {
        return clsActivity::activityListGet($param, $data);
    }

    /**
     * 常规活动 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public function commonActivitySave($param, &$data) {
        return clsActivity::commonActivitySave($param, $data);
    }
}