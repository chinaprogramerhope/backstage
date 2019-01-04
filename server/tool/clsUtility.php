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
}