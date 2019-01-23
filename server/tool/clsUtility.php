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

        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', sql = ' . $sql . ', tableName = ' . $tableName
            . ', row = ' . json_encode($row));

        if (empty($row) || empty($row['table_name'])) {
            return false;
        }

        return true;
    }

    /**
     * 检查表是否存在
     * @param $dbName
     * @param $tableName
     * @return bool
     */
    public static function checkTableExistByName($dbName, $tableName) {
        $pdo = clsMysql::getInstance($dbName);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName);
            return false;
        }

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
     * 获取前缀相同的16个数据库中, 前缀相同的16个表, 的数据 casinouserdb_xx库 casinouser_xx表
     * @param $dbPrefix - 数据库前缀
     * @param $tablePrefix - 表前缀
     * @param $search - 查询内容
     * @param $where - 查询条件
     * @param $pdoParam - inputParam
     * @return array
     */
    public static function getAllData($dbPrefix, $tablePrefix, $search = '*', $where = '', &$pdoParam = []) {
        $finalRet = [];

        for ($i = 0; $i <= 15; $i++) {
            $dbName = $dbPrefix . $i;

            $pdo = clsMysql::getInstance($dbName);
            if (null === $pdo) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
                continue;
            }

            $sql = '';
            for ($j = 0; $j <= 15; $j++) {
                $tableName = $tablePrefix . $j;
                if (!empty($sql)) {
                    $sql .= ' union all ';
                }
                $sql .= 'select ' . $search . ' from ' . $tableName . ' ' . $where;
                $sql .= ' limit ' . maxQueryNumTest; // todo  分页, 不然超级卡
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
                        . ', dbName = ' . $dbName);
                    continue;
                }

                $rows = $stmt->fetchAll();
                if (empty($rows)) {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                        . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
                } else {
                    $finalRet = array_merge($finalRet, $rows);
                }

                clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($rows)
                    . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                    . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                continue;
            }
        }

        return $finalRet;
    }

    /**
     * 获取一个表的数据 - 多行
     * @param $dbName
     * @param $sql
     * @param array $pdoParam
     * @return array
     */
    public static function getRows($dbName, $sql, $pdoParam = []) {
        $finalRet = [];

        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return [];
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
                    . ', dbName = ' . $dbName);
                return [];
            }

            $rows = $stmt->fetchAll();

            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($rows)
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));

            if (empty($rows)) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                    . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
                return [];
            } else {
                $finalRet = $rows;
                return $finalRet;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return [];
        }
    }

    /**
     * 获取一个表的数据 - 一行
     * @param $dbName
     * @param $sql
     * @param array $pdoParam
     * @return array
     */
    public static function getRow($dbName, $sql, $pdoParam = []) {
        $finalRet = [];

        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return [];
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
                    . ', dbName = ' . $dbName);
                return [];
            }

            $row = $stmt->fetch();

            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', dbName = ' . $dbName . ', rows = ' . json_encode($row)
                . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));

            if (empty($row)) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql
                    . ', dbName = ' . $dbName . ', pdoParam = ' . json_encode($pdoParam));
                return [];
            } else {
                $finalRet = $row;
                return $finalRet;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return [];
        }
    }

    /**
     * 更新/插入/删除 表的数据
     * @param $dbName
     * @param $sql
     * @param array $pdoParam
     * @return int
     */
    public static function updateData($dbName, $sql, $pdoParam = []) {
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbName = ' . $dbName);
            return ERR_MYSQL_CONNECT_FAIL;
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
                    . ', dbName = ' . $dbName);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', dbName = ' . $dbName . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 获取格式化日期 - 若开始和结束日期存在, 结束日期加一天; 若开始和结束日期不存在, 返回一个月内的开始和结束日期
     * @param $param
     * @return array
     */
    public static function getFormatDate(&$param) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = date('Y-m-d', strtotime($param['dateRange'][1]) + daySeconds);
        } else {
            $dateBegin = date('Y-m-d', strtotime('last month'));
            $dateEnd = date('Y-m-d', strtotime('+1 day'));
        }

        return [
            'dateBegin' => $dateBegin,
            'dateEnd' => $dateEnd
        ];
    }

    /**
     * 获取格式化日期 - 若开始和结束日期存在, 结束日期加一天; 若开始和结束日期不存在, 返回一个月内的开始和结束日期
     * @param $param
     * @return array
     */
    public static function getFormatDateTime(&$param) {
        if (isset($param['dateTimeRange']) && !empty($param['dateTimeRange'])) {
            $dateTimeBegin = $param['dateTimeRange'][0];
            $dateTimeEnd = date('Y-m-d H:i:s', strtotime($param['dateTimeRange'][1]) + daySeconds);
        } else {
            $dateTimeBegin = date('Y-m-d H:i:s', strtotime('last month'));
            $dateTimeEnd = date('Y-m-d H:i:s', strtotime('+1 day'));
        }

        return [
            'dateTimeBegin' => $dateTimeBegin,
            'dateTimeEnd' => $dateTimeEnd
        ];
    }

    /**
     * 生成orderId - smc_order
     * @param $userId
     * @return string
     */
    public static function generateOrderId($userId) {
        $type = [
            'alpha',
            'alnum',
            'numeric'
        ];

        $orderId = self::randomString($type[array_rand($type)], 6) . time() . $userId . self::randomString($type[array_rand($type)], 4);

        return $orderId;
    }

    private static function randomString($type = 'alnum', $len = 8) {
        switch ($type) {
            case 'basic'    :
                return mt_rand();
                break;
            case 'alnum'    :
            case 'numeric'    :
            case 'nozero'    :
            case 'alpha'    :

                switch ($type) {
                    case 'alpha'    :
                        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum'    :
                        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric'    :
                        $pool = '0123456789';
                        break;
                    case 'nozero'    :
                        $pool = '123456789';
                        break;
                }

                $str = '';
                for ($i = 0; $i < $len; $i++) {
                    $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
                }
                return $str;
                break;
            case 'unique'    :
            case 'md5'        :

                return md5(uniqid(mt_rand()));
                break;
            case 'encrypt'    :
            case 'sha1'    :

                $CI =& get_instance();
                $CI->load->helper('security');

                return do_hash(uniqid(mt_rand(), TRUE), 'sha1');
                break;
        }
    }
}