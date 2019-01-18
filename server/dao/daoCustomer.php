<?php

/**
 * User: hanxiaolong
 * Date: 2019/1/18
 */
class daoCustomer {
    /**
     * 用户信息管理 - 获取用户详细信息
     * @param $param
     * @param $data
     * @return int
     */
    public static function userDetailGet($param, &$data) {
        $userId = $param['userId'];
        $accountId = $param['accountId'];
        $aliPayAccount = $param['aliPayAccount'];
        $aliPayName = $param['aliPayName'];
        $mac = $param['mac'];
        $ip = $param['ip'];
        $bindPhone = $param['bindPhone'];
        $isRecharge = $param['isRecharge'];

        $finalRet = [];
        $retUserInfoList = [];

        /*
         * 获取表 casinouserdb_x.casinouser_x 信息
         */
        if (!empty($userId)) {
            $errCode = clsUtility::getUserInfo($userId, $retUserInfoList);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserInfo fail, '
                    . ' userId = ' . $userId . ', errCode = ' . $errCode);
                return $errCode;
            }
        } else {
            $condition = [];
            $where = ' ';
            $pdoParam = [];

            if (!empty($accountId)) {
                $condition[] = 'user_email like :user_email';
                $pdoParam[':user_email'] = '%' . $accountId . '%';
            }

            if (!empty($aliPayAccount)) {
                $condition[] = 'alipay_account like :alipay_account';
                $pdoParam[':alipay_account'] = '%' . $aliPayAccount . '%';
            }

            if (!empty($aliPayName)) {
                $condition[] = 'alipay_real_name like :alipay_real_name';
                $pdoParam[':alipay_real_name'] = '%' . $aliPayName . '%';
            }

            if (!empty($mac)) {
                $condition[] = 'mac like :mac';
                $pdoParam[':mac'] = '%' . $mac . '%';
            }

            if (!empty($ip)) {
                $condition[] = 'ip like :ip';
                $pdoParam[':ip'] = '%' . $ip . '%';
            }

            if (!empty($bindPhone)) {
                $condition[] = 'boundmobilenumber like :boundmobilenumber';
                $pdoParam[':boundmobilenumber'] = '%' . $bindPhone . '%';
            }

            if ($isRecharge !== -1) {
                if ($isRecharge === 1) {
                    $condition[] = 'total_total_money != 0';
                } else {
                    $condition[] = 'total_total_money = 0';
                }
            }

            if (!empty($condition)) {
                $where = ' where ' . implode(' and ', $condition);
            }

            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', where = ' . $where . ', pdoParam = ' . json_encode($pdoParam));

            $errCode = clsUtility::getUserInfoList($where, $pdoParam, $retUserInfoList);
            if ($errCode !== ERR_OK) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserInfo fail, '
                    . ' param = ' . json_encode($param) . ', errCode = ' . $errCode);
                return $errCode;
            }
        }

        if (empty($retUserInfoList)) {
            clsLog::info(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserInfoList return empty');
            return ERR_OK;
        }

        $redis = clsRedis::getInstance();
        if ($redis === null) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', redis connect fail');
        }

        /*
         * 继续获取其他信息 
         */
        foreach ($retUserInfoList as $key => $value) {
            $userId = intval($value['id']);

            $fishkkk = clsUtility::getGameFishkkk($userId);
            $fish = clsUtility::getGameFish($userId);
            $fishtool = clsUtility::getGameFishTool($userId);
            $rty = clsUtility::getGameStatusy($userId);
            $rty1 = clsUtility::getGameVipy($userId);

            $value ["signcardcount"] = $rty [0] ["signcardcount"];
            if ($rty [0] ["notecarddeviceeffectivetime"] > 0) {
                $value ["notecarddeviceeffectivetime"] = (round((time() - $rty [0] ["notecarddeviceeffectivetime"]) / 3600)) . "小时";
            } else {
                $value ["notecarddeviceeffectivetime"] = "0小时";
            }

            // 数据库位置
            $dbIndex = -1;
            $tableIndex = -1;
            $indexArr = clsUtility::getUserDBPos($userId);
            if (!is_array($indexArr) || empty($indexArr)) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', clsUtility::getUserDBPos fail, invalid userId, userId = ' . $userId);
            } else {
                $dbIndex = $indexArr['dbindex'];
                $tableIndex = $indexArr['tableindex'];
            }
            $value['dbIndex'] = $dbIndex;
            $value['tableIndex'] = $tableIndex;

            $value ["periodwinscore"] = isset($fishkkk [0] ["periodwinscore"]) ? $fishkkk [0] ["periodwinscore"] : 0;
            $value ["periodgamecount"] = isset($fishkkk [0] ["periodgamecount"]) ? $fishkkk [0] ["periodgamecount"] : 0;
            $value ["dailywinscore"] = isset($fishkkk [0] ["dailywinscore"]) ? $fishkkk [0] ["dailywinscore"] : 0;
            $value ["totalplayscore"] = isset($fishkkk [0] ["totalplayscore"]) ? $fishkkk [0] ["totalplayscore"] : 0;
            $value ["totalwinscore"] = isset($fishkkk [0] ["totalwinscore"]) ? $fishkkk [0] ["totalwinscore"] : 0;
            $value ["totalshotcount"] = isset($fishkkk [0] ["totalshotcount"]) ? $fishkkk [0] ["totalshotcount"] : 0;
            $value ["dailyshotcoun"] = isset($fishkkk [0] ["dailyshotcoun"]) ? $fishkkk [0] ["dailyshotcoun"] : 0;
            $value ["forcepool"] = isset($fishkkk [0] ["forcepool"]) ? $fishkkk [0] ["forcepool"] : 0;
            $value ["rewardpool"] = isset($fishkkk [0] ["rewardpool"]) ? $fishkkk [0] ["rewardpool"] : 0;

            $value ["explevel"] = isset($fish [0] ["explevel"]) ? $fish [0] ["explevel"] : 0;
            $value ["expvalue"] = isset($fish [0] ["expvalue"]) ? $fish [0] ["expvalue"] : 0;
            $value ["money"] = isset($fish [0] ["money"]) ? $fish [0] ["money"] : 0;
            $value ["secondmoney"] = isset($fish [0] ["secondmoney"]) ? $fish [0] ["secondmoney"] : 0;
            $value ["gunindex"] = isset($fish [0] ["gunindex"]) ? $fish [0] ["gunindex"] : 0;

            $value ["skill1num"] = isset($fishtool [0] ["skill1num"]) ? $fishtool [0] ["skill1num"] : 0;
            $value ["skill2num"] = isset($fishtool [0] ["skill2num"]) ? $fishtool [0] ["skill2num"] : 0;
            $value ["skill3num"] = isset($fishtool [0] ["skill3num"]) ? $fishtool [0] ["skill3num"] : 0;

            $value ["cofferchips"] = isset($rty [0] ["cofferchips"]) ? $rty [0] ["cofferchips"] : 0;

            $value ["cofferpassword"] = isset($rty [0] ["cofferpassword"]) ? $rty [0] ["cofferpassword"] : 0;

            $value ["silvertreasureboxcount"] = isset($rty [0] ["silvertreasureboxcount"]) ? $rty [0] ["silvertreasureboxcount"] : 0;

            $value ["goldentreasureboxcount"] = isset($rty [0] ["goldentreasureboxcount"]) ? $rty [0] ["goldentreasureboxcount"] : 0;

            $value ["newlevel"] = isset($rty1 [0] ["fishlevel"]) ? $rty1 [0] ["fishlevel"] : 0;

            $value ["exp"] = isset($rty1 [0] ["fishexp"]) ? $rty1 [0] ["fishexp"] : 0;

            $tests = isset($rty1 [0] ["fishexpiredate"]) ? $rty1 [0] ["fishexpiredate"] - (time() / (24 * 60 * 60)) : 0;

            if ($tests < 0)
                $tests = 0;

            $value ["expiredate"] = ceil($tests) . "天";

            $value ["lastrewarddate"] = isset($rty1 [0] ["fishlastrewarddate"]) ? $rty1 [0] ["fishlastrewarddate"] : 0;

            if (!empty ($userid)) {
                $value ["config"] = clsUtility::getDatabases($userId);
            }

            // 从smc_user表中获取alipay_account, alipay_real_name
            $value['alipay_account'] = '';
            $value['alipay_real_name'] = '';
            $retSmcUser = clsUtility::getSmcUser($userId);
            if (!empty($retSmcUser)) {
                $value['alipay_account'] = $retSmcUser['alipay_account'];
                $value['alipay_real_name'] = $retSmcUser['alipay_real_name'];
            }

            $channelName = array_key_exists($value['channel_id'], channelList) ? channelList[$value['channel_id']]['name'] : '';
            $value['channel_id'] = $value['channel_id'] == 0 ? "集集棋牌" : $channelName;
            $value['totalBuy'] = ($value['totalBuy'] / 100) . '元';
            $value['total_total_money'] = ($value['total_total_money'] / 100) . '元';
            $value['last_login_time'] = date('Y-m-d H:i:s', $value['last_login_time'] - 3600 * 8);

            if ($redis === null) {
                $value['is_reported'] = '否';
            } else {
                if ($redis->get('reported_' . $value['id']) == '1') {
                    $ttl = intval($redis->ttl('reported_' . $value['id']));
                    $value['is_reported'] = '是,剩余' . round($ttl / 60) . '分钟';
                } else {
                    $value['is_reported'] = '否';
                }
            }

            //黑名单信息
            $value['black_des'] = '';
            $blacklistInfo = clsUtility::getBlackList($userId);
            if (!empty($blacklistInfo)) {
                $value['black_des'] = $blacklistInfo['opertime'] . '被封，原因：' . $blacklistInfo['describecontent'];
            }
            clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', userId = ' . $userId . ', blackInfo = ' . json_encode($blacklistInfo));

            $finalRet[] = $value;
        }

        clsLog::debug(__METHOD__ . ', ' . __LINE__ . ', data = ' . json_encode($data));

        $data = $finalRet;

        return ERR_OK;
    }
}