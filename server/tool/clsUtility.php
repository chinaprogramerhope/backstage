<?php

/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-8
 * Time: 上午10:55
 *
 * 常用工具
 */
class clsUtility {
    /**
     * 是否包含所需参数
     * @param array $need - 所需参数
     * @param array $param - 实际传参
     * @return bool
     */
    public static function checkParamExist(array $need, array $param) {
        foreach ($need as $v) {
            if (!isset($param[$v])) {
                return false;
            }
        }

        return true;
    }

    public static function toClient($code, $data = []) {
        if (!is_int($code)) {

        }
        if (!is_array($data)) {

        }
    }

    /**
     * 检查表是否存在
     * @param $pdo
     * @param $tableName
     * @return bool
     */
    public static function checkTableExist(&$pdo, $tableName) {
        try {
            $sql = "select table_name from information_schema.tables where table_name=:tableName";
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute([
                ':tableName' => $tableName
            ]);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdo = ' . json_encode($pdo));
                return false;
            }

            $row = $stmt->fetch();
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        // test
        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', sql = ' . $sql . ', tableName = ' . $tableName
            . ', row = ' . json_encode($row));

        if (empty($row) || empty($row['table_name'])) {
            return false;
        }

        return true;
    }

    public static function getUserDBPos($userId) {
        $tmp = $userId & 0x00000000000000FF;

        $dbIndex = ($tmp & 0xF0) >> 4;
        $dbName = 'casinouserdb_' . $dbIndex;

        $tableIndex = $tmp & 0x0F;

        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select dbindex, tableindex';
        $sql .= ' from casinouser2account_' . $tableIndex;
        $sql .= ' where userid = :userId';
        $sql .= ' limit 1';

        try {
            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':userId' => $userId
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }

            $row = $stmt->fetch();
            if (!empty($row)) {
                return $row;
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return [];
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }
    }

//    public function getUserDBPosByAccount($account) { // todo
//        $host = SOCKET_SERVER_IP;
//        $port = 9109;
//
//        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'Could not create socket' );
//        $conn = socket_connect ( $socket, $host, $port );
//
//        socket_write ( $socket, $account );
//        $str = socket_read ( $socket, 1024 ); /* 倒数第二位为库索引，倒数第一位为表索引 */
//        socket_close ( $socket );
//
//        // 防止溢出，截取后8位
//        $str = substr ( $str, - 8 );
//        $str = strrev ( dechex ( $str ) );
//        $tb = hexdec ( $str {0} );
//        $db = hexdec ( $str {1} );
//
//        $ret = array (
//            'useraccount' => $account,
//            'dbindex' => $db,
//            'tableindex' => $tb
//        );
//        return $ret;
//    }

    /**
     * 判断表中是否存在某字段
     * @param $columnName
     * @param $tableName
     * @return bool
     */
    public static function checkColumnExist($columnName, $tableName, &$pdo) {
        $sql = 'desc ' . $tableName . ' ' . $columnName;
        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $row = $stmt->fetch();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql);
            return false;
        }
        if (empty($row)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql);
            return false;
        }

        return true;
    }

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
        $ip = self::cutStr($dsn, 'host=', ';charset');

        $dbName = 'casinouserdb_' . $dbIndex;
        $dsn = mysqlConfig[$dbName]['dsn'];
        $ip = self::cutStr($dsn, 'host=', ';charset');

        $finalRet = [
            'databases' => 'casinouserdb_' . $dbIndex . '.casinouser2account_' . $tableIndex,
            'databasescoff' => 'casinouserdb_' . $dbIndex . '.casinouserbaggageinfo_' . $tableIndex,
            'ip' => $ip,
            'ipcoff' => $ip
        ];

        return $finalRet;
    }

    /**
     * 截取指定两个字符之间字符串，默认字符集为utf-8
     * @param $str - 原始的字符串
     * @param $beginStr - 开始字符串
     * @param $endStr - 结束字符串
     * @return string
     */
    public static function cutStr($str, $beginStr, $endStr) {
        $posBegin = strpos($str, $beginStr) + strlen($beginStr);
        $posEnd = strpos($str, $endStr) - $posBegin;

        return substr($str, $posBegin, $posEnd);
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
}