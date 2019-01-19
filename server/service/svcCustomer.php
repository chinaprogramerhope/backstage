<?php
/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */

class svcCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public function userDetailGet($param, &$data) {
        $param['accountId'] = isset($param['accountId']) && !empty($param['accountId']) ? trim($param['accountId']) : '';
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : '';
        $param['aliPayAccount'] = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? trim($param['aliPayAccount']) : '';
        $param['aliPayName'] = isset($param['aliPayName']) && !empty($param['aliPayName']) ? trim($param['aliPayName']) : '';
        $param['mac'] = isset($param['mac']) && !empty($param['mac']) ? trim($param['mac']) : '';
        $param['ip'] = isset($param['ip']) && !empty($param['ip']) ? trim($param['ip']) : '';
        $param['bindPhone'] = isset($param['bindPhone']) && !empty($param['bindPhone']) ? trim($param['bindPhone']) : '';
        $param['isRecharge'] = isset($param['isRecharge']) && !empty($param['isRecharge']) ? intval($param['isRecharge']) : '';

        if (isset($param['userId']) && !empty($param['userId']) && $param['userId'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, invalid userId, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::userDetailGet($param, $data);
    }

    /**
     * 用户信息管理 - 金豆+保险箱最大的
     * @param $param
     * @param $data
     * @return int
     */
    public function userDetailGetMax($param, &$data) {
        return clsCustomer::userDetailGetMax($param, $data);
    }

    /**
     * 用户注册列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function userRegisterListGet($param, &$data) {
        return clsCustomer::userRegisterListGet($param, $data);
    }
}