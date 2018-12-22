<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 运营管理
 */
class clsOperation {
    /**
     * 游戏报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameReportGet($param, &$data) {
        return daoOperation::gameReportGet($param, $data);
    }

    /**
     * 资金帐变 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function moneyReportGet($param, &$data) {
        return daoOperation::moneyReportGet($param, $data);
    }
}