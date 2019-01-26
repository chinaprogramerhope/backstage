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

        $key = registerVcode . $ip;
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
        $key = registerVcode . $param['ip'];
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
        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $timeNow = date('Y-m-d H:i:s');

        try {
            $sql = 'insert into admin_admin (name, pass, create_time, update_time) values (:name, :pass, :create_time, :update_time)';
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute([
                ':name' => trim($param['userName']),
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
        $adminName = isset($param['userName']) ? trim($param['userName']) : '';

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
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

            // test
            clsLog::info('ok111, row = ' . json_encode($data) . ', sql = ' . $sql . ', username= ' . $adminName);
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

    /**
     * 管理员列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListGet($param, &$data) {
        $dbName = 'db_smc';
        $sql = 'select a.id, a.admin_name, a.status, r.role_name';
        $sql .= ' from smc_admin a left join smc_admin_role r';
        $sql .= ' on a.role_id = r.id';
        $sql .= ' order by id limit ' . maxQueryNum;

        $rows = clsUtility::getRows($dbName, $sql);
        if (!empty($rows)) {
            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql);
        }

        return ERR_OK;
    }

    /**
     * 管理员列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListAdd($param, &$data) {
        $name = $param['name'];
        $pass = $param['pass'];
        $roleId = $param['roleId'];
        $status = $param['status'];

        $dbName = 'db_smc';
        $tsNow = time();

        // 检测账号是否已存在
        $sql = 'select id from smc_admin where name = :name';
        $pdoParam = [':name' => $name];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', admin already exist, name = ' . $name);
            return ERR_ADMIN_ALREADY_EXIST;
        }

        // 添加
        $salt = rand(10000, 99999);
        $pass = crypt($pass, $salt);
        $sql = 'insert into smc_admin (admin_name, pass, status, add_time, salt, role_id)';
        $sql .= ' values (:admin_name, :pass, :status, :add_time, :salt, :role_id)';
        $pdoParam = [
            ':admin_name' => $name,
            ':pass' => $pass,
            ':status' => $status,
            ':add_time' => $tsNow,

            ':salt' => $salt,
            ':role_id' => $roleId
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 管理员列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListEdit($param, &$data) {
        $name = $param['name'];
        $pass = $param['pass'];
        $roleId = $param['roleId'];

        $status = $param['status'];
        $dbName = 'db_smc';
        $tsNow = time();

        // 检测账号是否已存在
        $sql = 'select id from smc_admin where name = :name';
        $pdoParam = [':name' => $name];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', admin already exist, name = ' . $name);
            return ERR_ADMIN_NOT_EXIST;
        }

        // 修改
        $salt = rand(10000, 99999);
        $pass = crypt($pass, $salt);
        $sql = 'update smc_admin set admin_name = :admin_name, pass = :pass, status = :status, add_time = :add_time, salt = :salt, role_id = :role_id';
        $sql .= ' where admin_name = :admin_name';
        $pdoParam = [
            ':admin_name' => $name,
            ':pass' => $pass,
            ':status' => $status,
            ':add_time' => $tsNow,

            ':salt' => $salt,
            ':role_id' => $roleId
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 管理员列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminListDel($param, &$data) {
        $id = $param['id'];
        $dbName = 'db_smc';
        $sql = 'delete from smc_admin where id = :id';
        $pdoParam = [':id' => $id];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 角色列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListGet($param, &$data) {
        $dbName = 'db_smc';

        $sql = 'select id, role_name, priv from smc_admin_role order by id limit ' . maxQueryNum;
        $rows = clsUtility::getRows($dbName, $sql);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $roleId = intval($row['id']);
                $sql = 'select admin_name from smc_admin where role_id = :role_id';
                $pdoParam = [':role_id' => $roleId];
                $rowsAdmin = clsUtility::getRows($dbName, $sql, $pdoParam);
                if (!empty($rowsAdmin)) {
                    $tmpArr = [];
                    foreach ($rowsAdmin as $rowAdmin) {
                        $tmpArr[] = $rowAdmin['admin_name'];
                    }
                    $row['adminList'] = implode(',', $tmpArr);
                } else {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                        . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));

                    $row['adminList'] = '--';
                }
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows fail, dbName = ' . $dbName
                . ', sql = ' . $sql);
        }
        return ERR_OK;
    }

    /**
     * 角色列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListAdd($param, &$data) {
        $roleName = $param['roleName'];
        $priv = $param['priv'];

        $dbName = 'db_smc';

        // 检测是否已存在此角色名
        $sql = 'select id from smc_admin_role where role_name = :role_name limit 1';
        $pdoParam = [':role_name' => $roleName];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', roleName already exist, roleName = ' . $roleName);
            return ERR_ADMIN_ROLE_NAME_ALREADY_EXIST;
        }

        // 添加
        $sql = 'insert into smc_admin_role (role_name, priv) values (:role_name, :priv)';
        $pdoParam = [':role_name' => $roleName, ':priv' => $priv];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 角色列表 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleListEdit($param, &$data) {
        $roleName = $param['roleName'];
        $priv = $param['priv'];

        $dbName = 'db_smc';

        // 检测是否已存在此角色名
        $sql = 'select id from smc_admin_role where role_name = :role_name limit 1';
        $pdoParam = [':role_name' => $roleName];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', roleName already exist, roleName = ' . $roleName);
            return ERR_ADMIN_ROLE_NAME_NOT_EXIST;
        }

        // 修改
        $sql = 'update smc_admin_role set role_name = :role_name, priv = :priv where role_name = :role_name';
        $pdoParam = [':role_name' => $roleName, ':priv' => $priv];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 管理员登录日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function adminLoginLogGet($param, &$data) {
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];
        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);

        $dbName = 'db_smc';
        $sql = 'select adminAccount, loginIP, from_unixtime(loginTime) as loginTime from smc_admin_login_log';
        $sql .= ' where loginTime >= :tsBegin and loginTime <= :tsEnd';
        $sql .= ' order by id desc limit ' . maxQueryNum;

        $pdoParam = [
            ':tsBegin' => $tsBegin,
            ':tsEnd' => $tsEnd
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = ' . $dbName
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }
}