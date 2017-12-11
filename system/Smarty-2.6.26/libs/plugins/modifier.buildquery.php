<?php
/**
 * http_build_query
 * 
 * @param array $arr
 * @param string $val
 * @param string $key
 */
function smarty_modifier_buildquery($url, $val, $key='') {
	$arr = array();
	parse_str($url, $arr);
	$arr[$key] = $val;
	return http_build_query($arr);
	
}