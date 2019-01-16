<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 会员管理
 */
class daoMember {
    /**
     * 获取会员列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function getList($param, &$data) {
        if (isset($param['userId']) && !empty($param['userId'])) {
            $userId = intval($param['userId']);
            $indexArr = clsUtility::getUserDBPos($userId);

            if (is_array($indexArr) && !empty($indexArr)) {
                return self::getListOne($userId, $indexArr, $data);
            } else {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, userId = ' . $userId);
                return ERR_INVALID_USER_ID;
            }
        } else {
            return self::getListAll($param, $data);
        }
    }

    /**
     * 用户详情 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function getDetail($param, &$data) {
        $userId = intval($param['userId']);
        $indexArr = clsUtility::getUserDBPos($userId);

        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, userId = ' . $userId);
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

        /**
         * 用户基础信息 -
         *
         * 用户id - id
         * 上级:
         * 用户等级: 比如 普通会员, vip1, vip2 等
         * 真实姓名: userIDCardName
         * 用户状态: todo 是黑名单吗
         * E-mail: user_email
         * 手机号码: mobile_number
         * 微信号码:
         * QQ号码:
         * 账户id: user_email
         * 注册时间: registertime - timestamp
         * 最后登录时间: last_login_time - bigint
         * 密码: password
         * 资金密码:
         * 用户标签:
         * 设备唯一标识码: todo user_device_id, uuid, mac 哪个是
         * 备注:
         *
         * 账户信息 -
         *
         * 账户余额: wallet total_total_money todo
         * 保险箱余额:
         * 支付宝: alipay_account
         * 银行卡:
         * 银行名称:
         * 充值次数: payBonusGameCount todo
         * 充值金额: payContribution todo
         * 提现次数:
         * 提现金额:
         * 返水金额:
         *
         * 会员权限设置 -
         *
         *
         * 用户游戏信息 -
         *
         * 游戏:
         * 游戏次数: total_competition_times todo
         * 输赢:
         * 最后游戏时间:
         *
         * 用户活动信息:
         *
         * 时间:
         * IP: lastLoginIp
         * 地址: location
         * 行为: 比如 官方充值请求, 用户绑定实名信息, 微信登录 等
         */
        $sql = 'select id, userIDCardName, user_email, mobile_number, registertime, last_login_time, password, wallet,';
        $sql .= ' alipay_account, payBonusGameCount, payContribution, total_competition_times, lastLoginIp, location';
        $sql .= ' from ' . $tableName;
        $sql .= ' where id = :userId';

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

