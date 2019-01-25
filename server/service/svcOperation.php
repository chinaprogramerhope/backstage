<?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 运营管理
 */
class svcOperation {
    /**
     * 游戏报表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function gameReportGet($param, &$data) {
        return clsOperation::gameReportGet($param, $data);
    }

    /**
     * 资金帐变 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function moneyReportGet($param, &$data) {
        return clsOperation::moneyReportGet($param, $data);
    }

    /**
     * 系统利润 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function systemProfitGet($param, &$data) {
        return clsOperation::systemProfitGet($param, $data);
    }

    /**
     * 系统维护 - 游戏开关
     * @param $param
     * @param $data
     * @return int
     */
    public function systemMaintenanceSwitch($param, &$data) {
        if (!isset($param['open']) || ($param['open'] != 0 && $param['open'] != 1) ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['open'] = intval($param['open']);
        $param['notice'] = isset($param['notice']) && !empty($param['notice']) ? trim($param['notice']) : '';

        return clsOperation::systemMaintenanceSwitch($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取游戏包列表
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeGetGameList($param, &$data) {
        return clsOperation::packageUpgradeGetGameList($param, $data);
    }

    /**
     * 整包升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeGet($param, &$data) {
        $param['selectTag'] = isset($param['selectTag']) && !empty($param['selectTag']) ? trim($param['selectTag']) : '';

        return clsOperation::packageUpgradeGet($param, $data);
    }

    /**
     * 整包升级服务器管理 - 添加游戏版本
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeAdd($param, &$data) {
        if (!isset($param['packageName']) || empty($param['packageName'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['packageName'] = trim($param['packageName']);
        $param['latestVersion'] = isset($param['latestVersion']) && !empty($param['latestVersion']) ? trim($param['latestVersion']) : 0;
        $param['expiredVersion'] = isset($param['expiredVersion']) && !empty($param['expiredVersion']) ? trim($param['expiredVersion']) : 0;
        $param['url'] = isset($param['url']) && !empty($param['url']) ? trim($param['url']) : ''; // todo

        $param['status'] = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : 0; // todo

        return clsOperation::packageUpgradeAdd($param, $data);
    }

    /**
     * 整包升级服务器管理 - 刷新redis
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeRefresh($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);

        return clsOperation::packageUpgradeRefresh($param, $data);
    }

    /**
     * 整包升级服务器管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeDel($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);

        return clsOperation::packageUpgradeDel($param, $data);
    }

    /**
     * 整包升级服务器管理 - 上线/下线
     * @param $param
     * @param $data
     * @return int
     */
    public function packageUpgradeChangeStatus($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])
            || !isset($param['type']) || empty($param['type'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        $param['type'] = intval($param['type']); // 1:上线, 2:下线

        if ($param['type'] !== 1 && $param['type'] !== 2) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::packageUpgradeChangeStatus($param, $data);
    }

    /**
     * 模块升级服务器管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function moduleUpgradeGet($param, &$data) {
        return clsOperation::moduleUpgradeGet($param, $data);
    }

    /**
     * 模块升级服务器管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public function moduleUpgradeModify($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])
            || !isset($param['latestVersion']) || !isset($param['expiredVersion'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        $param['latestVersion'] = trim($param['latestVersion']);
        $param['expiredVersion'] = trim($param['expiredVersion']);

        return clsOperation::moduleUpgradeModify($param, $data);
    }

    /**
     * 游戏开关管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function gameSwitchGet($param, &$data) {
        return clsOperation::gameSwitchGet($param, $data);
    }

    /**
     * 游戏开关管理 - 编辑
     * @param $param
     * @param $data
     * @return int
     */
    public function gameSwitchEdit($param, &$data) {
        if (!isset($param['channelId']) || !isset($param['dataArr']) || empty($param['dataArr'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['channelId'] = intval($param['channelId']);

        return clsOperation::gameSwitchEdit($param, $data);
    }

    /**
     * 转账支付宝管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferGet($param, &$data) {
        return clsOperation::aliPayTransferGet($param, $data);
    }

    /**
     * 转账支付宝管理 - 修改开关时间
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferModifyTime($param, &$data) {
        if (!isset($param['openTime']) || !isset($param['closeTime'])
            || $param['openTime'] == $param['closeTime']) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['openTime'] = intval($param['openTime']);
        $param['closeTime'] = intval($param['closeTime']);

        if ($param['openTime'] > 24 || $param['openTime'] < 0
            || $param['closeTime'] > 24 || $param['closeTime'] < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::aliPayTransferModifyTime($param, $data);
    }

    /**
     * 转账支付宝管理 - 打开/关闭账号
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferModifyStatus($param, &$data) {
        if (!isset($param['aliPayAccount']) || empty($param['aliPayAccount'])
            || !isset($param['type']) || empty($param['type'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['type'] = intval($param['type']); // 1打开, 2关闭
        if ($param['type'] !== 1 && $param['type'] !== 2) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', type = ' . $param['type']);
            return ERR_INVALID_PARAM;
        }

        $param['aliPayAccount'] = trim($param['aliPayAccount']);

        return clsOperation::aliPayTransferModifyStatus($param, $data);
    }

    /**
     * 支付管理 - 支付总开关
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentSwitch($param, &$data) {
        // closePay: 1关闭
        $param['closePay'] = isset($param['closePay']) && !empty($param['closePay']) ? intval($param['closePay']) : 0;

        // manualRecharge: 1开启
        $param['manualRecharge'] = isset($param['manualRecharge']) && !empty($param['manualRecharge']) ? intval($param['manualRecharge']) : 0;

        return clsOperation::paymentSwitch($param, $data);
    }

    /**
     * 支付管理 - 支付宝第三方
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentAliPayThird($param, &$data) {
        $param['aliPayThird'] = isset($param['aliPayThird']) && !empty($param['aliPayThird']) ? $param['aliPayThird'] : [];
        return clsOperation::paymentAliPayThird($param, $data);
    }

    /**
     * 支付管理 - 支付宝官方
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentAliPayOfficial($param, &$data) {
        $param['amount'] = isset($param['amount']) && !empty($param['amount']) ? intval($param['amount']) : 0;
        $param['openTime'] = isset($param['openTime']) && !empty($param['openTime']) ? intval($param['openTime']) : '';
        $param['closeTime'] = isset($param['openTime']) && !empty($param['openTime']) ? intval($param['openTime']) : '';
        $param['controlTime'] = isset($param['controlTime']) && !empty($param['controlTime']) ? intval($param['controlTime']) : '';

        $param['controlNum'] = isset($param['controlNum']) && !empty($param['controlNum']) ? intval($param['controlNum']) : '';
        $param['platformType'] = isset($param['platformType']) && !empty($param['platformType']) ? intval($param['platformType']) : 0;

        if ($param['amount'] < 0
            || ($param['platformType'] && array_key_exists($param['platformType'], officialAliPayPay))) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        if ($param['openTime'] !== '' && ($param['openTime'] < 0 || $param['openTime'] > 24)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        if ($param['closeTime'] !== '' && ($param['closeTime'] < 0 || $param['closeTime'] > 24)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        if ($param['controlTime'] !== '' && $param['controlTime'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        if ($param['controlNum'] !== '' && $param['controlNum'] <= 0 ) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::paymentAliPayOfficial($param, $data);
    }

    /**
     * 支付管理 - 微信第三方
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentWeChatThird($param, &$data) {
        $param['weChatThird'] = isset($param['weChatThird']) && !empty($param['weChatThird']) ? $param['weChatThird'] : [];
        return clsOperation::paymentWeChatThird($param, $data);
    }

    /**
     * 支付管理 - qq第三方
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentQqThird($param, &$data) {
        $param['qqThird'] = isset($param['qqThird']) && !empty($param['qqThird']) ? $param['qqThird'] : [];
        return clsOperation::paymentQqThird($param, $data);
    }

    /**
     * 支付管理 - 京东钱包第三方
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentJdThird($param, &$data) {
        $param['jdThird'] = isset($param['jdThird']) && !empty($param['jdThird']) ? $param['jdThird'] : [];
        return clsOperation::paymentJdThird($param, $data);
    }

    /**
     * 支付管理 - 银联快捷支付
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentYlThird($param, &$data) {
        $param['ylThird'] = isset($param['ylThird']) && !empty($param['ylThird']) ? $param['ylThird'] : [];
        return clsOperation::paymentYlThird($param, $data);
    }

    /**
     * 支付管理 - 配置支付渠道参数
     * @param $param
     * @param $data
     * @return int
     */
    public function paymentConfig($param, &$data) {
        // 聚宝云
        $param['jubaoPartnerId'] = isset($param['jubaoPartnerId']) && !empty($param['jubaoPartnerId']) ? trim($param['jubaoPartnerId']) : '';

        // 畅付appId
        $param['cfAppId'] = isset($param['cfAppId']) && !empty($param['cfAppId']) ? trim($param['cfAppId']) : '';

        // 畅付secretKey
        $param['cfSecretKey'] = isset($param['cfSecretKey']) && !empty($param['cfSecretKey']) ? trim($param['cfSecretKey']) : '';

        return clsOperation::paymentConfig($param, $data);
    }

    /**
     * Proxy Ip管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function proxyIpGet($param, &$data) {
        $param = isset($param['tag']) && !empty($param['tag']) ? trim($param['tag']) : '';
        return clsOperation::proxyIpGet($param, $data);
    }

    /**
     * Proxy Ip管理 - 保存
     * @param $param
     * @param $data
     * @return int
     */
    public function proxyIpSave($param, &$data) {
        if (!isset($param['tag']) || empty($param['tag'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['tag'] = trim($param['tag']);
        $param['ipStr'] = isset($param['ipStr']) && !empty($param['ipStr']) ? trim($param['ipStr']) : '';

        return clsOperation::proxyIpSave($param, $data);
    }

    /**
     * Proxy Ip管理 - 同步到redis
     * @param $param
     * @param $data
     * @return int
     */
    public function proxyIpRedisSync($param, &$data) {
        return clsOperation::proxyIpRedisSync($param, $data);
    }

    /**
     * 代理账号管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function agentAccountGet($param, &$data) {
        return clsOperation::agentAccountGet($param, $data);
    }

    /**
     * 代理账号管理 - 添加
     * @param $param
     * @param $data
     * @return int
     */
    public function agentAccountAdd($param, &$data) {
        if (isset($param['account']) || empty($param['account'])
            || !isset($param['pass']) || empty($param['pass'])
            || !isset($param['passAgain']) || empty($param['passAgain'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['account'] = trim($param['account']);
        $param['pass'] = trim($param['pass']);
        $param['passAgain'] = trim($param['passAgain']);
        $param['status'] = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : 1;

        $param['host'] = isset($param['host']) && !empty($param['host']) ? trim($param['host']) : '';
        $param['channelPriv'] = isset($param['channelPriv']) && !empty($param['channelPriv']) ? $param['channelPriv'] : [];
        $param['fieldPriv'] = isset($param['fieldPriv']) && !empty($param['fieldPriv']) ? $param['fieldPriv'] : [];

        if (strlen($param['account']) || $param['pass'] !== $param['passAgain']
            || ($param['status'] !== 1 && $param['status'] !== 2)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::agentAccountAdd($param, $data);
    }

    /**
     * 代理账号管理 - 修改
     * @param $param
     * @param $data
     * @return int
     */
    public function agentAccountEdit($param, &$data) {
        if (isset($param['id']) || empty($param['id'])
            || isset($param['account']) || empty($param['account'])
            || !isset($param['pass']) || empty($param['pass'])
            || !isset($param['passAgain']) || empty($param['passAgain'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        $param['account'] = trim($param['account']);
        $param['pass'] = trim($param['pass']);
        $param['passAgain'] = trim($param['passAgain']);

        $param['status'] = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : 1;
        $param['host'] = isset($param['host']) && !empty($param['host']) ? trim($param['host']) : '';
        $param['channelPriv'] = isset($param['channelPriv']) && !empty($param['channelPriv']) ? $param['channelPriv'] : [];
        $param['fieldPriv'] = isset($param['fieldPriv']) && !empty($param['fieldPriv']) ? $param['fieldPriv'] : [];

        if ($param['id'] <= 0
            || strlen($param['account']) || $param['pass'] !== $param['passAgain']
            || ($param['status'] !== 1 && $param['status'] !== 2)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::agentAccountEdit($param, $data);
    }

    /**
     * 代理账号管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function agentAccountDel($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);

        return clsOperation::agentAccountDel($param, $data);
    }

    /**
     * 紧急停服
     * @param $param
     * @param $data
     * @return int
     */
    public function stopServer($param, &$data) {
        if (!isset($param['gameId']) || empty($param['gameId'])
            || !isset($param['pass']) || empty($param['pass'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['gameId'] = intval($param['gameId']);
        $param['pass'] = trim($param['pass']);

        return clsOperation::stopServer($param, $data);
    }

    /**
     * 增加金币记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function goldAddLogGet($param, &$data) {
        $param['minGold'] = isset($param['minGold']) && !empty($param['minGold']) ? intval($param['minGold']) : 0;
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $param['dateRange'] = clsUtility::getFormatDate($param);
        $param['adminId'] = isset($param['adminId']) && !empty($param['adminId']) ? intval($param['adminId']) : -1;

        if ($param['userId'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsOperation::goldAddLogGet($param, $data);
    }

    /**
     * 绑定手机记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function bindPhoneLogGet($param, &$data) {
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $param['mobile'] = isset($param['mobile']) && !empty($param['mobile']) ? intval($param['mobile']) : '';
        $param['dateRange'] = clsUtility::getFormatDate($param);
        $param['bindStatus'] = isset($param['bindStatus']) && !empty($param['bindStatus']) ? intval($param['bindStatus']) : -1;

        if ($param['userId'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        return clsOperation::bindPhoneLogGet($param, $data);
    }

    /**
     * 绑定支付宝记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function bindAliPayLogGet($param, &$data) {
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $param['aliPayAccount'] = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? intval($param['aliPayAccount']) : '';
        $param['dateRange'] = clsUtility::getFormatDate($param);

        if ($param['userId'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        return clsOperation::bindAliPayLogGet($param, $data);
    }

    /**
     * 禁止支付管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function payLimitGet($param, &$data) {
        return clsOperation::payLimitGet($param, $data);
    }

    /**
     * 禁止支付管理 - 添加充值黑名单
     * @param $param
     * @param $data
     * @return int
     */
    public function payLimitBlackAdd($param, &$data) {
        return clsOperation::payLimitBlackAdd($param, $data);
    }

    /**
     * 禁止支付管理 - 同步黑名单到redis
     * @param $param
     * @param $data
     * @return int
     */
    public function payLimitBlackRedisSync($param, &$data) {
        return clsOperation::payLimitBlackRedisSync($param, $data);
    }

    /**
     * 禁止支付管理 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function payLimitDel($param, &$data) {
        return clsOperation::payLimitDel($param, $data);
    }

    /**
     * 账号及充值查询 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function rechargeLogGet($param, &$data) {
        return clsOperation::rechargeLogGet($param, $data);
    }

    /**
     * 充领开关 - 修改充
     * @param $param
     * @param $data
     * @return int
     */
    public function chongLingSwitchEditPay($param, &$data) {
        return clsOperation::chongLingSwitchEditPay($param, $data);
    }

    /**
     * 充领开关 - 修改领
     * @param $param
     * @param $data
     * @return int
     */
    public function chongLingSwitchEditTake($param, &$data) {
        return clsOperation::chongLingSwitchEditTake($param, $data);
    }

}