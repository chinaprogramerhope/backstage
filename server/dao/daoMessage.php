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
            $sql = 'select id, type, content, publishTime, status, creator, note from smc_sys_notice';

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

            $sql .= ' limit ' . maxQueryNum;

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
        $title = isset($param['title']) ? $param['title'] : '';
        $content = $param['content'];
        $status = intval($param['status']);
        $tag = $param['tag'];
        $carousel = intval($param['carousel']);
        $note = isset($param['note']) ? $param['note'] : '';
        $area = intval($param['area']);
        $terminal = intval($param['terminal']);

        $creator = ''; // todo

        $timeNow = date('Y-m-d H:i:s');
        $publishTime = $status === 1 ? $timeNow : 0;

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        try { // todo 改为不用pdo, 一次插入所有
            $sql = 'insert into smc_sys_notice(title, content, status, tag, carousel, note, area, terminal, creator, createTime, publishTime)';
            $sql .= ' values (:title, :content, :status, :tag, :carousel, :note, :area, :terminal, :creator, :createTime, :publishTime)';

            $stmt = $pdo->prepare($sql);

            $pdoParam = [
                ':title' => $title,
                ':content' => $content,
                ':status' => $status,
                ':tag' => $tag,
                ':carousel' => $carousel,
                ':note' => $note,
                ':area' => $area,
                ':terminal' => $terminal,
                ':creator' => $creator,
                ':createTime' => $timeNow,
                ':publishTime' => $publishTime
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
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
        $id = intval($param['id']);
        $title = isset($param['title']) ? $param['title'] : '';
        $content = $param['content'];
        $status = intval($param['status']);
        $tag = $param['tag'];
        $carousel = intval($param['carousel']);
        $note = isset($param['note']) ? $param['note'] : '';
        $area = intval($param['area']);
        $terminal = intval($param['terminal']);

        $creator = ''; // todo

        $timeNow = date('Y-m-d H:i:s');
        $publishTime = $status === 1 ? $timeNow : 0;

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        try {
            $sql = 'update smc_sys_notice set title = :title, content = :content, status = :status, tag = :tag,';
            $sql .= ' carousel = :carousel, note = :note, area = :area, terminal = :terminal, creator = :creator,';
            $sql .= ' createTime = :createTime, publishTime = :publishTime';
            $sql .= ' where id = :id';

            $stmt = $pdo->prepare($sql);

            $pdoParam = [
                ':title' => $title,
                ':content' => $content,
                ':status' => $status,
                ':tag' => $tag,
                ':carousel' => $carousel,
                ':note' => $note,
                ':area' => $area,
                ':terminal' => $terminal,
                ':creator' => $creator,
                ':createTime' => $timeNow,
                ':publishTime' => $publishTime,
                ':id' => $id
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }
        return ERR_OK;
    }

    /**
     * 公告列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListDel($param, &$data) {
        $id = intval($param['id']);
        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        try {
            $sql = 'delete from smc_sys_notice where id = :id';

            $stmt = $pdo->prepare($sql);

            $pdoParam = [
                ':id' => $id
            ];
            $ret = $stmt->execute($pdoParam);
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
                return ERR_MYSQL_EXECUTE_FAIL;
            }
        } catch (Exception $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception, exception = '
                . $e->getMessage() . ', sql = ' . $sql . ', pdoParam = ' . json_encode($pdoParam));
            return ERR_MYSQL_EXCEPTION;
        }

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