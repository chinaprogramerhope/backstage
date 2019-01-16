<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 游戏管理
 */
class svcGame {
    /**
     * 游戏列表 - 获取游戏列表
     * @param $param
     * @param $data
     * @return int
     */
    public function listGet($param, &$data) {
        return clsGame::listGet($param, $data);
    }

    /**
     * 游戏列表 - 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public function listChangeStatus($param, &$data) {
        return clsGame::listChangeStatus($param, $data);
    }

    /**
     * 游戏列表 - 获取游戏房间
     * @param $param
     * @param $data
     * @return int
     */
    public function roomGet($param, &$data) {
        return clsGame::roomGet($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 更改税收比例
     * @param $param
     * @param $data
     * @return int
     */
    public function roomChangeTaxRatio($param, &$data) {
        return clsGame::roomChangeTaxRatio($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public function roomClose($param, &$data) {
        return clsGame::roomClose($param, $data);
    }

    /**
     * 游戏分组 - 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public function groupGet($param, &$data) {
        return clsGame::groupGet($param, $data);
    }

    /**
     * 游戏分组 - 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public function groupGetGames($param, &$data) {
        return clsGame::groupGetGames($param, $data);
    }

    /**
     * 游戏分组 - 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public function groupStick($param, &$data) {
        return clsGame::groupStick($param, $data);
    }

    /**
     * 游戏分组 - 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public function groupCancelPopular($param, &$data) {
        return clsGame::groupCancelPopular($param, $data);
    }

    /**
     * 投注记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function betRecordGet($param, &$data) {
        return clsGame::betRecordGet($param, $data);
    }

    /**
     * 投注记录 - 获取详细
     * @param $param
     * @param $data
     * @return int
     */
    public function betRecordGetDetail($param, &$data) {
        return clsGame::betRecordGetDetail($param, $data);
    }

    /**
     * 投注记录 - 获取某游戏的底分
     * @param $param
     * @param $data
     * @return int
     */
    public function betRecordGetBaseScore($param, &$data) {
        if (!isset($param['gameId']) || !array_key_exists(intval($param['gameId']), gameBaseScore)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsGame::betRecordGetBaseScore($param, $data);
    }
}