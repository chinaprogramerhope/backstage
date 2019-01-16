<?php
/**
 * User: hanxiaolong
 * Date: 2018/12/14
 */

// 加载config目录下的所有文件
$configDir = __DIR__ . '/config/';
$files = scandir($configDir);
$files = is_array($files) ? $files : [];
if (!empty($files)) {
    foreach ($files as $file) {
        if (!($file == '.' || $file == '..') && substr($file, -4) === '.php') {
            require_once $configDir . $file;
        }
    }
}