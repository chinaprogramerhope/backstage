<?php
/**
 * User: hanxiaolong
 * Date: 18-10-8
 *
 * 管理员
 */

class svcAdmin {
    /**
     * 创建验证码
     * @param $param
     * @param $data
     * @return int
     */
    public function createVerifyCode($param, &$data) {
        return clsAdmin::createVerifyCode($param, $data);
    }

    /**
     * 注册
     * @param $param
     * @param $data
     * @return int
     */
    public function register($param, &$data) {
        if (!isset($param['userName']) || empty($param['userName'])
            || !isset($param['pass']) || empty($param['pass'])
            || !isset($param['passRepeat']) || empty($param['passRepeat'])
            || !isset($param['verifyCode']) || empty($param['verifyCode'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '请填写完整';
            return ERR_INVALID_PARAM;
        }

        $userNameLen = strlen($param['userName']);
        $passLen = strlen($param['pass']);
        if ($userNameLen < 4 || $userNameLen > 15) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '账号长度错误';
            return ERR_INVALID_PARAM;
        }
        if ($passLen < 6 || $passLen > 15) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '密码长度错误';
            return ERR_INVALID_PARAM;
        }
        if ($param['pass'] !== $param['passRepeat']) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '两次输入密码不一致';
            return ERR_INVALID_PARAM;
        }

        $regex = '/^[a-z0-9]+$/i';
        if (!preg_match($regex, $param['userName'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '账号只能为英文数字';
            return ERR_INVALID_PARAM;
        }
        if (!preg_match($regex, $param['pass'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '密码只能为英文数字';
            return ERR_INVALID_PARAM;
        }

        return clsAdmin::register($param, $data);
    }

    /**
     * 登陆
     * @param $param
     * @param $data
     * @return int
     */
    public function login($param, &$data) {
        if (!isset($param['adminName']) || !isset($param['pass'])
            || empty($param['adminName']) || empty($param['pass'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_ADMIN_PASSWORD_EMPTY;
        }

        $adminName = trim($param['adminName']);
        $pass = trim($param['pass']);

        return clsAdmin::login($param, $data);

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

        return clsAdmin::getAdminInfo($param, $data);
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