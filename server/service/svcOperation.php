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

    public function systemProfitGet($param, &$data) {
        return clsOperation::systemProfitGet($param, $data);
    }
}