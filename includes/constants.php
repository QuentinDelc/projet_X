<?php
//$url = $_SERVER['REQUEST_URI'];
$directory = basename(dirname(dirname(__FILE__)));
$url = explode('espacemembre', $_SERVER['REQUEST_URI']);
if(count($url)== 1) {
    define('WEBROOT', '/');
} else {
    define('WEBROOT', $url[0] . 'espacemembre/');
}
//var_dump(WEBROOT);