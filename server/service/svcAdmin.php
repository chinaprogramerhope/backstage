<?php
/**
 * User: hanxiaolong
 * Date: 18-10-8
 *
 * 管理员
 */

class svcAdmin {
    /**
     * 登陆
     * @param $param
     * @param $data
     * @return int
     */
    public function login($param, &$data) {
        if (!isset($param['adminName']) || !isset($param['password'])
            || empty($param['adminName']) || empty($param['password'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_ADMIN_PASSWORD_EMPTY;
        }

        $adminName = trim($param['adminName']);
        $password = trim($param['password']);

        return clsAdmin::login($adminName, $password, $data);

//        // todo 这样的返回值需要更改数据表结构
//        $ret['code'] = ERR_OK;
//        $data = '{"roles":["admin"],"token":"admin","introduction":"我是超级管理员","avatar":"https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif","name":"Super Admin"}';
//        $data = json_decode($data, true);
//        $ret['data'] = $data;
    }

    /**
     * 获取管理员信息
     * @param $param
     * @param $data
     * @return int
     */
    public function getAdminInfo($param, &$data) {
        if (!isset($param['token']) || empty($param['token'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_ADMIN_PASSWORD_EMPTY;
        }

        $token = trim($param['token']);

        return clsAdmin::getAdminInfo($token, $data);
    }

    /**
     * 登出
     * @param $param
     * @param $data
     * @return int
     */
    public function logout($param, &$data) {
        return clsAdmin::logout($data);
    }
}