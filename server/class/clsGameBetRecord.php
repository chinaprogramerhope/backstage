<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 投注记录
 */
class clsGameBetRecord {
    /**
     * 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function get($param, &$data) {
        return daoGameBetRecord::get($param, $data);
    }

    /**
     * 获取详细
     * @param $param
     * @param $data
     * @return int
     */
    public static function getDetail($param, &$data) {
        return daoGameBetRecord::getDetail($param, $data);
    }
}