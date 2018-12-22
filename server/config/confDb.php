<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-9
 * Time: 下午4:52
 */

// mysql连接配置
const mysqlConfig = [
    'new_admin' => [
        'dsn' => 'mysql:dbname=vue_admin;host=192.168.1.119',
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ]
];

// redis连接配置
const redis_ip = '127.0.0.1';
const redis_port = 6379;
const redis_pass = '';

const default_redis_expire_time = 604800; // redis键默认过期时间: 7天
