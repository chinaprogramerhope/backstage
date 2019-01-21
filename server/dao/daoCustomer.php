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
        $m1 = clsUtility::getData($dbName, $sql, $pdoParam);

        $sql = 'select * from casinoiprangeblacklist where opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m2 = clsUtility::getData($dbName, $sql, $pdoParam);

        $sql = 'select * from casinomacblacklist where usermac = :usermac and opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':usermac' => $keyword,
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m3 = clsUtility::getData($dbName, $sql, $pdoParam);

        $sql = 'select * from casinouseridblacklist where userid = :userid and opertime >= :dateBegin and opertime <= :dateEnd';
        $sql .= ' order by opertime desc limit ' . maxQueryNum;
        $pdoParam = [
            ':userid' => $keyword,
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        $m4 = clsUtility::getData($dbName, $sql, $pdoParam);

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
        $data = clsUtility::getData($dbName, $sql, $pdoParam);

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

        $orderList = clsUtility::getData($dbName, $sql, $pdoParam);
        if (empty($orderList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getData return empty, dbName = '
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

        $orderList = clsUtility::getData($dbName, $sql, $pdoParam);

        if (empty($orderList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getData return empty, dbName = '
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
        $rows = clsUtility::getData($dbName, $sql, $pdoParam);
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

        // 更新 todo
        self::orderSuccess($order);

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
        $rows = clsUtility::getData($dbName, $sql, $pdoParam);
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
        $rows = clsUtility::getData($dbName, $sql, $pdoParam);
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

        // 更新 todo
        self::orderFail($order, $reason);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', order transfer success, orderId = ' . $orderId);

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

        return clsUtility::getData($dbName, $sql, $pdoParam);
    }

    public static function orderSuccess($order) {

    }

    public static function orderFail($order, $reason) {
        $dbName = 'db_smc';
        $orderId = $order['order_sn'];
        $timeNow = time();

        $sql = 'update smc_order set status = :status, pay_success_time = :pay_success_time';
        $pdoParam = [
            ':status' => intval($order['status']),
            ':pay_success_time' => $timeNow
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
//        $this->Chat_model->insertRMessage($autoReplyData);

        return ERR_OK;
    }
}