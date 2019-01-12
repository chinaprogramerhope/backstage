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
                    $row['rechargeTotal'] = number_format($row['rechargeTotal'], 2, '.', ' ');
                    $row['withdrawalsTotal'] = number_format($row['withdrawalsTotal'], 2, '.', ' ');
                    $row['withdrawalsGiveTotal'] = number_format($row['withdrawalsGiveTotal'], 2, '.', ' ');
                    $row['withdrawalsPoundageTotal'] = number_format($row['withdrawalsPoundageTotal'], 2, '.', ' ');
                    $row['pumpTotal'] = number_format($row['pumpTotal'], 2, '.', ' ');
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
            $row['rechargeTotal'] = number_format($row['rechargeTotal'], 2, '.', ' ');
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

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);

        // 第一个库
        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $tmpArr = [];
        try {
            // 总提现
            $sql = 'select sum(cash_money) / 100 as cm, sum(real_cash_money) / 100 as rcm, sum(alirealtransfer) / 100 as art, sum(alifee) / 100 as af';
            $sql .= ' from smc_cash_order where status = :status';
            $sql .= ' and alifee != :alifee and update_time >= :tsBegin and update_time <= :tsEnd';
            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':status' => cashOrderStatusSuccess,
                ':alifee' => 0,
                ':tsBegin' => $tsBegin,
                ':tsEnd' => $tsEnd
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $row = $stmt->fetch();
            if (!empty($row)) {
                $tmpArr = $row;
                $tmpArr['fee'] = $tmpArr['cm'] - $tmpArr['rcm'];
            }

            // 人工处理的提现总额
            $sql = 'select sum(cash_money) / 100 as cm, sum(real_cash_money) / 100 as rcm';
            $sql .= ' from smc_cash_order where status = :status';
            $sql .= ' and alifee = :alifee and update_time >= :tsBegin and update_time <= :tsEnd';
            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':status' => cashOrderStatusSuccess,
                ':alifee' => 0,
                ':tsBegin' => $tsBegin,
                ':tsEnd' => $tsEnd
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $row = $stmt->fetch();
            if (!empty($row)) {
                $tmpArr['man'] = $row['cm'];
                $tmpArr['manfee'] = $row['cm'] - $row['rcm'];
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        $data = [ // todo 第一个库和第二个库数据相加  我们现在只有一个库吧 phphoutai withdrawalTotal.php
            'cmTotal' => number_format($tmpArr['cm'] + $tmpArr['man'], 2, '.', ' '), // 总提现(平台)
            'feeTotal' => number_format($tmpArr['fee'] + $tmpArr['manfee'], 2, '.', ' '), // 总手续费(平台)
            'man' => number_format($tmpArr['man'], 2, '.', ' '), // 手动处理的金额
            'cm' => number_format($tmpArr['cm'], 2, '.', ' '), // 自动处理的金额

            'fee' => number_format($tmpArr['fee'], 2, '.', ' '), // 自动处理手续费(平台)
            'autoMinus' => number_format($tmpArr['cm'] - $tmpArr['fee'], 2, '.', ' '), // 自动金额 减 手续费(平台)
            'art' => number_format($tmpArr['art'], 2, '.', ' '), // 支付宝总提现
            'af' => number_format($tmpArr['af'], 2, '.', ' '), // 支付宝总手续费
            'cashMinus' => number_format($tmpArr['art'] - $tmpArr['af'], 2, '.', ' ') // 提现金额 减 手续费(支付宝)
        ];

        return ERR_OK;
    }


    /**
     * 运营统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function financeReportGet($param, &$data) {
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

        $pdo = clsMysql::getInstance(mysqlConfig['casinostatdb']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $data = [
            'channelName' => '全部',
            'totalPay' => self::getTotalPay($pdo, -1, $dateBegin, $dateEnd),
            'totalCash' => self::getTotalCash($pdo, -1, $dateBegin, $dateEnd),
            'totalCashChoushui' => self::getTotalCashChoushui($pdo, -1, $dateBegin, $dateEnd),
            'totalChoushui' => self::getTotalChoushui($pdo, -1, $dateBegin, $dateEnd),

            'totalCashNum' => self::getCashNum($dateBegin, $dateEnd),
        ];

        return ERR_OK;
    }

    /**
     * 对账统计 - 获取 (获取最近5条数据, 依据原后台)
     * @param $param
     * @param $data
     * @return int
     */
    public static function reconciliationReportGet($param, &$data) {
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

            $data = $rows;
        }

        return ERR_OK;
    }

    /**
     * 代付账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

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
        $paramPdo = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];

        $bankcardNo = isset($param['bankcardNo']) && !empty($param['bankcardNo']) ? trim($param['bankcardNo']) : '';
        $bankBranch = isset($param['bankBranch']) && !empty($param['bankBranch']) ? trim($param['bankBranch']) : '';
        $cardholderName = isset($param['cardholderName']) && !empty($param['cardholderName']) ? trim($param['cardholderName']) : '';
        $cardholderMobile = isset($param['cardholderMobile']) && !empty($param['cardholderMobile']) ? trim($param['cardholderMobile']) : '';
        $describe = isset($param['describe']) && !empty($param['describe']) ? trim($param['describe']) : '';

        $sql = 'select id, bankcard_no as bankcardNo, bank_branch as bankBranch, cardholder_name as cardholderName,';
        $sql .= ' cardholder_mobile as cardholderMobile, customer_type as customerType, account_type as accountType,';
        $sql .= ' headquarters_bank_id as headquartersBankId, issue_bank_id as issueBankId, addtime as addTime,';
        $sql .= ' adduser as addUser, status';
        $sql .= ' from smc_task_bankcard';

        $haveWhere = false;
        if (!empty($bankcardNo)) {
            $sql .= ' where bankcard_no like :bankcardNo';

            $haveWhere = true;
            $paramPdo[':bankcardNo'] = '%' . $bankcardNo . '%';
        }

        if (!empty($bankBranch)) {
            if ($haveWhere) {
                $sql = ' and bank_branch like :bankBranch';
            } else {
                $sql .= ' where bank_branch like :bankBranch';
                $haveWhere = true;
            }
            $paramPdo[':bankcardNo'] = '%' . $bankcardNo . '%';
        }

        if (!empty($cardholderName)) {
            if ($haveWhere) {
                $sql = ' and cardholder_name like :cardholderName';
            } else {
                $sql .= ' where cardholder_name like :cardholderName';
                $haveWhere = true;
            }
            $paramPdo[':cardholderName'] = '%' . $cardholderName . '%';
        }

        if (!empty($cardholderMobile)) {
            if ($haveWhere) {
                $sql = ' and cardholder_mobile like :cardholderMobile';
            } else {
                $sql .= ' where cardholder_mobile like :cardholderMobile';
                $haveWhere = true;
            }
            $paramPdo[':cardholderMobile'] = '%' . $cardholderMobile . '%';
        }

        if (!empty($describe)) {
            if ($haveWhere) {
                $sql = ' and describe like :describe';
            } else {
                $sql .= ' where describe like :describe';
                $haveWhere = true;
            }
            $paramPdo[':describe'] = '%' . $describe . '%';
        }

        $sql .= ' limit ' . maxQueryNum;


        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        if (!empty($rows)) {
            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ' . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($paramPdo));
        }

        return ERR_OK;
    }

    /**
     * 代付账号管理 - 创建新账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageCreate($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $addTime = date('Y-m-d H:i:s');
        $addUser = 'hxl'; // todo
        $bankcardNo = $param['bankcardNo'];
        $bankBranch = $param['bankBranch'];

        $cardholderName = $param['cardholderName'];
        $cardholderMobile = $param['cardholderMobile'];
        $describe = isset($param['describe']) && !empty($param['describe']) ? $param['describe'] : '';
        $customerType = $param['customerType'];

        $accountType = $param['accountType'];
        $payPassword = isset($param['payPassword']) && !empty($param['payPassword']) ? $param['payPassword'] : '';
        $headquartersBankId = isset($param['headquartersBankId']) && !empty($param['headquartersBankId']) ? $param['headquartersBankId'] : '';
        $issueBankId = isset($param['issueBankId']) && !empty($param['issueBankId']) ? $param['issueBankId'] : '';

        $status = 'y'; // 状态: y 启用，n 禁用 todo 改为 1和2
        $uuid = md5(uniqid());


        $sql = 'insert into smc_task_bankcard (addtime, adduser, bankcard_no, bank_branch, cardholder_name,';
        $sql .= ' cardholder_mobile, describe, customer_type, account_type, pay_password, headquarters_bank_id,';
        $sql .= ' issue_bank_id, status, uuid) values';
        $sql .= ' (:addtime, :adduser, :bankcard_no, :bank_branch, :cardholder_name,';
        $sql .= ' :cardholder_mobile, :describe, :customer_type, :account_type, :pay_password, :headquarters_bank_id,';
        $sql .= ' :issue_bank_id, :status, :uuid)';
        try {
            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':addtime' => $addTime,
                ':adduser' => $addUser,
                ':bankcard_no' => $bankcardNo,
                ':bank_branch' => $bankBranch,

                ':cardholder_name' => $cardholderName,
                ':cardholder_mobile' => $cardholderMobile,
                ':describe' => $describe,
                ':customer_type' => $customerType,

                ':account_type' => $accountType,
                ':pay_password' => $payPassword,
                ':headquarters_bank_id' => $headquartersBankId,
                ':issue_bank_id' => $issueBankId,

                ':status' => $status,
                ':uuid' => $uuid
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 代付订单管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payOrderManageGet($param, &$data) {
        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

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
        $paramPdo = [
            ':dateBegin' => $dateBegin,
            ':dateEnd' => $dateEnd
        ];

        $cardId = isset($param['cardId']) && !empty($param['cardId']) ? trim($param['cardId']) : '';
        $amount = isset($param['amount']) && !empty($param['amount']) ? trim($param['amount']) : '';
        $outTradeNo = isset($param['outTradeNo']) && !empty($param['outTradeNo']) ? trim($param['outTradeNo']) : '';
        $messageNotify = isset($param['messageNotify']) && !empty($param['messageNotify']) ? trim($param['messageNotify']) : '';

        $orderStatus = isset($param['orderStatus']) && !empty($param['orderStatus']) ? trim($param['orderStatus']) : '';
        $payPlatform = isset($param['payPlatform']) && !empty($param['payPlatform']) ? trim($param['payPlatform']) : '';

        $sql = 'select res_code as orderStatus, amount, bankcard_no as bankcardNo, bank_branch as bankBranch,';
        $sql .= ' cardholder_name as cardholderName, cardholder_mobile as cardholderMobile, notify_cardholder as notifyCardholder,';
        $sql .= ' customer_type as customerType, account_type as accountType, headquarters_bank_id as headquartersBankId,';
        $sql .= ' issue_bank_id as issueBankId, pay_platform as payPlatform, addtime as addTime, out_trade_no as outTradeNo,';
        $sql .= ' platform_orderid as platformOrderId, opertime as operTime, res_msg as resMsg';
        $sql .= ' from smc_task_form';

        $sql .= ' where addtime >= :dateBegin and addtime <= :dateEnd';

        if (!empty($cardId)) {
            $sql .= ' and card_id like :cardId';
            $paramPdo[':cardId'] = '%' . $cardId . '%';
        }
        if (!empty($amount)) {
            $sql .= ' and amount like :amount';
            $paramPdo[':amount'] = '%' . $amount . '%';
        }
        if (!empty($outTradeNo)) {
            $sql .= ' and out_trade_no like :outTradeNo';
            $paramPdo[':outTradeNo'] = '%' . $outTradeNo . '%';
        }
        if (!empty($messageNotify)) {
            $sql .= ' and notify_cardholder like :messageNotify';
            $paramPdo[':messageNotify'] = '%' . $messageNotify . '%';
        }
        if (!empty($orderStatus)) {
            $sql .= ' and res_code like :orderStatus';
            $paramPdo[':orderStatus'] = '%' . $orderStatus . '%';
        }
        if (!empty($payPlatform)) {
            $sql .= ' and pay_platform like :payPlatform';
            $paramPdo[':payPlatform'] = '%' . $payPlatform . '%';
        }

        $sql .= ' limit ' . maxQueryNum;


        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $rows = $stmt->fetchAll();
        $payPlatformList = aliPayPay + wxPay + officialAliPayPay;
        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['orderStatus'] = array_key_exists($row['orderStatus'], payOrderStatus) ? payOrderStatus[$row['orderStatus']] : '未知' . $row['orderStatus'];
                $row['payPlatform'] = array_key_exists($row['payPlatform'], $payPlatformList) ? $payPlatformList[$row['payPlatform']] : '未知' . $row['payPlatform'];
            }
            unset($row);

            $data = $rows;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', ' . ', mysql select return empty, sql = ' . $sql
                . ', pdoParam = ' . json_encode($paramPdo));
        }

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

    /**
     * 代付订单管理 - 提现
     * @param $param
     * @param $data
     * @return int
     */
    public static function payAccountManageCashWithdrawal($param, &$data) {
        return ERR_OK;
    }

    public static function getPlatformArr() { // todo

    }

    private static function getTotalPay(&$pdo, $channelId, $dateBegin, $dateEnd) {
        $sql = 'select sum(pay_total_money) as xx';
        $sql .= ' from casinobusinessstatistics';
        $sql .= ' where statistics_date >= ' . $dateBegin . ' and statistics_date <= ' . $dateEnd;
        if ($channelId >= 0) {
            $sql .= ' and channelid = ' . $channelId;
        } else {
            foreach (noChannelList as $k => $v) {
                $sql .= ' and channelid != ' . $k;
            }
        }
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $row = $stmt->fetch();

        $ret = 0.00;
        if (!empty($row)) {
            $ret = number_format($row['xx'] / 100, 2, '.', ' ');
        }

        return $ret;
    }

    private static function getTotalCash(&$pdo, $channelId, $dateBegin, $dateEnd) {
        $sql = 'sum(cash_money+cash_money1) as xx';
        $sql .= ' from casinobusinessstatistics';
        $sql .= ' where statistics_date >= ' . $dateBegin . ' and statistics_date <= ' . $dateEnd;
        if ($channelId >= 0) {
            $sql .= ' and channelid = ' . $channelId;
        } else {
            foreach (noChannelList as $k => $v) {
                $sql .= ' and channelid != ' . $k;
            }
        }
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $row = $stmt->fetch();

        $ret = 0.00;
        if (!empty($row)) {
            $ret = number_format($row['xx'] / 100, 2, '.', ' ');
        }

        return $ret;
    }

    private static function getTotalCashChoushui(&$pdo, $channelId, $dateBegin, $dateEnd) {
        $sql = 'sum(choushui_money+choushui_money1) as xx';
        $sql .= ' from casinobusinessstatistics';
        $sql .= ' where statistics_date >= ' . $dateBegin . ' and statistics_date <= ' . $dateEnd;
        if ($channelId >= 0) {
            $sql .= ' and channelid = ' . $channelId;
        } else {
            foreach (noChannelList as $k => $v) {
                $sql .= ' and channelid != ' . $k;
            }
        }
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $row = $stmt->fetch();

        $ret = 0.00;
        if (!empty($row)) {
            $ret = number_format($row['xx'] / 100, 2, '.', ' ');
        }

        return $ret;
    }

    private static function getTotalChoushui(&$pdo, $channelId, $dateBegin, $dateEnd) {
        $sql = 'sum(ddz_choushui+huanle_ddz_choushui+laizi_ddz_choushui+zjh_choushui+niuniu_choushui+qiangzhuang_niuniu_choushui+buyu_choushui+fruit_money+bao_money+fruit_compare_money+zjh_bairen_choushui+lhp_choushui+malai_niuniu_choushui+sangong_choushui+hongheidz_choushui) as xx';
        $sql .= ' from casinobusinessstatistics';
        $sql .= ' where statistics_date >= ' . $dateBegin . ' and statistics_date <= ' . $dateEnd;
        if ($channelId >= 0) {
            $sql .= ' and channelid = ' . $channelId;
        } else {
            foreach (noChannelList as $k => $v) {
                $sql .= ' and channelid != ' . $k;
            }
        }
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $row = $stmt->fetch();

        $ret = 0.00;
        if (!empty($row)) {
            $ret = number_format($row['xx'] / 100, 2, '.', ' ');
        }

        return $ret;
    }

    private static function getCashNum($dateBegin, $dateEnd) {
        $pdo = clsMysql::getInstance(mysqlConfig['db_smc']); // todo 库1和库2相加; count(*)是否可以, 之前后台不是这样计算
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select count(*) as xx';
        $sql .= ' from smc_cash_order';
        $sql .= ' where add_time >= ' . $dateBegin . ' and add_time <= ' . $dateEnd;
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return ERR_MYSQL_EXECUTE_FAIL;
        }
        $num = $stmt->fetchColumn(); // todo

        $ret = empty($num) ? 0 : intval($num);

        return $ret;
    }
}