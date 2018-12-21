<?php
/**
 * Created by PhpStorm.
 * User: hjl
 * Date: 18-10-7
 * Time: 下午4:36
 */
const ERR_OK = 0; // 接口请求成功
const ERR_SERVER = 1; // 服务端错误
const ERR_CLIENT = 2; // 客户端错误

const ERR_INVALID_PARAM = 3; // 参数错误

// mysql
const ERR_MYSQL_CONNECT_FAIL = 100; // mysql连接失败
const ERR_MYSQL_EXCEPTION = 101; // mysql异常

// redis
const ERR_REDIS_CONNECT_FAIL = 200; // redis连接失败

// 管理员
const ERR_ADMIN_NOT_EXIST = 300; // 账号不存在
const ERR_ADMIN_PASSWORD_WRONG = 301; // 密码错误
const ERR_ADMIN_PASSWORD_EMPTY = 302; // 账号和密码不能为空
const ERR_ADMIN_NOT_ACTIVE = 303; // 账号不可用