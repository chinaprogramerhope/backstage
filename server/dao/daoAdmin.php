<?php

/**
 * User: hanxiaolong
 * Date: 18-10-9
 */
class daoAdmin {
    /**
     * 获取管理员信息
     * @param $adminName
     * @return array|int
     */
    public static function getAdmin($adminName) {
        $newAdminConfig = mysqlConfig['new_admin'];
        $pdo = clsMysql::getInstance($newAdminConfig);
        if (null === $pdo) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql connect fail');
            return ERR_MYSQL_CONNECT_FAIL;
        }

        try {
            $sql = 'select * from admin_admin where name = :adminName limit 1';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':adminName' => $adminName
            ]);
            $row = $stmt->fetch();
        } catch (PDOException $e) {
            clsLog::error(__METHOD__ . ', ' . __LINE__ . ', mysql exception: ' . $e->getMessage());
            return ERR_MYSQL_EXCEPTION;
        }

        if (empty($row)) {
            return [];
        }

        return $row;
    }
}