<?php
/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */

class svcCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public function userDetailGet($param, &$data) {
        $param['accountId'] = isset($param['accountId']) && !empty($param['accountId']) ? trim($param['accountId']) : '';
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : '';
        $param['aliPayAccount'] = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? trim($param['aliPayAccount']) : '';
        $param['aliPayName'] = isset($param['aliPayName']) && !empty($param['aliPayName']) ? trim($param['aliPayName']) : '';
        $param['mac'] = isset($param['mac']) && !empty($param['mac']) ? trim($param['mac']) : '';
        $param['ip'] = isset($param['ip']) && !empty($param['ip']) ? trim($param['ip']) : '';
        $param['bindPhone'] = isset($param['bindPhone']) && !empty($param['bindPhone']) ? trim($param['bindPhone']) : '';
        $param['isRecharge'] = isset($param['isRecharge']) && !empty($param['isRecharge']) ? intval($param['isRecharge']) : '';

        if (isset($param['userId']) && !empty($param['userId']) && $param['userId'] <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, invalid userId, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::userDetailGet($param, $data);
    }

    /**
     * 用户信息管理 - 金豆+保险箱最大的
     * @param $param
     * @param $data
     * @return int
     */
    public function userDetailGetMax($param, &$data) {
        return clsCustomer::userDetailGetMax($param, $data);
    }

    /**
     * 用户注册列表 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function userRegisterListGet($param, &$data) {
        return clsCustomer::userRegisterListGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistGet($param, &$data) {
        $keyword = isset($param['keyword']) && !empty($param['keyword']) ? trim($param['keyword']) : '';
        $param['keyword'] = $keyword;
        return clsCustomer::blacklistGet($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封批操作
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchDeBlock($param, &$data) {
        $ipArr = isset($param['ipArr']) && !empty($param['ipArr']) ? $param['ipArr'] : [];
        $macArr = isset($param['macArr']) && !empty($param['macArr']) ? $param['macArr'] : [];
        $idArr = isset($param['idArr']) && !empty($param['idArr']) ? $param['idArr'] : [];

        if (empty($ipArr) && empty($macArr) && empty($idArr)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['ipArr'] = $ipArr;
        $param['macArr'] = $macArr;
        $param['idArr'] = $idArr;

        return clsCustomer::blacklistBatchDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 解封单个
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistDeBlock($param, &$data) {
        $type = isset($param['type']) && !empty($param['type']) ? $param['type'] : 0;
        $value = isset($param['value']) && !empty($param['value']) ? trim($param['value']) : '';

        if ($type <= 0 || empty($value)) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['type'] = $type;
        $param['value'] = $value;

        return clsCustomer::blacklistDeBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量踢出相关用户id
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchBlock($param, &$data) {
        if (!isset($param['aliPayAccount']) || empty($param['aliPayAccount'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['aliPayAccount'] = trim($param['aliPayAccount']);

        return clsCustomer::blacklistBatchBlock($param, $data);
    }

    /**
     * 黑名单信息管理 - 批量封用户id-恶劣密码
     * @param $param
     * @param $data
     * @return int
     */
    public function blacklistBatchBlockPass($param, &$data) {
        return clsCustomer::blacklistBatchBlockPass($param, $data);
    }
    /**
     * 玩家游戏记录 - 查询
     * @param $param
     * @param $data
     * @return int
     */
    public function gameLogGet($param, &$data) {
        return clsCustomer::gameLogGet($param, $data);
    }

