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

dbdRequest::addRewrite('#^/v1/poll/?$#i', '/v1PollController');
dbdRequest::addRewrite('#^/v1/power/?$#i', '/v1PowerController');
dbdRequest::addRewrite('#^/v1/shutoff/?$#i', '/v1ShutoffController');
dbdRequest::addRewrite('#^/v1/events/?$#i', '/v1EventsController');
dbdRequest::addRewrite('#^/v1/events/([0-9]+)/?$#i', '/v1EventsInstanceController?id=$1');
dbdRequest::addRewrite('#^/v1/timers/?$#i', '/v1TimersController');
dbdRequest::addRewrite('#^/v1/timers/([0-9]+)/?$#i', '/v1TimersInstanceController?id=$1');
dbdRequest::addRewrite('#^/v1/triggers/?$#i', '/v1TriggersController');
dbdRequest::addRewrite('#^/v1/triggers/([0-9]+)/?$#i', '/v1TriggersInstanceController?id=$1');
dbdRequest::addRewrite('#^/v1/sms/?$#i', '/v1SmsController');
//dbdRequest::addRewrite('#^/v1/voice/?$#i', '/v1VoiceController');


dbdMVC::setDebugMode(DBD_DEBUG_HTML | DBD_DEBUG_JS);

dbdMVC::setErrorController('APErrorController');
dbdMVC::setFallbackController('APController');

dbdMVC::setControllerSuffix('Controller');

dbdMVC::setAppName('AquaPi');

/**
 * Run dbdMVC application.
 */
dbdMVC::run(DBD_APP_DIR);

/**
 * Log execution time of dbdMVC.
 */
//dbdMVC::logExecutionTime();
