<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 游戏列表
 */
class clsGameList {
    /**
     * 获取游戏列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function get($param, &$data) {
        return daoGameList::get($param, $data);
    }

    /**
     * 编辑(更改游戏状态)
     * @param $param
     * @param $data
     * @return int
     */
    public static function changeStatus($param, &$data) {

    }
}