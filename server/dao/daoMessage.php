<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 公告管理
 */
class daoMessage {
    /**
     * 公告列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListGet($param, &$data) {
        if (isset($param['type']) && !empty($param['type'])) {
            $type = intval($param['type']);
        } else {
            $type = -1;
        }

        if (isset($param['dateRange']) && !empty($param['dateRange'])) {
            $timeBegin = $param['dateRange'][0];
            $timeEnd = $param['dateRange'][1];
        } else {
            $timeBegin = $timeEnd = -1;
        }


        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        $haveWhere = false;
        try {
            $sql = 'select id, type, content, publishTime, status, creator, note from admin_announce';
            if ($type !== -1) {
                $sql .= ' where type = :type';

                $haveWhere = true;

                $pdoParam[':type'] = $type;
            }

            if ($timeBegin !== -1) {
                if ($haveWhere) {
                    $sql .= ' and publishTime >= :timeBegin';
                } else {
                    $sql .= ' where publishTime >= :timeBegin';

                    $haveWhere = true;
                }

                $pdoParam[':timeBegin'] = $timeBegin;
            }

            if ($timeEnd !== -1) {
                if ($haveWhere) {
                    $sql .= ' and publishTime <= :timeEnd';
                } else {
                    $sql .= ' where publishTime <= :timeEnd';

                    $haveWhere = true;
                }

                $pdoParam[':timeEnd'] = $timeEnd;
            }

            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', param = ' . json_encode($param)
                    . ', timeBegin = ' . $timeBegin . ', timeEnd = ' . $timeEnd);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
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
     * 公告列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListAdd($param, &$data) {
        $type = intval($param['type']);
        $status = intval($param['status']);
        $creator = $param['creator'];
        $content = $param['content'];
        $note = $param['note'];
        $area = intval($param['area']);
        $terminal = intval($param['terminal']);
        $createTime = $timeNow = date('Y-m-d H:i:s');
        if ($status == -1)

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        try {
            $sql = 'insert into admin_announce(type, status, )';

            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', param = ' . json_encode($param)
                    . ', timeBegin = ' . $timeBegin . ', timeEnd = ' . $timeEnd);
                return ERR_MYSQL_EXECUTE_FAIL;
            }
            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
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
     * 公告列表 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListEdit($param, &$data) {
        return ERR_OK;
    }

    /**
     * 公告列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListDel($param, &$data) {
        return ERR_OK;
    }

    /**
     * 站内消息 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 站内消息 - 发新消息
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageSend($param, &$data) {
        return ERR_OK;
    }

    /**
     * 站内消息 - 查看消息
     * @param $param
     * @param $data
     * @return int
     */
    public static function stationMessageViewMsg($param, &$data) {
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
}