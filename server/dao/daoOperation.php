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

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 修改成功, param = ' . json_encode($param));

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

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 添加成功');

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
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getRow return empty, dbName = '
                . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_INVALID_PARAM;
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

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', 刷新redis成功');

        return ERR_OK;
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeDel($param, &$data) {
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
}