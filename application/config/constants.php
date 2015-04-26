<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * Customize definition
 */
define('PATH_ROOT', rtrim(str_replace('system', '', str_replace($_SERVER['DOCUMENT_ROOT'], '', BASEPATH)),'/').'/');
define('PATH_CMS', str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", "/", FCPATH)));
define('IMG_UPLOAD_MAX_SIZE', 20480000);
define('FILE_UPLOAD_MAX_SIZE', 20480000);
define('DOC_ROOT', $_SERVER['DOCUMENT_ROOT'].PATH_ROOT.'/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'].PATH_ROOT.'uploads/');
define('RELATIVE_UPLOAD_DIR', str_replace($_SERVER['DOCUMENT_ROOT'], '', UPLOAD_DIR));
define('IMG_MAX_WIDTH',800);
define('IMG_MAX_HEIGHT',600);
define('IMG_THUMB_WIDTH',400);
define('IMG_THUMB_HEIGHT',400);
define('IMG_MED_WIDTH',208);
define('IMG_MED_HEIGHT',208);
define('IMG_SMALL_WIDTH',90);
define('IMG_SMALL_HEIGHT',90);
// global assets
define('GLOBAL_ASSETS_URL',PATH_CMS.'assets/default/');
define('GLOBAL_IMG_URL', GLOBAL_ASSETS_URL.'img/');
define('GLOBAL_CSS_URL', GLOBAL_ASSETS_URL.'css/');
define('GLOBAL_JS_URL', GLOBAL_ASSETS_URL.'js/');
define('GLOBAL_VENDOR_URL', GLOBAL_ASSETS_URL.'vendor/');
define('GLOBAL_LIBS_URL', GLOBAL_ASSETS_URL.'libs/');
// template assets
define('TEMPLATE_DIR','sbadmin2');
define('ASSETS_URL', PATH_CMS.'assets/'.TEMPLATE_DIR.'/');
define('IMG_URL', ASSETS_URL.'img/');
define('CSS_URL', ASSETS_URL.'css/');
define('JS_URL', ASSETS_URL.'js/');
define('VENDOR_URL', ASSETS_URL.'vendor/');
define('LIBS_URL', ASSETS_URL.'libs/');
define('SHOW_RECORDS_DEFAULT',10);
