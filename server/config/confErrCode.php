<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
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
const ERR_MYSQL_EXECUTE_FAIL = 102; // mysql执行失败
const ERR_TABLE_NOT_DEFINE = 103; // 表未定义
const ERR_TABLE_NOT_EXIST = 104; // 表不存在
const ERR_MYSQL_DB_NAME_WRONG = 105; // 数据库名错误

// redis
const ERR_REDIS_CONNECT_FAIL = 200; // redis连接失败

// 管理员
const ERR_ADMIN_NOT_EXIST = 300; // 账号不存在
const ERR_ADMIN_PASSWORD_WRONG = 301; // 密码错误
const ERR_ADMIN_PASSWORD_EMPTY = 302; // 账号和密码不能为空
const ERR_ADMIN_NOT_ACTIVE = 303; // 账号不可用
const ERR_ADMIN_REGISTER_VERIFY_CODE_WRONG = 304; // 注册 - 验证码错误
const ERR_ADMIN_REGISTER_REPEAT_USERNAME = 305; // 注册 - 该账号已被注册

// 会员管理 400 - 500
const ERR_INVALID_USER_ID = 400; // 用户id错误
const ERR_USER_NOT_EXIST = 401; // 用户不存在

// 客服管理 501 - 600
const ERR_ORDER_NOT_EXIST = 501; // 订单不存在
const ERR_ORDER_STATUS_WRONG = 502; // 订单状态错误
const ERR_SCORE_OPERATION_FAIL = 503; // score operation fail
const ERR_ORDER_ALREADY_EXIST = 504; // 订单已存在

const ERR_PUSH_FAIL = 505; // 推送失败

// 运营管理
const ERR_ALI_PAY_ACCOUNT_NOT_EXIST = 601; // 支付宝账号不存在
const ERR_ALI_PAY_ACCOUNT_ALREADY_CLOSE = 602; // 该支付宝账号当前已关闭
const ERR_ALI_PAY_ACCOUNT_ALREADY_OPEN = 603; // 该支付宝账号当前已打开
const ERR_ACCOUNT_ALREADY_EXIST = 604; // 账号已存在
const ERR_PASSWORD_WRONG = 605; // 密码错误
const ERR_LIMIT_TARGET_ALREADY_EXIST = 606; // 该玩家已在充值黑名单中



// 错误码对应文字
const errMsg = [
    ERR_SERVER => '服务端错误',
    ERR_CLIENT => '客户端错误',
    ERR_INVALID_PARAM => '参数错误',
    ERR_MYSQL_CONNECT_FAIL => 'mysql连接失败',

    ERR_MYSQL_EXCEPTION => 'mysql异常',
    ERR_MYSQL_EXECUTE_FAIL => 'mysql执行失败',
    ERR_TABLE_NOT_DEFINE => '表未定义',
    ERR_TABLE_NOT_EXIST => '表不存在',

    ERR_MYSQL_DB_NAME_WRONG => '数据库名错误',
    ERR_REDIS_CONNECT_FAIL => 'redis连接失败',
    ERR_ADMIN_NOT_EXIST => '账号不存在',
    ERR_ADMIN_PASSWORD_WRONG => '密码错误',

    ERR_ADMIN_PASSWORD_EMPTY => '账号和密码不能为空',
    ERR_ADMIN_NOT_ACTIVE => '账号不可用',
    ERR_ADMIN_REGISTER_VERIFY_CODE_WRONG => '注册 - 验证码错误',
    ERR_ADMIN_REGISTER_REPEAT_USERNAME => '注册 - 该账号已被注册',

    ERR_INVALID_USER_ID => '用户id错误',
    ERR_USER_NOT_EXIST => '用户不存在',

    ERR_ORDER_NOT_EXIST => '订单不存在',
    ERR_ORDER_STATUS_WRONG => '订单状态错误',
    ERR_SCORE_OPERATION_FAIL => 'score operation fail',

    ERR_ALI_PAY_ACCOUNT_NOT_EXIST => '支付宝账号不存在',
    ERR_ALI_PAY_ACCOUNT_ALREADY_CLOSE => '该支付宝账号当前已是不可用状态',
    ERR_ALI_PAY_ACCOUNT_ALREADY_OPEN => '该支付宝账号当前已打开',
    ERR_ACCOUNT_ALREADY_EXIST => '账号已存在',
    ERR_PASSWORD_WRONG => '密码错误',
    ERR_LIMIT_TARGET_ALREADY_EXIST => '该玩家已在充值黑名单中',
];


