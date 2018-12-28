<?php

/**
 * User: hanxiaolong
 * Date: 18-10-9
 */
class daoAdmin {
    /**
     * 保存注册验证码
     * @param $param
     * @param $data
     * @return int
     */
    public static function saveVerifyCode($param, &$data) {
        $ip = $param['ip'];
        $verifyCode = $param['verifyCode'];

        $key = register_vcode . $ip;
        $redis = clsRedis::getInstance();
        if (null === $redis) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $ttl = 300;
        $redis->setex($key, $ttl, $verifyCode);

        $data = [
            'verifyCode' => $verifyCode
        ];

        return ERR_OK;
    }

    /**
     * 获取注册验证码
     * @param $param
     * $param $data
     * @return int
     */
    public static function getVerifyCode($param, &$data) {
        $key = register_vcode . $param['ip'];
        $redis = clsRedis::getInstance();
        if (null === $redis) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $verifyCode = $redis->get($key);
        $data['verifyCode'] = $verifyCode;

        return ERR_OK;
    }

    /**
     * 注册
     * @param $param
     * @param $data
     * @return int
     */
    public static function register($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $timeNow = date('Y-m-d H:i:s');

        try {
            $sql = 'insert into admin_admin (name, pass, create_time, update_time) values (:name, :pass, :create_time, :update_time)';
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute([
                ':name' => $param['userName'],
                ':pass' => $param['pass'],
                ':create_time' => $timeNow,
                ':update_time' => $timeNow
            ]);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', param = ' . json_encode($param));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 获取管理员信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function getAdmin($param, &$data) {
        $adminName = isset($param['userName']) ? $param['userName'] : '';

        $newAdminConfig = mysqlConfig['new_admin'];
        $pdo = clsMysql::getInstance($newAdminConfig);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        try {
            $sql = 'select * from admin_admin where name = :userName limit 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':userName' => $adminName
            ]);
            $row = $stmt->fetch();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', admin not exist, sql = ' . $sql . ', param = ' . json_encode($param));
            return ERR_ADMIN_NOT_EXIST;
        }
        $data = $row;

        return ERR_OK;
    }
}