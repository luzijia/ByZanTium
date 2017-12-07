<?php
define('ROOT_PATH', dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
define('PRJ_PATH', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
require_once ROOT_PATH."ByZanTium/AutoLoader.php";
AutoLoad::initAutoLoader();
App::run(new \FrameWork\CLI("{$APP['APPNAME']}_api"));
