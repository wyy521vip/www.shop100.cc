<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');
include_once SERVER_ROOT . '/system/Smarty-2.6.26/smarty2.php';
/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

    /**
     * smarty渲染模板方法
     * 
     * @param string $template 模版名
     */
    public function render($template) {
        $smarty = new Smarty2($template);
        if (!isset($this->view) || !is_array($this->view)) {
            $this->view = array();
        }
        $smarty->output = $this->view;
        $smarty->displayShow();
        exit;
    }

    /**
     * 直接返回渲染后的html, 用于 ajax吐html片段时使用
     * 
     * @param string $template
     */
    public function fetchRender($template) {
        $smarty = new Smarty2($template);
        if (!$this->view || !is_array($this->view)) {
            $this->view = array();
        }
        $smarty->output = $this->view;
        return $smarty->getTemplate();
        exit;
    }

    /**
     * 批量$this->view变量赋值
     *
     * @param array $arr 需要赋值的数组 array(key =>value , key => value)
     * 
     */
    public function setView(array $arr) {
        foreach ($arr as $key => $val) {
            $this->view[$key] = $val;
        }
    }

    //简单封装$_GET强制 int  不支持value为数组
    public function getNum($key) {
        $value = $this->input->get($key, TRUE);
        if ($value === false) {
            return $value;
        }
        $value = intval($value);
        return $value;
    }

    //简单封装$_GET   不支持value为数组
    public function getString($key) {
        $value = $this->input->get($key, TRUE);
        $value = htmlspecialchars($value, ENT_QUOTES);
        return $value;
    }

    //简单封装 $_POST 强制int 不支持value为数组
    public function postNum($key) {
        $value = $this->input->post($key, true);
        if ($value === false) {
            return $value;
        }
        $value = intval($value);
        return $value;
    }

    //简单封装 $_POST 不支持value为数组
    public function postString($key,$boolean=true) {
        $value = $this->input->post($key, $boolean);
        $value = htmlspecialchars($value, ENT_QUOTES);
        return $value;
    }

    //成功跳转
    public function jump($messge, $url = "", $target = "") {
        header("Content-Type: text/html;charset=utf-8");
        if ($url == "") {
            $url = $_SERVER['HTTP_REFERER'];
        }
        echo "<script>";
        if ($messge) {
            echo "alert('" . $messge . "');";
        }
        echo "window" . $target . ".location.href='" . $url . "';</script>";
        exit;
    }

    //失败跳转
    public function jump2($message) {
        header("Content-Type: text/html;charset=utf-8");
        echo "<script>alert('" . $message . "');window.history.back();</script>";
        exit;
    }
}
