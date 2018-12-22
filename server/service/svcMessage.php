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
        return clsMessage::announceListAdd($param, $data);
    }

    /**
     * 公告列表 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListEdit($param, &$data) {
        return clsMessage::announceListEdit($param, $data);
    }

    /**
     * 公告列表 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function announceListDel($param, &$data) {
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