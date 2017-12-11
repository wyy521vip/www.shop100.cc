<?php
/**
 * CI框架扩展smarty类  ( 合理化分离PHP => HTML )
 * 
 * @author  wangchen@
 * @package system/Smarty-2.6.26
 * @version 2013-04-11
 * 
 */
if (!defined('SERVER_ROOT')) {
    define('SERVER_ROOT', dirname(dirname(dirname(__FILE__))));
}
include_once SERVER_ROOT.'/system/Smarty-2.6.26/libs/Smarty.class.php';
class Smarty2 extends Smarty {
	public $template;
	public function __construct($template) {
        //模版目录
        $this->template_dir = SERVER_ROOT.'/application/views/templates';
        //模版编译缓存目录
        $this->compile_dir = SERVER_ROOT.'/application/views/templates_c';
        //smarty获取全局变量配置目录
        $this->config_dir = SERVER_ROOT.'/application/config/';
        //缓存目录 
        $this->cache_dir = SERVER_ROOT.'/application/views/smartycache';
        //(不开启缓存)
        $this->caching = false;
        $this->template = $template;
	}
    public function assignArray() {
        foreach($this->output as $key => $val) {
            $this->assign($key,$val);
        }   
    }   
    public function displayShow() {
        $this->assignArray();
        $this->display($this->template);
        //$this->assign('template', $this->template);
        //$this->display('body.html');
    }   
    public function getTemplate() {
        $this->assignArray();
        return $this->fetch($this->template);
    }   
}
?>