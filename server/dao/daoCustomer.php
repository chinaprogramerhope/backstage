<?php

/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */
class daoCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGet($param, &$data) {
        $userId = $param['userId'];
        $accountId = $param['accountId'];
        $aliPayAccount = $param['aliPayAccount'];
        $aliPayName = $param['aliPayName'];
        $mac = $param['mac'];
        $ip = $param['ip'];
        $bindPhone = $param['bindPhone'];
        $isRecharge = $param['isRecharge'];

        $finalRet = [];
        $retUserInfoList = [];

        /*
         * 获取表 casinouserdb_x.casinouser_x 信息
         */
        if (!empty($userId)) {
            $errCode = self::getUserInfo($userId, $retUserInfoList);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::getUserInfo fail, '
                    . ' userId = ' . $userId . ', errCode = ' . $errCode);
                return $errCode;
            }
        } else {
            $condition = [];
            $where = ' ';
            $pdoParam = [];

            if (!empty($accountId)) {
                $condition[] = 'user_email like :user_email';
                $pdoParam[':user_email'] = '%' . $accountId . '%';
            }

            if (!empty($aliPayAccount)) {
                $condition[] = 'alipay_account like :alipay_account';
                $pdoParam[':alipay_account'] = '%' . $aliPayAccount . '%';
            }

            if (!empty($aliPayName)) {
                $condition[] = 'alipay_real_name like :alipay_real_name';
                $pdoParam[':alipay_real_name'] = '%' . $aliPayName . '%';
            }

            if (!empty($mac)) {
                $condition[] = 'mac like :mac';
                $pdoParam[':mac'] = '%' . $mac . '%';
            }

            if (!empty($ip)) {
                $condition[] = 'ip like :ip';
                $pdoParam[':ip'] = '%' . $ip . '%';
            }

            if (!empty($bindPhone)) {
                $condition[] = 'boundmobilenumber like :boundmobilenumber';
                $pdoParam[':boundmobilenumber'] = '%' . $bindPhone . '%';
            }

            if ($isRecharge !== -1) {
                if ($isRecharge === 1) {
                    $condition[] = 'total_total_money != 0';
                } else {
                    $condition[] = 'total_total_money = 0';
                }
            }

            if (!empty($condition)) {
                $where = ' where ' . implode(' and ', $condition);
            }

            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', where = ' . $where . ', pdoParam = ' . json_encode($pdoParam));

            $errCode = self::getUserInfoList($where, $pdoParam, $retUserInfoList);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::getUserInfo fail, '
                    . ' param = ' . json_encode($param) . ', errCode = ' . $errCode);
                return $errCode;
            }
        }

        if (empty($retUserInfoList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', self::getUserInfoList return empty');
            return ERR_OK;
        }

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
        }

        /*
         * 继续获取其他信息 
         */
        foreach ($retUserInfoList as $key => $value) {
            $userId = intval($value['id']);

            $fishkkk = self::getGameFishkkk($userId);
            $fish = self::getGameFish($userId);
            $fishtool = self::getGameFishTool($userId);
            $rty = self::getGameStatusy($userId);
            $rty1 = self::getGameVipy($userId);

            $value ["signcardcount"] = $rty [0] ["signcardcount"];
            if ($rty [0] ["notecarddeviceeffectivetime"] > 0) {
                $value ["notecarddeviceeffectivetime"] = (round((time() - $rty [0] ["notecarddeviceeffectivetime"]) / 3600)) . "小时";
            } else {
                $value ["notecarddeviceeffectivetime"] = "0小时";
            }

            // 数据库位置
            $dbIndex = -1;
            $tableIndex = -1;
            $indexArr = clsUtility::getUserDBPos($userId);
            if (!is_array($indexArr) || empty($indexArr)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            } else {
                $dbIndex = $indexArr['dbindex'];
                $tableIndex = $indexArr['tableindex'];
            }
            $value['dbIndex'] = $dbIndex;
            $value['tableIndex'] = $tableIndex;

            $value ["periodwinscore"] = isset($fishkkk [0] ["periodwinscore"]) ? $fishkkk [0] ["periodwinscore"] : 0;
            $value ["periodgamecount"] = isset($fishkkk [0] ["periodgamecount"]) ? $fishkkk [0] ["periodgamecount"] : 0;
            $value ["dailywinscore"] = isset($fishkkk [0] ["dailywinscore"]) ? $fishkkk [0] ["dailywinscore"] : 0;
            $value ["totalplayscore"] = isset($fishkkk [0] ["totalplayscore"]) ? $fishkkk [0] ["totalplayscore"] : 0;
            $value ["totalwinscore"] = isset($fishkkk [0] ["totalwinscore"]) ? $fishkkk [0] ["totalwinscore"] : 0;
            $value ["totalshotcount"] = isset($fishkkk [0] ["totalshotcount"]) ? $fishkkk [0] ["totalshotcount"] : 0;
            $value ["dailyshotcoun"] = isset($fishkkk [0] ["dailyshotcoun"]) ? $fishkkk [0] ["dailyshotcoun"] : 0;
            $value ["forcepool"] = isset($fishkkk [0] ["forcepool"]) ? $fishkkk [0] ["forcepool"] : 0;
            $value ["rewardpool"] = isset($fishkkk [0] ["rewardpool"]) ? $fishkkk [0] ["rewardpool"] : 0;

            $value ["explevel"] = isset($fish [0] ["explevel"]) ? $fish [0] ["explevel"] : 0;
            $value ["expvalue"] = isset($fish [0] ["expvalue"]) ? $fish [0] ["expvalue"] : 0;
            $value ["money"] = isset($fish [0] ["money"]) ? $fish [0] ["money"] : 0;
            $value ["secondmoney"] = isset($fish [0] ["secondmoney"]) ? $fish [0] ["secondmoney"] : 0;
            $value ["gunindex"] = isset($fish [0] ["gunindex"]) ? $fish [0] ["gunindex"] : 0;

            $value ["skill1num"] = isset($fishtool [0] ["skill1num"]) ? $fishtool [0] ["skill1num"] : 0;
            $value ["skill2num"] = isset($fishtool [0] ["skill2num"]) ? $fishtool [0] ["skill2num"] : 0;
            $value ["skill3num"] = isset($fishtool [0] ["skill3num"]) ? $fishtool [0] ["skill3num"] : 0;

            $value ["cofferchips"] = isset($rty [0] ["cofferchips"]) ? $rty [0] ["cofferchips"] : 0;

            $value ["cofferpassword"] = isset($rty [0] ["cofferpassword"]) ? $rty [0] ["cofferpassword"] : 0;

            $value ["silvertreasureboxcount"] = isset($rty [0] ["silvertreasureboxcount"]) ? $rty [0] ["silvertreasureboxcount"] : 0;

            $value ["goldentreasureboxcount"] = isset($rty [0] ["goldentreasureboxcount"]) ? $rty [0] ["goldentreasureboxcount"] : 0;

            $value ["newlevel"] = isset($rty1 [0] ["fishlevel"]) ? $rty1 [0] ["fishlevel"] : 0;

            $value ["exp"] = isset($rty1 [0] ["fishexp"]) ? $rty1 [0] ["fishexp"] : 0;

            $tests = isset($rty1 [0] ["fishexpiredate"]) ? $rty1 [0] ["fishexpiredate"] - (time() / (24 * 60 * 60)) : 0;

            if ($tests < 0)
                $tests = 0;

            $value ["expiredate"] = ceil($tests) . "天";

            $value ["lastrewarddate"] = isset($rty1 [0] ["fishlastrewarddate"]) ? $rty1 [0] ["fishlastrewarddate"] : 0;

            if (!empty ($userid)) {
                $value ["config"] = self::getDatabases($userId);
            }

            // 从smc_user表中获取alipay_account, alipay_real_name
            $value['alipay_account'] = '';
            $value['alipay_real_name'] = '';
            $retSmcUser = self::getSmcUser($userId);
            if (!empty($retSmcUser)) {
                $value['alipay_account'] = $retSmcUser['alipay_account'];
                $value['alipay_real_name'] = $retSmcUser['alipay_real_name'];
            }

            $channelName = array_key_exists($value['channel_id'], channelList) ? channelList[$value['channel_id']]['name'] : '';
            $value['channel_id'] = $value['channel_id'] == 0 ? "集集棋牌" : $channelName;
            $value['totalBuy'] = ($value['totalBuy'] / 100) . '元';
            $value['total_total_money'] = ($value['total_total_money'] / 100) . '元';
            $value['last_login_time'] = date('Y-m-d H:i:s', $value['last_login_time'] - 3600 * 8);

            if ($redis === null) {
                $value['is_reported'] = '否';
            } else {
                if ($redis->get('reported_' . $value['id']) == '1') {
                    $ttl = intval($redis->ttl('reported_' . $value['id']));
                    $value['is_reported'] = '是,剩余' . round($ttl / 60) . '分钟';
                } else {
                    $value['is_reported'] = '否';
                }
            }

            //黑名单信息
            $value['black_des'] = '';
            $blacklistInfo = self::getBlackList($userId);
            if (!empty($blacklistInfo)) {
                $value['black_des'] = $blacklistInfo['opertime'] . '被封，原因：' . $blacklistInfo['describecontent'];
            }
            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', userId = ' . $userId . ', blackInfo = ' . json_encode($blacklistInfo));

            $finalRet[] = $value;
        }

        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', data = ' . json_encode($data));

        $data = $finalRet;

        return ERR_OK;
    }

    /**
     * 用户信息管理 - 金豆+保险箱最大的
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGetMax($param, &$data) {
        $cofee = self::getAllDataCoffee();
        $jinDu = self::getAllDataJindu();

        $data = [
            'cofee' => $cofee,
            'jindu' => $jinDu
        ];

        // test
        clsLog::debug('ok411, data = ' . json_encode($data));
        return ERR_OK;
    }

    /**
     * 用户注册列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userRegisterListGet($param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];

            $tsBegin = strtotime($dateBegin);
            $tsEnd = strtotime($dateEnd);
        } else {
            $tsBegin = strtotime(date('Y-m-d'));
            $tsEnd = $tsBegin + daySeconds;
        }

        $dbName = 'casinogamehisdb';
        $tableName = 'CASINOREGISTERHISTORY';

        $sqlArr = [];
        for ($i = $tsBegin; $i <= $tsEnd; $i += daySeconds) {
            $sqlArr[] = '(select * from ' . $tableName . date('Ymd', $i) . ')';
        }
        if (empty($sqlArr)) {
            clsLog::error(__METHOD__ . ', ' . __METHOD__ . ', invalid param, sql empty, param = ' . json_encode($param));
            return ERR_OK;
        }

        $sql = implode(' union all ', $sqlArr);
        $sql .= ' order by registertime desc limit ' . maxQueryNumTest;

        $pdo = clsMysql::getInstance($dbName);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                foreach ($rows as $)

                $data = $rows;
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql . ', dbName = ' . $dbName);
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }
        return ERR_OK;
    }

    // ====

    /**
     * 获取用户信息 - 根据userId
     * @param $userId
     * @param $data
     * @return int
     */
    public static function getUserInfo($userId, &$data) {
        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return ERR_INVALID_USER_ID;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $tableName = 'casinouser_' . $tableIndex;

        $sql = 'select * from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        $row = $stmt->fetchAll();
        if (!empty($row)) {
            $data = $row;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
        }

        return ERR_OK;
    }

    /**
     * 获取casinouserdb_xx库 casinouser_xx表
     * @param $where
     * @param $pdoParam
     * @param $data
     * @return int
     */
    public static function getUserInfoList($where, &$pdoParam, &$data) {
        $dbPrefix = 'casinouserdb_';
        for ($i = 0; $i <= 15; $i++) {
            $dbName = $dbPrefix . $i;

            $pdo = clsMysql::getInstance($dbName);
            if (null === $pdo) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
                continue;
            }

            $tablePrefix = 'casinouser_';
            $sql = '';
            for ($j = 0; $j <= 15; $j++) {
                $tableName = $tablePrefix . $j;
                if (!empty($sql)) {
                    $sql .= ' union all ';
                }
                $sql .= 'select * from ' . $tableName . $where;
//                $sql .= ' limit ' . maxQueryNum;
                $sql .= ' limit 3'; // todo 分页 因为超级卡
            }
            try {
                $stmt = $pdo->prepare($sql);
                if (!empty($pdoParam)) {
                    $ret = $stmt->execute($pdoParam);
                } else {
                    $ret = $stmt->execute();
                }
                if (!$ret) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                        . ', dbName = ' . $dbName
                        . ', errCode = ' . $pdo->errorCode() . ', errInfo = ' . json_encode($pdo->errorInfo()));
                    continue;
                }

                $rows = $stmt->fetchAll();
                if (empty($rows)) {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                        . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
                } else {
                    $data = array_merge($data, $rows);
                }

                clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($rows)
                    . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                    . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                continue;
            }
        }


        return ERR_OK;
    }

    /**
     * 获取casinouserdb_xx库 casinouserfishcontrolinfo_xx
     * @param $userId
     * @return array
     */
    public static function getGameFishkkk($userId) {
        $finalRet = [];
        $finalRet[0]["periodwinscore"] = 0;
        $finalRet[0]["periodgamecount"] = 0;
        $finalRet[0]["dailywinscore"] = 0;
        $finalRet[0]["totalplayscore"] = 0;
        $finalRet[0]["totalwinscore"] = 0;
        $finalRet[0]["totalshotcount"] = 0;
        $finalRet[0]["dailyshotcoun"] = 0;
        $finalRet[0]["forcepool"] = 0;
        $finalRet[0]["rewardpool"] = 0;

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return $finalRet;
        }

        $tableName = 'casinouserfishcontrolinfo_' . $tableIndex;

        $sql = 'select * from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return $finalRet;
            }

            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return $finalRet;
        }
        if (!empty($rows)) {
            $finalRet = $rows;
            $finalRet[0]['dailyshotcoun'] = $finalRet[0]['dailyshotcount'];
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return $finalRet;
        }
    }

    /**
     * 获取casinouserdb_xx库 casinouserfishinfo_xx
     * @param $userId
     * @return array
     */
    public static function getGameFish($userId) {
        $finalRet = [];
        $finalRet[0]["signcardcount"] = 0;
        $finalRet[0]["notecarddeviceeffectivetime"] = 0;
        $finalRet[0]["cofferchips"] = 0;
        $finalRet[0]["cofferpassword"] = 0;

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return $finalRet;
        }

        $tableName = 'casinouserfishinfo_' . $tableIndex;

        $sql = 'select * from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return $finalRet;
            }

            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return $finalRet;
        }
        if (!empty($rows)) {
            $finalRet = $rows;
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return $finalRet;
        }
    }

    /**
     * 获取casinouserdb_xx库 casinouserfishskillinfo_xx
     * @param $userId
     * @return array
     */
    public static function getGameFishTool($userId) {
        $finalRet = [];
        $finalRet[0]["skill1num"] = 0;
        $finalRet[0]["skill2num"] = 0;
        $finalRet[0]["skill3num"] = 0;

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return $finalRet;
        }

        $tableName = 'casinouserfishskillinfo_' . $tableIndex;

        $sql = 'select * from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return $finalRet;
            }

            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return $finalRet;
        }
        if (!empty($rows)) {
            $finalRet = $rows;
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return $finalRet;
        }
    }

    /**
     * 获取casinouserdb_xx库 casinouserbaggageinfo_xx
     * @param $userId
     * @return array
     */
    public static function getGameStatusy($userId) {
        $finalRet = [];
        $finalRet[0]["signcardcount"] = 0;
        $finalRet[0]["notecarddeviceeffectivetime"] = 0;
        $finalRet[0]["cofferchips"] = 0;
        $finalRet[0]["cofferpassword"] = 0;

        $finalRet[0]["silvertreasureboxcount"] = 0;
        $finalRet[0]["goldentreasureboxcount"] = 0;

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return $finalRet;
        }

        $tableName = 'casinouserbaggageinfo_' . $tableIndex;

        $sql = 'select * from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return $finalRet;
            }

            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return $finalRet;
        }
        if (!empty($rows)) {
            $finalRet = $rows;
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return $finalRet;
        }
    }

    /**
     * 获取casinouserdb_xx库 casinouserbaggageinfo_xx
     * @param $userId
     * @return array
     */
    public static function getGameVipy($userId) {
        $finalRet = [];
        $finalRet[0]["fishlevel"] = 0;
        $finalRet[0]["fishexp"] = 0;
        $finalRet[0]["fishexpiredate"] = 0;
        $finalRet[0]["fishlastrewarddate"] = 0;

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return $finalRet;
        }

        $tableName = 'casinouserbaggageinfo_' . $tableIndex;

        $sql = 'select userid as fishuserid , level as fishlevel , exp as fishexp , expiredate as fishexpiredate ,lastrewarddate as fishlastrewarddate from ' . $tableName . ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return $finalRet;
            }

            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return $finalRet;
        }
        if (!empty($rows)) {
            $finalRet = $rows;
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return $finalRet;
        }
    }

    /**
     * 获取表数据 - db_smc.smc_user
     * @param $userId
     * @return array
     */
    public static function getSmcUser($userId) {
        $dbName = 'db_smc';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return [];
        }

        $sql = 'select * from smc_user where user_id = :user_id';
        $pdoParam = [
            ':user_id' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return [];
            }

            $row = $stmt->fetch();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return [];
        }
        if (!empty($row)) {
            return $row;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbName = ' . $dbName);
            return [];
        }
    }

    /**
     * @param $userId
     * @return array
     */
    public static function getDatabases($userId) {
        $finalRet = [
            'databases' => '',
            'databasescoff' => '',
            'ip' => '',
            'ipcoff' => ''
        ];
        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return $finalRet;
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $dsn = mysqlConfig[$dbName]['dsn'];
        $ip = clsUtility::cutStr($dsn, 'host=', ';charset');

        $finalRet = [
            'databases' => 'casinouserdb_' . $dbIndex . '.casinouser2account_' . $tableIndex,
            'databasescoff' => 'casinouserdb_' . $dbIndex . '.casinouserbaggageinfo_' . $tableIndex,
            'ip' => $ip,
            'ipcoff' => $ip
        ];

        return $finalRet;
    }

    /**
     * 获取表数据 - casinoblacklistdb.casinouseridblacklist
     * @param $userId
     * @return array|mixed
     */
    public static function getBlackList($userId) {
        $dbName = 'casinoblacklistdb';
        $tableName = 'casinouseridblacklist';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return [];
        }

        $sql = 'select describecontent,opertime from ' . $tableName . ' where user_id = :user_id limit 1';
        $pdoParam = [
            ':user_id' => $userId
        ];
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return [];
            }

            $row = $stmt->fetch();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage());
            return [];
        }
        if (!empty($row)) {
            return $row;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbName = ' . $dbName);
            return [];
        }
    }

    // todo 前50名金豆总和
    private static function getAllDataCoffee() {
        $dbPrefix = 'casinouserdb_';
        $tablePrefix = 'casinouserbaggageinfo_';
        $search = 'userid, cofferchips';
        $where = '';
        $pdoParam = [];

        return clsUtility::getAllData($dbPrefix, $tablePrefix, $search, $where, $pdoParam);
    }

    private static function getAllDataJindu() {
        $dbPrefix = 'casinouserdb_';
        $tablePrefix = 'casinouser_';
        $search = 'id, user_chips';
        $where = '';
        $pdoParam = [];

        return clsUtility::getAllData($dbPrefix, $tablePrefix, $search, $where, $pdoParam);
    }
}