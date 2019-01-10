<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-9
 * Time: 下午4:52
 */

// mysql连接配置
//const mysqlConfig = [
//    'new_admin' => [
//        'dsn' => 'mysql:dbname=admin;host=127.0.0.1;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
//        'user' => 'root',
//        'pass' => 'root',
//        'options' => [
//            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//        ]
//    ],
//
//    'gameHistory' => [
//        'dsn' => 'mysql:dbname=casinogamehisdb;host=127.0.0.1;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
//        'user' => 'root',
//        'pass' => 'root',
//        'options' => [
//            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//        ]
//    ],
//];

const mysqlConfig = [
    'new_admin' => [
        'dsn' => 'mysql:dbname=vue_admin;host=192.168.1.119;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'gameHistory' => [
        'dsn' => 'mysql:dbname=casinogamehisdb;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'db_smc' => [
        'dsn' => 'mysql:dbname=db_smc;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinostatdb' => [
        'dsn' => 'mysql:dbname=casinostatdb;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],
];

// redis连接配置
const redis_ip = '127.0.0.1';
const redis_port = 6379;
const redis_pass = '';
//const redis_pass = '{DE162344-69B1-41C6-8F6D-0085FE821AC7}{8FCFE755-611D-44E2-A11A-9F22EF130804}';

const default_redis_expire_time = 604800; // redis键默认过期时间: 7天
