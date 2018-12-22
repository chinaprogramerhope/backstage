<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-8
 * Time: 下午5:46
 *
 * mysql
 * todo Serialize/Unserialize破坏单例
 */

class clsMysql {
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

    public static function getInstance($config) {
        if (null === self::$instance) {
            try {
                self::$instance = new PDO($config['dsn'], $config['user'], $config['pass'], $config['options']);
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', create pdo fail: ' . $e->getMessage());
                self::$instance = null;
            }
        }

        return self::$instance;
    }

    public function __destruct() { // todo 保证接口调用结束时才释放
        $this->releaseMysql();
    }

    /**
     * 关闭mysql连接
     */
    public function releaseMysql() {
        if (null !== self::$instance) {
            self::$instance = null;
        }
    }
}
