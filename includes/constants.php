<?php
//$url = $_SERVER['REQUEST_URI'];
define('WWW_ROOT', dirname(dirname(__FILE__)));

$directory = basename(WWW_ROOT);
$url = explode('project_X', $_SERVER['REQUEST_URI']);
if(count($url)== 1) {
    define('WEBROOT', '/');
} else {
    define('WEBROOT', $url[0] . 'project_X/');
}
//var_dump(WEBROOT);

define('IMAGES', WWW_ROOT . DIRECTORY_SEPARATOR . 'assets/images');