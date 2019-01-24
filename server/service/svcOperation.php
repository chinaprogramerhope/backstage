<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 运营管理
 */
class svcOperation {
    /**
     * 游戏报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function gameReportGet($param, &$data) {
        return clsOperation::gameReportGet($param, $data);
    }

    /**
     * 资金帐变 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function moneyReportGet($param, &$data) {
        return clsOperation::moneyReportGet($param, $data);
    }

    /**
     * 系统利润 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function systemProfitGet($param, &$data) {
        return clsOperation::systemProfitGet($param, $data);
    }

    /**
     * 系统维护 - 游戏开关
     * @param $param
     * @param $data
     * @return int
     */
    public function systemMaintenanceSwitch($param, &$data) {
        if (!isset($param['open']) || ($param['open'] != 0 && $param['open'] != 1) ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['open'] = intval($param['open']);
        $param['notice'] = isset($param['notice']) && !empty($param['notice']) ? trim($param['notice']) : '';

        return clsOperation::systemMaintenanceSwitch($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取游戏包列表
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeGetGameList($param, &$data) {
        return clsOperation::packageUpgradeGetGameList($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeGet($param, &$data) {
        $param['selectTag'] = isset($param['selectTag']) && !empty($param['selectTag']) ? trim($param['selectTag']) : '';

        return clsOperation::packageUpgradeGet($param, $data);
    }

    /**
     * 整包升级服务器管理 - 添加游戏版本
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeAdd($param, &$data) {
        if (!isset($param['packageName']) || empty($param['packageName'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['packageName'] = trim($param['packageName']);
        $param['latestVersion'] = isset($param['latestVersion']) && !empty($param['latestVersion']) ? trim($param['latestVersion']) : 0;
        $param['expiredVersion'] = isset($param['expiredVersion']) && !empty($param['expiredVersion']) ? trim($param['expiredVersion']) : 0;
        $param['url'] = isset($param['url']) && !empty($param['url']) ? trim($param['url']) : ''; // todo

        $param['status'] = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : 0; // todo

        return clsOperation::packageUpgradeAdd($param, $data);
    }

    /**
     * 整包升级服务器管理 - 刷新redis
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeRefresh($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);

        return clsOperation::packageUpgradeRefresh($param, $data);
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeDel($param, &$data) {
        return clsOperation::packageUpgradeDel($param, $data);
    }

}