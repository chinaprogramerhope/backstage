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
            $userInfo = self::getUserInfo($userId);
            if (empty($userInfo)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', user not exist, userId = ' . $userId);
                return ERR_USER_NOT_EXIST;
            }

            $retUserInfoList[] = $userInfo;
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
            $tsToday = strtotime(date('Y-m-d'));

            $tsBegin = $tsToday - monthSeconds;
            $tsEnd = $tsToday;
        }

        $dbName = 'casinogamehisdb';
        $tablePrefix = 'CASINOREGISTERHISTORY';
        $pdo = clsMysql::getInstance($dbName);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sqlArr = [];
        for ($i = $tsBegin; $i <= $tsEnd; $i += daySeconds) {
            $tableName = $tablePrefix . date('Ymd', $i);
            if (clsUtility::checkTableExist($pdo, $tableName)) {
                $sqlArr[] = '(select * from ' . $tableName . ')';
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not exist, tableName = ' . $tableName . ', dbName = ' . $dbName);
            }
        }
        if (empty($sqlArr)) {
            clsLog::error(__METHOD__ . ', ' . __METHOD__ . ', invalid param, sql empty, param = ' . json_encode($param));
            return ERR_OK;
        }

        $sql = implode(' union all ', $sqlArr);
        $sql .= ' order by registertime desc limit ' . maxQueryNum;

        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                foreach ($rows as &$row) {
                    $row['guest'] = $row['guest'] ? '是' : '否';
                    $row['channelid'] = array_key_exists($row['channelid'], channelList) ? channelList[$row['channelid']]['name'] : '';
                }
                unset($row);

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

    /**
     * 黑名单信息管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistGet($param, &$data) {
        $dateArr = clsUtility::getFormatDate($param);
        $dateBegin = $dateArr['dateBegin'];
        $dateEnd = $dateArr['dateEnd'];

        $keyword = $param['keyword'];

        $dbName = 'casinoblacklistdb';

        $sql = 'select * from casinoipblacklist where userip = :userip and opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':userip' => $keyword,
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m1 = clsUtility::getRows($dbName, $sql, $pdoParam);

        $sql = 'select * from casinoiprangeblacklist where opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m2 = clsUtility::getRows($dbName, $sql, $pdoParam);

        $sql = 'select * from casinomacblacklist where usermac = :usermac and opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':usermac' => $keyword,
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m3 = clsUtility::getRows($dbName, $sql, $pdoParam);

        $sql = 'select * from casinouseridblacklist where userid = :userid and opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':userid' => $keyword,
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m4 = clsUtility::getRows($dbName, $sql, $pdoParam);

        $data = [
            'm1' => $m1,
            'm2' => $m2,
            'm3' => $m3,
            'm4' => $m4
        ];

        return ERR_OK;
    }

    /**
     * 黑名单信息管理 - 解封批操作 youhua 改为一次删除多个
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchDeBlock($param, &$data) {
        $ipArr = $param['ipArr'];
        $macArr = $param['macArr'];
        $idArr = $param['idArr'];

        if (!empty($ipArr)) {
            foreach ($ipArr as $k => $v) {
                self::delBlackList(1, $v);
            }
        }

        if (!empty($macArr)) {
            foreach ($macArr as $k => $v) {
                self::delBlackList(2, $v);
            }
        }

        if (!empty($idArr)) {
            foreach ($idArr as $k => $v) {
                self::delBlackList(3, $v);
            }
        }

        return ERR_OK;
    }

    /**
     * 黑名单信息管理 - 解封单个
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistDeBlock($param, &$data) {
        $type = $param['type'];
        $value = $param['value'];

        return self::delBlackList($type, $value);
    }

    /**
     * 黑名单信息管理 - 批量踢出相关用户id
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlock($param, &$data) {
        $aliPayAccount = $param['aliPayAccount'];
        $rows = self::getUserIdArrByAliPayAccount($aliPayAccount);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', userIds = ' . json_encode($rows));

        $num = 0;
        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $userId = intval($v['user_id']);
                $indexArr = clsUtility::getUserDBPos($userId);
                if (!is_array($indexArr) || empty($indexArr)) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
                    continue;
                }
                $dbIndex = $indexArr['dbindex'];
                $tableIndex = $indexArr['tableindex'];
                $des = '恶劣支付宝' . $aliPayAccount . '关联 批量封号';

                $dbName = 'casinouserdb_' . $dbIndex;
                $pdo = clsMysql::getInstance($dbName);
                if ($pdo === null) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
                    continue;
                }
                $tableUserBlack = 'casinoblackuser_' . $tableIndex;
                $tableUser = 'casinouser_' . $tableIndex;
                $sql = 'insert into ' . $tableUserBlack . '(userid, account, remarks) values';
                $sql .= '(:userId, (select user_email from ' . $tableUser . ' where id = :userId), :des)';
                $pdoParam = [
                    ':userId' => $userId,
                    ':des' => $des
                ];
                try {
                    $stmt = $pdo->prepare($sql);
                    $ret = $stmt->execute($pdoParam);
                    if (!$ret) {
                        clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, dbName = ' . $dbName
                            . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                        continue;
                    }
                } catch (PDOException $e) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage() . ', dbName = ' . $dbName
                        . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                    continue;
                }
                $num++;
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', num = ' . $num . ', userId = ' . $userId);
            }
        }
        $data['num'] = $num;
        return ERR_OK;
    }

    /**
     * 黑名单信息管理 - 批量封用户id-恶劣密码
     * @param $param
     * @param $data
     * @return int
     */
    public static function blacklistBatchBlockPass($param, &$data) {
        $num = 0;

        $dbPrefix = 'casinouserdb_';
        for ($i = 0; $i <= 15; $i++) {
            $dbName = $dbPrefix . $i;
            $pdo = clsMysql::getInstance($dbName);
            if ($pdo === null) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
                continue;
            }

            for ($j = 0; $j <= 15; $j++) {
                $tableTo = 'casinoblackuser_' . $j;
                $tableFrom = 'casinouser_' . $j;
                $remarks = '平安游戏-多账号恶意刷金币';
                $nowStr = date('Y-m-d H:i:s');

                $sql = " insert into $tableTo(userid,account,remarks,addtime) SELECT userid_base as userid,account,'$remarks' as remarks,'2017-09-13 00:00:00' as addtime from(
					SELECT a.userid,b.userid as userid_base,b.account from $tableFrom a right JOIN
					(select id as userid,user_email as account,'平安游戏-多账号恶意刷金币' as remarks,'$nowStr' as addtime from $tableFrom 
					where registertime>='2017-09-09 00:00:00' and `password` in ('qq1111','qqq111','qwe123','qq123123','a123123','qqq222','qqq111','a123456','zxc123')) b
					on a.userid=b.userid) x where x.userid is null;";
                try {
                    $stmt = $pdo->prepare($sql);
                    $ret = $stmt->execute();
                    if (!$ret) {
                        clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, dbName = ' . $dbName
                            . ', sql = ' . $sql);
                        continue;
                    }

                    $num += $stmt->rowCount();
                } catch (PDOException $e) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception = ' . $e->getMessage() . ', dbName = ' . $dbName
                        . ', sql = ' . $sql);
                    continue;
                }
            }
        }

        $data['num'] = $num;

        return ERR_OK;
    }

    /**
     * 玩家游戏记录 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameLogGet($param, &$data) {
    }

    /**
     * 玩家游戏记录 - 查询游戏次数
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameLogGetTimes($param, &$data) {
        return ERR_OK;
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLogGet($param, &$data) {
        $gameId = $param['gameId'];
        $eventId = $param['eventId'];
        $userId = $param['userId'];
        $account = $param['account'];
        $dateTimeBegin = $param['dateTimeRange']['dateTimeBegin'];
        $dateTimeEnd = $param['dateTimeRange']['dateTimeEnd'];
        $tsBegin = strtotime($dateTimeBegin);
        $tsEnd = strtotime($dateTimeEnd);

        $dbName = 'casinogamehisdb';
        $sql = '';
        for ($i = $tsBegin; $i <= $tsEnd; $i += daySeconds) {
            $tableName = 'casinogamehistory' . date('Ymd', $i);

            if (!clsUtility::checkTableExistByName($dbName, $tableName)) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not exist, dbName = ' . $dbName
                    . ', tableName = ' . $tableName);
                continue;
            }

            if (!empty($sql)) {
                $sql .= ' union all';
            }
            $sql .= ' select * from ' . $tableName . ' where happentime >= :dateTimeBegin and happentime <= :dateTimeEnd';
            if (!empty($userId)) {
                $sql .= ' and userid = :userid';
            }
            if ($gameId !== -1) {
                $sql .= ' and gamecode = :gamecode';
            }
            if ($eventId !== -1) {
                $sql .= ' and eventtype = :eventtype';
            }
        }

        if (empty($sql)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', return empty, sql = ' . $sql
                . ', dbName = ' . $dbName . ', param = ' . json_encode($param));

            return ERR_OK;
        }

        $sql .= ' order by happentime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':dateTimeBegin' => $dateTimeBegin,
            ':dateTimeEnd' => $dateTimeEnd,
            ':userid' => $userId,
            ':gamecode' => $gameId,
            ':eventtype' => $eventId
        ];
        $data = clsUtility::getRows($dbName, $sql, $pdoParam);

        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', return empty, sql = ' . $sql
                . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 玩家金豆变化记录 - 导出
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLogExport($param, &$data) {
        return ERR_OK;
    }

    /**
     * 玩家金豆变化(24小时内)
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldLog24Get($param, &$data) {
        $userId = $param['userId'];

        $db = 8; // todo 同游戏服务器确认; 在哪里保存的内容
        $redis = clsRedis::getInstance($db);

        // 从redis倒叙拿startIndex开始的20条数据
        $key = $userId . '_score';
        $ret = $redis->zRevRange($key, 0, 20);

        if (!empty($ret)) {
            $data = $ret;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ret is empty, db = ' . $db . ', key = ' . $key);
        }

        return ERR_OK;
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function orderInfoGet($param, &$data) {
        $account = $param['account'];
        $userId = $param['userId'];
        $orderId = $param['orderId'];
        $thirdOrderId = $param['thirdOrderId'];

        $dateTimeBegin = $param['dateTimeRange']['dateTimeBegin'];
        $dateTimeEnd = $param['dateTimeRange']['dateTimeEnd'];
        $tsBegin = strtotime($dateTimeBegin);
        $tsEnd = strtotime($dateTimeEnd);

        $payPlatformId = $param['payPlatformId'];
        $orderStatus = $param['orderStatus'];
        $gameId = $param['gameId'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_order';

        $sql .= ' where add_time >= :tsBegin and add_time <= :tsEnd';
        $pdoParam = [
            ':tsBegin' => $tsBegin,
            ':tsEnd' => $tsEnd
        ];

        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($orderId) {
            $sql .= ' and order_sn = :order_sn';
            $pdoParam[':order_sn'] = $orderId;
        }
        if ($thirdOrderId) {
            $sql .= ' and third_order_sn = :third_order_sn';
            $pdoParam[':third_order_sn'] = $thirdOrderId;
        }
        if ($payPlatformId !== -1) {
            $sql .= ' and pay_platform = :pay_platform';
            $pdoParam[':pay_platform'] = $payPlatformId;
        }
        if ($orderStatus !== -1) {
            if ($orderStatus == 2) { // todo 原后台逻辑, 为什么
                $orderStatus = 0;
            }

            $sql .= ' and status = :status';
            $pdoParam[':status'] = $orderStatus;
        }
        if ($gameId !== -1) {
            $sql .= ' and game_code = :game_code'; // todo 表中目前没这个字段
            $pdoParam[':game_code'] = $gameId;
        }
        $sql .= ' order by id desc limit ' . maxQueryNum;

        $orderList = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($orderList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        } else {
            foreach ($orderList as $k => &$v) {
                $status = intval($v['status']);
                switch ($status) {
                    case 0:
                        $v['status'] = '未支付';
                        break;
                    case 1:
                        $v['status'] = '支付成功';
                        break;
                    default:
                        $v['status'] = '支付失败';
                }

                $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
                $v['pay_success_time'] = $v['pay_success_time'] ? date('Y-m-d H:i:s', $v['pay_success_time']) : ' - ';
                $v['money'] = number_format($v['money'] / 100, 2, '.', ' ');

                $v['before_chips'] = number_format($v ['before_chips'], 2, '.', ' ');
                if ($status === 1) {
                    $v['after_chips'] = number_format($v ['before_chips'] + $v ['money'], 2, '.', ' ');
                } else {
                    $v['after_chips'] = '--';
                }
                $v['refer'] = $v['refer'] == 2 ? 'Android' : 'Ios';

//                $v['pay_platform'] = '';
            }
            unset($v);

            $data = $orderList;
        }

        return ERR_OK;
    }

    /**
     * 玩家金豆变化记录 - 获取延时订单 todo 需要修改原始后台传入参数, 延时查询输入项单独搞一列, 因为实际传入参数不一致; 逻辑跟上面几乎一样
     * @param $param
     * @param $data
     * @return int
     */
    public static function orderInfoGetDelay($param, &$data) {
        return ERR_OK;
    }

    /**
     * 支付宝转账订单审核 - 获取支付宝转账订单
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckGet($param, &$data) {
        $userId = $param['userId'];
        $orderId = $param['orderId'];
        $aliPayOrderId = $param['aliPayOrderId'];
        $aliPayAccount = $param['aliPayAccount'];

        $tsBegin = strtotime($param['dateTimeRange']['dateTimeBegin']);
        $tsEnd = strtotime($param['dateTimeRange']['dateTimeEnd']);
        $orderStatus = $param['orderStatus'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_order';

        $sql .= ' where add_time >= :tsBegin and add_time <= :tsEnd';
        $pdoParam = [
            ':tsBegin' => $tsBegin,
            ':tsEnd' => $tsEnd
        ];

        // todo 当前项目支付宝转账和支付宝网页转账对应的id
        $sql .= ' and pay_platform = ' . PAY_PLATFORM_ZFB_TRANSFER . ' or pay_platform = ' . PAY_PLATFORM_ZFB_TRANSFER_WEB;

        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($orderId) {
            $sql .= ' and order_sn = :order_sn';
            $pdoParam[':order_sn'] = $orderId;
        }
        if ($aliPayOrderId) {
            $sql .= ' and third_order_sn = :third_order_sn';
            $pdoParam[':third_order_sn'] = $aliPayOrderId;
        }
        if ($aliPayAccount) {
            $sql .= ' and param = :param';
            $pdoParam[':param'] = $aliPayAccount;
        }
        if ($orderStatus !== -1) {
            $sql .= ' and status = :status';
            $pdoParam[':status'] = $orderStatus;
        }

        $sql .= ' order by id desc limit ' . maxQueryNum;

        $orderList = clsUtility::getRows($dbName, $sql, $pdoParam);

        if (empty($orderList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_OK;
        }

        foreach ($orderList as $k => &$v) {
            $v['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
            $v['pay_success_time'] = $v['pay_success_time'] ? date('Y-m-d H:i:s', $v['pay_success_time  ']) : ' - ';

            $v['after_chips'] = $v['status'] == 1 ? $v ['before_chips'] + $v ['money'] : '--';
        }
        unset($v);
        $data = $orderList;

        return ERR_OK;
    }

    /**
     * 支付宝转账订单审核 - 确认转账成功
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckConfirm($param, &$data) {
        $orderId = $param['orderId'];

        // 获取订单
        $dbName = 'db_smc';
        $sql = 'select * from smc_order where order_sn = :order_sn limit 1';
        $pdoParam = [':order_sn' => $orderId];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($rows) || empty($rows[0])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $orderId
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_ORDER_NOT_EXIST;
        }

        // notice 日志记录管理员id, 名字和订单id

        $order = $rows[0];
        $orderStatus = intval($order['status']);
        if ($orderStatus !== 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order status wrong, orderId = ' . $orderId
                . ', orderStatus = ' . $orderStatus);
            return ERR_ORDER_STATUS_WRONG;
        }

        // 更新
        $errCode = self::orderSuccess($order);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::orderSuccess fail, order = ' . json_encode($order));
            return $errCode;
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', order transfer success, orderId = ' . $orderId);

        return ERR_OK;
    }

    /**
     * 支付宝转账订单审核 - 修改金额
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckModify($param, &$data) {
        $orderId = $param['orderId'];
        $money = $param['money'];

        // 获取订单
        $dbName = 'db_smc';
        $sql = 'select * from smc_order where order_sn = :order_sn limit 1';
        $pdoParam = [':order_sn' => $orderId];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($rows) || empty($rows[0])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $orderId
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_ORDER_NOT_EXIST;
        }

        $order = $rows[0];
        $orderStatus = intval($order['status']);
        if ($orderStatus !== 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order status wrong, orderId = ' . $orderId
                . ', orderStatus = ' . $orderStatus);
            return ERR_ORDER_STATUS_WRONG;
        }

        // notice 日志记录管理员id, 名字和订单id

        // 更新
        $dbName = 'db_smc';
        $sql = 'update smc_order set money = :money where order_sn = :order_sn';
        $pdoParam = [':order_sn' => $orderId];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', order transfer fail, orderId = ' . $orderId);
            return $errCode;
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', order transfer success, orderId = ' . $orderId);

        return ERR_OK;
    }

    /**
     * 支付宝转账订单审核 - 关闭订单
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCheckClose($param, &$data) {
        $orderId = $param['orderId'];
        $reason = $param['reason'];

        // 获取订单
        $dbName = 'db_smc';
        $sql = 'select * from smc_order where order_sn = :order_sn limit 1';
        $pdoParam = [':order_sn' => $orderId];
        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($rows) || empty($rows[0])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $orderId
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_ORDER_NOT_EXIST;
        }

        $order = $rows[0];
        $orderStatus = intval($order['status']);
        if ($orderStatus !== 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order status wrong, orderId = ' . $orderId
                . ', orderStatus = ' . $orderStatus);
            return ERR_ORDER_STATUS_WRONG;
        }

        // notice 日志记录管理员id, 名字和订单id

        // 更新
        $errCode = self::orderFail($order, $reason);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::orderFail fail, order = ' . json_encode($order)
                . ', reason = ' . $reason);
            return $errCode;
        }

        $redis = clsRedis::getInstance();
        if ($redis !== null) {
            $redis->del('al_' . $order['third_order_sn']);
        } else {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', order transfer success, orderId = ' . $orderId);

        return ERR_OK;
    }

    /**
     * 支付宝转账卡号卡密 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferCardGet($param, &$data) {
        $aliPayOrderId = $param['aliPayOrderId'];
        $aliPayAccount = $param['aliPayAccount'];
        $userId = $param['userId'];
        $cardNumber = $param['cardNumber'];

        $cardPassword = $param['cardPassword'];
        $dateTimeBegin = $param['dateTimeRange']['dateTimeBegin'];
        $dateTimeEnd = $param['dateTimeRange']['dateTimeEnd'];
        $tsBegin = strtotime($dateTimeBegin);
        $tsEnd = strtotime($dateTimeEnd);
        $orderStatus = $param['orderStatus'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_card';
        $sql .= ' where createTime >= :tsBegin and createTime <= :tsEnd';
        $pdoParam = [':tsBegin' => $tsBegin, ':tsEnd' => $tsEnd];

        if ($aliPayOrderId) {
            $sql .= ' and alipayOrderId = :alipayOrderId';
            $pdoParam[':alipayOrderId'] = $aliPayOrderId;
        }
        if ($aliPayAccount) {
            $sql .= ' and alipayAccount = :alipayAccount';
            $pdoParam[':alipayAccount'] = $aliPayAccount;
        }
        if ($userId) {
            $sql .= ' and userId = :userId';
            $pdoParam[':userId'] = $userId;
        }
        if ($cardNumber) {
            $sql .= ' and cardNum = :cardNum';
            $pdoParam[':cardNum'] = $cardNumber;
        }
        if ($cardPassword) {
            $sql .= ' and cardPass = :cardPass';
            $pdoParam[':cardPass'] = $cardPassword;
        }
        if ($orderStatus) {
            $sql .= ' and status = :status';
            $pdoParam[':status'] = $orderStatus;
        }
        $sql = ' order by createTime desc limit :limit';

        $data = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 客户端缺陷工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugGet($param, &$data) {
        $id = $param['id'];
        $userId = $param['userId'];
        $recorder = $param['recorder'];
        $dateBegin = $param['dateRange']['dateBegin'];

        $dateEnd = $param['dateRange']['dateEnd'];
        $describe = $param['describe'];
        $status = $param['status'];
        $bugType = $param['bugType'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_client_bug';
        $sql .= ' where opertime >= :dateBegin and opertime <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($id) {
            $sql .= ' and id = :id';
            $pdoParam[':id'] = $id;
        }
        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($recorder) {
            $sql .= ' and operuser = :operuser';
            $pdoParam[':operuser'] = $recorder;
        }
        if ($describe) {
            $sql .= ' and describe like :describe';
            $pdoParam[':describe'] = '%' . $describe . '%';
        }
        if ($status) {
            $sql .= ' and status = :status';
            $pdoParam[':status'] = $status;
        }
        if ($bugType) {
            $sql .= ' and bugtype = :bugtype';
            $pdoParam[':bugtype'] = $bugType;
        }
        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

        $data = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($data)) {
            foreach ($data as &$row) {
                $status = 1;
                $row['status'] = $status === 1 ? '开启' : '关闭';
                $row['opertime'] = $row['opertime'] ? $row['opertime'] : '-';
            }
            unset($row);
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 客户端缺陷工单 - 批量处理关闭
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugBatchClose($param, &$data) {
        $idArr = $param['idArr'];

        $currentAdmin = ''; // todo 当前管理员
        $status = 1;
        $tsNow = time();

        $dbName = 'db_smc';
        $sql = 'update smc_client_bug set status = :status, update_user = :update_user, update_time = :update_time';
        $sql .= ' where id = :id';
        $pdoParam = [
            ':status' => $status,
            ':update_user' => $currentAdmin,
            ':update_time' => $tsNow
        ];

        foreach ($idArr as $id) {
            $pdoParam[':id'] = $id;
            $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                    . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                continue;
            }
        }

        return ERR_OK;
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 创建
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneCreate($param, &$data) {
        $pdoParam = [
            'user_id' => $param['userId'],
            'phonesystem' => $param['phoneSystem'],
            'phonemodel' => $param['phoneModel'],
            'networktype' => $param['networkType'],

            'address' => $param['address'],
            'appsize' => $param['appSize'],
            'appsource' => $param['appSource'],
            'bugtype' => $param['bugType'],

            'describe' => $param['describe'],
            'operuser' => $param['recorder'],
            'status' => 0, // 默认开启状态
            'uuid' => md5(uniqid())
        ];
        $dbName = 'db_smc';
        $sql = 'insert into smc_client_bug(user_id, phonesystem, phonemodel, networktype, address, appsize, appsource, bugtype, describe, operuser, status, uuid)';
        $sql .= ' values (:user_id, :phonesystem, :phonemodel, :networktype, :address, :appsize, :appsource, :bugtype, :describe, :operuser, :status, :uuid)';
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneGet($param, &$data) {
        $id = $param['id'];
        $dbName = 'db_smc';
        $sql = 'select * from smc_client_bug where id = :id limit 1';
        $pdoParam = [':id' => $id];
        $data = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     *  客户端缺陷工单 - 单个工单 - 关闭
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneUpdate($param, &$data) {
        $id = $param['id'];
        $dbName = 'db_smc';
        $sql = 'update smc_client_bug set status = :status where id = :id';
        $pdoParam = [':id' => $id, ':status' => 1];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = ' . $dbName
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function clientBugOneDel($param, &$data) {
        $id = $param['id'];
        $dbName = 'db_smc';
        $sql = 'delete from smc_client_bug where id = :id';
        $pdoParam = [':id' => $id];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = ' . $dbName
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 举报管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportGet($param, &$data) {
        $userId = $param['userId'];
        $gameId = $param['gameId'];
        $status = $param['status'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_report';

        $itemArr = [];
        $pdoParam = [];

        if (!empty($userId)) {
            $itemArr[] = 'user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($gameId !== -1) {
            $itemArr[] = 'type = :type';
            $pdoParam[':type'] = $gameId;
        }
        if ($status !== -1) {
            $itemArr[] = 'status = :status';
            $pdoParam[':status'] = $status;
        }

        if (!empty($itemArr)) {
            $sql .= ' where ';
            $sqlWhere = implode(' and ', $itemArr);
            $sql .= $sqlWhere;
        }

        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $playRecord = self::getGamePlayRecord($row['type'], $row['table_id'], $row['user_id']);
                if (!empty($playRecord)) {
                    $row['play_record'] = $playRecord['play_record'];
                    $row['jinbi'] = intval($playRecord['user_score_end']) - intval($playRecord['user_score_begin']);
                }
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 举报管理 - 回放
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportPlayback($param, &$data) {
        $gameId = $param['gameId'];
        $gameNumber = $param['gameNumber'];
        $userId = $param['userId'];

        $data = self::getGamePlayRecord($gameId, $gameNumber, $userId);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', self::getGamePlayRecord return empty, param = '
                . json_encode($param));
        }

        return ERR_OK;
    }

    /**
     * 举报管理 - 回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function userReportReply($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 添加快捷回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineQuickReplyAdd($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 获取快捷回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineQuickReplyGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 禁言
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineForbidWord($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 关闭并受理
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineCloseAndAccept($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineReply($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 回复并查看下一条
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineReplyAndNext($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 批量转客服
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineBatchTransfer($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 设置紧急回复
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineGetUrgentReplyAdd($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 开启人工充值
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineManualRechargeOpen($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 设置在线
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineSetOnline($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 转给其他客服
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineTransfer($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 客服结束
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineFinish($param, &$data) {
        return ERR_OK;
    }

    /**
     * 在线客服 - 取消禁言
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlineCancelForbidWord($param, &$data) {
        return ERR_OK;
    }

    /**
     * 提现支付宝管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageGet($param, &$data) {
        $appId = $param['appId'];
        $email = $param['email'];
        $operator = $param['operator'];
        $ip = $param['ip'];

        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];
        $status = $param['status'];
        $checkFlag = $param['checkFlag'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_alipay_cash_config';
        $sql .= ' where oper_time >= :dateBegin and oper_time < :dateEnd';
        $pdoParam = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];

        if ($appId) {
            $sql .= ' and app_id = :app_id';
            $pdoParam[':app_id'] = $appId;
        }
        if ($email) {
            $sql .= ' and email like :email';
            $pdoParam[':email'] = '%' . $email . '%';
        }
        if ($operator) {
            $sql .= ' and update_admin = :update_admin';
            $pdoParam[':update_admin'] = $operator;
        }
        if ($ip) {
            $sql .= ' and ip like :ip';
            $pdoParam[':ip'] = $ip;
        }
        if ($status) {
            $sql .= ' and status = :status';
            $pdoParam[':status'] = $status;
        }
        if ($checkFlag) {
            $sql .= ' and check_flag = :check_flag';
            $pdoParam[':check_flag'] = $checkFlag;
        }

        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

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
     * 提现支付宝管理 - 开启/关闭总闸
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageSwitch($param, &$data) {
        $switchStatus = $param['switchStatus'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->set(aliPayCashSwitch, $switchStatus);
        if ('open' === $switchStatus) {
            $redis->setex(aliPayCashSwitch . '_PS', 60, '1');
        }
        $value = $redis->get(aliPayCashSwitch);
        if ('open' === $value) {
            $data['msg'] = '已开启支付宝提现，请务必通知客服停止人工提现！！！';
        } else {
            $data['msg'] = '已关闭支付宝提现，请通知客服开始人工提现！！！';
        }
        return ERR_OK;
    }

    /**
     * 提现支付宝管理 - 添加新支付宝
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageAddAliPay($param, &$data) {
        return ERR_OK;
    }

    /**
     * 提现支付宝管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageForbid($param, &$data) {
        return ERR_OK;
    }

    /**
     * 提现支付宝管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayCashManageDel($param, &$data) {
        return ERR_OK;
    }

    /**
     * 客服代理充值注册 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterGet($param, &$data) {
        $agentNo = $param['agentNo'];
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];
        $describe = $param['describe'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_dailipay_no';
        $pdoParam = [];

        $sql .= ' where addtime >= :dateBegin and addtime < :dateEnd';
        $pdoParam[':dateBegin'] = $dateBegin;
        $pdoParam[':dateEnd'] = $dateEnd;

        if ($agentNo) {
            $sql .= ' and daili_no = :daili_no';
            $pdoParam[':daili_no'] = $agentNo;
        }
        if ($describe) {
            $sql .= ' and describe like :describe';
            $pdoParam[':describe'] = '%' . $describe . '%';
        }

        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

        $data = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 客服代理充值注册 - 创建新账户
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterCreate($param, &$data) {
        $agentNo = $param['agentNo'];
        $describe = $param['describe'];
        $addUser = ''; // todo 当前管理员
        $timeNow = date('Y-m-d H:i:s');

        $dbName = 'db_smc';
        $sql = 'insert into smc_dailipay_no (daili_no, adduser, describe, addtime)';
        $sql .= ' values (:daili_no, :adduser, :describe, :addtime)';
        $pdoParam = [
            ':daili_no' => $agentNo,
            ':adduser' => $addUser,
            ':describe' => $describe,
            ':addtime' => $timeNow
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 客服代理充值注册 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentRechargeRegisterDel($param, &$data) {
        $id = $param['id'];

        $dbName = 'db_smc';
        $sql = 'delete from smc_dailipay_no where id = :id';
        $pdoParam = [
            ':id' => $id
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 客服手工充值查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualRechargeInfoGet($param, &$data) {
        $userId = $param['userId'];
        $tsBegin = strtotime($param['dateTimeRange']['dateTimeBegin']);
        $tsEnd = strtotime($param['dateTimeRange']['dateTimeEnd']);
        $customerId = $param['customerId'];

        $dbName = 'db_smc';
        $pdoParam = [];
        $sql = 'select * from smc_order';

        $sql .= ' where add_time >= :tsBegin and add_time <= :tsEnd';
        $pdoParam[':tsBegin'] = $tsBegin;
        $pdoParam[':tsEnd'] = $tsEnd;

        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($customerId !== -1) {
            $sql .= ' and refer = :refer';
            $pdoParam[':refer'] = $customerId;
        }

        $sql .= ' and pay_platform = 98'; // todo

        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $status = intval($row['orderStatus']);
                switch ($status) {
                    case 0:
                        $row['status'] = '未支付';
                        break;
                    case 1:
                        $row['status'] = '支付成功';
                        break;
                    default:
                        $row['status'] = '支付失败';
                }

                $row['add_time'] = date('Y-m-d H:i:s', $row['add_time']);
                $row['pay_success_time'] = $row['pay_success_time'] ? date('Y-m-d H:i:s', $row['pay_success_time']) : ' - ';
                $row['money'] = number_format($row['money'] / 100, 2, '.', ' ');
                $row['after_chips'] = $status === 1 ? $row['before_chips'] + $row['money'] : '--';
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 客服手工充值 - 人工充值
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualRecharge($param, &$data) {
        $userId = $param['userId'];
        $money = $param['money'] * 100;
        $thirdOrderId = $param['thirdOrderId'];

        $userInfo = self::getUserInfo($userId);
        if (empty($userInfo)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', user not exist, userId = ' . $userId);
            return ERR_USER_NOT_EXIST;
        }

        // 检测订单是否已存在
        if ($thirdOrderId !== '') {
            $dbName = 'db_smc';
            $pdoParam = [];
            $sql = 'select id from smc_order where third_order_sn = :third_order_sn limit 1';
            $pdoParam[':third_order_sn'] = $thirdOrderId;
            $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
            if (!empty($rows)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order already exist, thirdOrderId = ' . $thirdOrderId);
                return ERR_ORDER_ALREADY_EXIST;
            }
        }

        // 充值
        $errCode = self::score_operation_by_kefu_recharge($userId, $money);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', 充值失败, self::score_operation_by_kefu_recharge fail, param = ' . json_encode($param));
            return $errCode;
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 充值成功, userId = ' . $userId . ', money = ' . $money);

        // 更新后台数据库
        $tsNow = time();
        $dbName = 'db_smc';
        $sql = 'insert into smc_order (user_id, order_sn, add_time, pay_success_time, money, pay_type, refer, third_order_sn, channel_id, before_chips, pay_platform, status)';
        $sql .= ' values (:user_id, :order_sn, :add_time, :pay_success_time, :money, :pay_type, :refer, :third_order_sn, :channel_id, :before_chips, :pay_platform, :status)';
        $pdoParam = [
            ':user_id' => $userId,
            ':order_sn' => clsUtility::generateOrderId($userId),
            ':add_time' => $tsNow,
            ':pay_success_time' => $tsNow,
            ':money' => $money,
            ':pay_type' => 'kefu_recharge',
            ':refer' => 'testAdmin', // todo
            ':third_order_sn' => $thirdOrderId,
            ':channel_id' => $userInfo ['channel_id'],
            ':before_chips' => $userInfo ['user_chips'],
            ':pay_platform' => 98, // todo
            ':status' => 1
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = ' . $dbName
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 游戏代理查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameAgentGet($param, &$data) {
        $name = $param['name'];
        $phone = $param['phone'];
        $qq = $param['qq'];
        $weChat = $param['weChat'];

        $ip = $param['ip'];
        $status = $param['ip'];

        $dbName = 'db_smc';
        $item = [];
        $pdoParam = [];
        $sql = 'select * from smc_game_agent_apply';

        if ($name) {
            $item[] = 'name = :name';
            $pdoParam[':name'] = $name;
        }
        if ($phone) {
            $item[] = 'telephone = :telephone';
            $pdoParam[':telephone'] = $phone;
        }
        if ($qq) {
            $item[] = 'qq = :qq';
            $pdoParam[':qq'] = $qq;
        }
        if ($weChat) {
            $item[] = 'weixin = :weixin';
            $pdoParam[':weixin'] = $weChat;
        }
        if ($ip) {
            $item[] = 'ip = :ip';
            $pdoParam[':ip'] = $ip;
        }
        if ($status === 0 || $status === 1 || $status === 2) {
            $item[] = 'status = :status';
            $pdoParam[':status'] = $status;
        }

        if (!empty($item)) {
            $sql .= ' where ';

            $sqlCondition = implode(' and ', $item);
            $sql .= $sqlCondition;
        }

        $sql .= ' order by id desc limit :limit';
        $pdoParam[':limit'] = maxQueryNum;

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
     * 游戏代理查询 - 批处理为 待审核|通过|驳回
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameAgentBatchProcess($param, &$data) {
        $status = $param['status'];
        $idArr = $param['idArr'];

        $dbName = 'db_smc';
        $sql = 'update smc_game_agent_apply set status = :status';
        $sql .= ' where id in (' . implode(',', $idArr) . ')';
        $pdoParam = [':status' => $status];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, errCode = ' . $errCode);
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 自动回复设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyGet($param, &$data) {
        $dbName = 'db_smc';
        $sql = 'select * from smc_chat_auto_reply order by id desc limit ' . maxQueryNum;

        $data = clsUtility::getRows($dbName, $sql);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql);
        }

        return ERR_OK;
    }

    /**
     * 自动回复设置 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyAdd($param, &$data) {
        $keyword = $param['keyword'];
        $reply = $param['reply'];

        $dbName = 'db_smc';
        $sql = 'insert into smc_chat_auto_reply(keywords, reply) values (:keywords, :reply)';
        $pdoParam = [
            ':keywords' => $keyword,
            ':reply' => $reply
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 自动回复设置 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyModify($param, &$data) {
        $keyword = $param['keyword'];
        $reply = $param['reply'];
        $id = $param['id'];

        $dbName = 'db_smc';
        $sql = 'update smc_chat_auto_reply set keywords = :keywords, reply = :reply where id = :id';
        $pdoParam = [
            ':keywords' => $keyword,
            ':reply' => $reply,
            ':id' => $id
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }
        return ERR_OK;
    }

    /**
     * 自动回复设置 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function chatAutoReplyDel($param, &$data) {
        $id = $param['id'];

        $dbName = 'db_smc';
        $sql = 'delte from smc_chat_auto_reply where id = :id';
        $pdoParam = [
            ':id' => $id
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }
        return ERR_OK;
    }

    /**
     * 支付宝黑名单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistGet($param, &$data) {
        $aliPayAccount = $param['aliPayAccount'];
        $aliPayRealName = $param['aliPayRealName'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_black_alipay_account';

        $item = [];
        $pdoParam = [];

        if ($aliPayAccount) {
            $item[] = 'alipay_account = :alipay_account';
            $pdoParam[':alipay_account'] = $aliPayAccount;
        }
        if ($aliPayRealName) {
            $item[] = 'alipay_real_name = :alipay_real_name';
            $pdoParam[':alipay_real_name'] = $aliPayRealName;
        }

        if (!empty($item)) {
            $sql .= ' where ';

            $sqlCondition = implode(' and ', $item);
            $sql .= $sqlCondition;
        }

        $data = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($data)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        } 

        return ERR_OK;
    }

    /**
     * 支付宝黑名单 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistAdd($param, &$data) {
        $aliPayAccount = $param['aliPayAccount'];
        $aliPayRealName = $param['aliPayRealName'];
        $describe = $param['describe'];
        $tsNow = time();
        $isLock = 1;

        $dbName = 'db_smc';
        $sql = 'insert into smc_black_alipay_account(alipay_account, alipay_real_name, add_time, discribe, is_lock)';
        $sql .= ' values (:alipay_account, :alipay_real_name, :add_time, :discribe, :is_lock)';
        $pdoParam = [
            ':alipay_account' => $aliPayAccount,
            ':alipay_real_name' => $aliPayRealName,
            ':add_time' => $tsNow,
            ':discribe' => $describe,
            ':is_lock' => $isLock
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 支付宝黑名单 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistDel($param, &$data) {
        $id = $param['id'];

        $dbName = 'db_smc';
        $sql = 'delete from smc_black_alipay_account where id = :id';
        $pdoParam = [
            ':id' => $id
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return ERR_OK;
    }

    /**
     * 支付宝黑名单 - 清空
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayBlacklistClear($param, &$data) {
        $dbName = 'db_smc';
        $sql = 'delete from smc_black_alipay_account where is_lock = 0';

        $errCode = clsUtility::updateData($dbName, $sql);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql);
        }
        return ERR_OK;
    }

    /**
     * 提现订单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function cashOrderGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 提现订单 - 批量处理完成
     * @param $param
     * @param $data
     * @return int
     */
    public static function cashOrderBatchFinish($param, &$data) {
        $idArr = $param['idArr'];
        $adminId = ''; // todo
        $adminName = ''; // todo
        $tsNow = time();

        $updateData = [
            ':status' => cashOrderStatusSuccess,
            ':update_time' => $tsNow,
            ':discribe' => $adminName.'批量完成',
        ];

        foreach ($idArr as $id) {
            $order = self::getCashOrder($id);
            if (empty($order)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $order);
                continue;
            }

            $cashMoney = $order['cash_money'];
            $orderStatus = intval($order['status']);
            $userId = intval($order['user_id']);

            $updateData[':real_cash_money'] = intval(self::calMoney($cashMoney / 100)) * 100;
            $updateData[':order_sn'] = $id;

            if ($orderStatus !== cashOrderStatusWaitReview && $orderStatus !== cashOrderStatusUnknown && $orderStatus !== cashOrderStatusDealing) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', orderStatus wrong, orderStatus = ' . $orderStatus . ', param = ' . json_encode($param));
                continue;
            }

            // 更新提现订单
            $errCode = self::updateCashOrder($updateData);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::updateCashOrder fail, orderId = '
                    . $id . ', updateData = ' . json_encode($updateData));
                continue;
            }

            // 插入提现订单日志
            $errCode = self::logBatchCashOrderInsert($id, $orderStatus, $tsNow, $adminName, 'batchFinish');
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::logBatchCashOrderInsert fail, id = '
                    . $id . ', orderStatus = ' . $orderStatus . ', tsNow = ' . $tsNow . ', adminName = '
                    . $adminName . ', batchFinish');
            }

            // 更新casinouser_
            $indexArr = clsUtility::getUserDBPos($userId);
            if (is_array($indexArr) && !empty($indexArr)) {
                $dbName = 'casinouserdb_' . $indexArr['dbindex'];
                $table = 'casinouser_' . $indexArr['tableindex'];
                $sql = 'update ' . $table . ' set total_total_money = total_total_money + :cash_money';
                $sql .= ' where id = :userId';
                $pdoParam = [
                    ':cash_money' => $cashMoney,
                    ':userId' => $userId
                ];
                $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
                if ($errCode !== ERR_OK) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData, dbName = ' . $dbName
                        . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                }
            } else {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, user not exist, userId = ' . $userId);
            }

            // 推送消息
            $errCode = self::chatCreateSession($userId);
            if ($errCode === ERR_OK) {
                $pdoParam = [
                    ':admin_id' => $adminId,
                    ':content' => '您的兑换已经处理完毕，请查看支付宝账单,处理时间（' . date('Y-m-d H:i:s', $tsNow) . '）',
                    ':user_id' => $userId,
                    ':add_time' => $tsNow
                ];

                $errCode = self::chatInsertMessage($pdoParam);
                if ($errCode === ERR_OK) {
                    $errCode = self::pushAddPushQueue($userId, '您的兑换已成功');
                    if ($errCode !== ERR_OK) {
                        clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::pushAddPushQueue fail, userId = ' . $userId
                            . ', errCode = ' . $errCode);
                    }
                } else {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::chatInsertMessage fail, pdoParam = ' . json_encode($pdoParam)
                        . ', errCode = ' . $errCode);
                }
            } else {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::createChatSession fail, userId = ' . $userId
                    . ', errCode = ' . $errCode);
            }
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success');

        return ERR_OK;
    }

    /**
     * 提现订单 - 批量重新处理
     * @param $param
     * @param $data
     * @return int
     */
    public static function cashOrderBatchAgain($param, &$data) {
        $idArr = $param['idArr'];
        $adminName = ''; // todo
        $tsNow = time();

        $updateData = [
            ':status' => cashOrderStatusNew,
            ':update_time' => $tsNow,
            ':discribe' => $adminName.'批量重新处理',
            ':is_process' => 1
        ];

        foreach ($idArr as $id) {
            $order = self::getCashOrder($id);
            if (empty($order)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $order);
                continue;
            }

            $orderStatus = intval($order['status']);
            $updateData[':order_sn'] = $id;
            if ($orderStatus === cashOrderStatusWaitReview) {
                $errCode = self::orderDelOneBlack($order ['alipay_account'], $order ['alipay_real_name']);
                if ($errCode !== ERR_OK) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::orderDelOneBlack fail, aliPayAccount = '
                        . $order ['alipay_account'] . ', aliPayRealName = ' . $order ['alipay_real_name']);
                }
                $errCode = self::updateCashOrder($updateData);
                if ($errCode !== ERR_OK) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::updateCashOrder fail, updateData = '
                        . json_encode($updateData));
                }
            } else if ($orderStatus === cashOrderStatusDealing || $orderStatus === cashOrderStatusUnknown) {
                $errCode = self::updateCashOrder($updateData);
                if ($errCode !== ERR_OK) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::updateCashOrder fail, updateData = '
                        . json_encode($updateData));
                }
            }
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 修改成功');

        return ERR_OK;
    }

    /**
     * 提现订单 - 批量处理成功
     * @param $param
     * @param $data
     * @return int
     */
    public static function cashOrderBatchSuccess($param, &$data) {
        $idArr = $param['idArr'];
        $adminName = ''; // todo
        $tsNow = time();

        $updateData = [
            ':status' => cashOrderStatusSuccess,
            ':update_time' => $tsNow,
            ':discribe' => $adminName.'批量成功',
        ];

        foreach ($idArr as $id) {
            $order = self::getCashOrder($id);
            if (empty($order)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order not exist, orderId = ' . $order);
                continue;
            }

            $cashMoney = $order['cash_money'];
            $orderStatus = intval($order['status']);

            $updateData[':real_cash_money'] = intval(self::calMoney($cashMoney / 100)) * 100;
            $updateData[':order_sn'] = $id;

            $errCode = self::updateCashOrder($updateData);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::updateCashOrder fail, updateData = '
                    . json_encode($updateData));
            }

            // 插入提现订单日志
            $errCode = self::logBatchCashOrderInsert($id, $orderStatus, $tsNow, $adminName, 'batchFinish');
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', self::logBatchCashOrderInsert fail, id = '
                    . $id . ', orderStatus = ' . $orderStatus . ', tsNow = ' . $tsNow . ', adminName = '
                    . $adminName . ', batchFinish');
            }
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 修改成功');

        return ERR_OK;
    }

    // ====

    /**
     * 获取用户信息 - 根据userId
     * @param $userId
     * @return array
     */
    public static function getUserInfo($userId) {
        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            return [];
        }

        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return [];
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
            return [];
        }

        $row = $stmt->fetchAll();
        if (empty($row)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
            return [];
        }

        return $row;
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

    /**
     * 删除黑名单
     * @param $type
     * @param $rid
     * @return int
     */
    public static function delBlackList($type, $rid) {
        // 删除游戏黑名单
        $errCode = self::delBlackListGame($type, $rid);

        if ($errCode == 0) {
            // 删除后台黑名单
            return self::delBlackListAdmin($type, $rid);
        }

        return ERR_OK;
    }

    /**
     * 删除游戏黑名单  todo 封装这种同游戏服务器的交互为一个方法
     * @param $type
     * @param $rid
     * @return bool
     */
    public static function delBlackListGame($type, $rid) {
//        if ($type == '1') {
//            $command = 80031;
//            $query = new deleteIPBlackListReq();
//            $query->set_userip($rid);
//            $rsp = new deleteIPBlackListRsp();
//        } elseif ($type == '2') {
//            $command = 80035;
//            $query = new deleteMACBlackListReq();
//            $query->set_usermac($rid);
//            $rsp = new deleteMACBlackListRsp();
//        } elseif ($type == '3') {
//            $command = 80033;
//            $query = new deleteUserIDBlackListReq();
//            $query->set_userID($rid);
//            $rsp = new deleteUserIDBlackListRsp();
//        }
//
//        $buf = $query->SerializeToString();
//
//        $ret = $this->_request_midlayer_res($buf, $command);
//
//        $rsp->ParseFromString($ret);
//
//        return $rsp->returncode();
        return true;
    }

    /**
     * 删除后台黑名单
     * @param $type
     * @param $rid
     * @return int
     */
    public static function delBlackListAdmin($type, $rid) {
        $dbName = 'casinoblacklistdb';
        $pdo = clsMysql::getInstance($dbName);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }
        switch ($type) {
            case 1: // ip
                $sql = 'delete from casinoipblacklist where userip = :userip';
                $pdoParam = [
                    ':userip' => $rid
                ];
                break;
            case 2: // mac
                $sql = 'delete from casinomacblacklist where usermac = :usermac';
                $pdoParam = [
                    ':usermac' => $rid
                ];
                break;
            case 3: // id
                $sql = 'delete from casinouseridblacklist where userid = :userid';
                $pdoParam = [
                    ':userid' => $rid
                ];
                break;
            default:
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid type, type = ' . $type);
                return ERR_INVALID_PARAM;
        }

        return clsUtility::updateData($dbName, $sql, $pdoParam);
    }

    /**
     * 获取aliPayAccount对应的所有userId
     * @param $aliPayAccount
     * @return array
     */
    public static function getUserIdArrByAliPayAccount($aliPayAccount) {
        $dbName = 'db_smc';
        $sql = 'select distinct user_id from smc_user where lower(alipay_account) = :alipay_account';
        $pdoParam = [
            ':alipay_account' => strtolower($aliPayAccount)
        ];

        return clsUtility::getRows($dbName, $sql, $pdoParam);
    }

    public static function orderSuccess($order) {
        $orderId = $order['order_sn'];
        $orderStatus = intval($order['status']);
        $tsNow = time();

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        if ($orderStatus != orderStatusNew || $redis->incr($orderId) !== 1) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', order status error, orderId = '
                . $orderId . ', order = ' . json_encode($order));
            return ERR_ORDER_STATUS_WRONG;
        }

        $gold = intval($order['money']);
        $userId = intval($order ['user_id']);
        if (self::score_operation($userId, $gold) !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', score operation failed, orderId = ' . $orderId
                . ', gold = ' . $gold);
            return ERR_SCORE_OPERATION_FAIL;
        }

        $dbName = 'db_smc';
        $sql = 'update smc_order set status = :status, pay_success_time = :pay_success_time';
        $sql .= ' where order_sn = :order_sn';
        $pdoParam = [
            ':status' => orderStatusSuccess,
            ':pay_success_time' => $tsNow,
            ':order_sn' => $orderId
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos, userId = ' . $userId);
            return ERR_INVALID_USER_ID;
        }
        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $tableName = 'casinouser_' . $tableIndex;
        $sql = 'update ' . $tableName . ' set totalBuy = totalBuy + :gold';
        $sql .= ' where id = :userId';
        $pdoParam = [
            ':gold' => $gold,
            ':userId' => $userId
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        // 更新总支付金额
        $redis->incrBy('alipay_tr_total_pay_' . date('Ymd'), intval($order ['money'] / 100));

        if ($redis->exists('euc_' . $order ['user_id'])) {
            $redis->incrBy('euc_' . $order ['user_id'], intval($order ['money'] / 100));
        } else {
            $expireTime = strtotime(date('Ymd')) + daySeconds - $tsNow;
            $redis->setex('euc_' . $order ['user_id'], $expireTime, intval($order ['money'] / 100));
        }

        // 需要发一段话
        $autoReplyData = array();
        $rechargeMoney = intval($order['money'] / 100);
        $autoReplyData ['content'] = "您好，您的支付宝转账充值成功，订单号：{$order['third_order_sn']}, 金额：$rechargeMoney";
        $autoReplyData ['user_id'] = $order['user_id'];
        $autoReplyData ['add_time'] = $tsNow + 5;
        // 表示管理员在说话
        $autoReplyData ['admin_id'] = 1;
        $autoReplyData ['is_recharge'] = 1;
        $errCode = self::insertChatMessage($autoReplyData);
        if ($errCode !== ERR_OK) {
            clsLog::warn(__METHOD__ . ', ' . __LINE__ . ', self::insertChatMessage fail, autoReplyData = '
                . json_encode($autoReplyData));
        }

        return ERR_OK;
    }

    public static function orderFail($order, $reason) {
        $dbName = 'db_smc';
        $orderId = $order['order_sn'];
        $timeNow = time();

        $sql = 'update smc_order set status = :status, pay_success_time = :pay_success_time';
        $sql .= ' where order_sn = :order_sn';
        $pdoParam = [
            ':status' => intval($order['status']),
            ':pay_success_time' => $timeNow,
            ':order_sn' => $orderId
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        // 需要发一段话
        $autoReplyData = [
            'content' => "您好，您的支付宝转账充值失败，订单号：{$order['third_order_sn']}, 失败原因：$reason",
            'user_id' => $order['user_id'],
            'add_time' => $timeNow + 5, // notice
            'admin_id' => 1, // 表示管理员在说话
            'is_recharge' => 1
        ];
        $errCode = self::insertChatMessage($autoReplyData);
        if ($errCode !== ERR_OK) {
            clsLog::warn(__METHOD__ . ', ' . __LINE__ . ', self::insertChatMessage fail, autoReplyData = '
                . json_encode($autoReplyData) . ', errCode = ' . $errCode);
        }

        return ERR_OK;
    }

    /**
     * db_smc.smc_chat - 新增
     * @param $data
     * @return int
     */
    public static function insertChatMessage($data) {
        $dbName = 'db_smc';
        $sql = 'insert into smc_chat (content, user_id, admin_id, is_recharge, add_time) values (:content, :user_id, :admin_id, :is_recharge, :add_time)';
        $errCode = clsUtility::updateData($dbName, $sql, $data);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', smc_chat insert fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($data));
            return $errCode;
        }

        $sql = 'update smc_chat_session set update_time = :update_time, is_user_reply = :is_user_reply';
        $sql .= ' where user_id = :user_id and is_recharge = :is_recharge';
        $pdoParam = [
            ':update_time' => $data['add_time'],
            ':is_user_reply' => 1,
            ':user_id' => $data['user_id'],
            ':is_recharge' => 1
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', smc_chat insert fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $errCode;
    }

    /**
     * middleServer scoreOperation
     * @param $uid
     * @param $chip
     * @return int
     */
    public static function score_operation($uid, $chip) {
//        $CI = &get_instance();
//        $db_smc = $CI->load->database('default', true);
//
//        $data = array(
//            'admin_id' => $this->session->userdata('id'),
//            'user_id' => $uid,
//            'add_time' => time(),
//            'action' => '充值' . $chip . '金币',
//            'chips' => $chip
//        );
//        $db_smc->insert('smc_admin_log', $data);
//        $db_smc->close();
//
//        $scoreoper = new GameServerMiddleLayerServerScoreOperation();
//        $scoreoper->set_userID($uid);
//        $scoreoper->set_score($chip);
//        $scoreoper->set_gameCode('999999');
//        $scoreoper->set_addtype(19);
//
//        $buf = $scoreoper->SerializeToString();
//
//        $ret = $this->_request_midlayer_res1($buf, 60002, DISPATCH_SERVER_IP, DISPATCH_SERVER_PORT);
//
//        $rsp = new GameServerMiddleLayerServerScoreOperationRsp();
//        $rsp->ParseFromString($ret);
//
//        return $rsp->returncode() == EnumResult::enumResultSucc;

        return ERR_OK;
    }

    /**
     *
     * @param $gameId - 游戏id
     * @param $gameNumber - 牌局编号
     * @param $userId - 用户id
     * @return array
     */
    public static function getGamePlayRecord($gameId, $gameNumber, $userId) {
        $finalRet = [];

        $dbDate = date('Ymd', substr($gameNumber, 0, 10));

        $dbName = 'casinogamehisdb';
        switch ($gameId) {
            case 1:
                $tableName = 'casinogamerecord_ddz_' . $dbDate;
                break;
            case 2:
                $tableName = 'casinogamerecord_ddzhuanle_' . $dbDate;
                break;
            case 3:
                $tableName = 'casinogamerecord_laizi_' . $dbDate;
                break;
            default:
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid gameId, gameId = ' . $gameId);
                return [];
        }

        if (!clsUtility::checkTableExistByName($dbName, $tableName)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', table not exist, dbName = '
                . $dbName . ', tableName = ' . $tableName);
            return [];
        }

        $pdoParam = [];
        $sql = 'select play_record,user_score_end,user_score_begin';
        $sql .= ' from ' . $tableName;
        $sql .= ' where game_number = :game_number';
        $pdoParam[':game_number'] = $gameNumber;
        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        $sql .= ' limit 1';

        $finalRet = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($finalRet)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $finalRet;
    }

    /**
     * 客服充值 todo
     * @param $uid
     * @param $chip
     * @return bool
     */
    public static function score_operation_by_kefu_recharge($uid, $chip) {
//        //  $this->_require('pb_proto_clientgameserver');
//
//        $scoreoper = new GameServerMiddleLayerServerScoreOperation();
//        $scoreoper->set_userID($uid);
//        $scoreoper->set_score($chip);
//        $scoreoper->set_gameCode('999994');
//        $scoreoper->set_addtype(EnumAddScoreType::enumAddScoreType_BackgroundAdd);
//
//        $buf = $scoreoper->SerializeToString();
//
//        $ret = $this->_request_midlayer_res1($buf,60002, DISPATCH_SERVER_IP, DISPATCH_SERVER_PORT);
//
//        $rsp = new GameServerMiddleLayerServerScoreOperationRsp();
//        $rsp->ParseFromString($ret);
//
//        return $rsp->returncode() === EnumResult::enumResultSucc ;

        return ERR_OK;
    }

    /**
     * 提现订单 - 获取
     * @param $orderId
     * @return array
     */
    public static function getCashOrder($orderId) {
        $dbName = 'db_smc';
        $sql = 'select * from smc_cash_order where order_sn = :order_sn limit 1';
        $pdoParam = [':order_sn' => $orderId];

        return clsUtility::getRow($dbName, $sql, $pdoParam);
    }

    /**
     * 提现订单 - 更新 todo 需要修改, 批量重新处理发来的参数和其他两次不一样
     * @param $pdoParam
     * @return int
     */
    public static function updateCashOrder($pdoParam) {
        $dbName = 'db_smc';
        $sql = 'update smc_cash_order set status = :status, update_time = :update_time, discribe = :discribe, real_cash_money = :real_cash_money';
        $sql .= ' where order_sn = :order_sn';

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }
        
        return $errCode;
    }

    /**
     * 提现订单日志 - 新增
     * @param $orderId
     * @param $statusOld
     * @param $updateTime
     * @param $adminName
     * @param $action
     * @return int
     */
    public static function logBatchCashOrderInsert($orderId, $statusOld, $updateTime, $adminName, $action) {
        if (!$orderId || 1 === $statusOld) {
            clsLog::error(__METHOD__ . ', ' . __LINE__.  ', orderId or orderStatus wrong, orderId = '
                . $orderId . ', orderStatus = ' . $statusOld);
            return ERR_INVALID_PARAM;
        }

        $dbName = 'db_smc';
        $sql = 'insert into smc_log_batch_cash_order(order_sn, status_old, update_time, admin_name, action)';
        $sql .= ' values (:order_sn, :status_old, :update_time, :admin_name, :action)';
        $pdoParam = [
            ':order_sn' => $orderId,
            ':status_old' => $statusOld,
            ':update_time' => $updateTime,
            ':admin_name' => $adminName,
            ':action' => $action
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        return $errCode;
    }

    /**
     * @param $money
     * @return float
     */
    public static function calMoney($money) {
        $chouShui1 = 3; // 100以下扣3元
        $chouShui2 = 0.02; // 100以上扣2%

        if ($money <= 100) {
            $money = $money - $chouShui1;
        } else {
            $money = floor ( $money * (1 - $chouShui2) );
        }

        return $money;
    }

    /**
     * smc_chat_session - 新增
     * @param $userId
     * @return int
     */
    public static function chatCreateSession($userId) {
        $dbName = 'db_smc';
        $sql = 'select id, admin_id from smc_chat_session where user_id = :user_id limit 1';
        $pdoParam = [':user_id' => $userId];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            $pdoParam = [
                ':user_id' => $userId,
                ':admin_id' => 0,
                ':update_time' => 0,
                ':user_update_time' => 0
            ];
            $sql = 'insert into smc_chat_session(user_id, admin_id, update_time, user_update_time)';
            $sql .= ' values (:user_id, :admin_id, :update_time, :user_update_time)';
            $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                    . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return $errCode;
            }
        }

        return ERR_OK;
    }

    /**
     * smc_chat - 新增
     * @param $pdoParam
     * @return int
     */
    public static function chatInsertMessage($pdoParam) {
        $dbName = 'db_smc';

        // smc_chat - insert
        $sql = 'insert into smc_chat (content, user_id, admin_id, add_time)';
        $sql .= ' values (:content, :user_id, :admin_id, :add_time)';
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        // smc_chat_session - update
        $sql = 'update smc_chat_session set update_time = :update_time, is_user_reply = :is_user_reply';
        $sql .= ' where user_id = :user_id and is_recharge = :is_recharge';

        $roleId = 1; // todo
        $isRecharge = $roleId === 14 ? 1 : 0;
        $pdoParam1 = [
            ':update_time' => $pdoParam[':add_time'],
            ':is_user_reply' => 0,
            ':user_id' => $pdoParam[':user_id'],
            ':is_recharge' => $isRecharge
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam1);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__.  ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam1));
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * push - 新增
     * @param $userId
     * @param $message
     * @return int
     */
    public static function pushAddPushQueue($userId, $message) {
        // 获取device
        $dbName = 'db_smc';
        $sql = 'select ios_push_device, tag from smc_user where user_id = :user_id limit 1';
        $pdoParam = [
            ':user_id' => $userId
        ];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::info(__METHOD__.  ', ' . __LINE__.  ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        if (empty($row) || !array_key_exists($row['tag'], keyArray) || strlen($row['ios_push_device']) < 20) {
            clsLog::error(__METHOD__.  ', ' . __LINE__ . ', fail');
            return ERR_PUSH_FAIL;
        }

        // redis新增数据
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $pushArr = [
            'device' => $row ['ios_push_device'],
            'message' => $message,
            'pem' => keyArray[$row ['tag']] ['pem'],
            'pass' => keyArray[$row ['tag']] ['pass'],
            'user_id' => $userId
        ];
        $redis->rPush('ios_push_queue', json_encode($pushArr));

        return ERR_OK;
    }

    /**
     * smc_black_alipay_account - delete
     * @param $aliPayAccount
     * @param $aliPayRealName
     * @return int
     */
    public static function orderDelOneBlack($aliPayAccount, $aliPayRealName) {
        $dbName = 'db_smc';
        $sql = 'delete from smc_black_alipay_account where alipay_account = :alipay_account and alipay_real_name = :alipay_real_name';
        $pdoParam = [
            ':alipay_account' => $aliPayAccount,
            ':alipay_real_name' => $aliPayRealName
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        return ERR_OK;
    }
}