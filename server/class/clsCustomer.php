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
}