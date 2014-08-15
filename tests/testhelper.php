<?php
define('BASE_PATH', realpath(dirname(__FILE) . '/../'));
define('APPLICATION_PATH',BASE_PATH . '/src');
define('TEST_PATH',BASE_PATH . '/test');
define('APPLICATION_ENV','testing');

set_include_path(
'.'
 . PATH_SEPARATOR . BASE_PATH . '/src'
 . PATH_SEPARATOR . get_include_path()
);
date_default_timezone_set('Europe/Moscow');
error_reporting( E_ALL | E_STRICT );