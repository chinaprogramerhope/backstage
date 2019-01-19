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
    private static $instance = [];

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

    public static function getInstance($dbName) {
        if (!is_string($dbName) && !is_int($dbName)) {
            clsLog::error(__METHOD__ . ', invalid dbName, dbName = ' . json_encode($dbName));
            return ERR_MYSQL_DB_NAME_WRONG;
        }

        if (!array_key_exists($dbName, mysqlConfig)) {
            clsLog::error(__METHOD__ . ', invalid dbName, dbName = ' . $dbName);
            return ERR_MYSQL_DB_NAME_WRONG;
        }

        $config = mysqlConfig[$dbName];
        if (empty(self::$instance) || !isset(self::$instance[$dbName]) || empty(self::$instance[$dbName])) {
            try {
                $pdo = new PDO($config['dsn'], $config['user'], $config['pass'], $config['options']);

                // 抛出异常
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                self::$instance[$dbName] = $pdo;
            } catch (PDOException $e) {
                clsLog::error(__METHOD__ . ', ' . __LINE__ . ', create pdo fail: ' . $e->getMessage() . ', dbName = ' . $dbName);
                self::$instance[$dbName] = null;
            }
        }

        return self::$instance[$dbName];
    }

    public function __destruct() { // todo 保证接口调用结束时才释放; 具体什么时候调用
        $this->releaseMysql();
    }

    /**
     * 关闭mysql连接
     */
    public function releaseMysql() {
        if (!empty(self::$instance)) {
            foreach (self::$instance as &$v) {
                $v = null;
            }
            unset($v);
        }
    }
}
