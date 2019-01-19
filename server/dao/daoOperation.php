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
}