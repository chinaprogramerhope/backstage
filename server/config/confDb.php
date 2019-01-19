<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-9
 * Time: 下午4:52
 */

const mysqlConfig = [
    'new_admin' => [
        'dsn' => 'mysql:dbname=vue_admin;host=192.168.1.119;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinogamehisdb' => [
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

    'casinoglobalinfo' => [
        'dsn' => 'mysql:dbname=casinoglobalinfo;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_0' => [
        'dsn' => 'mysql:dbname=casinouserdb_0;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_1' => [
        'dsn' => 'mysql:dbname=casinouserdb_1;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_2' => [
        'dsn' => 'mysql:dbname=casinouserdb_2;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_3' => [
        'dsn' => 'mysql:dbname=casinouserdb_3;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_4' => [
        'dsn' => 'mysql:dbname=casinouserdb_4;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_5' => [
        'dsn' => 'mysql:dbname=casinouserdb_5;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_6' => [
        'dsn' => 'mysql:dbname=casinouserdb_6;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_7' => [
        'dsn' => 'mysql:dbname=casinouserdb_7;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_8' => [
        'dsn' => 'mysql:dbname=casinouserdb_8;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_9' => [
        'dsn' => 'mysql:dbname=casinouserdb_9;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_10' => [
        'dsn' => 'mysql:dbname=casinouserdb_10;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_11' => [
        'dsn' => 'mysql:dbname=casinouserdb_11;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_12' => [
        'dsn' => 'mysql:dbname=casinouserdb_12;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_13' => [
        'dsn' => 'mysql:dbname=casinouserdb_13;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_14' => [
        'dsn' => 'mysql:dbname=casinouserdb_14;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    'casinouserdb_15' => [
        'dsn' => 'mysql:dbname=casinouserdb_15;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
        'user' => 'RoamGame',
        'pass' => 'Xmpx3hTpYujflCgbRkJV1',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ],

    // 黑名单
    'casinoblacklistdb' => [
        'dsn' => 'mysql:dbname=casinoblacklistdb;host=192.168.1.58;charset=utf8mb4', // charset=utf8mb4: 防止从mysql获取中文为?
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
