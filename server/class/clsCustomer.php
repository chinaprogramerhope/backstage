<?php

/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */
class clsCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGet($param, &$data) {
        return daoCustomer::userDetailGet($param, $data);
    }

    /**
     * 用户信息管理 - 金豆+保险箱最大的
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGetMax($param, &$data) {
        return daoCustomer::userDetailGetMax($param, $data);
    }

    /**
     * 用户注册列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userRegisterListGet($param, &$data) {
        return daoCustomer::userRegisterListGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistGet($param, &$data) {
        return daoCustomer::blacklistGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封批操作
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchDeBlock($param, &$data) {
        return daoCustomer::blacklistBatchDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封单个
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistDeBlock($param, &$data) {
        return daoCustomer::blacklistDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量踢出相关用户id
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlock($param, &$data) {
        return daoCustomer::blacklistBatchBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量封用户id-恶劣密码
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlockPass($param, &$data) {
        return daoCustomer::blacklistBatchBlockPass($param, $data);
    }
}