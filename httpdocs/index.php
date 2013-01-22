<?php
/**
 * index.php :: dbdMVC Bootstrap Sample File
 *
 * @package dbdMVC
 * @version 1.4
 * @author Don't Blink Design <info@dontblinkdesign.com>
 * @copyright Copyright (c) 2006-2009 by Don't Blink Design
 */
define('DBD_DOC_ROOT', dirname(__FILE__));
define('DBD_APP_DIR', realpath(DBD_DOC_ROOT.'/../dbdApp').'/');
define('DBD_MVC_DIR', '/var/www/dbdMVC2/');

require_once(DBD_MVC_DIR.'dbdMVC.php');

dbdRequest::addRewrite('#^(.+\.css)$#i', '/dbdCSS/combine/?files=$1');
dbdRequest::addRewrite('#^(.+\.js)$#i', '/dbdJS/combine/?files=$1');

//dbdMVC::setDebugMode(DBD_DEBUG_DB | DBD_DEBUG_HTML);

dbdMVC::setErrorController('HYErrorController');
dbdMVC::setFallbackController('HYController');

dbdMVC::setControllerSuffix('Controller');

dbdMVC::setAppName('Hyduino');

/**
 * Run dbdMVC application.
 */
dbdMVC::run(DBD_APP_DIR);

/**
 * Log execution time of dbdMVC.
 */
dbdMVC::logExecutionTime();
