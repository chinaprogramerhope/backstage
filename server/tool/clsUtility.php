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
        foreach($need as $v) {
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

    public function getUserDBPosByAccount($account) { // todo
        $host = SOCKET_SERVER_IP;
        $port = 9109;

        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'Could not create socket' );
        $conn = socket_connect ( $socket, $host, $port );

        socket_write ( $socket, $account );
        $str = socket_read ( $socket, 1024 ); /* 倒数第二位为库索引，倒数第一位为表索引 */
        socket_close ( $socket );

        // 防止溢出，截取后8位
        $str = substr ( $str, - 8 );
        $str = strrev ( dechex ( $str ) );
        $tb = hexdec ( $str {0} );
        $db = hexdec ( $str {1} );

        $ret = array (
            'useraccount' => $account,
            'dbindex' => $db,
            'tableindex' => $tb
        );
        return $ret;
    }
}