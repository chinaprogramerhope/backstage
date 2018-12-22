<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 系统设置
 */
class clsSystem {
    /**
     * 厅主子账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountGet($param, &$data) {
        return  daoSystem::subAccountGet($param, $data);
    }

    /**
     * 厅主子账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountAdd($param, &$data) {
        return  daoSystem::subAccountAdd($param, $data);
    }

    /**
     * 厅主子账号管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountEdit($param, &$data) {
        return  daoSystem::subAccountEdit($param, $data);
    }

    /**
     * 厅主子账号管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountForbid($param, &$data) {
        return  daoSystem::subAccountForbid($param, $data);
    }

    /**
     * 全局参数 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function globalParamSave($param, &$data) {
        return  daoSystem::globalParamSave($param, $data);
    }
    /**
     * 全局参数 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountUpload($param, &$data) {
        return  daoSystem::subAccountUpload($param, $data);
    }

    /**
     * 全局参数 - 重置
     * @param $param
     * @param $data
     * @return int
     */
    public static function subAccountReset($param, &$data) {
        return  daoSystem::subAccountReset($param, $data);
    }

    /**
     * 个人资料设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileGet($param, &$data) {
        return  daoSystem::userProfileGet($param, $data);
    }

    /**
     * 个人资料设置 - 保存姓名
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileSaveName($param, &$data) {
        return  daoSystem::userProfileSaveName($param, $data);
    }

    /**
     * 个人资料设置 - 绑定google身份验证器
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileBindGoogle($param, &$data) {
        return  daoSystem::userProfileBindGoogle($param, $data);
    }

    /**
     * 个人资料设置 - 绑定手机
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileBindPhone($param, &$data) {
        return  daoSystem::userProfileBindPhone($param, $data);
    }

    /**
     * 个人资料设置 - 修改密码
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileChangePass($param, &$data) {
        return  daoSystem::userProfileChangePass($param, $data);
    }

    /**
     * 个人资料设置 - 两步验证 (未启用/启用)
     * @param $param
     * @param $data
     * @return int
     */
    public static function userProfileTwoStepVerify($param, &$data) {
        return  daoSystem::userProfileTwoStepVerify($param, $data);
    }

    /**
     * 操作日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function operateLogGet($param, &$data) {
        return  daoSystem::operateLogGet($param, $data);
    }

    /**
     * 下载设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfGet($param, &$data) {
        return  daoSystem::downloadConfGet($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfEdit($param, &$data) {
        return  daoSystem::downloadConfEdit($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfUpload($param, &$data) {
        return  daoSystem::downloadConfUpload($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 删除已上传
     * @param $param
     * @param $data
     * @return int
     */
    public static function downloadConfDelUpload($param, &$data) {
        return  daoSystem::downloadConfDelUpload($param, $data);
    }

    /**
     * 角色管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageGet($param, &$data) {
        return  daoSystem::roleManageGet($param, $data);
    }

    /**
     * 角色管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageAdd($param, &$data) {
        return  daoSystem::roleManageAdd($param, $data);
    }

    /**
     * 角色管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageEdit($param, &$data) {
        return  daoSystem::roleManageEdit($param, $data);
    }

    /**
     * 角色管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageForbid($param, &$data) {
        return  daoSystem::roleManageForbid($param, $data);
    }

    /**
     * 角色管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageDel($param, &$data) {
        return  daoSystem::roleManageDel($param, $data);
    }

    /**
     * 角色管理 - 权限控制 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function roleManageSave($param, &$data) {
        return  daoSystem::roleManageSave($param, $data);
    }
}