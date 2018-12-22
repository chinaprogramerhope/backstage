<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 系统设置
 */
class daoSystem {
    /**
     * 厅主子账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountGet($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 厅主子账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountAdd($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 厅主子账号管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountEdit($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 厅主子账号管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountForbid($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 全局参数 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function globalParamSave($param, &$data) {
        return  ERR_OK;
    }
    /**
     * 全局参数 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountUpload($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 全局参数 - 重置
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountReset($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileGet($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 保存姓名
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileSaveName($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 绑定google身份验证器
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileBindGoogle($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 绑定手机
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileBindPhone($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 修改密码
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileChangePass($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 个人资料设置 - 两步验证 (未启用/启用)
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileTwoStepVerify($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 操作日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function operateLogGet($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 下载设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfGet($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 下载设置 - 编辑 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfEdit($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 下载设置 - 编辑 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfUpload($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 下载设置 - 编辑 - 删除已上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfDelUpload($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageGet($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageAdd($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageEdit($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageForbid($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageDel($param, &$data) {
        return  ERR_OK;
    }

    /**
     * 角色管理 - 权限控制 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageSave($param, &$data) {
        return  ERR_OK;
    }
}