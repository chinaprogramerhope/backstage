<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-9
 * Time: 下午4:31
 *
 * redis
 *
 * todo 玩家register信息永久保存是否合适
 * todo Serialize/Unserialize破坏单例
 */

class clsRedis {
    private static $instance = null;

    /**
     * 不允许直接调用构造方法
     * clsMysql constructor.
     */
    private function __construct() {
    }

    /**
     * 不允许深度复制
     */
    private function __clone() {
    }

    public static function getInstance($db = 0) {
        if (null === self::$instance) {
            try {
                self::$instance = new Redis();
                self::$instance->connect(redis_ip, redis_port);
                if (redis_pass) {
                    self::$instance->auth(redis_pass);
                }
                self::$instance->select($db);
            } catch (Exception $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ .', init redis fail: ' . $e->getMessage());
                self::$instance = null;
            }
        }

        return self::$instance;
    }

    public function __destruct() { // todo 保证接口调用结束时才释放
        $this->releaseRedis();
    }

    /**
     * 关闭redis连接
     */
    public function releaseRedis() {
        if (null !== self::$instance) {
            self::$instance->close();
            self::$instance = null;
        }
    }
}
