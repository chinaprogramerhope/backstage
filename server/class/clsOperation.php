<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/22
 *
 * 运营管理
 */
class clsOperation {
    /**
     * 游戏报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameReportGet($param, &$data) {
        return daoOperation::gameReportGet($param, $data);
    }

    /**
     * 资金帐变 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function moneyReportGet($param, &$data) {
        return daoOperation::moneyReportGet($param, $data);
    }

    /**
     * 系统利润 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemProfitGet($param, &$data) {
        return daoOperation::systemProfitGet($param, $data);
    }

    /**
     * 系统维护 - 游戏开关
     * @param $param
     * @param $data
     * @return int
     */
    public static function systemMaintenanceSwitch($param, &$data) {
        return daoOperation::systemMaintenanceSwitch($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取游戏包列表
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGetGameList($param, &$data) {
        return daoOperation::packageUpgradeGetGameList($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeGet($param, &$data) {
        return daoOperation::packageUpgradeGet($param, $data);
    }

    /**
     * 整包升级服务器管理 - 添加游戏版本
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeAdd($param, &$data) {
        return daoOperation::packageUpgradeAdd($param, $data);
    }

    /**
     * 整包升级服务器管理 - 刷新redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeRefresh($param, &$data) {
        return daoOperation::packageUpgradeRefresh($param, $data);
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeDel($param, &$data) {
        return daoOperation::packageUpgradeDel($param, $data);
    }

    /**
     * 整包升级服务器管理 - 上线/下线
     * @param $param
     * @param $data
     * @return int
     */
    public static function packageUpgradeChangeStatus($param, &$data) {
        return daoOperation::packageUpgradeChangeStatus($param, $data);
    }

    /**
     * 模块升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function moduleUpgradeGet($param, &$data) {
        return daoOperation::moduleUpgradeGet($param, $data);
    }

    /**
     * 模块升级服务器管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function moduleUpgradeModify($param, &$data) {
        return daoOperation::moduleUpgradeModify($param, $data);
    }

    /**
     * 游戏开关管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameSwitchGet($param, &$data) {
        return daoOperation::gameSwitchGet($param, $data);
    }

    /**
     * 游戏开关管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public static function gameSwitchEdit($param, &$data) {
        return daoOperation::gameSwitchEdit($param, $data);
    }

    /**
     * 转账支付宝管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferGet($param, &$data) {
        return daoOperation::aliPayTransferGet($param, $data);
    }

    /**
     * 转账支付宝管理 - 修改开关时间
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferModifyTime($param, &$data) {
        return daoOperation::aliPayTransferModifyTime($param, $data);
    }

    /**
     * 转账支付宝管理 - 打开/关闭账号
     * @param $param
     * @param $data
     * @return int
     */
    public static function aliPayTransferModifyStatus($param, &$data) {
        return daoOperation::aliPayTransferModifyStatus($param, $data);
    }

    /**
     * 支付管理 - 支付总开关
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentSwitch($param, &$data) {
        return daoOperation::paymentSwitch($param, $data);
    }

    /**
     * 支付管理 - 支付宝第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentAliPayThird($param, &$data) {
        return daoOperation::paymentAliPayThird($param, $data);
    }

    /**
     * 支付管理 - 支付宝官方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentAliPayOfficial($param, &$data) {
        return daoOperation::paymentAliPayOfficial($param, $data);
    }

    /**
     * 支付管理 - 微信第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentWeChatThird($param, &$data) {
        return daoOperation::paymentWeChatThird($param, $data);
    }

    /**
     * 支付管理 - qq第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentQqThird($param, &$data) {
        return daoOperation::paymentQqThird($param, $data);
    }

    /**
     * 支付管理 - 京东钱包第三方
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentJdThird($param, &$data) {
        return daoOperation::paymentJdThird($param, $data);
    }

    /**
     * 支付管理 - 银联快捷支付
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentYlThird($param, &$data) {
        return daoOperation::paymentYlThird($param, $data);
    }

    /**
     * 支付管理 - 配置支付渠道参数
     * @param $param
     * @param $data
     * @return int
     */
    public static function paymentConfig($param, &$data) {
        return daoOperation::paymentConfig($param, $data);
    }

    /**
     * Proxy Ip管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpGet($param, &$data) {
        return daoOperation::proxyIpGet($param, $data);
    }

    /**
     * Proxy Ip管理 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpSave($param, &$data) {
        return daoOperation::proxyIpSave($param, $data);
    }

    /**
     * Proxy Ip管理 - 同步到redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function proxyIpRedisSync($param, &$data) {
        return daoOperation::proxyIpRedisSync($param, $data);
    }

    /**
     * 代理账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountGet($param, &$data) {
        return daoOperation::agentAccountGet($param, $data);
    }

    /**
     * 代理账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountAdd($param, &$data) {
        return daoOperation::agentAccountAdd($param, $data);
    }

    /**
     * 代理账号管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountEdit($param, &$data) {
        return daoOperation::agentAccountEdit($param, $data);
    }

    /**
     * 代理账号管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function agentAccountDel($param, &$data) {
        return daoOperation::agentAccountDel($param, $data);
    }

    /**
     * 紧急停服
     * @param $param
     * @param $data
     * @return int
     */
    public static function stopServer($param, &$data) {
        return daoOperation::stopServer($param, $data);
    }

    /**
     * 增加金币记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function goldAddLogGet($param, &$data) {
        return daoOperation::goldAddLogGet($param, $data);
    }

    /**
     * 绑定手机记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bindPhoneLogGet($param, &$data) {
        return daoOperation::bindPhoneLogGet($param, $data);
    }

    /**
     * 绑定支付宝记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function bindAliPayLogGet($param, &$data) {
        return daoOperation::bindAliPayLogGet($param, $data);
    }

    /**
     * 禁止支付管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitGet($param, &$data) {
        return daoOperation::payLimitGet($param, $data);
    }

    /**
     * 禁止支付管理 - 添加充值黑名单
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitBlackAdd($param, &$data) {
        return daoOperation::payLimitBlackAdd($param, $data);
    }

    /**
     * 禁止支付管理 - 同步黑名单到redis
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitBlackRedisSync($param, &$data) {
        return daoOperation::payLimitBlackRedisSync($param, $data);
    }

    /**
     * 禁止支付管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public static function payLimitDel($param, &$data) {
        return daoOperation::payLimitDel($param, $data);
    }

    /**
     * 账号及充值查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public static function rechargeLogGet($param, &$data) {
        return daoOperation::rechargeLogGet($param, $data);
    }

    /**
     * 充领开关 - 修改充
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongLingSwitchEditPay($param, &$data) {
        return daoOperation::chongLingSwitchEditPay($param, $data);
    }

    /**
     * 充领开关 - 修改领
     * @param $param
     * @param $data
     * @return int
     */
    public static function chongLingSwitchEditTake($param, &$data) {
        return daoOperation::chongLingSwitchEditTake($param, $data);
    }
}