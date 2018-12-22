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