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

    /**
     * 黑名单信息管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistGet($param, &$data) {
        $keyword = isset($param['keyword']) && !empty($param['keyword']) ? trim($param['keyword']) : '';
        $param['keyword'] = $keyword;
        return clsCustomer::blacklistGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封批操作
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchDeBlock($param, &$data) {
        $ipArr = isset($param['ipArr']) && !empty($param['ipArr']) ? $param['ipArr'] : [];
        $macArr = isset($param['macArr']) && !empty($param['macArr']) ? $param['macArr'] : [];
        $idArr = isset($param['idArr']) && !empty($param['idArr']) ? $param['idArr'] : [];

        if (empty($ipArr) && empty($macArr) && empty($idArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['ipArr'] = $ipArr;
        $param['macArr'] = $macArr;
        $param['idArr'] = $idArr;

        return clsCustomer::blacklistBatchDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封单个
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistDeBlock($param, &$data) {
        $type = isset($param['type']) && !empty($param['type']) ? $param['type'] : 0;
        $value = isset($param['value']) && !empty($param['value']) ? trim($param['value']) : '';

        if ($type <= 0 || empty($value)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['type'] = $type;
        $param['value'] = $value;

        return clsCustomer::blacklistDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量踢出相关用户id
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchBlock($param, &$data) {
        if (!isset($param['aliPayAccount']) || empty($param['aliPayAccount'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['aliPayAccount'] = trim($param['aliPayAccount']);

        return clsCustomer::blacklistBatchBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量封用户id-恶劣密码
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchBlockPass($param, &$data) {
        return clsCustomer::blacklistBatchBlockPass($param, $data);
    }
}