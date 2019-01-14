<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 会员管理
 */
class clsMember {
    /**
     * 获取会员列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function getList($param, &$data) {
        return daoMember::getList($param, $data);
    }

    /**
     * 获取登陆日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLoginLog($param, &$data) {
        return daoMember::getLoginLog($param, $data);
    }

    /**
     * 获取标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLabel($param, &$data) {
        return daoMember::getLabel($param, $data);
    }

    /**
     * 添加标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLabel($param, &$data) {
        return daoMember::addLabel($param, $data);
    }

    /**
     * 获取等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLv($param, &$data) {
        return daoMember::getLv($param, $data);
    }

    /**
     * 新增等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLv($param, &$data) {
        return daoMember::addLv($param, $data);
    }

    /**
     * 编辑等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function editLv($param, &$data) {
        return daoMember::editLv($param, $data);
    }

    /**
     * 删除等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function delLv($param, &$data) {
        return daoMember::delLv($param, $data);
    }
}