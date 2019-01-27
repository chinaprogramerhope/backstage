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
            || !isset($param['verifyCode']) || empty($param['verifyCode'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            $data['msg'] = '请填写完整';
            return ERR_INVALID_PARAM;
        }

        $userName = trim($param['userName']);

        $userNameLen = strlen($userName);
        $passLen = strlen($param['pass']);
        if ($userNameLen < 4 || $userNameLen > 10) {
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
        if (!preg_match($regex, $userName)) {
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
        if (!isset($param['userName']) || !isset($param['pass'])
            || empty($param['userName']) || empty($param['pass'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_ADMIN_PASSWORD_EMPTY;
        }

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

    /**
     * 管理员列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function adminListGet($param, &$data) {
        return clsAdmin::adminListGet($param, $data);
    }

    /**
     * 管理员列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function adminListAdd($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])
            || !isset($param['pass']) || empty($param['pass'])
            || !isset($param['passAgain']) || empty($param['passAgain'])
            || !isset($param['roleId']) || empty($param['roleId']) || !is_numeric($param['roleId'])
            || !isset($param['status'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['name'] = trim($param['name']);
        $param['pass'] = trim($param['pass']);
        $param['passAgain'] = trim($param['passAgain']);
        $param['roleId'] = intval($param['roleId']);

        $param['status'] = intval($param['status']);

        // todo 账号和密码长度限制

        if ($param['pass'] !== $param['passAgain']
            || ($param['status'] !== 1 && $param['status'] !== 0)
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsAdmin::adminListAdd($param, $data);
    }

    /**
     * 管理员列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public function adminListEdit($param, &$data) {
        if (!isset($param['name']) || empty($param['name'])
            || !isset($param['pass']) || empty($param['pass'])
            || !isset($param['passAgain']) || empty($param['passAgain'])
            || !isset($param['roleId']) || empty($param['roleId']) || !is_numeric($param['roleId'])
            || !isset($param['status'])
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['name'] = trim($param['name']);
        $param['pass'] = trim($param['pass']);
        $param['passAgain'] = trim($param['passAgain']);
        $param['roleId'] = intval($param['roleId']);

        $param['status'] = intval($param['status']);

        // todo 账号和密码长度限制

        if ($param['pass'] !== $param['passAgain']
            || ($param['status'] !== 1 && $param['status'] !== 0)
        ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsAdmin::adminListEdit($param, $data);
    }

    /**
     * 管理员列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function adminListDel($param, &$data) {
        if (!isset($param['id']) || !is_numeric($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);

        return clsAdmin::adminListDel($param, $data);
    }

    /**
     * 角色列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function roleListGet($param, &$data) {
        return clsAdmin::roleListGet($param, $data);
    }

    /**
     * 角色列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function roleListAdd($param, &$data) {
        if (!isset($param['roleName']) || empty($param['roleName'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['roleName'] = trim($param['roleName']);
        $param['priv'] = isset($param['priv']) && !empty($param['priv']) ? $param['priv'] : [];
        $param['priv'] = json_encode($param['priv']);

        return clsAdmin::roleListAdd($param, $data);
    }

    /**
     * 角色列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public function roleListEdit($param, &$data) {
        if (!isset($param['roleName']) || empty($param['roleName'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['roleName'] = trim($param['roleName']);
        $param['priv'] = isset($param['priv']) && !empty($param['priv']) ? $param['priv'] : [];
        if ($param['priv'] === 'all') {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, priv is all, cannot edit, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['priv'] = json_encode($param['priv']);

        return clsAdmin::roleListEdit($param, $data);
    }

    /**
     * 管理员登录日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function adminLoginLogGet($param, &$data) {
        $dateRange = clsUtility::getFormatDate($param);

        return clsAdmin::adminLoginLogGet($param, $data);
    }

    /**
     * 运营数据总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function masterGet($param, &$data) {
        return clsAdmin::masterGet($param, $data);
    }

    /**
     * 管理员登录日志 - 导出excel
     * @param $param
     * @param $data
     * @return int
     */
    public function masterExport($param, &$data) {
        return clsAdmin::masterExport($param, $data);
    }

    /**
     * 充提抽水曲线 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function chongTiChouShuiCurveGet($param, &$data) {
        $param['dateRange'] = clsUtility::getFormatDate($param);
        return clsAdmin::chongTiChouShuiCurveGet($param, $data);
    }

    /**
     * 渠道统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function channelStatisticsGet($param, &$data) {
        $param['dateRange'] = clsUtility::getFormatDate($param);
        return clsAdmin::channelStatisticsGet($param, $data);
    }

    /**
     * 捕鱼运营总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function fishMasterGet($param, &$data) {
        $param['dateRange'] = clsUtility::getFormatDate($param);
        return clsAdmin::fishMasterGet($param, $data);
    }
}