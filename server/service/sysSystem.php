<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 系统设置
 */
class sysSystem {
    /**
     * 厅主子账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountGet($param, &$data) {
        return  clsSystem::subAccountGet($param, $data);
    }

    /**
     * 厅主子账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountAdd($param, &$data) {
        return  clsSystem::subAccountAdd($param, $data);
    }

    /**
     * 厅主子账号管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountEdit($param, &$data) {
        return  clsSystem::subAccountEdit($param, $data);
    }

    /**
     * 厅主子账号管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountForbid($param, &$data) {
        return  clsSystem::subAccountForbid($param, $data);
    }

    /**
     * 全局参数 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public function globalParamSave($param, &$data) {
        return  clsSystem::globalParamSave($param, $data);
    }
    /**
     * 全局参数 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountUpload($param, &$data) {
        return  clsSystem::subAccountUpload($param, $data);
    }

    /**
     * 全局参数 - 重置
     * @param $param
     * @param $data
     * @return int
     */
    public function subAccountReset($param, &$data) {
        return  clsSystem::subAccountReset($param, $data);
    }

    /**
     * 个人资料设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileGet($param, &$data) {
        return  clsSystem::userProfileGet($param, $data);
    }

    /**
     * 个人资料设置 - 保存姓名
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileSaveName($param, &$data) {
        return  clsSystem::userProfileSaveName($param, $data);
    }

    /**
     * 个人资料设置 - 绑定google身份验证器
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileBindGoogle($param, &$data) {
        return  clsSystem::userProfileBindGoogle($param, $data);
    }

    /**
     * 个人资料设置 - 绑定手机
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileBindPhone($param, &$data) {
        return  clsSystem::userProfileBindPhone($param, $data);
    }

    /**
     * 个人资料设置 - 修改密码
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileChangePass($param, &$data) {
        return  clsSystem::userProfileChangePass($param, $data);
    }

    /**
     * 个人资料设置 - 两步验证 (未启用/启用)
     * @param $param
     * @param $data
     * @return int
     */
    public function userProfileTwoStepVerify($param, &$data) {
        return  clsSystem::userProfileTwoStepVerify($param, $data);
    }

    /**
     * 操作日志 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function operateLogGet($param, &$data) {
        return  clsSystem::operateLogGet($param, $data);
    }

    /**
     * 下载设置 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function downloadConfGet($param, &$data) {
        return  clsSystem::downloadConfGet($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public function downloadConfEdit($param, &$data) {
        return  clsSystem::downloadConfEdit($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 上传
     * @param $param
     * @param $data
     * @return int
     */
    public function downloadConfUpload($param, &$data) {
        return  clsSystem::downloadConfUpload($param, $data);
    }

    /**
     * 下载设置 - 编辑 - 删除已上传
     * @param $param
     * @param $data
     * @return int
     */
    public function downloadConfDelUpload($param, &$data) {
        return  clsSystem::downloadConfDelUpload($param, $data);
    }

    /**
     * 角色管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageGet($param, &$data) {
        return  clsSystem::roleManageGet($param, $data);
    }

    /**
     * 角色管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageAdd($param, &$data) {
        return  clsSystem::roleManageAdd($param, $data);
    }

    /**
     * 角色管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageEdit($param, &$data) {
        return  clsSystem::roleManageEdit($param, $data);
    }

    /**
     * 角色管理 - 禁用
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageForbid($param, &$data) {
        return  clsSystem::roleManageForbid($param, $data);
    }

    /**
     * 角色管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageDel($param, &$data) {
        return  clsSystem::roleManageDel($param, $data);
    }

    /**
     * 角色管理 - 权限控制 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public function roleManageSave($param, &$data) {
        return  clsSystem::roleManageSave($param, $data);
    }
}