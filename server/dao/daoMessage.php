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
            $sql = 'select id, title, content, status, tag, carousel, note, creator, publishTime from smc_sys_notice';

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
                foreach ($rows as &$row) {
                    $row['status'] = array_key_exists($row['status'], messageStatus) ? messageStatus[$row['status']] : '';
                    $row['channel'] = array_key_exists($row['tag'], messageChannel) ? messageChannel[$row['tag']] : '';
                    $row['carousel'] = array_key_exists($row['carousel'], messageCarousel) ? messageCarousel[$row['carousel']] : '';
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
     * 公告列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function announceListAdd($param, &$data) {
        // test
        clsLog::debug('ok11, addParam = ' . json_encode($param));

        $title = isset($param['title']) ? $param['title'] : '';
        $content = $param['content'];
        $status = intval($param['status']);
        $tagArr = $param['tagArr'];
        $carousel = intval($param['carousel']);
        $note = isset($param['note']) ? $param['note'] : '';
        $areaArr = $param['areaArr'];
        $terminal = intval($param['terminal']);

        $creator = 'hxl'; // todo

        $timeNow = date('Y-m-d H:i:s');
        $publishTime = $status === 1 ? $timeNow : 0;
        $editTime = 0;

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        try {
            $sql = 'insert into smc_sys_notice(title, content, status, tag, carousel, note, area, terminal, creator, createTime, publishTime, editTime) values';

            foreach ($tagArr as $tag) {
                foreach ($areaArr as $area) {
                    $sql .= ' (' . $pdo->quote($title) . ', ' . $pdo->quote($content) . ', ' . $status . ', ' . $tag;
                    $sql .= ', ' . $carousel . ', ' . $note . ', ' . $area . ', ' . $terminal . ', ' . $pdo->quote($creator);
                    $sql .= ', ' . $pdo->quote($timeNow) . ', ' . $pdo->quote($publishTime) . ', ' .  $pdo->quote($editTime) . '),';
                }
            }

            $sql = rtrim($sql, ',');

            $stmt = $pdo->prepare($sql);
            $ret = $stmt->execute();
            if (!$ret) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql execute fail, sql = ' . $sql . ', param = ' . json_encode($param));
                return ERR_MYSQL_EXECUTE_FAIL;
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
        $id = intval($param['id']);
        $title = isset($param['title']) ? $param['title'] : '';
        $content = $param['content'];
        $status = intval($param['status']);
        $carousel = intval($param['carousel']);
        $note = isset($param['note']) ? $param['note'] : '';

        $creator = 'hxl1'; // todo

        $timeNow = date('Y-m-d H:i:s');
        $publishTime = $status === 1 ? $timeNow : 0;

        $pdo = clsMysql::getInstance(mysqlConfig['new_admin']);
        if ($pdo === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail, dbconfig = ' . json_encode(mysqlConfig['new_admin']));
            return ERR_MYSQL_CONNECT_FAIL;
        }

        $pdoParam = [];
        try {
            $sql = 'update smc_sys_notice set title = :title, content = :content, status = :status, carousel = :carousel,';
            $sql .= ' note = :note, creator = :creator, publishTime = :publishTime, editTime = :editTime where id = :id';

            $stmt = $pdo->prepare($sql);

            $pdoParam = [
                ':title' => $title,
                ':content' => $content,
                ':status' => $status,
                ':carousel' => $carousel,
                ':note' => $note,
                ':creator' => $creator,
                ':publishTime' => $publishTime,
                ':editTime' => $timeNow,
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