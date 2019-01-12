    <?php

/**
 * User: hanxiaolong
 * Date: 2018/12/21
 *
 * 会员管理
 */
class svcMember {
    /**
     * 获取会员列表
     * @param $param
     * @param $data
     * @return int
     */
    public function getList($param, &$data) {
        return clsMember::getList($param, $data);
    }

    /**
     * 获取登陆日志
     * @param $param
     * @param $data
     * @return int
     */
    public function getLoginLog($param, &$data) {
        return clsMember::getLoginLog($param, $data);
    }

    /**
     * 获取标签
     * @param $param
     * @param $data
     * @return int
     */
    public function getLabel($param, &$data) {
        return clsMember::getLabel($param, $data);
    }

    /**
     * 添加标签
     * @param $param
     * @param $data
     * @return int
     */
    public function addLabel($param, &$data) {
        return clsMember::addLabel($param, $data);
    }

    /**
     * 获取等级
     * @param $param
     * @param $data
     * @return int
     */
    public function getLv($param, &$data) {
        return clsMember::getLv($param, $data);
    }

    /**
     * 新增等级
     * @param $param
     * @param $data
     * @return int
     */
    public function addLv($param, &$data) {
        return clsMember::addLv($param, $data);
    }
}