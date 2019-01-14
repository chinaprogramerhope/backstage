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
        $searchStr = isset($param['searchStr']) ? trim($param['searchStr']) : '';
        $gameStatus = isset($param['gameStatus']) && !empty($param['gameStatus']) ? intval($param['gameStatus']) : -1;

        $retArr = [];

        $key = gameStatus;
        $redis = clsRedis::getInstance();
        if (null === $redis) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
            return ERR_REDIS_CONNECT_FAIL;
        }
        $gameIdStatusArr = $redis->hGetAll($key);

        // 根据$searchStr(模糊查询), gameStatus 查询 todo now
        foreach (gameIdName as $gameId => $gameName) {
            clsGame::listGetLogic1($searchStr, $gameId, $gameName, $gameStatus, $gameIdStatusArr, $retArr);
        }

        $data = $retArr;

        // test
        clsLog::debug('ok91, data = ' . json_encode($data));

        // [[gameName - roomName, score, gameStatus], []]
        return ERR_OK;
    }

    /**
     * 游戏列表 - 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public static function listChangeStatus($param, &$data) {

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
        return ERR_OK;
    }

    /**
     * 游戏分组 - 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public static function groupGetGames($param, &$data) {
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
            $dateBegin = $param['dateRange'][0];
            $dateEnd = $param['dateRange'][1];
        } else {
            $dateBegin = $dateEnd = -1;
        }

        $gameId = isset($param['gameId']) && !empty($param['gameId']) ? intval($param['gameId']) : -1;
        $roomId = isset($param['roomId']) ? intval($param['roomId']) : -1;
        $userId = isset($param['userId']) && !empty($param['userId']) ? $param['userId'] : -1;

        $pdoParam = [];
        if ($userId !== -1) {
            $pdoParam[':userId'] = $userId;
        }
        if ($dateBegin !== -1) { // 开始时间和结束时间要么不选要么都选
            $pdoParam[':timeBegin'] = $dateBegin;
            $pdoParam[':timeEnd'] = $dateEnd;
        }

        $pdo = clsMysql::getInstance('casinogamehisdb');
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        // test
        $currentDate = '20190103';
//        $currentDate = date('Ymd');

        $sql = clsGame::betRecordGetGenerateSql($pdo, $dateBegin, $dateEnd, $gameId, $roomId, $userId);

        if (!empty($sql)) {
            $sql .= ' limit ' . maxQueryNum;
        } else {
            clsLog::info(__METHOD__ . ', sql empty, param = ' . json_encode($param));
            return ERR_OK;
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