        $row = $stmt->fetch();
        if (!empty($row)) {
            $data = $row;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam). ', dbIndex = ' . json_encode($dbIndex));
        }

        return ERR_OK;
    }

    /**
     * 用户详情 - 更新用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function updateDetail($param, &$data) {
        $userId = intval($param['userId']);
        $realName = $param['realName'];
        $mobileNumber = $param['mobileNumber'];
        $aliPayAccount = $param['aliPayAccount'];

        $indexArr = clsUtility::getUserDBPos($userId);

        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, userId = ' . $userId);
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

        $sql = 'update ' . $tableName;
        $sql .= ' set userIDCardName = :realName, mobile_number = :mobileNumber, alipay_account = :aliPayAccount';
        $sql .= ' where id = :userId';

        $pdoParam = [
            ':userId' => $userId,
            ':realName' => $realName,
            ':mobileNumber' => $mobileNumber,
            ':aliPayAccount' => $aliPayAccount
        ];
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        return ERR_OK;
    }

    /**
     * 获取登陆日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLoginLog($param, &$data) {
        if (isset($param['userId']) && !empty($param['userId'])) {
            return self::getLoginLogByUserId($param, $data);
        } else {
            return self::getLoginLogAll($param, $data);
        }
    }

    /**
     * 获取标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLabel($param, &$data) {
        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select id, name, sort, autoMoney from admin_user_label order by id desc limit ' . maxQueryNum;
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql);
            return ERR_MYSQL_EXCEPTION;
        }
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['personNum'] = 0; // notice 测试数据
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql . ', dbName = ' . $dbName);
        }

        return ERR_OK;
    }

    /**
     * 添加标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLabel($param, &$data) {
        $name = trim($param['name']);
        $sort = intval($param['sort']);
        $autoMoney = isset($param['autoMoney']) && !empty($param['autoMoney']) ? intval($param['autoMoney']) : 1;

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':name' => $name,
            ':sort' => $sort,
            ':autoMoney' => $autoMoney
        ];
        $sql = 'insert into admin_user_label(name, sort, autoMoney) values (:name, :sort, :autoMoney)';
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 编辑标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function editLabel($param, &$data) {
        $id = intval($param['id']);
        $name = trim($param['name']);
        $sort = intval($param['sort']);
        $autoMoney = isset($param['autoMoney']) && !empty($param['autoMoney']) ? intval($param['autoMoney']) : 1;

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':id' => $id,
            ':name' => $name,
            ':sort' => $sort,
            ':autoMoney' => $autoMoney
        ];
        $sql = 'update admin_user_label set name = :name, sort = :sort, autoMoney = :autoMoney';
        $sql .= ' where id = :id';
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 删除标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function delLabel($param, &$data) {
        $name = trim($param['name']);

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':name' => $name
        ];
        $sql = 'delete from admin_user_label';
        $sql .= ' where name = :name';
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 获取等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLv($param, &$data) {
        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select id, name, upPrice, templateId, note from admin_user_lv order by name asc limit ' . maxQueryNum;
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['userNum'] = 0;
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql . ', dbName = ' . $dbName);
        }

        $retNum = 0;
        $errCode = self::getUserNumByUserLvName($retNum, '普通用户');
        if ($errCode !== ERR_OK) {
            return $errCode;
        } else {
            $row['userNum'] = $retNum;
        }

//        $data[] = [
//            'name' => '普通用户',
//            'upPrice' => 0,
//            'userNum' => $retNum
//        ];
        $commonArr = [
            'name' => '普通用户',
            'upPrice' => 0,
        ];
        array_unshift($data, $commonArr); // todo 为何放在开头和结尾都是第一个显示

        return ERR_OK;
    }

    /**
     * 新增等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLv($param, &$data) {
        $name = trim($param['name']);
        $upPrice = intval($param['upPrice']);
        $templateId = intval($param['templateId']);
        $note = isset($param['note']) && !empty($param['note']) ? trim($param['note']) : '';

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':name' => $name,
            ':upPrice' => $upPrice,
            ':templateId' => $templateId,
            ':note' => $note
        ];
        $sql = 'insert into admin_user_lv(name, upPrice, templateId, note) values (:name, :upPrice, :templateId, :note)';
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        return ERR_OK;
    }

    /**
     * 编辑等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function editLv($param, &$data) {
        $id = intval($param['id']);
        $name = trim($param['name']);
        $upPrice = intval($param['upPrice']);
        $templateId = intval($param['templateId']);
        $note = isset($param['note']) && !empty($param['note']) ? trim($param['note']) : '';

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':id' => $id,
            ':name' => $name,
            ':upPrice' => $upPrice,
            ':templateId' => $templateId,
            ':note' => $note
        ];
        $sql = 'update admin_user_lv set name = :name, upPrice = :upPrice, templateId = :templateId, note = :note';
        $sql .= ' where id = :id';
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        return ERR_OK;
    }

    /**
     * 删除等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function delLv($param, &$data) {
        $name = trim($param['name']);

        $dbName = 'new_admin';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':name' => $name
        ];
        $sql = 'delete from admin_user_lv';
        $sql .= ' where name = :name';
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', dbName = ' . $dbName
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        return ERR_OK;
    }

    /**
     * 获取用户信息列表
     * @param $param
     * @param $data
     * @return int
     */
    private function getListAll(&$param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];
            $dateEnd = date('Y-m-d H:i:s', strtotime($dateEnd) + 86400);
        } else {
            $dateBegin = $dateEnd = '';
        }

        $isOnline = isset($param['isOnline']) && !empty($param['isOnline']) ? $param['isOnline'] : '';
        $userEmail = isset($param['userEmail']) && !empty($param['userEmail']) ? $param['userEmail'] : '';
        $realName = isset($param['realName']) && !empty($param['realName']) ? $param['realName'] : '';
        $mobileNumber = isset($param['mobileNumber']) && !empty($param['mobileNumber']) ? $param['mobileNumber'] : '';
        $aliPayAccount = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? $param['aliPayAccount'] : '';

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
            $pdoParam = [];
            for ($j = 0; $j <= 15; $j++) {
                $tableName = $tablePrefix . $j;
                if (!empty($sql)) {
                    $sql .= ' union all ';
                }
                $sql .= 'select id, user_email, registertime, userIDCardName';
                $sql .= ' from ' . $tableName;

                $haveWhere = false;
                if ($dateBegin !== '') {
                    $sql .= ' where registertime >= :dateBegin and registertime <= :dateEnd';
                    $haveWhere = true;
                    $pdoParam[':dateBegin'] = $dateBegin;
                    $pdoParam[':dateEnd'] = $dateEnd;
                }

                if ($userEmail !== '') {
                    if ($haveWhere) {
                        $sql .= ' and user_email like :userEmail';
                    } else {
                        $sql .= ' where user_email like :userEmail';
                        $haveWhere = true;
                    }
                    $pdoParam[':userEmail'] = '%' . $userEmail . '%';
                }

                if ($realName !== '') {
                    if ($haveWhere) {
                        $sql .= ' and userIDCardName like :realName';
                    } else {
                        $sql .= ' where userIDCardName like :realName';
                        $haveWhere = true;
                    }
                    $pdoParam[':realName'] = '%' . $realName . '%';
                }

                if ($mobileNumber !== '') {
                    if ($haveWhere) {
                        $sql .= ' and mobile_number like :mobileNumber';
                    } else {
                        $sql .= ' where mobile_number like :mobileNumber';
                        $haveWhere = true;
                    }
                    $pdoParam[':mobileNumber'] = '%' . $mobileNumber . '%';
                }

                if ($aliPayAccount !== '') {
                    if ($haveWhere) {
                        $sql .= ' and alipay_account like :aliPayAccount';
                    } else {
                        $sql .= ' where alipay_account like :aliPayAccount';
                        $haveWhere = true;
                    }
                    $pdoParam[':aliPayAccount'] = '%' . $aliPayAccount . '%';
                }
                $sql .= ' limit ' . maxQueryNum;
            }
            try {
                $stmt = $pdo->prepare($sql);
                $ret = $stmt->execute($pdoParam);
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
                    . ', sql = ' . $sql. ', pdoParam = ' . json_encode($pdoParam));
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                    . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                continue;
            }
        }

        return ERR_OK;
    }

    /**
     * 根据userId获取一个用户信息
     * @param $userId
     * @param $indexArr
     * @param $data
     * @return int
     */
    public static function getListOne($userId, &$indexArr, &$data) {
        $dbIndex = $indexArr['dbindex'];
        $tableIndex = $indexArr['tableindex'];

        $dbName = 'casinouserdb_' . $dbIndex;
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $tableName = 'casinouser_' . $tableIndex;

        $sql = 'select id, user_email, registertime, userIDCardName';
        $sql .= ' from ' . $tableName;
        $sql .= ' where id = :userId';

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
                . ', pdoParam = ' . json_encode($pdoParam). ', dbIndex = ' . json_encode($dbIndex));
        }

        return ERR_OK;
    }

    /**
     * 根据userId获取登陆日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLoginLogByUserId(&$param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];

            $tsBegin = strtotime($dateBegin);
            $tsEnd = strtotime($dateEnd) + 86400;
        } else {
            $tsBegin = $tsEnd = '';
        }

        $ip = isset($param['ip']) && !empty($param['ip']) ? $param['ip'] : '';

        $userId = intval($param['userId']);
        $indexArr = clsUtility::getUserDBPos($userId);
        if (!is_array($indexArr) || empty($indexArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, userId = ' . $userId);
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

        $pdoParam = [
            ':userId' => $userId
        ];

        $sql = 'select id, last_login_time, lastLoginIp, location, lastLoginMac'; // activate_device, uuid, lastLoginMac哪个是设备
        $sql .= ' from ' . $tableName;
        $sql .= ' where id = :userId';

        if ($tsBegin !== '') {
            $sql .= ' and last_login_time >= :tsBegin and last_login_time <= :tsEnd';
            $pdoParam[':tsBegin'] = $tsBegin;
            $pdoParam[':tsEnd'] = $tsEnd;
        }
        if ($ip !== '') {
            $sql .= ' and lastLoginIp = :ip';
            $pdoParam[':ip'] = $ip;
        }

        $sql .= ' limit ' . maxQueryNum;

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['last_login_time'] = date('Y-m-d H:i:s', $row['last_login_time']);
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam) . ', dbIndex = ' . json_encode($dbIndex));
        }

        return ERR_OK;
    }

    /**
     * 获取用户登陆日志列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLoginLogAll(&$param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];

            $tsBegin = strtotime($dateBegin);
            $tsEnd = strtotime($dateEnd) + 86400;
        } else {
            $tsBegin = $tsEnd = '';
        }

        $ip = isset($param['ip']) && !empty($param['ip']) ? $param['ip'] : '';

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
            $pdoParam = [];
            for ($j = 0; $j <= 15; $j++) {
                $tableName = $tablePrefix . $j;
                if (!empty($sql)) {
                    $sql .= ' union all ';
                }

                $sql = 'select id, last_login_time, lastLoginIp, location, activate_device'; // activate_device, uuid, lastLoginMac哪个是设备
                $sql .= ' from ' . $tableName;

                $haveWhere = false;
                if ($tsBegin !== '') {
                    $sql .= ' where last_login_time >= :tsBegin and last_login_time <= :tsEnd';
                    $haveWhere = true;
                    $pdoParam[':tsBegin'] = $tsBegin;
                    $pdoParam[':tsEnd'] = $tsEnd;
                }

                if ($ip !== '') {
                    if ($haveWhere) {
                        $sql .= ' and lastLoginIp = :ip';
                        $pdoParam[':ip'] = $ip;
                    } else {
                        $sql .= ' where lastLoginIp = :ip';
                        $pdoParam[':ip'] = $ip;
                    }
                }

                $sql .= ' limit ' . maxQueryNum;
            }
            try {
                $stmt = $pdo->prepare($sql);
                $ret = $stmt->execute($pdoParam);
                if (!$ret) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                        . ', dbName = ' . $dbName
                        . ', errCode = ' . $pdo->errorCode() . ', errInfo = ' . json_encode($pdo->errorInfo()));
                    continue;
                }

                $rows = $stmt->fetchAll();
                if (!empty($rows)) {
                    foreach ($rows as &$row) {
                        $row['last_login_time'] = date('Y-m-d H:i:s', $row['last_login_time']);
                    }
                    unset($row);

                    $data = array_merge($data, $rows);
                } else {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                        . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
                }

                clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($rows)
                    . ', sql = ' . $sql. ', pdoParam = ' . json_encode($pdoParam));
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                    . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                continue;
            }
        }

        return ERR_OK;
    }

    /**
     * 根据用户等级名获取对应的用户数量
     * @param $retNum
     * @param string $userLvName
     * @return int
     */
    public static function getUserNumByUserLvName(&$retNum, $userLvName = '') {
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

                $sql = 'select count(*) as userNum';
                $sql .= ' from ' . $tableName; // notice 以后要根据用户等级获取, 目前没有用户等级这个功能
            }

            try {
                $stmt = $pdo->prepare($sql);
                $ret = $stmt->execute();
                if (!$ret) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                        . ', dbName = ' . $dbName
                        . ', errCode = ' . $pdo->errorCode() . ', errInfo = ' . json_encode($pdo->errorInfo()));
                    continue;
                }

                $rows = $stmt->fetchAll();
                if (!empty($rows)) {
                    foreach ($rows as $row) {
                        $retNum += intval($row['userNum']);
                    }
                } else {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                        . ', dbName = ' . $dbName);
                }

                clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($rows)
                    . ', sql = ' . $sql);
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                    . ', dbName = ' . $dbName . ', sql = ' . $sql);
                continue;
            }
        }

        return ERR_OK;
    }
}