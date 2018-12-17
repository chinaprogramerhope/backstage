<?php

/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-8
 * Time: 下午5:40
 */
class clsAdmin {
    /**
     * 登陆
     * @param $adminName
     * @param $password
     * @param $data
     * @return int
     */
    public static function login($adminName, $password, &$data) {
        $adminInfo = daoAdmin::getAdmin($adminName);

        // 账号是否存在
        if (empty($adminInfo)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ERR_ADMIN_NOT_EXIST, adminName = ' . $adminName);
            return ERR_ADMIN_NOT_EXIST;
        }

        // 密码是否正确 todo 保存加密密码
        if ($password != $adminInfo ['pass']) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ERR_ADMIN_PASSWORD_WRONG, adminName = ' . $adminName
                . ', password = ' . $password . ', adminInfo = ' . json_encode($adminInfo));
            return ERR_ADMIN_PASSWORD_WRONG;
        }

        session_start();
        $_SESSION['admin_name'] = $adminName;

        // todo token
        $data['token'] = $adminName;

        return ERR_OK;
    }

    /**
     * 获取管理员信息
     * @param $token
     * @param $data
     * @return int
     */
    public static function getAdminInfo($token, &$data) {
        // todo 根据token获取信息
        $adminName = $token;

        $adminInfo = daoAdmin::getAdmin($adminName);
        if (is_int($adminInfo)) {
            $code = $adminInfo;
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', daoAdmin::getAdmin fail , adminName = ' . $adminName);
            return $code;
        }

        $data = $adminInfo;

        return ERR_OK;
    }

    public static function logout(&$data) {
        return ERR_OK;
    }
}