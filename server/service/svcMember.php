<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 会员管理
 */
class svcMember {
    /**
     * 获取会员列表
     * @param $param
     * @param $data
     * @return int
     */
    public function getList($param, &$data) {
        return clsMember::getList($param, $data);
    }

    /**
     * 获取登陆日志
     * @param $param
     * @param $data
     * @return int
     */
    public function getLoginLog($param, &$data) {
        return clsMember::getLoginLog($param, $data);
    }

    /**
     * 获取标签
     * @param $param
     * @param $data
     * @return int
     */
    public function getLabel($param, &$data) {
        return clsMember::getLabel($param, $data);
    }

    /**
     * 添加标签
     * @param $param
     * @param $data
     * @return int
     */
    public function addLabel($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])
            || !isset($param['sort']) || empty($param['sort'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::addLabel($param, $data);
    }

    /**
     * 编辑标签
     * @param $param
     * @param $data
     * @return int
     */
    public function editLabel($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])
            || !isset($param['name']) || empty($param['name'])
            || !isset($param['sort']) || empty($param['sort'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::editLabel($param, $data);
    }

    /**
     * 删除标签
     * @param $param
     * @param $data
     * @return int
     */
    public function delLabel($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::delLabel($param, $data);
    }

    /**
     * 获取等级
     * @param $param
     * @param $data
     * @return int
     */
    public function getLv($param, &$data) {
        return clsMember::getLv($param, $data);
    }

    /**
     * 新增等级
     * @param $param
     * @param $data
     * @return int
     */
    public function addLv($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])
            || !isset($param['upPrice']) || empty($param['upPrice'])
            || !isset($param['templateId']) || empty($param['templateId'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::addLv($param, $data);
    }

    /**
     * 编辑等级
     * @param $param
     * @param $data
     * @return int
     */
    public function editLv($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])
            || !isset($param['name']) || empty($param['name'])
            || !isset($param['upPrice']) || empty($param['upPrice'])
            || !isset($param['templateId']) || empty($param['templateId'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::editLv($param, $data);
    }

    /**
     * 删除等级
     * @param $param
     * @param $data
     * @return int
     */
    public function delLv($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMember::delLv($param, $data);
    }
}