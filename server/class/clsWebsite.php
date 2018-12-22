<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 网站管理
 */
class clsWebsite {
    /**
     * 轮播图设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingGet($param, &$data) {
        return daoWebsite::bannerSettingGet($param, $data);
    }

    /**
     * 轮播图设置 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingUpload($param, &$data) {
        return daoWebsite::bannerSettingUpload($param, $data);
    }

    /**
     * 轮播图设置 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function bannerSettingSave($param, &$data) {
        return daoWebsite::bannerSettingSave($param, $data);
    }

    /**
     * 广告图设置 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function adSettingUpload($param, &$data) {
        return daoWebsite::adSettingUpload($param, $data);
    }

    /**
     * 广告图设置 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function adSettingSave($param, &$data) {
        return daoWebsite::adSettingSave($param, $data);
    }
}