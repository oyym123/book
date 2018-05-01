<?php
//默认跳转的首页
if (strpos($_SERVER['REQUEST_URI'], 'index.php?') === false) {
    header("Location: index.php?c=home&a=index");
}

// get runtime controller prefix
$c_str = $_GET['c'];
// the full name of controller
$c_name = $c_str . 'Controller';
// the path of controller
$c_path = './controller/' . ucfirst($c_name) . '.php';
// get runtime action
$method = $_GET['a'];
// get runtime parameter
$param = [];
foreach ($_GET as $item) {
    if ($item !== 'a' || $item !== 'c') {
        $param[] = $item;
    }
}
// load controller file
require($c_path);

function userAutoload($class_name)
{
    //判断是否为可增加（控制器类，模型类）
    //控制器类，截取后是个字符，匹配Controller
    if (substr($class_name, -10) == 'Controller') {
        // 控制器类， 当前平台下controller目录
        require './controller/' . ucfirst($class_name) . '.php';
    } //模型类，截取后5个字符，匹配Model
    elseif (substr($class_name, -5) == 'Model') {
        // 模型类，当前平台下model目录
        require './model/' . ucfirst($class_name) . '.php';
    }
}

spl_autoload_register('userAutoload');
// instantiate controller
$c_name = 'App\controller\\' . $c_name;
$controller = new $c_name;
// run the controller  method
$controller->$method($param);

