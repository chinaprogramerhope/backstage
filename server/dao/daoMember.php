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
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = '';

        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);

            $data = $rows;
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
        return ERR_OK;
    }

    /**
     * 获取标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLabel($param, &$data) {
        return ERR_OK;
    }

    /**
     * 添加标签
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLabel($param, &$data) {
        return ERR_OK;
    }

    /**
     * 获取等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function getLv($param, &$data) {
        return ERR_OK;
    }

    /**
     * 新增等级
     * @param $param
     * @param $data
     * @return int
     */
    public static function addLv($param, &$data) {
        return ERR_OK;
    }
}