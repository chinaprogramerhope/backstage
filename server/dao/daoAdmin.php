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

    /**
     * 运营数据总表 - 获取 todo
     * @param $param
     * @param $data
     * @return int
     */
    public static function masterGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 管理员登录日志 - 导出excel todo
     * @param $param
     * @param $data
     * @return int
     */
    public static function masterExport($param, &$data) {
        return ERR_OK;
    }

    /**
     * 充提抽水曲线 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongTiChouShuiCurveGet($param, &$data) {
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $dbName = 'casinostatdb';
        $sql = "SELECT
					statistics_date,
					sum(pay_total_money) / 100 AS sum_total_pay,
					sum(cash_money+cash_money1) / 100 AS sum_total_cash,
					sum(ddz_choushui+huanle_ddz_choushui+laizi_ddz_choushui+zjh_choushui+niuniu_choushui+qiangzhuang_niuniu_choushui+buyu_choushui+fruit_money+bao_money+fruit_compare_money+zjh_bairen_choushui + lhp_choushui + malai_niuniu_choushui + sangong_choushui + hongheidz_choushui)/100 as sum_total_choushui,
					0 as sum_total_pcc
				FROM
					CASINOBUSINESSSTATISTICS t
				WHERE
					statistics_date >= '$dateBegin'
				AND statistics_date <= '$dateEnd'
				GROUP BY
					statistics_date";
        $rows = clsUtility::getRows($dbName, $sql);

        $retPay = [];
        $retCash = [];
        $retChoushui = [];
        $retPcc = [];

        if (!empty($rows)) {
            foreach ($rows as $row) {
                $retPay[] = ["tm" => $row['statistics_date'], "ct" => intval($row['sum_total_pay'])];
                $retCash[] = ["tm" => $row['statistics_date'], "ct" => intval($row['sum_total_cash'])];
                $retChoushui[] = ["tm" => $row['statistics_date'], "ct" => intval($row['sum_total_choushui'])];
                $retPcc[] = ["tm" => $row['statistics_date'], "ct" => (intval($row['sum_total_pay']) - intval($row['sum_total_cash']) - intval($row['sum_total_choushui']))];
            }
        }
        $data = [
            'sumTotalPay' => $retPay,
            'sumTotalCash' => $retCash,
            'sumTotalChoushui' => $retChoushui,
            'sumTotalPcc' => $retPcc,
            'minTime' => strtotime($dateBegin),
            'maxTime' => strtotime($dateEnd)
        ];

        return ERR_OK;
    }

    /**
     * 渠道统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function channelStatisticsGet($param, &$data) {
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $noChannelList = noChannelList;
        $channelList = channelList;

        $data[] = [
            'name' => '全部',
            'newRegist' => self::getTotalNewRegistration(-1, $dateBegin, $dateEnd),
            'totalPay' => self::getTotalPay(-1, $dateBegin, $dateEnd),
            'totalCash' => self::getTotalCash(-1, $dateBegin, $dateEnd),
            'totalCashChoushui' => self::getTotalCashChoushui(-1, $dateBegin, $dateEnd),
            'totalChoushui' => self::getTotalChoushui(-1, $dateBegin, $dateEnd)
        ];

        $data[] = [
            'name' => '集集棋牌',
            'newRegist' => self::getTotalNewRegistration(0, $dateBegin, $dateEnd),
            'totalPay' => self::getTotalPay(0, $dateBegin, $dateEnd),
            'totalCash' => self::getTotalCash(0, $dateBegin, $dateEnd),
            'totalCashChoushui' => self::getTotalCashChoushui(0, $dateBegin, $dateEnd),
            'totalChoushui' => self::getTotalChoushui(0, $dateBegin, $dateEnd)
        ];

        foreach ($channelList as $k => $v) {
            if (isset($noChannelList[$k])) {
                continue;
            }

            $data[] = [
                'name' => '集集棋牌',
                'newRegist' => self::getTotalNewRegistration($k, $dateBegin, $dateEnd),
                'totalPay' => self::getTotalPay($k, $dateBegin, $dateEnd),
                'totalCash' => self::getTotalCash($k, $dateBegin, $dateEnd),
                'totalCashChoushui' => self::getTotalCashChoushui($k, $dateBegin, $dateEnd),
                'totalChoushui' => self::getTotalChoushui($k, $dateBegin, $dateEnd)
            ];
        }

        // 进行排序
        usort($data, ['daoAdmin', 'sortByNewRegist']);

        return ERR_OK;
    }

    /**
     * 捕鱼运营总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function fishMasterGet($param, &$data) {
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $dbName = 'casinostatdb';
        $sql = 'select * from casinofishstat where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $sql .= ' limit ' . maxQueryNum;
        $pdoParam = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 电玩城运营总表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameCityMasterGet($param, &$data) {
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $dbName = 'casinostatdb';
        $sql = 'select * from casinovideoarcadestat where statistics_date >= :dateBegin and statistics_date<= :dateEnd';
        $sql .= ' limit ' . maxQueryNum;
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 当前在线人数 - 获取 todo
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineNumCurrentGet($param, &$data) {
        $gameId = $param['gameId'];

        if (in_array($gameId, [
            '0',    // 全部
            '1',
            '5',
            '17',    // 牛牛
            "18",
            "20",    // 看牌抢庄牛牛
            "21",    // 百人牛牛
            "49",    // 三张牌
            "52",    // 百人三张
            "54",    // 红黑大战
            "99",
            "145",
            "146",
            "148",
            "149",
            "177",
            "178",
            "289",    // 电玩城
            "322",    // 连环炮
            '23',
            '24'
        ])) {
            $data = self::getOnlineMsg1($gameId);
        }

        if (in_array($gameId, [
            "97",    // 普通斗地主
            "98",    // 欢乐斗地主
            "101"    // 癞子斗地主
        ])) {
            $data = self::getOnlineMsg4($gameId);
        }
        if (in_array($gameId, [
            '257'
        ])) {

            $data = self::getOnlineMsg3($gameId);
        }

        if (in_array($gameId, [
            '193' // 捕鱼
        ])) {
            $data = self::getOnlineMsg5($gameId);
        }
        if (in_array($gameId, [
            '100'
        ])) {
            $data = self::getOnlineMsg2($gameId);
        }

        if (in_array($gameId, [
            '289'    // 电玩城
        ])) {
            $data = self::getOnlineMsg20($gameId);
        }

        return ERR_OK;
    }

    /**
     * 历史在线人数 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineNumHistoryGet($param, &$data) {
        $gameId = $param['gameId'];
        $selectDate = $param['selectDate'];
        $selectTs = strtotime($selectDate);

        if (in_array($gameId, ['0', '1', '5', '17', "18", "20", "21", "23", "24", "49", "51", "52", "54", "97", "98", "101", "145", "146", "148", "149", "177", "178", "193", "257", "289"])) {
            $tableName = 'casinodetailonlinestatistics';
            $data = self::getHisMsg($gameId, $selectTs, $tableName);
        }

        if (in_array($gameId, ['100'])) {
            $tableName = 'casinoonlinetournamentgamestatistics';
            $data = self::getHisMsg($gameId, $selectTs, $tableName);
        }

        return ERR_OK;
    }

    /**
     * 捕鱼历史在线人数 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function fishOnlineNumHistoryGet($param, &$data) {
        $gameId = $param['gameId'];
        $selectDate = $param['selectDate'];

        $dateBegin = $selectDate;
        $dateEnd = date($selectDate, strtotime($selectDate) + daySeconds);

        $dbName = 'casinoglobalinfo';

        $sql = 'select substr(statistics_time,12,5) as tm ,sum(roomusercount) as ct from casinodetailonlinestatistics';
        $sql .= ' where statistics_time >= :dateBegin and statistics_time < :dateEnd';
        $sql .= ' and roomid = :roomId and gametype = :gameId';
        $pdoParam1TimesRoom = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd,
            ':roomId' => 1,
            ':gameId' => 193
        ];

        $pdoParam30TimesRoom = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd,
            ':roomId' => 2,
            ':gameId' => 193
        ];

        $pdoParam80TimesRoom = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd,
            ':roomId' => 3,
            ':gameId' => 193
        ];

        $pdoParam300TimesRoom = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd,
            ':roomId' => 4,
            ':gameId' => 193
        ];

        $gameServerIp['193'] = '';

        if ($gameId !== -1) {
            $sql .= ' and gameserverip = :gameServerIp';
            $pdoParam1TimesRoom[':gameServerIp'] = $gameServerIp['193'];
            $pdoParam30TimesRoom[':gameServerIp'] = $gameServerIp['193'];
            $pdoParam80TimesRoom[':gameServerIp'] = $gameServerIp['193'];
            $pdoParam300TimesRoom[':gameServerIp'] = $gameServerIp['193'];
        }

        $sql .= ' group by statistics_time limit ' . maxQueryNum;

        $rows1TimesRoom = clsUtility::getRows($dbName, $sql, $pdoParam1TimesRoom);
        if (empty($rows1TimesRoom)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam1TimesRoom = ' . json_encode($pdoParam1TimesRoom));
        }

        $rows30TimesRoom = clsUtility::getRows($dbName, $sql, $pdoParam30TimesRoom);
        if (empty($rows1TimesRoom)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam30TimesRoom = ' . json_encode($pdoParam30TimesRoom));
        }

        $rows80TimesRoom = clsUtility::getRows($dbName, $sql, $pdoParam80TimesRoom);
        if (empty($rows1TimesRoom)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam80TimesRoom = ' . json_encode($pdoParam80TimesRoom));
        }

        $rows300TimesRoom = clsUtility::getRows($dbName, $sql, $pdoParam300TimesRoom);
        if (empty($rows300TimesRoom)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam300TimesRoom = ' . json_encode($pdoParam300TimesRoom));
        }

        $data = [
            '1TimesRoom' => $rows1TimesRoom,
            '30TimesRoom' => $rows30TimesRoom,
            '80TimesRoom' => $rows80TimesRoom,
            '300TimesRoom' => $rows300TimesRoom
        ];

        return ERR_OK;
    }

    /**
     * 金豆和宝箱变化表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldAndSafeBoxGet($param, &$data) {
        $gameId = $param['gameId'];
        $selectTs = strtotime($param['selectDate']);

        $dbName = 'casinostatdb';

        // 今天
        $dateTodayBegin = date('Y-m-d', $selectTs);
        $dateTodayEnd = date('Y-m-d', $selectTs + daySeconds);

        // 昨天
        $dateYesterdayBegin = date('Y-m-d', $selectTs - daySeconds);
        $dateYesterdayEnd = date('Y-m-d', $selectTs);

        // 上周的今天
        $dateWeekBegin = date('Y-m-d', $selectTs - weekSeconds);
        $dateWeekEnd = date('Y-m-d', $selectTs - weekSeconds + daySeconds);

        // 上月的今天
        $dateMonthBegin = date('Y-m-d', $selectTs - monthSeconds);
        $dateMonthEnd = date('Y-m-d', $selectTs - monthSeconds + daySeconds);

        $sql = 'select substr(stattime,12,5) as tm ,sumchips/100 as sumchips,sumcofferchips/100 as sumcofferchips from casinosumchiphistory';
        $sql .= ' where statistics_time >= :dateBegin and statistics_time < :dateEnd';
        $sql .= ' limit ' . maxQueryNum;

        $pdoToday = [
            ':dateBegin' => $dateTodayBegin,
            ':dateEnd' => $dateTodayEnd
        ];

        $pdoYesterday = [
            ':dateBegin' => $dateYesterdayBegin,
            ':dateEnd' => $dateYesterdayEnd
        ];

        $pdoWeek = [
            ':dateBegin' => $dateWeekBegin,
            ':dateEnd' => $dateWeekEnd
        ];

        $pdoMonth = [
            ':dateBegin' => $dateMonthBegin,
            ':dateEnd' => $dateMonthEnd
        ];

        if ($gameId !== -1) {
            $sql .= ' and gametype = :gameId';

            $pdoToday[':gameId'] = $gameId;
            $pdoYesterday[':gameId'] = $gameId;
            $pdoWeek[':gameId'] = $gameId;
            $pdoMonth[':gameId'] = $gameId;
        }

        $rowsToday = clsUtility::getRows($dbName, $sql, $pdoToday);
        if (empty($rowsToday)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoToday = ' . json_encode($pdoToday));
        }

        $rowsYesterday = clsUtility::getRows($dbName, $sql, $pdoYesterday);
        if (empty($rowsYesterday)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoYesterday = ' . json_encode($pdoYesterday));
        }

        $rowsWeek = clsUtility::getRows($dbName, $sql, $pdoWeek);
        if (empty($rowsWeek)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoWeek = ' . json_encode($pdoWeek));
        }

        $rowsMonth = clsUtility::getRows($dbName, $sql, $pdoMonth);
        if (empty($rowsMonth)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoMonth = ' . json_encode($pdoMonth));
        }

        $data = [
            'today' => $rowsToday,
            'yesterday' => $rowsYesterday,
            'week' => $rowsWeek,
            'month' => $rowsMonth
        ];

        return ERR_OK;
    }

    /**
     * 充值数据统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rechargeStatisticsGet($param, &$data) {
        $channelId = $param['channelId'];
        $selectDate = $param['selectDate'];

        $dbName = 'db_smc';

        $data = [
            'pay_total_num' => [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => '今日充值',
                        'data' => [],
                        'pointStrokeColor' => '#fff',
                        'fill' => false,
                        'borderColor' => 'green',
                        'spanGaps' => true,
                        'lineTension' => 0.1
                    ],
                    [
                        'label' => '昨日充值',
                        'data' => [],
                        'pointStrokeColor' => '#fff',
                        'fill' => false,
                        'borderColor' => 'red',
                        'spanGaps' => true,
                        'lineTension' => 0.1
                    ],
                    [
                        'label' => '前日充值',
                        'data' => [],
                        'pointStrokeColor' => '#fff',
                        'fill' => false,
                        'borderColor' => 'blue',
                        'spanGaps' => true,
                        'lineTension' => 0.1
                    ],
                    [
                        'label' => '上周充值',
                        'data' => [],
                        'pointStrokeColor' => '#fff',
                        'fill' => false,
                        'borderColor' => 'yellow',
                        'spanGaps' => true,
                        'lineTension' => 0.1
                    ]
                ]
            ]
        ];

        $sql = 'select date, pay_total_num from smc_log_order';
        $sql .= ' where channel_id = :channel_id and date1 = :date1';
        $sql .= ' order by date limit ' . maxQueryNum;

        // 昨日
        $yesterdayTotalMoney = 0;
        $pdoYesterday = [
            ':channel_id' => $channelId,
            ':date1' => date('Ymd', strtotime($selectDate) - daySeconds)
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoYesterday);
        if (!empty($rows)) {

        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoYesterday = ' . json_encode($pdoYesterday));
        }

        // 今日
        $todayTotalMoney = 0;
        $pdoToday = [
            ':channel_id' => $channelId,
            ':date1' => $selectDate
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoToday);

        // 前日
        $dayBeforeYesterdayTotalMoney = 0;
        $pdoDayBeforeYesterday = [
            ':channel_id' => $channelId,
            ':date1' => date('Ymd', strtotime($selectDate) - daySeconds * 2)
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoDayBeforeYesterday);

        // 上周
        $lastWeekTotalMoney = 0;
        $pdoLastWeek = [
            ':channel_id' => $channelId,
            ':date1' => date('Ymd', strtotime($selectDate) - weekSeconds)
        ];
        $rows = clsUtility::getRows($dbName, $sql, $pdoLastWeek);

        return ERR_OK;
    }

    // ====

    /**
     * @param $channelId
     * @param $dateBegin
     * @param $dateEnd
     * @return int
     */
    public static function getTotalNewRegistration($channelId, $dateBegin, $dateEnd) {
        $finalRet = 0;

        $noChannelList = noChannelList;

        $dbName = 'casinostatdb';
        $sql = 'select sum(new_device_count) as xx from casinobusinessstatistics';
        $sql .= ' where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($channelId >= 0) {
            $sql .= ' and channelid = :channelid';
            $pdoParam[':channelid'] = $channelId;
        } else {
            if (!empty($noChannelList)) {
                foreach ($noChannelList as $k => $v) {
                    $sql .= ' and channelid != ' . $k;
                }
            }
        }

        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $finalRet = intval($row['xx']);
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * @param $channelId
     * @param $dateBegin
     * @param $dateEnd
     * @return string
     */
    public static function getTotalPay($channelId, $dateBegin, $dateEnd) {
        $finalRet = '0.00';

        $noChannelList = noChannelList;

        $dbName = 'casinostatdb';
        $sql = 'select sum(pay_total_money) as xx from casinobusinessstatistics';
        $sql .= ' where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($channelId >= 0) {
            $sql .= ' and channelid = :channelid';
            $pdoParam[':channelid'] = $channelId;
        } else {
            if (!empty($noChannelList)) {
                foreach ($noChannelList as $k => $v) {
                    $sql .= ' and channelid != ' . $k;
                }
            }
        }

        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $finalRet = number_format($row['xx'] / 100, 2, '.', ' ');
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * @param $channelId
     * @param $dateBegin
     * @param $dateEnd
     * @return string
     */
    public static function getTotalCash($channelId, $dateBegin, $dateEnd) {
        $finalRet = '0.00';

        $noChannelList = noChannelList;

        $dbName = 'casinostatdb';
        $sql = 'select sum(cash_money+cash_money1) as xx from casinobusinessstatistics';
        $sql .= ' where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($channelId >= 0) {
            $sql .= ' and channelid = :channelid';
            $pdoParam[':channelid'] = $channelId;
        } else {
            if (!empty($noChannelList)) {
                foreach ($noChannelList as $k => $v) {
                    $sql .= ' and channelid != ' . $k;
                }
            }
        }

        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $finalRet = number_format($row['xx'] / 100, 2, '.', ' ');
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * @param $channelId
     * @param $dateBegin
     * @param $dateEnd
     * @return string
     */
    public static function getTotalCashChoushui($channelId, $dateBegin, $dateEnd) {
        $finalRet = '0.00';

        $noChannelList = noChannelList;

        $dbName = 'casinostatdb';
        $sql = 'select sum(choushui_money+choushui_money1) as xx from casinobusinessstatistics';
        $sql .= ' where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($channelId >= 0) {
            $sql .= ' and channelid = :channelid';
            $pdoParam[':channelid'] = $channelId;
        } else {
            if (!empty($noChannelList)) {
                foreach ($noChannelList as $k => $v) {
                    $sql .= ' and channelid != ' . $k;
                }
            }
        }

        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $finalRet = number_format($row['xx'] / 100, 2, '.', ' ');
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * @param $channelId
     * @param $dateBegin
     * @param $dateEnd
     * @return string
     */
    public static function getTotalChoushui($channelId, $dateBegin, $dateEnd) {
        $finalRet = '0.00';

        $noChannelList = noChannelList;

        $dbName = 'casinostatdb';
        $sql = 'sum(ddz_choushui+huanle_ddz_choushui+laizi_ddz_choushui+zjh_choushui+niuniu_choushui+qiangzhuang_niuniu_choushui+buyu_choushui+fruit_money+bao_money+fruit_compare_money+zjh_bairen_choushui+lhp_choushui+malai_niuniu_choushui+sangong_choushui+hongheidz_choushui) as xx';
        $sql .= ' where statistics_date >= :dateBegin and statistics_date <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($channelId >= 0) {
            $sql .= ' and channelid = :channelid';
            $pdoParam[':channelid'] = $channelId;
        } else {
            if (!empty($noChannelList)) {
                foreach ($noChannelList as $k => $v) {
                    $sql .= ' and channelid != ' . $k;
                }
            }
        }

        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $finalRet = number_format($row['xx'] / 100, 2, '.', ' ');
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * @param $a
     * @param $b
     * @return int
     */
    public static function sortByNewRegist($a, $b) {
        if ($a['new_regist'] == $b['new_regist']) {
            return 0;
        }

        return $a['new_regist'] > $b['new_regist'] ? -1 : 1;
    }

    public static function getOnlineMsg1($gameId) {

    }

    public static function getOnlineMsg2($gameId) {

    }

    public static function getOnlineMsg3($gameId) {

    }

    public static function getOnlineMsg4($gameId) {

    }

    public static function getOnlineMsg5($gameId) {

    }

    public static function getOnlineMsg20($gameId) {

    }

    /**
     * @param $gameId
     * @param $selectTs
     * @param $tableName
     * @return array
     */
    public static function getHisMsg($gameId, $selectTs, $tableName) {
        $dbName = 'casinoglobalinfo';

        // 今天
        $dateTodayBegin = date('Y-m-d', $selectTs);
        $dateTodayEnd = date('Y-m-d', $selectTs + daySeconds);

        // 昨天
        $dateYesterdayBegin = date('Y-m-d', $selectTs - daySeconds);
        $dateYesterdayEnd = date('Y-m-d', $selectTs);

        // 上周的今天
        $dateWeekBegin = date('Y-m-d', $selectTs - weekSeconds);
        $dateWeekEnd = date('Y-m-d', $selectTs - weekSeconds + daySeconds);

        // 上月的今天
        $dateMonthBegin = date('Y-m-d', $selectTs - monthSeconds);
        $dateMonthEnd = date('Y-m-d', $selectTs - monthSeconds + daySeconds);

        $sql = 'select substr(statistics_time,12,5) as tm ,sum(roomusercount) as ct from ' . $tableName;

        $sqlToday = $sql . ' where statistics_time >= :dateTodayBegin and statistics_time < :dateTodayEnd';
        $pdoToday = [
            ':dateTodayBegin' => $dateTodayBegin,
            ':dateTodayEnd' => $dateTodayEnd
        ];

        $sqlYesterday = $sql . ' where statistics_time >= :dateYesterdayBegin and statistics_time < :dateYesterdayEnd';
        $pdoYesterday = [
            ':dateYesterdayBegin' => $dateYesterdayBegin,
            ':dateYesterdayEnd' => $dateYesterdayEnd
        ];

        $sqlWeek = $sql . ' where statistics_time >= :dateWeekBegin and statistics_time < :dateWeekEnd';
        $pdoWeek = [
            ':dateWeekBegin' => $dateWeekBegin,
            ':dateWeekEnd' => $dateWeekEnd
        ];

        $sqlMonth = $sql . ' where statistics_time >= :dateMonthBegin and statistics_time < :dateMonthEnd';
        $pdoMonth = [
            ':dateMonthBegin' => $dateMonthBegin,
            ':dateMonthEnd' => $dateMonthEnd
        ];

        if ($gameId !== -1) {
            $sqlToday .= ' and gametype = :gameId';
            $pdoToday[':gameId'] = $gameId;

            $sqlYesterday .= ' and gametype = :gameId';
            $pdoYesterday[':gameId'] = $gameId;

            $sqlWeek .= ' and gametype = :gameId';
            $pdoWeek[':gameId'] = $gameId;

            $sqlMonth .= ' and gametype = :gameId';
            $pdoMonth[':gameId'] = $gameId;
        }

        $sqlToday .= ' group by statistics_time limit ' . maxQueryNum;
        $sqlYesterday .= ' group by statistics_time limit ' . maxQueryNum;
        $sqlWeek .= ' group by statistics_time limit ' . maxQueryNum;
        $sqlMonth .= ' group by statistics_time limit ' . maxQueryNum;

        $rowsToday = clsUtility::getRows($dbName, $sqlToday, $pdoToday);
        if (empty($rowsToday)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sqlToday = ' . $sqlToday . ', pdoToday = ' . json_encode($pdoToday));
        }

        $rowsYesterday = clsUtility::getRows($dbName, $sqlYesterday, $pdoYesterday);
        if (empty($rowsYesterday)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sqlYesterday = ' . $sqlToday . ', pdoYesterday = ' . json_encode($pdoYesterday));
        }

        $rowsWeek = clsUtility::getRows($dbName, $sqlWeek, $pdoWeek);
        if (empty($rowsWeek)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sqlWeek = ' . $sqlWeek . ', pdoWeek = ' . json_encode($pdoWeek));
        }

        $rowsMonth = clsUtility::getRows($dbName, $sqlMonth, $pdoMonth);
        if (empty($rowsMonth)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sqlMonth = ' . $sqlMonth . ', pdoMonth = ' . json_encode($pdoMonth));
        }

        return [
            'today' => $rowsToday,
            'yesterday' => $rowsYesterday,
            'week' => $rowsWeek,
            'month' => $rowsMonth
        ];
    }

    /**
     * 处理当某一天的某个小时没有收入时的状况，手动插入一条数据
     * @param array $queryArr
     */
    private static function dealWithDateTotalIncome(&$queryArr) {
        $lastDateTime = 0;
        for ($i = 0; $i < count($queryArr); $i++) {
            $dateTime = strtotime($queryArr[$i] ['date'] . '0000');
            if ($lastDateTime != 0 && $lastDateTime != $dateTime - 3600) {
                // 缺少这个记录，手动插入一条
                $dateTime = $lastDateTime + 3600;
                array_splice($queryArr, $i, 0, array(array('date' => date('YmdH', $dateTime), 'pay_total_num' => 0)));
            }

            $lastDateTime = $dateTime;
        }
    }
}