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
        $dbName = 'db_smc';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $param['parentId'] = isset($param['parentId']) ? $param['parentId'] : 0;

        $sql = 'select id, account, channel_name as channelName, agent_balance as agentBalance, balance,';
        $sql .= ' status, last_login_time as lastLoginTime, last_login_ip as lastLoginIp, level';
        $sql .= ' from smc_tg_account';
        $sql .= ' where parent_id = :parentId';
        $sql .= ' order by id';
        $sql .= ' limit ' . maxQueryNum;

        try {
            $stmt = $pdo->prepare($sql);
            $pdoParam = [
                ':parentId' => $param['parentId']
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as $row) {
                if ($row['level'] > 1) {
                    $pre = '|----';
                    for ($i = 1; $i < $row['level']; $i++) {
                        $pre .= '----';
                    }
                    $row['account'] = $pre . $row['account'];
                }
                $row['account'] = ' (' . $row['level'] . '级)';
                unset($row['level']);

                $data[] = $row;

                $param['parentId'] = $row['id'];
                self::promotionAccountGet($param, $data); // todo
            }
        }

        return ERR_OK;
    }

    /**
     * 推广账号 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountAdd($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广账号 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountEdit($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广账号 - 获取操作日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountOperationLogGet($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广账号 - 获取收入统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionAccountIncomeGet($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广信用金日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionBalanceLogGet($param, &$data) {
        $dbName = 'db_smc';
        $pdo = clsMysql::getInstance($dbName);
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
        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);

        $agentAccount = isset($param['agentAccount']) && !empty($param['agentAccount']) ? $param['agentAccount'] : '';
        $userId = isset($param['userId']) && !empty($param['userId']) ? $param['userId'] : '';
        $logType = isset($param['logType']) && !empty($param['logType']) ? $param['logType'] : -1;

        $sql = 'select add_time as addTime, agent_account as agentAccount, money, data_type as dataType,';
        $sql .= ' agentbalanace_before as agentbalanaceBefore, userid as userId, content';
        $sql .= ' from smc_tg_agent_balance_log';
        $sql .= ' where add_time >= :tsBegin and add_time <= :tsEnd';

        $pdoParam = [
            ':tsBegin' => $tsBegin,
            ':tsEnd' => $tsEnd,
        ];

        if (!empty($agentAccount)) {
            $sql .= ' and agent_account like :agent_account';
            $pdoParam[':agent_account'] = '%' . $agentAccount . '%';
        }
        if (!empty($userId)) {
            $sql .= ' and userid like :userid';
            $pdoParam[':userId'] = '%' . $userId . '%';
        }
        if ($logType !== -1) {
            $sql .= ' and logType like :logType';
            $pdoParam[':logType'] = $logType;
        }
        $sql .= ' order by add_time desc';
        $sql .= ' limit ' . maxQueryNum;

        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['addTime'] = date('Y-m-dn H:i:s', $row['add_time']);
                $row['money'] = number_format($row['money'] / 100, 2, '.', ' ');

                if ($row['dataType'] === 'agent_recharge') {
                    $row['dataType'] = '推广代理充值';
                } else if ($row['dataType'] === 'houtai') {
                    $row['dataType'] = '后台增减信用金';
                }
                $row['agentbalanaceBefore'] = number_format($row['agentbalanaceBefore'] / 100, 2, '.', ' ');
            }
            unset($row);

            $data = $rows;
        }

        return ERR_OK;
    }

    /**
     * 推广统计 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsGet($param, &$data) {
        $dbName = 'db_smc';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select p.id, p.promotion_url as promotionUrl, p.add_time as addTime, a.account, a.channel_name as channelName';
        $sql .= ' from smc_tg_promotion p left join smc_tg_account a';
        $sql .= ' on a.id = p.tg_account_id';
        $sql .= ' order by p.id';
        $sql .= ' limit ' . maxQueryNum;

        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage()
                . ', sql = ' . $sql);
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['tgUrl'] = 'http://tuiguang.yuming.com/download/app/' . $row ['id'];
            }
            unset($row);

            $data = $rows;
        }

        return ERR_OK;
    }

    /**
     * 推广统计 - 统计
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneGet($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广统计 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionStatisticsOneQuery($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广ID修正 - 修正推广链id - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetId($param, &$data) {
        $userId = intval($param['userId']);

        $retTmp = [];
        try {
            // 1. proid_smc_user
            $dbName = 'db_smc';
            $pdo = clsMysql::getInstance($dbName);
            if (null === $pdo) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
                return ERR_MYSQL_CONNECT_FAIL;
            }

            $sql = 'select promotion_id from smc_user where user_id = :userId limit 1';
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
            $row = $stmt->fetch();
            if (!empty($row)) {
                $retTmp['proid_1'] = intval($row['promotion_id']);
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', find empty in smc_user, userId = ' . $userId);
                return ERR_OK;
            }

            // 2. proid_user_channel
            $dbName = 'casinogamehisdb';
            $pdo = clsMysql::getInstance($dbName);
            if (null === $pdo) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
                return ERR_MYSQL_CONNECT_FAIL;
            }

            $sql = 'select promotion_id, channel_id from casinouserchannel where user_id = :userId limit 1';
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
            $row = $stmt->fetch();
            if (!empty($row)) {
                $retTmp['proid_2'] = $row['promotion_id'];
                $retTmp['channel_id'] = $row['channel_id'];
            } else {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', find empty in casinouserchannel, userId = ' . $userId);

                $channelid_tmp = 0;
                $flagAdd = self::addChannelRecord($userId, $channelid_tmp, intval($retTmp['proid_1']));
                if (!$flagAdd) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', error add userId in casinouserchannel, userId = ' . $userId);
                    return ERR_MYSQL_EXECUTE_FAIL;
                } else {
                    $retTmp['proid_2'] = $retTmp['proid_1'];
                    $retTmp['channel_id'] = $channelid_tmp;
                }
            }

            // 3. proid_casino_user todo
//            $this->load->model ( 'detail_model' );
//            $ttt = $this->detail_model->get_index ( $user_id );
//            if(!$ttt||intval($ttt["dbx"])<0||intval($ttt["pos"])<0||intval($ttt["dbx"])>15||intval($ttt["pos"])>15){
//                $this->writeLog("no db index and pos $user_id");
//                return null;
//            }
//            $dbx1 = $ttt["dbx"];
//            $posx1  = $ttt["pos"];
//            $db_casino = $this->load->database ( 'eus'.$dbx1, true );
//            $db_casino->select ( 'promotion_id' );
//            $db_casino->from ( 'CASINOUSER_'.$posx1 );
//            $db_casino->where ( 'id', $user_id );
//            $query = $db_casino->get ();
//            $db_casino->close ();
//            if ($query->num_rows () > 0) {
//                $data['proid_3'] = $query->row ()->promotion_id;
//            }else{
//                $this->writeLog("no casinouser:$user_id CASINOUSERDB_$dbx1,CASINOUSER_$posx1");
//                return null;
//            }

            $data = $retTmp;
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        return ERR_OK;
    }

    /**
     * 推广ID修正 - 修正推广链id - 提交
     * todo tgCorrection.php -> ajaxCorrectionPromotion
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionUpdate($param, &$data) {
        $dbName = 'casinostatdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select date, recharge_chips as rechargeChips, cash_chips as cashChips, choushui_chips as choushuiChips,';
        $sql .= '  register_chips as registerChips, bind_phone_chips as bindPhoneChips, change_chips as changeChips';
        $sql .= ' from casinoreconciliation';
        $sql .= ' order by listorder desc limit 5';

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
     * 推广ID修正 - 获取修正日志
     * @param $param
     * @param $data
     * @return int
     */
    public static function promotionCorrectionGetLog($param, &$data) {
        $dbName = 'db_smc';
        $pdo = clsMysql::getInstance($dbName);
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

        $userId = isset($param['userId']) && !empty($param['userId']) ? $param['userId'] : '';
        $adminName = isset($param['adminName']) && !empty($param['adminName']) ? $param['adminName'] : '';
        $promotionOld = isset($param['promotionOld']) && !empty($param['promotionOld']) ? $param['promotionOld'] : '';
        $promotionNew = isset($param['promotionNew']) && !empty($param['promotionNew']) ? $param['promotionNew'] : '';

        $pdoParam = [];

        $sql = 'select user_id as userId, promotion_id as promotionId, correction_time as correctionTime,';
        $sql .= ' admin_name as adminName, correction_ip as correctionIp, promotion_old as promotionOld,';
        $sql .= ' promotion_new as promotionNew, flag, discribe';
        $sql .= ' from smc_tg_correction_log';
        $sql .= ' where correction_time >= :dateBegin and correction_time <= :dateEnd';

        $pdoParam[':dateBegin'] = $dateBegin;
        $pdoParam['dateEnd'] = $dateEnd;

        if (!empty($userId)) {
            $sql .= ' and user_id like :userId';
            $pdoParam[':userId'] = '%' . $userId . '%';
        }
        if (!empty($adminName)) {
            $sql .= ' and admin_name like :adminName';
            $pdoParam[':adminName'] = '%' . $adminName . '%';
        }
        if (!empty($promotionOld)) {
            $sql .= ' and promotion_old like :promotionOld';
            $pdoParam[':promotionOld'] = '%' . $promotionOld . '%';
        }
        if (!empty($promotionNew)) {
            $sql .= ' and promotion_new like :promotionNew';
            $pdoParam[':promotionNew'] = '%' . $promotionNew . '%';
        }

        $sql .= ' order by id desc';
        $sql .= ' limit ' . maxQueryNum;

        try {
            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                    . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                $row['flag'] = $row['flag'] ? '成功' : '失败';
            }
            unset($row);

            $data = $rows;
        }

        return ERR_OK;
    }

    /**
     * @param $userId
     * @param $channelId
     * @param int $promotionId
     * @return bool
     */
    private static function addChannelRecord($userId, &$channelId, $promotionId = 0) {
        for ($datefix = 0; $datefix < 7; $datefix++) {
            $data = self::doQueryChannelFromRegisTab($userId, $datefix);
            if (!empty($data) && array_key_exists('channelid', $data)) {
                $channelId = intval($data['channelid']);
                $flag = self::doAddChannelRecord($userId, $channelId, $promotionId);
                return $flag;
            }
        }
        return false;
    }

    /**
     * @param $user_id
     * @param int $datefix
     * @return array
     */
    private static function doQueryChannelFromRegisTab($user_id, $datefix = 0) {
        $finalRet = [];

        $tabFrom = 'casinoregisterhistory' . date('Ymd');
        if ($datefix > 0) {
            $tabFrom = 'casinoregisterhistory' . date('Ymd', strtotime("-$datefix day"));
        }

        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', getChannelFromRegisTab, table = ' . $tabFrom);

        $dbName = 'casinogamehisdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return [];
        }

        $sql = 'select channelid from ' . $tabFrom . ' where user_id = :userId';
        $pdoParam = [
            ':userId' => $user_id
        ];

        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($pdoParam);
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                . ', pdoParam = ' . json_encode($pdoParam));
            return [];
        }
        $row = $stmt->fetch();
        if (!empty($row)) {
            $finalRet ['channelid'] = $row['channelid'];
            return $finalRet;
        } else {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', no registeruser in ' . $tabFrom . ', userId = ' . $user_id);
            return [];
        }
    }

    /**
     * @param $user_id
     * @param $channelid
     * @param int $promotion_id
     * @return bool
     */
    private static function doAddChannelRecord($user_id, $channelid, $promotion_id = 0) {
        $dbName = 'casinogamehisdb';
        $pdo = clsMysql::getInstance($dbName);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return false;
        }

        $sql = 'insert into casinouserchannel (user_id, channel_id, promotion_id) values (:user_id, :channel_id, :promotion_id)';
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql);
            return false;
        }

        return true;
    }
}