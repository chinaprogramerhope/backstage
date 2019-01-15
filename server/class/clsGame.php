<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 游戏管理
 */
class clsGame {
    /**
     * 游戏列表 - 获取游戏列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function listGet($param, &$data) {
        return daoGame::listGet($param, $data);
    }

    /**
     * 游戏列表 - 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public static function listChangeStatus($param, &$data) {
        return daoGame::listChangeStatus($param, $data);
    }

    /**
     * 游戏列表 - 获取游戏房间
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomGet($param, &$data) {
        return daoGame::roomGet($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 更改税收比例
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomChangeTaxRatio($param, &$data) {
        return daoGame::roomChangeTaxRatio($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function roomClose($param, &$data) {
        return daoGame::roomClose($param, $data);
    }

    /**
     * 游戏分组 - 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupGet($param, &$data) {
        return daoGame::groupGet($param, $data);
    }

    /**
     * 游戏分组 - 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupGetGames($param, &$data) {
        return daoGame::groupGetGames($param, $data);
    }

    /**
     * 游戏分组 - 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupStick($param, &$data) {
        return daoGame::groupStick($param, $data);
    }

    /**
     * 游戏分组 - 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupCancelPopular($param, &$data) {
        return daoGame::groupCancelPopular($param, $data);
    }

    /**
     * 投注记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function betRecordGet($param, &$data) {
        return daoGame::betRecordGet($param, $data);
    }

    /**
     * 投注记录 - 获取详细
     * @param $param
     * @param $data
     * @return int
     */
    public static function betRecordGetDetail($param, &$data) {
        return daoGame::betRecordGetDetail($param, $data);
    }

    /**
     * 根据roomId获取与该roomId对应的游戏房间名相同的所有roomId
     * @param $roomId
     * @return array
     */
    public static function getRoomIdArr($roomId) {
        $roomIdArr = [];
        switch ($roomId) {
            case 0:
                $roomIdArr = [0, 6];
                break;
            case 1:
                $roomIdArr = [1, 7];
                break;
            case 2:
                $roomIdArr = [2, 8];
                break;
            default:
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, roomId = ' . json_encode($roomId));
        }

        return $roomIdArr;
    }

    /**
     * 生成 (投注记录 - 获取)方法 的sql
     * @param $pdo
     * @param $dateBegin
     * @param $dateEnd
     * @param $gameId
     * @param $roomId
     * @param $userId
     * @return string
     */
    public static function betRecordGetGenerateSql(&$pdo, $dateBegin, $dateEnd, $gameId, $roomId, $userId) {
        $sql = '';

        $tsBegin = strtotime($dateBegin);
        $tsEnd = strtotime($dateEnd);
        if ($dateBegin !== -1) {
            for ($i = $tsBegin; $i <= $tsEnd; $i += 86400) {
                $tableSuffix = date('Ymd', $i);

                $oneDaySql = self::getOneDaySql($pdo, $gameId, $roomId, $userId, $tableSuffix);
                $sql .= $oneDaySql;
            }
        } else { // 如果没有选择日期, 默认取最近30天的数据
            $todayTs = strtotime(date('Ymd'));
            $dateMonthAgoTs = $todayTs - 2592000;
            for ($i = $dateMonthAgoTs; $i <= $todayTs; $i += 86400) {
                $tableSuffix = date('Ymd', $i);

                clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', tableSuffix = ' . $tableSuffix);

                $oneDaySql = self::getOneDaySql($pdo, $gameId, $roomId, $userId, $tableSuffix);
                $sql .= $oneDaySql;
            }
        }

        $sql = rtrim($sql, ' union all ');

        return $sql;
    }

    /**
     * 生成 (投注记录 - 获取)方法 一天的sql
     * @param $pdo
     * @param $gameId
     * @param $roomId
     * @param $userId
     * @param $tableSuffix - 日期
     * @return string
     */
    public static function getOneDaySql(&$pdo, $gameId, $roomId, $userId, $tableSuffix) {
        $sql = '';

        if ($gameId === -1) {
            foreach (gameHistoryTables as $k => $tablePrefix) {
                if (!empty($tablePrefix)) { // 表前缀已定义
                    $tableName = $tablePrefix . $tableSuffix;

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

                        $sql .= ' union all ';
                    } else {
                        clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not exist, tableName = ' . $tableName);
                    }
                } else {
                    clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not define, gameId = ' . $gameId);
                }
            }
        } else {
            if (!array_key_exists($gameId, gameHistoryTables)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid gameId, gameId = ' . $gameId);
            }
            if (empty(gameHistoryTables[$gameId])) {
                clsLog::info(__METHOD__ . ', ' . __LINE__ . ', table not define, gameId = ' . $gameId);
            }

            $tablePrefix = gameHistoryTables[$gameId];
            $tableName = $tablePrefix . $tableSuffix;

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

                $sql .= ' union all ';
            }
        }

        return $sql;
    }

    /**
     * 获取游戏列表逻辑1
     * @param $searchStr
     * @param $gameId
     * @param $gameName
     * @param $gameStatus
     * @param $gameIdStatusArr
     * @param $retArr
     */
    public static function listGetLogic1($searchStr, $gameId, $gameName, $gameStatus, &$gameIdStatusArr, &$retArr) {
        if (array_key_exists($gameId, $gameIdStatusArr)) { // 检测redis中是否存在已定义的游戏
            $theGameIdName[$gameId] = $gameName;

            foreach (gameIdLimit[$gameId] as $roomId => $score) {
                $gameStatusId = intval($gameIdStatusArr[$gameId]);
                if ($gameStatus === -1) {
                    self::listGetLogic2($searchStr, $roomId, $gameName, $score, $gameStatusId, $retArr);
                } else {
                    if ($gameStatusId === $gameStatus) {
                        self::listGetLogic2($searchStr, $roomId, $gameName, $score, $gameStatusId, $retArr);
                    }
                }
            }
        } else {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', game not exist in redis, gameId = ' . $gameId . ', gameName = ' . $gameName);
        }
    }

    public static function listGetLogic2($searchStr, $roomId, $gameName, $score, $gameStatusId, &$retArr) {
        if ($searchStr !== '') {
            if (strpos($gameName, $searchStr) !== false) {
                self::listGetLogic3($roomId, $gameName, $score, $gameStatusId, $retArr);
            }
        } else {
            self::listGetLogic3($roomId, $gameName, $score, $gameStatusId, $retArr);
        }
    }

    public static function listGetLogic3($roomId, $gameName, $score, $gameStatusId, &$retArr) {
        $tmpArr = [];

        $tmpArr['gameName'] = $gameName;
        if (!empty(roomIdName[$roomId])) {
            $tmpArr['roomName'] = roomIdName[$roomId];
        } else {
            $tmpArr['roomName'] = ' - ';
        }

        $tmpArr['score'] = $score;

        if (!empty(gameStatusName[$gameStatusId])) {
            $tmpArr['gameStatus'] = gameStatusName[$gameStatusId];
        } else {
            $tmpArr['gameStatus'] = '';
        }

        $retArr[] = $tmpArr;
    }
}