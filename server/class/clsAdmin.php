<?php

/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-8
 * Time: 下午5:40
 */
class clsAdmin {
    /**
     * 创建验证码
     * @param $param
     * @param $data
     * @return int
     */
    public static function createVerifyCode($param, &$data) {
        $ip = self::getIp();
        $verifyCode = strval(rand(1000, 9999));

        $param = [
            'ip' => $ip,
            'verifyCode' => $verifyCode
        ];

        return daoAdmin::saveVerifyCode($param, $data);
    }

    /**
     * 注册
     * @param $param
     * @param $data
     * @return int
     */
    public static function register($param, &$data) {
        // 是否已被注册
        $adminData = [];
        daoAdmin::getAdmin($param, $adminData);
        if (!empty($adminData)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', repeat userName, param = ' . json_encode($param));
            $data['msg'] = '该账号已被注册';
            return ERR_ADMIN_REGISTER_REPEAT_USERNAME;
        }

        // 检测验证码
        $ip = self::getIp();
        $verifyCode = intval($param['verifyCode']);
        $tmpParam['ip'] = $ip;
        $ret = daoAdmin::getVerifyCode($tmpParam, $data);
        if ($ret !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', daoAdmin::getVerifyCode fail, errCode = ' . $ret
                . ', param = ' . json_encode($param) . ', ip = ' . $ip);
            $data['msg'] = '服务器错误';
            unset($data['verifyCode']);
            return $ret;
        }

        $savedVerifyCode = $data['verifyCode'];
        if ($verifyCode != $savedVerifyCode) { // todo session保存验证码
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', verifyCode wrong, param = ' . json_encode($param)
                . ', savedVerifyCode = ' . $savedVerifyCode . ', verifyCode = ' . $verifyCode);
            $data['msg'] = '验证码错误';
            unset($data['verifyCode']);
            return ERR_ADMIN_REGISTER_VERIFY_CODE_WRONG;
        }

        unset($data['verifyCode']);
        return daoAdmin::register($param, $data);
    }

    /**
     * 登陆
     * @param $param
     * @param $data
     * @return int
     */
    public static function login($param, &$data) {
        $adminName = $param['userName'];
        $pass = $param['pass'];

        daoAdmin::getAdmin($param, $data);
        $savePass = $data['pass'];

        // 账号是否存在
        $adminInfo = $data;
        if (empty($adminInfo)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ERR_ADMIN_NOT_EXIST, userName = ' . $adminName);
            return ERR_ADMIN_NOT_EXIST;
        }

        // 密码是否正确 todo 保存加密密码
        if ($pass != $savePass) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ERR_ADMIN_PASSWORD_WRONG, userName = ' . $adminName
                . ', pass = ' . $pass . ', adminInfo = ' . json_encode($adminInfo));
            return ERR_ADMIN_PASSWORD_WRONG;
        }

        session_start();
        $_SESSION['admin_name'] = $adminName;

        // todo 客户端token只能是admin和editor貌似, 需要改
        $data['token'] = 'admin';

        return ERR_OK;
    }

    /**
     * 获取管理员信息
     * @param $token
     * @param $data
     * @return int
     */
    public static function getAdminInfo($param, &$data) {
        // todo 根据token获取信息
        $token = isset($param['token']) ? $param['token'] : '';
        $adminName = $token;

        $ret = daoAdmin::getAdmin($param, $data);
        if ($ret !== ERR_OK) {
            $code = $data;
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', daoAdmin::getAdmin fail , userName = ' . $adminName);
            return $code;
        }

        return ERR_OK;
    }

    public static function logout(&$data) {
        return ERR_OK;
    }

    /**
     * 管理员列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListGet($param, &$data) {
        return daoAdmin::adminListGet($param, $data);
    }

    /**
     * 管理员列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListAdd($param, &$data) {
        return daoAdmin::adminListAdd($param, $data);
    }

    /**
     * 管理员列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListEdit($param, &$data) {
        return daoAdmin::adminListEdit($param, $data);
    }

    /**
     * 管理员列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListDel($param, &$data) {
        return daoAdmin::adminListDel($param, $data);
    }

    /**
     * 角色列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListGet($param, &$data) {
        return daoAdmin::roleListGet($param, $data);
    }

    /**
     * 角色列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListAdd($param, &$data) {
        return daoAdmin::roleListAdd($param, $data);
    }

    /**
     * 角色列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListEdit($param, &$data) {
        return daoAdmin::roleListEdit($param, $data);
    }

    /**
     * 管理员登录日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminLoginLogGet($param, &$data) {
        return daoAdmin::adminLoginLogGet($param, $data);
    }

    /**
     * 运营数据总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function masterGet($param, &$data) {
        return daoAdmin::masterGet($param, $data);
    }

    /**
     * 管理员登录日志 - 导出excel
     * @param $param
     * @param $data
     * @return int
     */
    public static function masterExport($param, &$data) {
        return daoAdmin::masterExport($param, $data);
    }

    /**
     * 充提抽水曲线 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongTiChouShuiCurveGet($param, &$data) {
        return daoAdmin::chongTiChouShuiCurveGet($param, $data);
    }

    /**
     * 渠道统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function channelStatisticsGet($param, &$data) {
        return daoAdmin::channelStatisticsGet($param, $data);
    }

    /**
     * 捕鱼运营总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function fishMasterGet($param, &$data) {
        return daoAdmin::fishMasterGet($param, $data);
    }

    // ====

    /**
     * 获取客户端ip
     * @return string
     */
    public static function getIp() {
        $ipTmp = 'none';
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ipTmp = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ipTmp = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ipTmp = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ipTmp = $_SERVER['REMOTE_ADDR'];
        }
        $ip = preg_match('/[\d\.]{7,15}/', $ipTmp, $matches) ? $matches[0] : '';

        return $ip;
    }
}