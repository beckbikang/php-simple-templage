<?php

/**
 *
* Copyright(c) 201x,
* All rights reserved.
*
* 功 能：
* @author bikang@book.sina.com
* date:2016年11月25日
* 版 本：1.0
 */
/**
 * 模版类
 */
class Templates
{
	//注入变量
	private $_vars = array();
	//保存系统变量数组字段
	private $_config = array();
	//创建一个构造方法，来检测各个目录是否存在
	public function __construct()
	{
		if (! is_dir(TPL_DIR) || ! is_dir(TPL_C_DIR) || ! is_dir(CACHE) || !is_dir(CONFIG)) {
			echo 'ERROR:模版目录或编译目录，缓存目录不存在！自动创建！'."<br />";
			if (!is_dir(TPL_DIR)) {
				mkdir(TPL_DIR);
				echo '模版目录'.TPL_DIR.'建立'."<br />";
			}
			if (!is_dir(TPL_C_DIR)) {
				mkdir(TPL_C_DIR);
				echo '编译目录'.TPL_C_DIR.'建立'."<br />";
			}
			if (!is_dir(CACHE)) {
				mkdir(CACHE);
				echo '缓存目录'.CACHE.'建立'."<br />";
			}
			if (!is_dir(CONFIG)) {
				mkdir(CONFIG);
				echo '缓存目录'.CONFIG.'建立'."<br />";
			}
			exit();
		}
		//保存系统变量
		$_sxe = simplexml_load_file(CONFIG.'/config.xml');
		$_tagLib = $_sxe->xpath('/root/taglib');
		foreach ($_tagLib as $_tag) {
			$this->_config["$_tag->name"] = $_tag->value;
		}
	}

	//assign()方法，用于注入变量
	public function assign($_var,$_value){
		//$_var用于同步模版里的变量名
		//$_value表示值
		if (isset($_var)&&!empty($_var)) {
			$this->_vars[$_var] = $_value;
		}else{
			exit('ERROR:设置模版变量！');
		}

	}

	//display()方法
	public function display($_file)
	{
		$_tplFile = TPL_DIR . $_file;
		// 判断文件是否存在
		if (! file_exists($_tplFile)) {
			echo 'ERROR:模版文件不存在！自动创建Index.tpl模版文件！';
			file_put_contents($_tplFile,'Index');
			exit();
		}

		//生成编译文件
		$_path = TPL_C_DIR.md5($_file).'-'.$_file.'.php';
		//缓存文件
		$_cacheFile = CACHE.md5($_file).'-'.$_file.'.html';
		//当第二次运行相同文件，直接载入缓存文件
		if (IS_CACHE) {
			//判断缓存文件和编译文件都存在
			if (file_exists($_cacheFile)&&file_exists($_path)) {
				//判断模版文件是否修改过
				if (filemtime($_path)>=filemtime($_tplFile)&&filemtime($_cacheFile)>=filemtime($_path)) {
					include $_cacheFile;
					echo '<!--cache-->';
					return;
				}
			}
		}
		//当编译文件不存在或者文件发生改变则重新生成
		if (!file_exists($_path)||filemtime($_path)<filemtime($_tplFile)) {
			require ROOT_PATH.'/Class/parser.class.php';
			//构造方法是传入模版文件地址
			$_parser = new Parser($_tplFile);
			//传入编译文件地址
			$_parser->compile($_path);
		}
		//载入编译文件
		include $_path;
		if (IS_CACHE) {
			//获取缓冲区数据
			file_put_contents($_cacheFile,ob_get_contents());
			//清楚缓冲区
			ob_end_clean();
			//载入缓存文件
			include $_cacheFile;
		}
	}
}