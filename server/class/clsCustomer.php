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
}