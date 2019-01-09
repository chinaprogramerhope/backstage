<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 公告管理
 */
class svcMessage {
    /**
     * 公告列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListGet($param, &$data) {
        return clsMessage::announceListGet($param, $data);
    }

    /**
     * 公告列表 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListAdd($param, &$data) {
        if (!isset($param['content']) || empty($param['content'])
            || !isset($param['status']) || empty($param['status'])
            || !isset($param['tagArr']) || empty($param['tagArr'])
            || !isset($param['carousel']) || empty($param['carousel'])
            || !isset($param['areaArr']) || empty($param['areaArr'])
            || !isset($param['terminal']) || empty($param['terminal'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        // todo 自动获取当前管理员 为creator创建人

        return clsMessage::announceListAdd($param, $data);
    }

    /**
     * 公告列表 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListEdit($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])
            || !isset($param['content']) || empty($param['content'])
            || !isset($param['status']) || empty($param['status'])
            || !isset($param['carousel']) || empty($param['carousel'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMessage::announceListEdit($param, $data);
    }

    /**
     * 公告列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListDel($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsMessage::announceListDel($param, $data);
    }

    /**
     * 站内消息 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function stationMessageGet($param, &$data) {
        return clsMessage::stationMessageGet($param, $data);
    }

    /**
     * 站内消息 - 发新消息
     * @param $param
     * @param $data
     * @return int
     */
    public function stationMessageSend($param, &$data) {
        return clsMessage::stationMessageSend($param, $data);
    }

    /**
     * 站内消息 - 查看消息
     * @param $param
     * @param $data
     * @return int
     */
    public function stationMessageViewMsg($param, &$data) {
        return clsMessage::stationMessageViewMsg($param, $data);
    }

    /**
     * 站内消息 - 查看收件人
     * @param $param
     * @param $data
     * @return int
     */
    public function stationMessageViewRecipient($param, &$data) {
        return clsMessage::stationMessageViewRecipient($param, $data);
    }
}