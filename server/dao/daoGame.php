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