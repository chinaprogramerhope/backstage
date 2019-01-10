<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 财务管理
 */
class daoFinance {
    /**
     * 人工存提
     * @param $param
     * @param $data
     * @return int
     */
    public static function manualOperate($param, &$data) {
        return ERR_OK;
    }

    /**
     * 官方支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function officialChargeGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 线上支付 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function onlinePayGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 支付宝出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayAuditGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 银行卡出款审核 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bankCardAuditGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 自动出款交易记录
     * @param $param
     * @param $data
     * @return int
     */
    public static function autoPayTradeRecordGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 出入款配置
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeConfig($param, &$data) {
        return ERR_OK;
    }

    /**
     * 财务统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsGet($param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];
        } else {
            $dateBegin = $dateEnd = -1;
        }

        if ($dateBegin === -1) { // 默认获取最近30天
            $tomorrowTs = strtotime(date('Ymd')) + daySeconds;
            $monthAgoTs = $tomorrowTs - monthSeconds;

            $dateBegin = date('Ymd', $monthAgoTs);
            $dateEnd = date('Ymd', $tomorrowTs);
        }

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];
        try {
            // 充值总额rechargeTotal, 提现总额withdrawalsTotal, 提现赠送总额withdrawalsGiveTotal, 提现手续费总额withdrawalsPoundageTotal, 抽水总额pumpTotal
            $sql = 'select
                channelid,
                sum(pay_total_money)/100 as rechargeTotal,
                sum(cash_money+cash_money1)/100 as withdrawalsTotal,
                sum(cash_send_money+cash_send_money1)/100 as withdrawalsGiveTotal,
                sum(choushui_money+choushui_money1)/100 as withdrawalsPoundageTotal,
                sum(ddz_choushui+huanle_ddz_choushui+laizi_ddz_choushui+zjh_choushui+niuniu_choushui+qiangzhuang_niuniu_choushui+buyu_choushui+fruit_money+bao_money+fruit_compare_money+zjh_bairen_choushui+lhp_choushui+malai_niuniu_choushui+sangong_choushui+hongheidz_choushui)/100 as pumpTotal
                from casinobusinessstatistics
                where statistics_date >= :dateBegin and statistics_date <= :dateEnd
                group by chahnelid
                ';

            $sql .= ' limit ' . maxQueryNum;

            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                foreach ($rows as &$row) {
                    $row['channelName'] = array_key_exists($row['channelid'], channelList) ? channelList[$row['channelid']] : '未知渠道' . $row['channelid'];
                    $row['rechargeTotal'] = number_format($row['rechargeTotal'], 2, '.', '');
                    $row['withdrawalsTotal'] = number_format($row['withdrawalsTotal'], 2, '.', '');
                    $row['withdrawalsGiveTotal'] = number_format($row['withdrawalsGiveTotal'], 2, '.', '');
                    $row['withdrawalsPoundageTotal'] = number_format($row['withdrawalsPoundageTotal'], 2, '.', '');
                    $row['pumpTotal'] = number_format($row['pumpTotal'], 2, '.', '');
                    unset($row['channelid']);
                }
                unset($row);

                $data = $rows;
            }
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', param = ' . json_encode($param));
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 财务统计 - 更新昨日充值数据
     * @param $param
     * @param $data
     * @return int
     */
    public static function finStatisticsUpdate($param, &$data) {
        /**
         * 更新昨日充值数据
         */
        $step = 1; // 昨日数据

        $tableFrom = 'smc_order';
        $tableTo = 'casinopaytotalstatistics';

        $dateYesterday = date('Ymd', time() - daySeconds);
        $dateToday = date('Ymd');

        $pdoSmc = clsMysql::getInstance(mysqlConfig['db_smc']);
        if ($pdoSmc === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['db_smc']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoCasinostatdb = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if ($pdoCasinostatdb === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['casinostatdb']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        // 删除$tableTo中的昨日数据
        $sql1 = 'delete from ' . $tableTo . ' where statistics_date = :dateYesterday';
        $stmt1 = $pdoCasinostatdb->prepare($sql1);
        $pdoParam1 = [
            ':dateYesterday' => $dateYesterday
        ];
        $ret1 = $stmt1->execute($pdoParam1);
        if (!$ret1) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql1 = ' . $sql1 . ', pdoParam1 = ' . json_encode($pdoParam1));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        $tsBegin = strtotime(date('Y-m-d', time() - 3600 * 24 * ($step + 1)));
        $tsEnd = strtotime(date('Y-m-d', time() - 3600 * 24 * ($step - 1)));
        $sql2 = "SELECT GROUP_CONCAT(DISTINCT channel_id) channels,GROUP_CONCAT(DISTINCT  pay_platform) platforms from $tableFrom where (add_time>=$tsBegin and add_time<=$tsEnd) or (pay_success_time>=$tsBegin and pay_success_time<=$tsEnd)";
        $stmt2 = $pdoSmc->prepare($sql2);
        $ret2 = $stmt2->execute();
        if (!$ret2) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql2 = ' . $sql2);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows2 = $stmt2->fetchAll();

        $dbChannels = [];
        $dbPlatforms = [];
        if (!empty($rows2) || !empty($rows2[0])) {
            if ($rows2[0]['channels']) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', channels = ' . $rows2[0]['channels']);
                $dbChannels = explode(',', $rows2[0]['channels']);
            }
            if ($rows2[0]['platforms']) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', platforms = ' . $rows2[0]['platforms']);
                $dbPlatforms = explode(',', $rows2[0]['platforms']);
            }
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', payforms empty, sql2 = ' . $sql2);
            return ERR_OK;
        }

        // 补全$dbChannels
        foreach (channelList as $channelId => $v) {
            if (! in_array($channelId, $dbChannels)) {
                $dbChannels[] = $channelId;
            }
        }

        $tsBegin = strtotime($dateYesterday);
        $tsEnd = strtotime($dateToday);
        foreach ($dbChannels as $channelId) {
            $payTotalChannel = 0;
            foreach ($dbPlatforms as $payPlatformId) {
                $totalMoney = 0;
                $payUserCount = 0;
                $payTotalNum = 0;

                $timeField = array_key_exists($payPlatformId, payPlatform) ? payPlatform[$payPlatformId] : 'pay_success_time'; // 默认到账时间
                $timeDelay = array_key_exists($payPlatformId, payTimeDelay) ? payTimeDelay[$payPlatformId] : 0;

                $tsBegin += $timeDelay;
                $tsEnd += $timeDelay;
                $sql3 = "SELECT SUM(money) AS total_money,count(distinct(user_id)) AS pay_user_count,count(id) AS pay_total_num FROM $tableFrom WHERE status=1  and pay_platform=$payPlatformId and channel_id=$channelId and $timeField>=$tsBegin and $timeField<$tsEnd";
                $stmt3 = $pdoSmc->prepare($sql3);
                $ret3 = $stmt3->execute();
                if (!$ret3) {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql3 = ' . $sql3);
                    continue;
                }
                $rows3 = $stmt3->fetchAll();
                if (!empty($rows3)) {
                    $totalMoney = $rows3[0] && $rows3[0]['total_money'] ? intval($rows3[0]['total_money']) : 0;
                    $payUserCount = $rows3[0] && $rows3[0]['pay_user_count'] ? intval($rows3[0]['pay_user_count']) : 0;
                    $payTotalNum = $rows3[0] && $rows3[0]['pay_total_num'] ? intval($rows3[0]['pay_total_num']) : 0;
                }

                $sql4 = "insert into $tableTo (`statistics_date`,`channelid`,`pay_platform`,`pay_user_count`,`pay_total_money`,`pay_total_num`,`stat_standard`) 
                      values ('$dateYesterday',$channelId,$payPlatformId,$payUserCount,$totalMoney,$payTotalNum,'$timeField')";
                $stmt4 = $pdoCasinostatdb->prepare($sql4);
                $ret4 = $stmt4->execute();
                if (!$ret4) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql4 = ' . $sql4);
                    continue;
                }
                $payTotalChannel += $totalMoney;
            }

            $sql5 = " update casinobusinessstatistics set pay_total_money=$payTotalChannel where channelid=$channelId and statistics_date='$dateYesterday' ";
            $stmt5 = $pdoCasinostatdb->prepare($sql5);
            $ret5 = $stmt5->execute();
            if (!$ret5) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql5 = ' . $ret5);
                continue;
            }
        }

        /**
         * 获取昨日数据
         */
        $param = [
            'dateRange' => [
                $dateYesterday,
                $dateYesterday
            ]
        ];
        $ret = daoFinance::finStatisticsGet($param, $data);
        if ($ret !== ERR_OK) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', daoFinance::finStatisticsGet fail, errCode = ' . $ret);
            return $ret;
        }

        return ERR_OK;
    }

    /**
     * 支付统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payStatisticsGet($param, &$data) {
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];
        } else {
            $dateBegin = $dateEnd = -1;
        }

        if ($dateBegin === -1) { // 默认获取最近30天
            $tomorrowTs = strtotime(date('Ymd')) + daySeconds;
            $monthAgoTs = $tomorrowTs - monthSeconds;

            $dateBegin = date('Ymd', $monthAgoTs);
            $dateEnd = date('Ymd', $tomorrowTs);
        }

        $channelId = intval($param['channelId']);
        $payType = $param['payType'];

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime();

        $platFormArr = [];
        $ret = self::getPlatformArr($dateBegin, $dateEnd, $channelId, $payType, $platFormArr); // todo
        if ($ret !== ERR_OK) {
            clsLog::error(__METHOD__ . ', self::getPlatformArr fail, param = ' . json_encode($param)
                . ', errCode = ' . $ret);
            return $ret;
        }
        if (empty($platFormArr)) {
            clsLog::info(__METHOD__ . ', self::getPlatformArr return empty, param = ' . json_encode($param));
            return ERR_OK;
        }

        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = '';

        $sqlFrag = 'select pay_platform,SUM(money/100) as rechargeTotal from smc_order where status = 1';
        if (!empty($channelId)) {
            $sqlFrag .= ' and channel_id = ' . $channelId;
        }
        if (!empty($payType)) {
            $sqlFrag .= ' and pay_type = ' . $payType;
        }

        foreach ($platFormArr as $platFormId) {
            $timeField = array_key_exists($platFormId, payPlatform) ? payPlatform[$platFormId] : 'pay_success_time'; // 默认到账时间
            $timeDelay = !empty(payTimeDelay) && !empty(payTimeDelay[$platFormId]) ? $platFormId[$platFormId] : 0;

            $tsBegin += $timeDelay;
            $tsEnd += $timeDelay;

            $sql .= $sqlFrag;
            $sql .= ' and pay_platform = ' . $platFormId . ' and ' . $timeField . ' >= ' . $tsBegin . ' and ' . $timeField . ' <= ' . $tsEnd;
            $sql .= ' union all ';
        }
        $sql = rtrim($sql, ' union all ');
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        $rows = $stmt->fetchAll();
        if (empty($rows)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sql = ' . $sql);
            return ERR_OK;
        }

        // 查询成功率, 即status为1的订单除以总数
        $sqlAll = 'select count(*) as num, pay_platform from smc_order group by pay_platform';
        $stmtAll = $pdo->prepare($sqlAll);
        $retAll = $stmtAll->execute();
        if (!$retAll) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sqlAll = ' . $sqlAll);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rowsAll = $stmtAll->fetchAll();
        if (empty($rowsAll)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sqlAll = ' . $sqlAll);
            return ERR_OK;
        }
        $allArr = [];
        foreach ($rowsAll as $row) {
            $allArr[$row['pay_platform']] = $row['num'];
        }

        $sqlSuccess = 'select count(*) as num, pay_platform where status = 1 from smc_order group by pay_platform';
        $stmtSuccess = $pdo->prepare($sqlSuccess);
        $retSuccess = $stmtAll->execute();
        if (!$retSuccess) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sqlSuccess = ' . $sqlSuccess);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rowsSuccess = $stmtSuccess->fetchAll();
        if (empty($rowsSuccess)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', mysql select return empty, sqlSuccess = ' . $sqlSuccess);
            return ERR_OK;
        }
        $successArr = [];
        foreach ($rowsSuccess as $row) {
            $successArr[$row['pay_platform']] = $row['num'];
        }

        foreach ($rows as $k => &$row) {
            $payPlatformId = $row['pay_platform'];

            if (array_key_exists($payPlatformId, $successArr)) {
                $row['paySuccessRate'] = round(($successArr['num'] / $allArr['num']) * 100, 2) . '%';
            } else {
                $row['paySuccessRate'] = '0.00%';
            }

            $row['timeType'] = 'pay_success_time' === payPlatform[$payPlatformId] ? '到账时间' : '创建时间';
        }
        unset($row);

        $data['tableData'] = $rows;
        $data['payPlatformList'] = ownPay + ylPay + jdPay + qqPay + wxPay + aliPayPay + officialAliPayPay;

        return ERR_OK;
    }

    /**
     * 提现总额统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function withdrawalTotalGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 运营统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 对账统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function reconciliationReportGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付账号管理 - 创建新账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageCreate($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付订单管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 代付订单管理 - 更新派支付提款单状态
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageUpdate($param, &$data) {
        return ERR_OK;
    }

    public static function getPlatformArr() {

    }
}