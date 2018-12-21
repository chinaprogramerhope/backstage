<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 游戏分组
 */
class daoGameGroup {
    /**
     * 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public static function get($param, &$data) {
        // test
        $data = gameGroup;

        return ERR_OK;
    }

    /**
     * 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public static function getGames($param, &$data) {
        return ERR_OK;
    }

    /**
     * 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public static function stick($param, &$data) {
        return ERR_OK;
    }

    /**
     * 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public static function cancelPopular($param, &$data) {
        return ERR_OK;
    }
}