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
        return clsGameList::get($data);
    }

    /**
     * 游戏列表 - 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public function listChangeStatus($param, &$data) {
        return clsGameList::changeStatus($param, $data);
    }

    /**
     * 游戏列表 - 获取游戏房间
     * @param $param
     * @param $data
     * @return int
     */
    public function roomGet($param, &$data) {
        return clsGameRoom::get($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 更改税收比例
     * @param $param
     * @param $data
     * @return int
     */
    public function roomChangeTaxRatio($param, &$data) {
        return clsGameRoom::changeTaxRatio($param, $data);
    }

    /**
     * 游戏列表 - 游戏房间 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public function roomClose($param, &$data) {
        return clsGameRoom::close($param, $data);
    }

    /**
     * 游戏分组 - 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public function groupGet($param, &$data) {
        return clsGameGroup::get($param, $data);
    }

    /**
     * 游戏分组 - 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public function groupGetGames($param, &$data) {
        return clsGameGroup::getGames($param, $data);
    }

    /**
     * 游戏分组 - 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public function groupStick($param, &$data) {
        return clsGameGroup::stick($param, $data);
    }

    /**
     * 游戏分组 - 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public function groupCancelPopular($param, &$data) {
        return clsGameGroup::cancelPopular($param, $data);
    }

    /**
     * 投注记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function betRecordGet($param, &$data) {
        return clsGameBetRecord::get($param, $data);
    }

    /**
     * 投注记录 - 获取详细
     * @param $param
     * @param $data
     * @return int
     */
    public function betRecordGetDetail($param, &$data) {
        return clsGameBetRecord::getDetail($param, $data);
    }
}