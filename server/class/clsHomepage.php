<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 首页
 */
class clsHomepage {
    /**
     * 获取头部信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function getHead($param, &$data) {
        return daoHomepage::getHead($param, $data);
    }

    /**
     * 获取笔数/人数
     * @param $param
     * @param $data
     * @return int
     */
    public static function getNum($param, &$data) {
        return daoHomepage::getNum($param, $data);
    }

    /**
     * 获取充提
     * @param $param
     * @param $data
     * @return int
     */
    public static function getCharge($param, &$data) {
        return daoHomepage::getCharge($param, $data);
    }

    /**
     * 获取盈亏
     * @param $param
     * @param $data
     * @return int
     */
    public static function getProfit($param, &$data) {
        return daoHomepage::getProfit($param, $data);
    }

    /**
     * 获取在线人数
     * @param $param
     * @param $data
     * @return int
     */
    public static function getOnlineNum($param, &$data) {
        return daoHomepage::getOnlineNum($param, $data);
    }
}