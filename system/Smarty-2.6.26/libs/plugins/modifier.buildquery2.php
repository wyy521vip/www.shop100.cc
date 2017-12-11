<?php
/**
 * http_build_query
 * 
 * @param array $arr
 * @param string $val
 * @param string $key
 */
function smarty_modifier_buildquery2($uri, $url, $val, $key='') {
	$arr = array();
	parse_str($url, $arr);
    $urirep    = implode('_', $arr);
	$arr[$key] = $key.$val;
	$urisub    = implode('_', $arr);
    $res       = str_replace($urirep, $urisub, $uri);
    return $res;
}
