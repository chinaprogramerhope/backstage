<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 推广管理
 */
class daoPromotion {
    /**
     * 推广玩家 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionUserGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广报表 - 查看(上级/下级)
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionReportView($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广返利 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionRebateGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 新增
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsAdd($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 返利经验设置
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsExpSet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 返利设置 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function rebateSettingsEdit($param, &$data) {
        return ERR_OK;
    }

    /**
     * 站内消息 - 查看收件人
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageViewRecipient($param, &$data) {
        return ERR_OK;
    }

    /**
     * 推广账号 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广账号 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountAdd($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广账号 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountEdit($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广账号 - 获取操作日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountOperationLogGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广账号 - 获取收入统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountIncomeGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广信用金日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionBalanceLogGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广统计 - 统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广统计 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneQuery($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广ID修正 - 获取用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetId($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广ID修正 - 修正用户的推广id
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionUpdate($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }

    /**
     * 推广ID修正 - 获取修正日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetLog($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $addChips = $row ['rechargeChips'] - $row ['cashChips'] - $row ['choushuiChips'] + $row ['registerChips'] + $row ['bindPhoneChips'];

                $row['addChips'] = $addChips;
                $row['minus'] = $row['addChips'] - $row['changeChips'];
            }
            unset($row);
        }

        $data = $rows;

        return ERR_OK;
    }
}