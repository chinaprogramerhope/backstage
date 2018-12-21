<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 游戏分组
 */
class clsGameGroup {
    /**
     * 获取游戏分组
     * @param $param
     * @param $data
     * @return int
     */
    public static function get($param, &$data) {
        return daoGameGroup::get($param, $data);
    }

    /**
     * 获取分组内的游戏
     * @param $param
     * @param $data
     * @return int
     */
    public static function getGames($param, &$data) {
        return daoGameGroup::getGames($param, $data);
    }

    /**
     * 设为置顶
     * @param $param
     * @param $data
     * @return int
     */
    public static function stick($param, &$data) {
        return daoGameGroup::stick($param, $data);
    }

    /**
     * 取消热门
     * @param $param
     * @param $data
     * @return int
     */
    public static function cancelPopular($param, &$data) {
        return daoGameGroup::cancelPopular($param, $data);
    }
}