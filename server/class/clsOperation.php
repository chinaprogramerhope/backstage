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

    /**
     * 系统利润 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemProfitGet($param, &$data) {
        return daoOperation::systemProfitGet($param, $data);
    }

    /**
     * 系统维护 - 游戏开关
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemMaintenanceSwitch($param, &$data) {
        return daoOperation::systemMaintenanceSwitch($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取游戏包列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGetGameList($param, &$data) {
        return daoOperation::packageUpgradeGetGameList($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGet($param, &$data) {
        return daoOperation::packageUpgradeGet($param, $data);
    }

    /**
     * 整包升级服务器管理 - 添加游戏版本
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeAdd($param, &$data) {
        return daoOperation::packageUpgradeAdd($param, $data);
    }

    /**
     * 整包升级服务器管理 - 刷新redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeRefresh($param, &$data) {
        return daoOperation::packageUpgradeRefresh($param, $data);
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeDel($param, &$data) {
        return daoOperation::packageUpgradeDel($param, $data);
    }
}