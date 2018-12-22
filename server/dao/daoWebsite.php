<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 网站管理
 */
class daoWebsite {
    /**
     * 轮播图设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingGet($param, &$data) {
        return ERR_OK;
    }

    /**
     * 轮播图设置 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingUpload($param, &$data) {
        return ERR_OK;
    }

    /**
     * 轮播图设置 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingSave($param, &$data) {
        return ERR_OK;
    }

    /**
     * 广告图设置 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function adSettingUpload($param, &$data) {
        return ERR_OK;
    }

    /**
     * 广告图设置 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function adSettingSave($param, &$data) {
        return ERR_OK;
    }
}