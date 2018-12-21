<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 游戏房间
 */
class clsGameRoom {
    /**
     * 获取游戏房间
     * @param $param
     * @param $data
     * @return int
     */
    public static function get($param, &$data) {
        return daoGameRoom::get($param, $data);
    }

    /**
     * 更改税收比例
     * @param $param
     * @param $data
     * @return int
     */
    public static function changeTaxRatio($param, &$data) {
        return daoGameRoom::changeTaxRatio($param, $data);
    }

    /**
     * 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function close($param, &$data) {
        return daoGameRoom::close($param, $data);
    }
}