    /**
     * 玩家游戏记录 - 查询游戏次数
     * @param $param
     * @param $data
     * @return int
     */
    public function gameLogGetTimes($param, &$data) {
        return clsCustomer::gameLogGetTimes($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function goldLogGet($param, &$data) {
        $gameId = isset($param['gameId']) && !empty($param['gameId']) ? intval($param['gameId']) : -1;
        $eventId = isset($param['eventId']) && !empty($param['eventId']) ? intval($param['eventId']) : -1; // 金豆途径
        $userId = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $account = isset($param['account']) && !empty($param['account']) ? trim($param['account']) : '';
        $dateTimeRange = clsUtility::getFormatDateTime($param);

        $param['gameId'] = $gameId;
        $param['eventId'] = $eventId;
        $param['userId'] = $userId;
        $param['account'] = $account;
        $param['dateTimeRange'] = $dateTimeRange;

        return clsCustomer::goldLogGet($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 导出
     * @param $param
     * @param $data
     * @return int
     */
    public function goldLogExport($param, &$data) {
        return clsCustomer::goldLogExport($param, $data);
    }

    /**
     * 玩家金豆变化(24小时内)
     * @param $param
     * @param $data
     * @return int
     */
    public function goldLog24Get($param, &$data) {
        $userId = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        if ($userId <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['userId'] = $userId;
        return clsCustomer::goldLog24Get($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function orderInfoGet($param, &$data) {
        $account = isset($param['account']) && !empty($param['account']) ? trim($param['account']) : '';
        $userId = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $orderId = isset($param['orderId']) && !empty($param['orderId']) ? trim($param['orderId']) : '';
        $thirdOrderId = isset($param['thirdOrderId']) && !empty($param['thirdOrderId']) ? trim($param['thirdOrderId']) : '';

        $dateTimeRange = clsUtility::getFormatDateTime($param);
        $payPlatformId = isset($param['payPlatformId']) && !empty($param['payPlatformId']) ? intval($param['payPlatformId']) : -1;
        $orderStatus = isset($param['orderStatus']) && !empty($param['orderStatus']) ? intval($param['orderStatus']) : -1;
        $gameId = isset($param['gameId']) && !empty($param['gameId']) ? intval($param['gameId']) : -1;

        $param['account'] = $account;
        $param['userId'] = $userId;
        $param['orderId'] = $orderId;
        $param['thirdOrderId'] = $thirdOrderId;

        $param['dateTimeRange'] = $dateTimeRange;
        $param['payPlatformId'] = $payPlatformId;
        $param['orderStatus'] = $orderStatus;
        $param['gameId'] = $gameId;

        return clsCustomer::orderInfoGet($param, $data);
    }

    /**
     * 玩家金豆变化记录 - 获取延时订单 aliPayTransferCheckGet
     * @param $param
     * @param $data
     * @return int
     */
    public function orderInfoGetDelay($param, &$data) {
        return clsCustomer::orderInfoGetDelay($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 获取支付宝转账订单
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferCheckGet($param, &$data) {
        $userId = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $orderId = isset($param['orderId']) && !empty($param['orderId']) ? trim($param['orderId']) : '';
        $aliPayOrderId = isset($param['aliPayOrderId']) && !empty($param['aliPayOrderId']) ? trim($param['aliPayOrderId']) : '';
        $aliPayAccount = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? trim($param['aliPayAccount']) : 0;

        $dateTimeRange = clsUtility::getFormatDateTime($param);
        $orderStatus = isset($param['orderStatus']) && !empty($param['orderStatus']) ? intval($param['orderStatus']) : -1;

        if ($userId < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['userId'] = $userId;
        $param['orderId'] = $orderId;
        $param['aliPayOrderId'] = $aliPayOrderId;
        $param['aliPayAccount'] = $aliPayAccount;

        $param['dateTimeRange'] = $dateTimeRange;
        $param['orderStatus'] = $orderStatus;

        return clsCustomer::aliPayTransferCheckGet($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 确认转账成功
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferCheckConfirm($param, &$data) {
        if (!isset($param['orderId']) || empty($param['orderId'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['orderId'] = trim($param['orderId']);

        return clsCustomer::aliPayTransferCheckConfirm($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 修改金额
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferCheckModify($param, &$data) {
        if (!isset($param['orderId']) || empty($param['orderId'])
            || !isset($param['money']) || empty($param['money'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $money = intval($param['money']);
        if ($money <= 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }
        $orderId = trim($param['orderId']);

        $param['orderId'] = $orderId;
        $param['money'] = $money;
        return clsCustomer::aliPayTransferCheckModify($param, $data);
    }

    /**
     * 支付宝转账订单审核 - 关闭订单
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferCheckClose($param, &$data) {
        if (!isset($param['orderId']) || empty($param['orderId'])
            || !isset($param['reason']) || empty($param['reason'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['orderId'] = trim($param['orderId']);
        $param['reason'] = trim($param['reason']);

        return clsCustomer::aliPayTransferCheckClose($param, $data);
    }

    /**
     * 支付宝转账卡号卡密 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function aliPayTransferCardGet($param, &$data) {
        $aliPayOrderId = isset($param['aliPayOrderId']) && !empty($param['aliPayOrderId']) ? trim($param['aliPayOrderId']) : '';
        $aliPayAccount = isset($param['aliPayAccount']) && !empty($param['aliPayAccount']) ? trim($param['aliPayAccount']) : '';
        $userId = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $cardNumber = isset($param['cardNumber']) && !empty($param['cardNumber']) ? trim($param['cardNumber']) : '';

        $cardPassword = isset($param['cardPassword']) && !empty($param['cardPassword']) ? trim($param['cardPassword']) : '';
        $dateTimeRange = clsUtility::getFormatDateTime($param);
        $orderStatus = isset($param['orderStatus']) && !empty($param['orderStatus']) ? intval($param['aliPayOrderId']) : -1;

        if ($userId < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, invalid userId, userId = ' . $userId);
            return ERR_INVALID_PARAM;
        }

        $param['aliPayOrderId'] = $aliPayOrderId;
        $param['aliPayAccount'] = $aliPayAccount;
        $param['userId'] = $userId;
        $param['cardNumber'] = $cardNumber;

        $param['cardPassword'] = $cardPassword;
        $param['dateTimeRange'] = $dateTimeRange;
        $param['orderStatus'] = $orderStatus;

        return clsCustomer::aliPayTransferCardGet($param, $data);
    }

    /**
     * 客户端缺陷工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugGet($param, &$data) {
        $id = isset($param['id']) && !empty($param['id']) ? intval($param['id']) : 0;
        $userId = isset($param['userId']) && !empty($param['userId']) ? trim($param['userId']) : '';
        $recorder = isset($param['recorder']) && !empty($param['recorder']) ? trim($param['recorder']) : 0;
        $dateRange = clsUtility::getFormatDate($param);

        $describe = isset($param['describe']) && !empty($param['describe']) ? trim($param['describe']) : 0;
        $status = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : -1;
        $bugType = isset($param['bugType']) && !empty($param['bugType']) ? intval($param['bugType']) : -1;

        $param['id'] = $id;
        $param['userId'] = $userId;
        $param['recorder'] = $recorder;
        $param['dateRange'] = $dateRange;

        $param['describe'] = $describe;
        $param['status'] = $status;
        $param['bugType'] = $bugType;

        if ($id < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, invalid id, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::clientBugGet($param, $data);
    }

    /**
     * 客户端缺陷工单 - 批量处理关闭
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugBatchClose($param, &$data) {
        if (!isset($param['idArr']) || empty($param['idArr'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, idArr empty, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::clientBugBatchClose($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 创建
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugOneCreate($param, &$data) {
        if (!isset($param['userId']) || empty($param['userId'])
            || !isset($param['phoneSystem']) || empty($param['phoneSystem'])
            || !isset($param['networkType']) || empty($param['networkType'])
            || !isset($param['describe']) || empty($param['describe'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['userId'] = trim($param['userId']);
        $param['phoneSystem'] = trim($param['phoneSystem']);
        $param['networkType'] = trim($param['networkType']);
        $param['describe'] = trim($param['describe']);

        $param['recorder'] = isset($param['recorder']) && !empty($param['recorder']) ? trim($param['recorder']) : '';
        $param['phoneModel'] = isset($param['phoneModel']) && !empty($param['phoneModel']) ? $param['phoneModel'] : '';
        $param['address'] = isset($param['address']) && !empty($param['address']) ? trim($param['address']) : '';
        $param['appSize'] = isset($param['appSize']) && !empty($param['appSize']) ? trim($param['appSize']) : '';

        $param['appSource'] = isset($param['appSource']) && !empty($param['appSource']) ? trim($param['appSource']) : '';
        $param['bugType'] = isset($param['bugType']) && !empty($param['bugType']) ? intval($param['bugType']) : 1;

        return clsCustomer::clientBugOneCreate($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugOneGet($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        if ($param['id'] < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::clientBugOneGet($param, $data);
    }

    /**
     *  客户端缺陷工单 - 单个工单 - 关闭
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugOneUpdate($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        if ($param['id'] < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::clientBugOneUpdate($param, $data);
    }

    /**
     * 客户端缺陷工单 - 单个工单 - 删除
     * @param $param
     * @param $data
     * @return int
     */
    public function clientBugOneDel($param, &$data) {
        if (!isset($param['id']) || empty($param['id'])) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        $param['id'] = intval($param['id']);
        if ($param['id'] < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::clientBugOneDel($param, $data);
    }

    /**
     * 举报管理 - 获取
     * @param $param
     * @param $data
     * @return int
     */
    public function userReportGet($param, &$data) {
        $param['userId'] = isset($param['userId']) && !empty($param['userId']) ? intval($param['userId']) : 0;
        $param['gameId'] = isset($param['gameId']) && !empty($param['gameId']) ? intval($param['gameId']) : -1;
        $param['status'] = isset($param['status']) && !empty($param['status']) ? intval($param['status']) : -1;

        if ($param['userId'] < 0) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', invalid param, invalid userId, param = ' . json_encode($param));
            return ERR_INVALID_PARAM;
        }

        return clsCustomer::userReportGet($param, $data);
    }

    /**
     * 举报管理 - 回放
     * @param $param
     * @param $data
     * @return int
     */
    public function userReportPlayback($param, &$data) {
        return clsCustomer::userReportPlayback($param, $data);
    }

    /**
     * 举报管理 - 回复
     * @param $param
     * @param $data
     * @return int
     */
    public function userReportReply($param, &$data) {
        return clsCustomer::userReportReply($param, $data);
    }
}