<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 18-10-7
 * Time: 下午3:36
 */

date_default_timezone_set('Asia/shanghai');

require_once 'autoload.php';
require_once 'loadConfig.php';


$data = [];
$ret = [ // 返回值标准格式, 支持只返回其中一个
    'code' => ERR_OK,
    'data' => []
];

/*
 * 跨域问题解决, 即客户端先发一次options请求, 再发post请求
 * todo OPTIONS请求, 我怎么返回会影响客户端是否继续发送POST请求
 */
header("Access-Control-Allow-Origin:*"); // 允许其他域名访问 貌似nginx配置了, 这里不能再配置
header('Access-Control-Allow-Methods:OPTIONS,POST'); // 响应类型
header('Access-Control-Allow-Headers:x-requested-with,content-type,x-token'); // 响应头设置
if((strtolower($_SERVER['REQUEST_METHOD']) == 'options')
    || (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest")){ // 判断是否为 options (ajax) 请求
    echo json_encode($ret);
    ob_flush();
    exit();
}

/*
 * vue-element-admin中, axios发送post请求时服务端通过$_POST获取不到参数: https://blog.csdn.net/csdn_yudong/article/details/79668655\
 *
 * php://input allows you to read raw POST data.
 * It is a less memory intensive alternative to $HTTP_RAW_POST_DATA and does not need any special php.ini directives.
 * php://input is not available with enctype=”multipart/form-data”.
 */
$tmpParam = file_get_contents("php://input");
if (empty($_POST) && !empty($tmpParam)) {
    $_POST = json_decode($tmpParam, true);
}

//clsLog::debug('index.php, param = ' . json_encode($_POST));

if (!isset($_POST['cmd']) || !array_key_exists($_POST['cmd'], cmdArr)) {
    clsLog::error(basename(__FILE__) . ', ' . __LINE__ . ', invalid param, param = ' . json_encode($_POST));
    $ret['code'] = ERR_CLIENT;
    $ret['msg'] = errMsg[$ret['code']];
    echo json_encode($ret);
    ob_flush();
    exit();
}

$cmdContent = cmdArr[$_POST['cmd']];

$svc = $cmdContent['svc'];
$func = $cmdContent['func'];
$param = isset($_POST['param']) ? $_POST['param'] : [];

$code = (new $svc)->$func($param, $data);

//$code = (new $_POST['svc'])->{$_POST['func']}($_POST['param'], $data);

if (!is_int($code) || !is_array($data)) {
    clsLog::error('index.php, ' . __LINE__ . ', code type = ' . gettype($code) . ', data type = ' . gettype($data));
    $code = ERR_SERVER;
}

//if ($code !== ERR_OK) {
//    $data = [];
//}

$ret = [
    'code' => $code,
    'msg' => array_key_exists($code, errMsg) ? errMsg[$code] : '',
    'data' => $data
];
echo json_encode($ret);
ob_flush();
exit();
