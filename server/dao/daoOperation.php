<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 运营管理
 */
class daoOperation {
    /**
     * 游戏报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 资金帐变 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function moneyReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 系统利润 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemProfitGet($param, &$data) {
        $dbName = 'casinoglobalinfo';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = date('Ymd', strtotime($param['dateRange'][1]) + daySeconds);
        } else {
//            $dateBegin = date('Ymd');
//            $dateEnd = date('Ymd', time() + daySeconds);
            $dateBegin = $dateEnd = -1;
        }

        try {
            $sql = 'select id, sdate as sDate, gametype as gameType, roomid as roomId, systemprofit as systemProfit from casinosystemprofit';
            if ($dateBegin !== -1) {
                $sql .= ' where str_to_date(sdate, "%Y%m%d") >= :dateBegin and str_to_date(sdate, "%Y%m%d") < :dateEnd';
            }
            $sql .= ' order by gametype asc, roomid asc';

            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':dateBegin' => $dateBegin,
                ':dateEnd' => $dateEnd
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', param = ' . json_encode($param)
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();

            if (!empty($rows)) {
                foreach ($rows as &$row) {
                    $row['systemProfit'] = number_format($row['systemProfit'], 2, '.', ' ');
                    $row['gameType'] = array_key_exists($row['gameType'], gameIdName) ? gameIdName[$row['gameType']] : $row['gameType'];
                }
                unset($row);

                $data = $rows;
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql);
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 系统维护 - 游戏开关
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemMaintenanceSwitch($param, &$data) {
        $open = $param['open'];
        $notice = $param['notice'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $gameSwitch = [
            'open' => $open,
            'notice' => $notice
        ];
        $redis->set(gameSwitch, json_encode($gameSwitch));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 获取游戏包列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGetGameList($param, &$data) {
        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGet($param, &$data) {
        $selectTag = $param['selectTag'];

        $dbName = 'db_smc';
        $pdoParam = [];
        $sql = 'select * from smc_version';
        if ($selectTag !== -1) {
            $sql .= ' where packagename = :packagename';
            $pdoParam[':packagename'] = $selectTag;
        }
        $sql .= ' order by packagename, latestVersion desc limit ' . maxQueryNum;

        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (empty($rows)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_OK;
        }

        // 先找到每个tag在channelList中的index
        $tagIndex = [];
        $tagChannelId = [];
        $channelCount = count(channelList);
        for ($i = 0; $i < $channelCount; $i++) {
            $c = channelList[$i];
            $tagIndex[$c['tag']] = $i;
            $tagChannelId[$c['tag']] = $c['channelId'];
        }

        // 设置每一个结果都把index设置一下
        $resultCount = count($rows);
        for ($i = 0; $i < $resultCount; $i++) {
            if (!isset($tagIndex[$rows[$i]['packagename']])) {
                $rows[$i]['i'] = -1;
                $rows[$i]['channelId'] = -1;
            } else {
                $rows[$i]['i'] = $tagIndex[$rows[$i]['packagename']];
                $rows[$i]['channelId'] = $tagChannelId[$rows[$i]['packagename']];
            }
        }

        usort($rows, ['daoOperation', 'sortByTagAndVersion']);
        $data = $rows;

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 添加游戏版本
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeAdd($param, &$data) {
        $packageName = $param['packageName'];
        $latestVersion = $param['latestVersion'];
        $expiredVersion = $param['expiredVersion'];
        $url = $param['url'];

        $status = $param['status'];

        $dbName = 'db_smc';
        $sql = 'insert into smc_version (packagename, latestVersion, expiredVersion, url, status)';
        $sql .= ' (:packagename, :latestVersion, :expiredVersion, :url, :status)';
        $pdoParam = [
            ':packagename' => $packageName,
            ':latestVersion' => $latestVersion,
            ':expiredVersion' => $expiredVersion,
            ':url' => $url,

            ':status' => $status
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        // 更新redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->set('versionstatus_' . $packageName . '_' . $latestVersion, $status . '');
        $redis->del('versioninfo_' . $packageName);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 刷新redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeRefresh($param, &$data) {
        $id = $param['id'];

        // 获取package
        $dbName = 'db_smc';
        $sql = 'select * from smc_version where id = :id limit 1';
        $pdoParam = [':id' => $id];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_OK;
        }

        // 刷新 - 即删除相关redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        // 删除versioninfo
        $redis->del('versioninfo_' . $row['packagename']);
        // 删除所有versionstatus
        $versionStatusKeys = $redis->keys('versionstatus_' . $row['packagename'] . '_' . '*');
        foreach ($versionStatusKeys as $k => $v) {
            $redis->del($v);
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeDel($param, &$data) {
        $id = $param['id'];

        // 获取package
        $dbName = 'db_smc';
        $sql = 'select * from smc_version where id = :id limit 1';
        $pdoParam = [':id' => $id];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_OK;
        }

        // db删除
        $sql = 'delete from smc_version where id = :id';
        $pdoParam = [':id' => $id];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return $errCode;
        }

        // redis删除
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        // 删除versioninfo
        $redis->del('versioninfo_' . $row['packagename']);
        // 删除所有versionstatus
        $versionStatusKeys = $redis->keys('versionstatus_' . $row['packagename'] . '_' . '*');
        foreach ($versionStatusKeys as $k => $v) {
            $redis->del($v);
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 上线/下线
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeChangeStatus($param, &$data) {
        $id = $param['id'];
        $type = $param['type']; // 1上线, 2下线

        $status = $type === 1 ? 1 : 0; // 1上线, 0下线

        // 获取package
        $dbName = 'db_smc';
        $sql = 'select * from smc_version where id = :id limit 1';
        $pdoParam = [':id' => $id];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (empty($row)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_INVALID_PARAM;
        }

        // 更新db
        $sql = 'update smc_version set status = :status where id = :id';
        $pdoParam = [':status' => $status, ':id' => $id];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if (!$errCode) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        // 更新redis
        $redis = clsRedis::getInstance();
        $redis->set('versionstatus_' . $row['packagename'] . '_' . $row['latestVersion'], '1');
        $redis->del('versioninfo_' . $row['packagename']);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 模块升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function moduleUpgradeGet($param, &$data) {
        $dbName = 'db_smc';
        $sql = 'select * from smc_version_module order by id limit ' . maxQueryNum;
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
     * 模块升级服务器管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function moduleUpgradeModify($param, &$data) {
        $id = $param['id'];
        $latestVersion = $param['latestVersion'];
        $expiredVersion = $param['expiredVersion'];

        // 更新mysql
        $dbName = 'db_smc';
        $sql = 'update smc_version_module set latestVersion = :latestVersion, expiredVersion = :expiredVersion';
        $sql .= ' where id = :id';
        $pdoParam = [
            ':latestVersion' => $latestVersion,
            ':expiredVersion' => $expiredVersion,
            ':id' => $id
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        // 更新redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->del('moduleUpdateInfo');

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 游戏开关管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameSwitchGet($param, &$data) {
        // 获取数据库内容
        $dbName = 'db_smc';
        $sql = 'select * from smc_game_switch order by id desc limit ' . maxQueryNum;
        $rows = clsUtility::getRows($dbName, $sql);
        if (empty($rows)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql);
        }

        // 重组后的dbData
        $dbDataMap = [];
        foreach ($rows as $row) {
            $dbName[$row['channelId']] = $row;
        }

        $finalRet = [];
        $defaultChannel = 0;
        $copyList = [
            'useDefault',
            'ddz',
            'ddzhl',
            'ddzlz',
            'zhajinhua',
            'zhajinhuabr',
            'niuniu',
            'niuniuqz',
            'niuniubr',
            'videoarcade',
            'fishing',
            'lhp',
            'niuniuml',
            'shisanzhang',
            'pacs',
            'sangong',
            'hongheidz',
        ];

        // 先插入默认行
        $finalRet[] = [
            'channelId' => $defaultChannel,
            'channelName' => '默认',
            'channelTag' => '[无]'
        ];
        foreach (channelList as $v) {
            $finalRet[] = [
                'channelId' => $v['channelId'],
                'channelName' => $v['name'],
                'channelTag' => $v['tag']
            ];
        }

        // 查询数据库返回数据中的开关情况
        $num = count($finalRet);
        for ($i = 0; $i < $num; $i++) {
            $channelId = $finalRet[$i]['channelId'];
            if (isset($dbDataMap[$channelId])) {
                $dbEntry = $dbDataMap[$channelId];
                foreach ($copyList as $c) {
                    $finalRet[$i][$c] = $dbEntry[$c];
                }
            } else {
                // 数据库中没有, 则使用默认配置
                foreach ($copyList as $c) {
                    $finalRet[$i][$c] = 0;
                }

                $finalRet[$i]['useDefault'] = 1;
            }
        }

        $data = $finalRet;

        return ERR_OK;
    }

    /**
     * 游戏开关管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameSwitchEdit($param, &$data) {
        $channelId = $param['channelId'];
        $dataArr = $param['dataArr'];

        $dbName = 'db_smc';
        $sql = 'update smc_game_switch set useDefault = :useDefault, ddz = :ddz,';
        $sql .= ' ddzhl = :ddzhl, ddzlz = :ddzlz, zhajinhua = :zhajinhua, zhajinhuabr = :zhajinhuabr, niuniu = :niuniu,';
        $sql .= ' niuniuqz = :niuniuqz, videoarcade = :videoarcade, fishing = :fishing, lhp = :lhp, niuniubr = :niuniubr,';
        $sql .= ' niuniuml = :niuniuml, shisanzhang = :shisanzhang, sangong = :sangong, hongheidz = :hongheidz,';
        $sql .= ' channelTag = :channelTag';
        $sql .= ' where channelId = :channelId';

        $pdoParam = [
            ':channelId' => $channelId,
            ':useDefault' => $dataArr['useDefault'],
            ':ddz' => $dataArr['ddz'],
            ':ddzhl' => $dataArr['ddzhl'],

            ':ddzlz' => $dataArr['ddzlz'],
            ':zhajinhua' => $dataArr['zhajinhua'],
            ':zhajinhuabr' => $dataArr['zhajinhuabr'],
            ':niuniu' => $dataArr['niuniu'],

            ':niuniuqz' => $dataArr['niuniuqz'],
            ':videoarcade' => $dataArr['videoarcade'],
            ':fishing' => $dataArr['fishing'],
            ':lhp' => $dataArr['lhp'],

            ':niuniubr' => $dataArr['niuniubr'],
            ':niuniuml' => $dataArr['niuniuml'],
            ':shisanzhang' => $dataArr['shisanzhang'],
            ':sangong' => $dataArr['sangong'],

            ':hongheidz' => $dataArr['hongheidz'],
            ':channelTag' => $dataArr['channelTag']
        ];

        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        // 删除redis内容
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->del(gameSwitchData);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 转账支付宝管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferGet($param, &$data) {
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $invalidAccounts = $redis->sMembers(invalidAliPayAccount);

        $allAccounts = aliPayTransferAccount;
        $num = count($allAccounts);
        for ($i = 0; $i < $num; $i++) {
            if (in_array($allAccounts[$i]['account'], $invalidAccounts)) {
                $allAccounts[$i]['invalid'] = true;
            } else {
                $allAccounts[$i]['invalid'] = false;
            }
        }

        $data = $allAccounts;

        return ERR_OK;
    }

    /**
     * 转账支付宝管理 - 修改开关时间
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferModifyTime($param, &$data) {
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $openTime = $param['openTime'];
        $closeTime = $param['closeTime'];

        $switchTime = [$openTime, $closeTime];
        $redis->set(aliPayTransferSwitchTime, implode(',', $switchTime));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 转账支付宝管理 - 打开/关闭账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferModifyStatus($param, &$data) {
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $type = $param['type']; // 1打开, 2关闭
        $aliPayAccount = $param['aliPayAccount'];

        if ($type === 1) { // 打开 - 移除invalid aliPayAccount
            $ret = $redis->sRem(invalidAliPayAccount, $aliPayAccount);
            if ($ret === 1) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', open success, param = ' . json_encode($param));
            } else {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', already open, param = ' . json_encode($param));
                return ERR_ALI_PAY_ACCOUNT_ALREADY_OPEN;
            }
        } else { // 关闭 - 添加invalid aliPayAccount
            $found = false;
            foreach (aliPayTransferAccount as $v) {
                if ($v['account'] == $aliPayAccount) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, aliPayAccount not exist');
                return ERR_ALI_PAY_ACCOUNT_NOT_EXIST;
            }

            if ($redis->sIsMember(invalidAliPayAccount, $aliPayAccount)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', already close, param = ' . json_encode($param));
                return ERR_ALI_PAY_ACCOUNT_ALREADY_CLOSE;
            }

            $redis->sAdd(invalidAliPayAccount, $aliPayAccount);

            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', close success, param = ' . json_encode($param));
        }

        return ERR_OK;
    }

    /**
     * 支付管理 - 支付总开关
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentSwitch($param, &$data) {
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $closePay = $param['closePay'];
        $manualRecharge = $param['manualRecharge'];

        $redis->set(closePayKey, $closePay);
        $redis->set(manualRecharge, $manualRecharge);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 支付管理 - 支付宝第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentAliPayThird($param, &$data) {
        $aliPayThird = $param['aliPayThird'];

        $aliPayPlatformsRange = [];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        // 遍历所有的支付宝支付方式, 获取最大值最小值
        foreach (aliPayPay as $k => $v) {
            $min = intval($_POST['min' . $k]);
            $max = intval($_POST['max' . $k]);
            $closeStart = intval($_POST['closeStart' . $k]);
            $closeEnd = intval($_POST['closeEnd' . $k]);
            if (in_array($k, $aliPayThird)) {
                $open = 1;
            } else {
                $open = 0;
            }

            $aliPayPlatformsRange[$k] = [
                'open' => $open,
                'min' => $min,
                'max' => $max,
                'closeStart' => $closeStart,
                'closeEnd' => $closeEnd
            ];
        }

        $redis->set(aliPayPlatformsRange, json_encode($aliPayPlatformsRange));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 支付管理 - 支付宝官方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentAliPayOfficial($param, &$data) {
        $amount = $param['amount'];
        $openTime = $param['openTime'];
        $closeTime = $param['closeTime'];
        $controlTime = $param['controlTime'];

        $controlNum = $param['controlNum'];
        $platformType = $param['platformType'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        if ($openTime !== '' && $closeTime !== '') {
            $switchTime = [
                $openTime,
                $closeTime
            ];
            $redis->set(formatAliPaySwitchTime, implode(',', $switchTime));
        }

        if ($controlTime !== '' && $controlNum !== '') {
            $aliPayControl = [
                $controlTime,
                $controlNum
            ];
            $redis->set(formatAliCurrentOrderControl, implode(',', $aliPayControl));
        }

        $redis->set(aliPayAmountKey, $amount);
        $redis->set(formatAliPayPlatformType, $platformType);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 支付管理 - 微信第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentWeChatThird($param, &$data) {
        $weChatThird = $param['weChatThird'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        // 遍历所有的微信第三方支付方式, 获取最大值最小值
        $weChatPlatformRange = [];

        foreach (wxPay as $k => $v) {
            $min = intval($_POST['min' . $k]);
            $max = intval($_POST['max' . $k]);
            if (in_array($k, $weChatThird)) {
                $open = 1;
            } else {
                $open = 0;
            }

            $weChatPlatformRange[$k] = [
                'open' => $open,
                'min' => $min,
                'max' => $max
            ];
        }

        $redis->set(weChatPayPlatformsRange, json_encode($weChatPlatformRange));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 支付管理 - qq第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentQqThird($param, &$data) {
        $qqThird = $param['qqThird'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        // 遍历所有的qq支付方式, 获取最大值和最小值
        $qqPlatformRange = [];
        foreach (qqPay as $k => $v) {
            $min = intval($_POST['min' . $k]);
            $max = intval($_POST['max' . $k]);
            if (in_array($k, $qqThird)) {
                $open = 1;
            } else {
                $open = 0;
            }

            $qqPlatformRange[$k] = [
                'open' => $open,
                'min' => $min,
                'max' => $max
            ];
        }

        $redis->set(qqPayPlatformsRange, json_encode($qqPlatformRange));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));
        return ERR_OK;
    }

    /**
     * 支付管理 - 京东钱包第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentJdThird($param, &$data) {
        $jdThird = $param['jdThird'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        // 遍历所有的jd支付方式, 获取最大值和最小值
        $jdPlatformRange = [];
        foreach (jdPay as $k => $v) {
            $min = intval($_POST['min' . $k]);
            $max = intval($_POST['max' . $k]);
            if (in_array($k, $jdThird)) {
                $open = 1;
            } else {
                $open = 0;
            }

            $jdPlatformRange[$k] = [
                'open' => $open,
                'min' => $min,
                'max' => $max
            ];
        }

        $redis->set(jdPayPlatformsRange, json_encode($jdPlatformRange));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));
        return ERR_OK;
    }

    /**
     * 支付管理 - 银联快捷支付
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentYlThird($param, &$data) {
        $ylThird = $param['ylThird'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        // 遍历所有的jd支付方式, 获取最大值和最小值
        $ylPlatformRange = [];
        foreach (jdPay as $k => $v) {
            $min = intval($_POST['min' . $k]);
            $max = intval($_POST['max' . $k]);
            if (in_array($k, $ylThird)) {
                $open = 1;
            } else {
                $open = 0;
            }

            $ylPlatformRange[$k] = [
                'open' => $open,
                'min' => $min,
                'max' => $max
            ];
        }

        $redis->set(ylPayPlatformsRange, json_encode($ylPlatformRange));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));
        return ERR_OK;
    }

    /**
     * 支付管理 - 配置支付渠道参数
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentConfig($param, &$data) {
        $jubaoPartnerId = $param['jubaoPartnerId'];
        $cfAppId = $param['cfAppId'];
        $cfSecretKey = $param['cfSecretKey'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $jubaoConfig = [
            'partnerId' => $jubaoPartnerId
        ];
        $cdConfig = [
            'appId' => $cfAppId,
            'secretKey' => $cfSecretKey
        ];

        $redis->set(jubaoConfig, json_encode($jubaoConfig));
        $redis->set(cfConfig, json_encode($cdConfig));

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * Proxy Ip管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpGet($param, &$data) {
        $tag = $param['tag'];
        $finalRet = [];

        // 获取packageList
        $packageList = [];
        $dbName = 'db_smc';
        $sql = 'select * from smc_proxy_ip';

        $pdoParam = [];
        if ($tag !== '') {
            $sql .= ' where tag = :tag';
            $pdoParam = [':tag' => $tag];
        }
        $sql .= ' limit ' . maxQueryNum;

        $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $packageList[$row['tag']] = $row['ip_list'];
            }
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
        }

        $tagList = array_column(channelList, 'name', 'tag');
        foreach ($tagList as $k => $v) {
            if (isset($packageList[$k])) {
                $finalRet[] = [
                    'packagename' => $k,
                    'ip_list' => $packageList[$k],
                    'name' => $v
                ];
            } else {
                if ($tag === '' || $tag == $k) {
                    $finalRet[] = [
                        'packagename' => $k,
                        'ip_list' => '',
                        'name' => $v
                    ];
                }
            }
        }

        $data = $finalRet;

        return ERR_OK;
    }

    /**
     * Proxy Ip管理 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpSave($param, &$data) {
        $tag = $param['tag'];
        $ipStr = $param['ipStr'];

        // mysql insert or update
        $dbName = 'db_smc';

        $sql = 'select * from smc_proxy_ip where tag = :tag limit 1';
        $pdoParam = [':tag' => $tag];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            $sql = 'update smc_proxy_ip set ip_list = :ip_list where tag = :tag';
            $pdoParam = [':ip_list' => $ipStr, ':tag' => $tag];
            $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                    . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
                return $errCode;
            }
        } else {
            $sql = 'insert into smc_proxp_ip (tag, ip_list, ip_list_shenhe) values (:tag, :ip_list, :ip_list_shenhe)';
            $pdoParam = [
                ':tag' => $tag,
                ':ip_list' => $ipStr,
                ':ip_list_shenhe' => ''
            ];
            $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                    . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
                return $errCode;
            }
        }

        // 更新redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->del(ipList . $tag);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * Proxy Ip管理 - 同步到redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpRedisSync($param, &$data) {
        // 同步成功数量
        $num = 0;

        // smc_proxy_ip - select
        $packageList = [];
        $dbName = 'db_smc';
        $sql = 'select * from smc_proxy_ip limit ' . maxQueryNum;
        $rows = clsUtility::getRows($dbName, $sql);
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $packageList[$row['tag']] = $row['ip_list'];
            }
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql);
        }

        if (!empty($packageList)) {
            $redis = clsRedis::getInstance();
            if ($redis === null) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
                return ERR_REDIS_CONNECT_FAIL;
            }

            foreach ($packageList as $tag => $ipList) {
                $redis->set(ipList . $tag, $ipList);
                $num++;
            }
        }

        $data['num'] = $num;

        return ERR_OK;
    }

    /**
     * 代理账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountGet($param, &$data) {
        $dbName = 'db_smc';
        $sql = 'select * from smc_agent_account order by id limit ' . maxQueryNum;
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
     * 代理账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountAdd($param, &$data) {
        $account = $param['account'];
        $pass = $param['pass'];
        $status = $param['status'];
        $channelPriv = json_encode($param['channelPriv']);

        $fieldPriv = json_encode($param['fieldPriv']);
        $tsNow = time();

        $dbName = 'db_smc';

        // 判断账号是否已存在
        $sql = 'select id from smc_agent_account where account = :account limit 1';
        $pdoParam = [':account' => $account];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', account already exist, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_ACCOUNT_ALREADY_EXIST;
        }

        // 添加
        $salt = rand(10000, 99999);
        $pass = crypt($pass, $salt);

        $sql = 'insert into smc_agent_account (account, pass, salt, add_time, status, channel_priv, field_priv)';
        $sql .= ' values (:account, :pass, :salt, :add_time, :status, :channel_priv, :field_priv)';
        $pdoParam = [
            ':account' => $account,
            ':pass' => $pass,
            ':salt' => $salt,
            ':add_time' => $tsNow,

            ':status' => $status,
            ':channel_priv' => $channelPriv,
            ':field_priv' => $fieldPriv
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 代理账号管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountEdit($param, &$data) {
        $id = $param['id'];
        $account = $param['account'];
        $pass = $param['pass'];
        $status = $param['status'];

        $channelPriv = json_encode($param['channelPriv']);
        $fieldPriv = json_encode($param['fieldPriv']);
        $tsNow = time();

        $dbName = 'db_smc';

        // 判断账号是否已存在
        $sql = 'select id from smc_agent_account where account = :account limit 1';
        $pdoParam = [':account' => $account];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', account already exist, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_ACCOUNT_ALREADY_EXIST;
        }

        // 修改
        $salt = rand(10000, 99999);
        $pass = crypt($pass, $salt);

        $sql = 'update smc_agent_account';
        $sql .= ' set account = :account, pass = :pass, salt = :salt, add_time = :add_time, status = :status,';
        $sql .= ' channel_priv = :channel_priv, field_priv = :field_priv';
        $sql .= ' where id = :id';
        $pdoParam = [
            ':account' => $account,
            ':pass' => $pass,
            ':salt' => $salt,
            ':add_time' => $tsNow,

            ':status' => $status,
            ':channel_priv' => $channelPriv,
            ':field_priv' => $fieldPriv,
            ':id' => $id
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 代理账号管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountDel($param, &$data) {
        $id = $param['id'];

        $dbName = 'db_smc';
        $sql = 'delete from smc_agent_account where id = :id';
        $pdoParam = [':id' => $id];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        return ERR_OK;
    }

    /**
     * 紧急停服
     * @param $param
     * @param $data
     * @return int
     */
    public static function stopServer($param, &$data) {
        $gameId = $param['gameId'];
        $pass = $param['pass'];

        $cPass = 'axxxxxxxxxxx';
        $salt = 'abc123';

        if (crypt($pass, $salt) !== $cPass) {
            clsLog::error(__METHOD__ . ', password wrong, param = ' . json_encode($param));
            return ERR_PASSWORD_WRONG;
        }

        $errCode = ERR_SERVER;
        switch ($gameId) {
            case -1: // 全部
                $errCode1 = self::stopDdz();
                $errCode2 = self::stopNiuniu();
                $errCode3 = self::stopZjh();
                $errCode4 = self::stopSg();

                if ($errCode1 === ERR_OK && $errCode2 === ERR_OK && $errCode3 === ERR_OK && $errCode4 === ERR_OK) {
                    $errCode = ERR_OK;
                }
                break;
            case 1: // 斗地主
                $errCode = self::stopDdz();
                break;
            case 2: // 牛牛
                $errCode = self::stopNiuniu();
                break;
            case 3: // 炸金花
                $errCode = self::stopZjh();
                break;
            case 24:
                $errCode = self::stopSg();
                // 三公
                break;
        }

        if ($errCode === ERR_OK) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));
        }

        return ERR_OK;
    }

    /**
     * 增加金币记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldAddLogGet($param, &$data) {
        $minGold = $param['minGold'];
        $userId = $param['userId'];
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);
        $adminId = $param['adminId'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_admin_log';
        $sql .= ' where add_time >= :tsBegin and add_time <= :tsEnd';
        $sql .= ' and chips >= :chips';
        $pdoParam = [
            ':tsBegin' => $tsBegin,
            ':tsEnd' => $tsEnd,
            ':chips' => $minGold
        ];
        if ($userId) {
            $sql .= ' and user_id = :user_id';
            $pdoParam[':user_id'] = $userId;
        }
        if ($adminId !== -1) {
            $sql .= ' and admin_id = :admin_id';
            $pdoParam[':admin_id'] = $adminId;
        }
        $sql .= ' order by id desc limit ' . maxQueryNum;

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
     * 绑定手机记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bindPhoneLogGet($param, &$data) {
        $userId = $param['userId'];
        $mobile = $param['mobile'];
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);
        $bindStatus = $param['bindStatus'];


        $tableArr = self::getBindPhoneLogTables();
        if (!empty($tableArr)) {
            $dbName = 'casinogamehisdb';
            $sql = '';
            $pdoParam = [];

            foreach ($tableArr as $k => $tableName) {
                $tsTmp = strtotime($k);
                if ($tsTmp >= $tsBegin && $tsTmp <= $tsEnd) { // todo 这个开始结束时间怎么在表名和查询内容中都用到
                    if (!$sql !== '') {
                        $sql .= ' union all ';
                    }
                    $sql .= 'select * from ' . $tableName;

                    $item = [];
                    if ($userId) {
                        $item[] = 'userid = :userid';
                        $pdoParam[':userid'] = $userId;
                    }
                    if ($mobile) {
                        $item[] = 'mobile = :mobile';
                        $pdoParam[':mobile'] = $mobile;
                    }
                    if ($bindStatus !== -1) {
                        $item[] = 'bind = :bind';
                        $pdoParam[':bind'] = $bindStatus;
                    }
                    if (!empty($dateBegin)) {
                        $item[] = 'recordtime >= :dateBein';
                        $pdoParam[':dateBein'] = $dateBegin;
                    }
                    if (!empty($dateEnd)) {
                        $item[] = 'recordtime <= :dateEnd';
                        $pdoParam[':dateEnd'] = $dateEnd;
                    }

                    if (!empty($item)) {
                        $sql .= ' where ';

                        $sqlTmp = implode(' and ', $item);
                        $sql .= $sqlTmp;
                    }
                }
            }

            $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
            if (!empty($rows)) {
                $data = $rows;
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
            }
        }

        return ERR_OK;
    }

    /**
     * 绑定支付宝记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bindAliPayLogGet($param, &$data) {
        $userId = $param['userId'];
        $aliPayAccount = $param['aliPayAccount'];
        $dateBegin = $param['dateRange']['dateBegin'];
        $dateEnd = $param['dateRange']['dateEnd'];

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);

        $tableArr = self::getBindAliAccountLogTables();
        if (!empty($tableArr)) {
            $dbName = 'casinogamehisdb';
            $sql = '';
            $pdoParam = [];

            foreach ($tableArr as $k => $tableName) {
                $tsTmp = strtotime($k);
                if ($tsTmp >= $tsBegin && $tsTmp <= $tsEnd) { // todo 这个开始结束时间怎么在表名和查询内容中都用到
                    if (!$sql !== '') {
                        $sql .= ' union all ';
                    }
                    $sql .= 'select * from ' . $tableName;

                    $item = [];
                    if ($userId) {
                        $item[] = 'userid = :userid';
                        $pdoParam[':userid'] = $userId;
                    }
                    if ($aliPayAccount) {
                        $item[] = 'alipay_account = :alipay_account';
                        $pdoParam[':alipay_account'] = $aliPayAccount;
                    }
                    if (!empty($dateBegin)) {
                        $item[] = 'recordtime >= :dateBein';
                        $pdoParam[':dateBein'] = $dateBegin;
                    }
                    if (!empty($dateEnd)) {
                        $item[] = 'recordtime <= :dateEnd';
                        $pdoParam[':dateEnd'] = $dateEnd;
                    }

                    if (!empty($item)) {
                        $sql .= ' where ';

                        $sqlTmp = implode(' and ', $item);
                        $sql .= $sqlTmp;
                    }
                }
            }

            $rows = clsUtility::getRows($dbName, $sql, $pdoParam);
            if (!empty($rows)) {
                $data = $rows;
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
            }
        }

        return ERR_OK;
    }

    /**
     * 禁止支付管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitGet($param, &$data) {
        $userId = $param['userId'];
        $describe = $param['describe'];
        $operator = $param['operator'];
        $dateBegin = $param['dateRange']['dateBegin'];

        $dateEnd = $param['dateRange']['dateEnd'];

        $dbName = 'db_smc';
        $sql = 'select * from smc_pay_limit';
        $sql .= ' where add_time >= :dateBegin and add_time <= :dateEnd';
        $pdoParam = [':dateBegin' => $dateBegin, ':dateEnd' => $dateEnd];

        if ($userId) {
            $sql .= ' and limit_target = :limit_target';
            $pdoParam[':limit_target'] = $userId;
        }
        if ($describe) {
            $sql .= ' and discribe like :discribe';
            $pdoParam[':discribe'] = '%' . $describe . '%';
        }
        if ($operator !== -1) {
            $sql .= ' and optuser = :optuser';
            $pdoParam[':optuser'] = $operator;
        }
        $sql .= ' order by id desc limit ' . maxQueryNum;

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
     * 禁止支付管理 - 添加充值黑名单
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitBlackAdd($param, &$data) {
        $userId = $param['userId'];
        $describe = $param['describe'];
        $timeNow = date('Y-m-d H:i:s');
        $operator = ''; // todo 当前管理员

        // 检测是否已存在
        $dbName = 'db_smc';
        $sql = 'select id from smc_pay_limit where limit_target = :limit_target';
        $pdoParam = [':limit_target' => $userId];
        $row = clsUtility::getRow($dbName, $sql, $pdoParam);
        if (!empty($row)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', userId already exist, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . $pdoParam);
            return ERR_LIMIT_TARGET_ALREADY_EXIST;
        }

        // 添加到mysql
        $sql = 'insert into smc_pay_limit (limit_target, optuser, add_time, discribe)';
        $sql .= ' values (:limit_target, :optuser, :add_time, :discribe)';
        $pdoParam = [
            ':limit_target' => $userId,
            ':optuser' => $operator,
            ':add_time' => $timeNow,
            ':discribe' => $describe
        ];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        // 添加到redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_INVALID_PARAM;
        }
        $redis->sAdd(payLimit, $userId);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 禁止支付管理 - 同步黑名单到redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitBlackRedisSync($param, &$data) {
        // 从mysql获取
        $dbName = 'db_smc';
        $sql = 'select id, limit_target from smc_pay_limit limit ' . maxQueryNum;
        $rows = clsUtility::getRows($dbName, $sql);
        if (empty($rows)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRows return empty, dbName = '
                . $dbName . ', sql = ' . $sql);
            return ERR_OK;
        }
        $retArr = [];
        foreach ($rows as $row) {
            $retArr[$row['id']] = $row['limit_target'];
        }

        // 保存到redis
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->del(payLimit);
        foreach ($retArr as $v) {
            $redis->sAdd(payLimit, $v);
        }
        $redis->sAdd(payLimit, -1); // 每次同步, 需要确保键值对存在

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 禁止支付管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitDel($param, &$data) {
        $userId = $param['userId'];

        // mysql删除
        $dbName = 'db_smc';
        $sql = 'delete from smc_pay_limit where limit_target = :limit_target';
        $pdoParam = [':limit_target' => $userId];
        $errCode = clsUtility::updateData($dbName, $sql, $pdoParam);
        if ($errCode !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::updateData fail, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam) . ', errCode = ' . $errCode);
            return $errCode;
        }

        // redis删除
        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $redis->sRem(payLimit, $userId);
        $redis->sAdd(payLimit, -1); // 确保键值存在

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 账号及充值查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rechargeLogGet($param, &$data) {
        $dbName = 'db_smc';

        // 获取表名
        $fix = date('Ymd', time());
        $strTime0 = date('Y-m-d H:i:s', time());
        $strTime1 = date('Y-m-d', time()) . " 05:30:00";
        $flag = strtotime($strTime0) < strtotime($strTime1);
        if ($flag) {
            $fix = date('Ymd', strtotime("-1 day", time()));
        }
        $tableName = "ALL_CASINOUSER" . $fix . ' ';
        $sql = 'select * from ' . $tableName;

        // 组装sql
        $sql .= self::contructSqlStr($param);
        $sql .= ' order by id desc limit ' . maxQueryNum;
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
     * 充领开关 - 修改充
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongLingSwitchEditPay($param, &$data) {
        $close = $param['close'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $redis->set(closeTransferPay, $close);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    /**
     * 充领开关 - 修改领
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongLingSwitchEditTake($param, &$data) {
        $close = $param['close'];

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }

        $redis->set(closeTransferTake, $close);

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', success, param = ' . json_encode($param));

        return ERR_OK;
    }

    // ====

    /**
     * 根据tag和版本号排序
     * @param $a
     * @param $b
     * @return int
     */
    private static function sortByTagAndVersion($a, $b) {
        if ($a['i'] > $b['i']) {
            return 1;
        } else if ($a['i'] < $b['i']) {
            return -1;
        } else {
            return $b['latestVersion'] - $a['latestVersion'];
        }
    }

    /**
     * 关服 - 斗地主
     * @return int
     */
    private static function stopDdz() {
//        $romid = 97;
//        $query = new Onlinedata_GameStatus ();
//        $query->set_gameType ( $romid );
//        $buf = $query->SerializeToString ();
//
//        $ret = $this->_request_midlayer_res1 ( $buf, 20300, DDZ_SERVER_IP, DDZ_SERVER_PORT );
        return ERR_OK;
    }

    /**
     * 关服 - 牛牛
     * @return int
     */
    private static function stopNiuniu() {
//        $romid = 18;
//        $query = new Onlinedata_GameStatus ();
//        $query->set_gameType ( $romid );
//        $buf = $query->SerializeToString ();
//
//        $rrt = array ();
//        $ret = $this->_request_midlayer_res1 ( $buf, 20300, NIUNIU_SERVER_IP, NIUNIU_SERVER_PORT );
        return ERR_OK;
    }

    /**
     * 关服 - 炸金花
     * @return int
     */
    private static function stopZjh() {
//        $romid = 49;
//        $query = new Onlinedata_GameStatus ();
//        $query->set_gameType ( $romid );
//        $buf = $query->SerializeToString ();
//
//        $rrt = array ();
//        $ret = $this->_request_midlayer_res1 ( $buf, 20300, ZJH_SERVER_IP, ZJH_SERVER_PORT );
        return ERR_OK;
    }

    /**
     * 关服 - 三公
     * @return int
     */
    private static function stopSg() {
//        $romid = 24;
//        $query = new Onlinedata_GameStatus ();
//        $query->set_gameType ( $romid );
//        $buf = $query->SerializeToString ();
//
//        $rrt = array ();
//        $ret = $this->_request_midlayer_res1 ( $buf, 20300, SANGONG_SERVER_IP, SANGONG_SERVER_PORT );
        return ERR_OK;
    }

    /**
     * 绑定手机记录 - 获取表名
     * @return array
     */
    public static function getBindPhoneLogTables() {
        $finalRet = [];

        $dbName = 'casinogamehisdb';
        $tablePrefix = 'CASINOBINDMOBILERECORD';
        $sql = "SELECT DISTINCT TABLE_NAME from information_schema.`COLUMNS` where TABLE_NAME LIKE '" . $tablePrefix . "%' ORDER BY TABLE_NAME desc";
        $rows = clsUtility::getRows($dbName, $sql);
        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $index = str_replace($tablePrefix, '', $v['TABLE_NAME']);
                $finalRet[$index] = $v['TABLE_NAME'];
            }
        }

        return $finalRet;
    }

    /**
     * 绑定支付宝记录 - 获取表名
     * @return array
     */
    public static function getBindAliAccountLogTables() {
        $finalRet = [];

        $dbName = 'casinogamehisdb';
        $tablePrefix = 'CASINOBINDALIPAYACCOUNT';
        $sql = "SELECT DISTINCT TABLE_NAME from information_schema.`COLUMNS` where TABLE_NAME LIKE '" . $tablePrefix . "%' ORDER BY TABLE_NAME desc";
        $rows = clsUtility::getRows($dbName, $sql);
        if (!empty($rows)) {
            foreach ($rows as $k => $v) {
                $index = str_replace($tablePrefix, '', $v['TABLE_NAME']);
                $finalRet[$index] = $v['TABLE_NAME'];
            }
        }

        return $finalRet;
    }

    /**
     * 账号及充值查询 - 生成sql
     * @param $query
     * @return string
     */
    private static function contructSqlStr($query) {
        $whereSql = "";
        $keyTypeArr = self::getColumnTypeArr();
        foreach ($keyTypeArr as $columnName => $columnType) {
            $val = self::getVal($query, $columnName); //$query[$columnName];
            $val_extra = self::getVal($query, "extra_" . $columnName); //$query["extra_".$columnName];
            if ($columnName && strlen("" . $val) > 0) {
                $connStr = self::getConnStr($columnType);
                $oper = $query["operation_" . $columnName];
                $columnSql = self::createColumnSql($val, $connStr, $oper, $columnName);
                if ($val_extra) {
                    $oper_extra = $query["operation_extra_" . $columnName];
                    $columnSql .= " and " . self::createColumnSql($val_extra, $connStr, $oper_extra, $columnName);;
                }
                if (strlen($whereSql) > 0) {
                    $whereSql .= " and ";
                }
                $whereSql .= " (" . $columnSql . ") ";
            }

        }
        if (strlen($whereSql) > 0) {
            $whereSql = " where " . $whereSql;
        }
        return " " . $whereSql . " ";
    }

    private static function getColumnTypeArr() {
        $resArr = array();
        $resArr['id'] = "bigint";
        $resArr['nickname'] = "varchar";
        $resArr['password'] = "varchar";
        $resArr['registertime'] = "timestamp";
        $resArr['user_email'] = "varchar";
        $resArr['user_device_id'] = "varchar";
        $resArr['user_chips'] = "bigint";
        $resArr['ip'] = "varchar";
        $resArr['mac'] = "varchar";
        $resArr['win_game'] = "int";
        $resArr['lose_game'] = "int";
        $resArr['draw_game'] = "int";
        $resArr['channel_id'] = "varchar";
        $resArr['totalBuy'] = "int";
        $resArr['lastLoginIp'] = "varchar";
        $resArr['lastLoginMac'] = "varchar";
        $resArr['alipay_real_name'] = "varchar";
        $resArr['alipay_account'] = "varchar";
        $resArr['total_total_money'] = "bigint";
        $resArr['boundmobilenumber'] = "varchar";
        $resArr['last_login_time'] = "bigint";
        $resArr['sum_game'] = "int";
        return $resArr;
    }

    private static function getVal($query, $columnName) {
        $res = $query[$columnName];
        if ("last_login_time" == $columnName || "extra_last_login_time" == $columnName) {
            return strtotime($res);
        }
        return $res;
    }

    private static function getConnStr($columnType) {
        if ($columnType) {
            $columnType = strtolower($columnType);
        }
        if ($columnType === 'tinyint' || $columnType === 'smallint' || $columnType === 'mediumint' || $columnType === 'int' || $columnType === 'bigint') {
            return "";
        } else {
            return "'";
        }
    }

    private static function createColumnSql($val, $connStr, $oper, $columnName) {
        if ($val) {
            $columnSql = "";
            if ("6" == "" . $oper)//部分匹配
            {
                $columnSql = "instr(" . $columnName . ",'" . $val . "')> 0";
                return $columnSql;
            } else if ("7" == "" . $oper)//后缀匹配
            {
                $columnSql = "reverse(" . $columnName . ") like reverse('%" . $val . "')";
                return $columnSql;
            } else if ("8" == "" . $oper)//后缀匹配
            {
                $columnSql = $columnName . " like '" . $val . "%'";
                return $columnSql;
            } else {
                $val_real = self::transColumnVal($val, $connStr, $oper);
                $oper_real = self::getRealOperStr($oper);
                $columnSql = $columnName . " " . $oper_real . " " . $val_real;
                return $columnSql;
            }
        }

        return "";
    }

    private static function transColumnVal($val, $connStr, $oper) {
        $res = $val;
        if ("'" === $connStr || "\\'" === $connStr) {
            /**
             * <option value="0">等于</option>
             * <option value="1">不等于</option>
             * <option value="2">大于</option>
             * <option value="3">小于</option>
             * <option value="4">大于等于</option>
             * <option value="5">小于等于</option>
             * <option value="6">部分匹配</option>
             * <option value="7">前缀匹配</option>
             * <option value="8">后缀匹配</option>
             *
             * **/
            if ("6" === $oper) {

                $res = "%" . $res . "%";
            } else if ("7" === $oper) {
                $res = "%" . $res;
            } else if ("8" === $oper) {
                $res = $res . "%";
            }
            $res = $connStr . $res . $connStr;
            return $res;
        } else {
            return $res;
        }
    }

    private static function getRealOperStr($oper) {
        /**
         * <option value="0">等于</option>
         * <option value="1">不等于</option>
         * <option value="2">大于</option>
         * <option value="3">小于</option>
         * <option value="4">大于等于</option>
         * <option value="5">小于等于</option>
         * <option value="6">部分匹配</option>
         * <option value="7">前缀匹配</option>
         * <option value="8">后缀匹配</option>
         **/
        switch ($oper) {
            case '1':
                return "<>";
            case '2':
                return ">";
            case '3':
                return "<";
            case '4':
                return ">=";
            case '5':
                return "<=";
            case '6':
                return "like";
            case '7':
                return "like";
            case '8':
                return "like";
            default:
                return "=";
        }
    }
}