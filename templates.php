<?php
//设置字符编码UTF-8
header('Content-Type:text/html;charset=utf-8');

//网站根目录
define('ROOT_PATH',dirname(__FILE__));

//存放模版文件夹
define('TPL_DIR',ROOT_PATH.'/Templates/');

//编译文件夹
define('TPL_C_DIR',ROOT_PATH.'/Templates_c/');

//缓存文件夹
define('CACHE',ROOT_PATH.'/Cache/');

//系统变量配置目录
define('CONFIG',ROOT_PATH.'/Config/');

//是否开启缓冲区
define('IS_CACHE',false);//false

//判断是否需要开启
IS_CACHE ? ob_start() : null;

//引入模版类
require ROOT_PATH.'/Class/Templates.class.php';

//实例化模版类
$_tpl=new Templates();

$_tpl->assign('a', "abc");
$_tpl->assign('array', array("a"=>1,"b"=>2,"c"=>3,"d"=>4));
$_tpl->assign("name", "helo");
$_tpl->assign('WebName',"tom");

$_tpl->display('index.tpl');