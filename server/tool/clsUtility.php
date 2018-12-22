<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-8
 * Time: 上午10:55
 *
 * 常用工具
 */

class clsUtility {
    /**
     * 是否包含所需参数
     * @param array $need - 所需参数
     * @param array $param - 实际传参
     * @return bool
     */
    public static function checkParamExist(array $need, array $param) {
        foreach($need as $v) {
            if (!isset($param[$v])) {
                return false;
            }
        }

        return true;
    }

    public static function toClient($code, $data = []) {
        if (!is_int($code)) {

        }
        if (!is_array($data)) {
            
        }
    }
}