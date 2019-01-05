<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 游戏管理
 */
class daoGame {
    /**
     * 游戏列表 - 获取游戏列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function listGet($param, &$data) {
        $gameName = isset($param['gameName']) ? $param['gameName'] : '';
        $gameType = intval($param['gameType']);
        $gameStatus = intval($param['gameStatus']);

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];

        try {
            $sql = 'select gameName, gameType, gameStatus from admin_game';
            $haveWhere = false;

            if ($gameName !== '') {
                $sql .= ' where gameName like :gameName';
                $pdoParam[':gameName'] = '%' . $gameName . '%';

                $haveWhere = true;
            }
            if ($gameType !== -1) {
                if ($haveWhere) {
                    $sql .= ' and gameType = :gameType';
                } else {
                    $sql .= ' where gameType = :gameType';

                    $haveWhere = true;
                }

                $pdoParam[':gameType'] = $gameType;
            }
            if ($gameStatus !== -1) {
                if ($haveWhere) {
                    $sql .= ' and gameStatus = :gameStatus';
                } else {
                    $sql .= ' where gameStatus = :gameStatus';

                    $haveWhere = true;
                }

                $pdoParam[':gameStatus'] = $gameStatus;
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($pdoParam);
            $rows = $stmt->fetchAll();
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', param = ' . json_encode($param));
            return ERR_MYSQL_EXCEPTION;
        }

        if (!empty($rows)) {
            foreach ($rows as &$row) {
                if (array_key_exists($row['gameType'], gameType)) {
                    $row['gameType'] = gameType[$row['gameType']];
                } else {
                    $row['gameType'] = '未知';
                }

                if (array_key_exists($row['gameStatus'], gameStatus)) {
                    $row['gameStatus'] = gameStatus[$row['gameStatus']];
                } else {
                    $row['gameStatus'] = '未知';
                }
            }
            unset($row);
        }
        $data = !empty($rows) ? $rows : [];

        // test
        clsLog::error('ok91, data = ' . json_encode($data));

        return ERR_OK;
    }

    /**
     * 游戏列表 - 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public static function listChangeStatus($param, &$data) {
        $gameName = $param['gameName'];
        $gameStatus = intval($param['gameStatus']);

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        try {
            $sql = 'update admin_game set gameStatus = :gameStatus where gameName = :gameName';

            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute([
                ':gameName' => $gameName,
                ':gameStatus' => $gameStatus
            ]);
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', name = ' . $gameName . ', status = ' . $gameStatus);
            return ERR_MYSQL_EXCEPTION;
        }

        if (!$ret) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', stmt->execute fail, sql = ' . $sql . ', param = ' . json_encode($param));
            return ERR_MYSQL_EXECUTE_FAIL;
        }

        return ERR_OK;
    }

    /**
     * 游戏列表 - 获取游戏房间
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 游戏列表 - 游戏房间 - 更改税收比例
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomChangeTaxRatio($param, &$data) {
        return ERR_OK;
    }

    /**
     * 游戏列表 - 游戏房间 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomClose($param, &$data) {
        return ERR_OK;
    }

    /**
     * 游戏分组 - 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupGet($param, &$data) {
        $data = gameGroup;
        return ERR_OK;
    }

    /**
     * 游戏分组 - 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupGetGames($param, &$data) {
        $groupId = intval($param['groupId']);

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $sql = 'select gameName from admin_game where groupId=:groupId';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':groupId' => $groupId
        ]);
        $rows = $stmt->fetchAll();
        $data = !empty($rows) ? $rows : [];

        // test
        clsLog::error('data = ' . json_encode($data));

        return ERR_OK;
    }

    /**
     * 游戏分组 - 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupStick($param, &$data) {
        return ERR_OK;
    }

    /**
     * 游戏分组 - 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupCancelPopular($param, &$data) {
        return ERR_OK;
    }

    /**
     * 投注记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function betRecordGet($param, &$data) {
        // test
        clsLog::debug('ok11, param = ' . json_encode($param));
        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $timeBegin = $param['dateRange'][0];
            $timeEnd = $param['dateRange'][1];
        } else {
            $timeBegin = $timeEnd = -1;
        }

        $gameId = isset($param['gameId']) && !empty($param['gameId']) ? intval($param['gameId']) : -1;
        $roomId = isset($param['roomId']) && !empty($param['roomId']) ? $param['roomId'] : -1;
        $userId = isset($param['userId']) && !empty($param['userId']) ? $param['userId'] : -1;

        $pdoParam = [];
        if ($userId !== -1) {
            $pdoParam[':userId'] = $userId;
        }
        if ($timeBegin !== -1) { // 开始时间和结束时间要么不选要么都选
            $pdoParam[':timeBegin'] = $timeBegin;
            $pdoParam[':timeEnd'] = $timeEnd;
        }

        $pdo = clsMysql::getInstance(mysqlConfig['gameHistory']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        // test
        $currentDate = '20190103';
//        $currentDate = date('Ymd');

        $sql = '';

        if ($timeBegin !== -1) {
            for ($i = $timeBegin; )
        } else { // 如果没有选择日期, 默认取最近30天的数据

        }


        if ($gameId === -1) {
            foreach (gameHistoryTables as $k => $tablePrefix) {
                if (!empty($tablePrefix)) { // 表前缀已定义
                    $tableName = $tablePrefix . $currentDate;

                    $gameName = '';
                    if (array_key_exists($k, gameIdName) && !empty(gameIdName[$k])) {
                        $gameName = gameIdName[$k];
                    }

                    if (clsUtility::checkTableExist($pdo, $tableName)) { // 表存在
                        $sql .= 'select user_id as userId, user_nickname as userNickname,';
                        $sql .= ' "' . $gameName . '" as gameName,';
                        $sql .= ' room_id as roomId, game_number as gameNumber, user_game_result as userGameResult,';
                        $sql .= ' user_table_fee as userTableFee, user_score_begin as userScoreBegin,';
                        $sql .= ' user_score_end as userScoreEnd, game_time as gameTime, record_timestamp as recordTimestamp';
                        $sql .= ' from ' . $tableName;

                        $haveWhere = false;

                        if ($roomId !== -1) {
                            $roomIdArr = clsGame::getRoomIdArr($roomId);
                            if (!empty($roomIdArr)) {
                                $in = implode(',', $roomIdArr);
                                $sql .= ' where room_id in (' . $in . ')';
                                $haveWhere = true;
                            }
                        }
                        if ($userId !== -1) {
                            if ($haveWhere) {
                                $sql .= ' and user_id = :userId';
                            } else {
                                $sql .= ' where user_id = :userId';
                                $haveWhere = true;
                            }
                        }
                        if ($timeBegin !== -1) {
                            if ($haveWhere) {
                                $sql .= ' and record_timestamp >= :timeBegin';
                            } else {
                                $sql .= ' where record_timestamp >= :timeBegin';
                                $haveWhere = true;
                            }
                        }
                        if ($timeEnd !== -1) {
                            if ($haveWhere) {
                                $sql .= ' and record_timestamp <= :timeEnd';
                            } else {
                                $sql .= ' where record_timestamp <= :timeEnd';
                                $haveWhere = true;
                            }
                        }

                        $sql .= ' union all ';
                    } else {
                        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not exist');
                    }
                } else {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not define');
                }
            }
            $sql = rtrim($sql, ' union all ');
        } else {
            if (!array_key_exists($gameId, gameHistoryTables)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid gameId, param = ' . json_encode($param));
                return ERR_INVALID_PARAM;
            }
            if (empty(gameHistoryTables[$gameId])) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not define, param = ' . json_encode($param));
                return ERR_TABLE_NOT_DEFINE;
            }
            $tableName = gameHistoryTables[$gameId] . $currentDate;

            $gameName = '';
            if (array_key_exists($gameId, gameIdName) && !empty(gameIdName[$gameId])) {
                $gameName = gameIdName[$gameId];
            }

            if (clsUtility::checkTableExist($pdo, $tableName)) { // 表存在
                $sql .= 'select user_id as userId, user_nickname as userNickname,';
                $sql .= ' "' . $gameName . '" as gameName,';
                $sql .= ' room_id as roomId, game_number as gameNumber, user_game_result as userGameResult,';
                $sql .= ' user_table_fee as userTableFee, user_score_begin as userScoreBegin,';
                $sql .= ' user_score_end as userScoreEnd, game_time as gameTime, record_timestamp as recordTimestamp';
                $sql .= ' from ' . $tableName;

                $haveWhere = false;

                if ($roomId !== -1) {
                    $roomIdArr = clsGame::getRoomIdArr($roomId);
                    if (!empty($roomIdArr)) {
                        $in = implode(',', $roomIdArr);
                        $sql .= ' where room_id in (' . $in . ')';
                        $haveWhere = true;
                    }
                }
                if ($userId !== -1) {
                    if ($haveWhere) {
                        $sql .= ' and user_id = :userId';
                    } else {
                        $sql .= ' where user_id = :userId';
                        $haveWhere = true;
                    }
                }
                if ($timeBegin !== -1) {
                    if ($haveWhere) {
                        $sql .= ' and record_timestamp >= :timeBegin';
                    } else {
                        $sql .= ' where record_timestamp >= :timeBegin';
                        $haveWhere = true;
                    }
                }
                if ($timeEnd !== -1) {
                    if ($haveWhere) {
                        $sql .= ' and record_timestamp <= :timeEnd';
                    } else {
                        $sql .= ' where record_timestamp <= :timeEnd';
                        $haveWhere = true;
                    }
                }
            }
        }

        if (!empty($sql)) {
            $sql .= ' limit ' . maxQueryNum;
        }

        $rows = [];

        if (!empty($sql)) {
            try {
                $stmt = $pdo->prepare($sql);
                $ret = $stmt->execute($pdoParam);
                if (!$ret) {
                    clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql
                        . ', pdoParam = ' . json_encode($pdoParam));
                    return ERR_MYSQL_EXECUTE_FAIL;
                }
                $rows = $stmt->fetchAll();

                if (!empty($rows)) {
                    foreach ($rows as &$row) {
                        $roomId = intval($row['roomId']);
                        if (array_key_exists($roomId, roomIdName) && !empty(roomIdName[$roomId])) {
                            $row['roomName'] = roomIdName[$roomId];
                        } else {
                            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', undefined roomId, roomId = ' . $roomId);
                            $row['roomName'] = '';
                        }
                        unset($row['roomId']);
                    }
                    unset($row);
                }
            } catch (Exception $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = ' . $e->getMessage());
                return ERR_MYSQL_EXCEPTION;
            }
        }

//        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
//        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', rows = ' . json_encode($rows));

        $data = !empty($rows) ? $rows : [];

        clsLog::debug('ok12, data = ' . json_encode($data) . ', sql = ' . $sql);

        return ERR_OK;
    }

    /**
     * 投注记录 - 获取详细
     * @param $param
     * @param $data
     * @return int
     */
    public static function betRecordGetDetail($param, &$data) {
        return ERR_OK;
    }
}