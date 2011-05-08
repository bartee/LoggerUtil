<?php
/**
 * This Logger is a generic Logging service, to be able to write notes to a file. 
 * 
 * Usage: 
 * - Download and unzip all in your project.
 * - In files where you want to use the logger, require this file.
 * - Use LogFactory::get(loggername)->log(yourmessage);
 * - Each message will be prepended with a timestamp. 
 * - The log can be autorotated, if you define the constant
 * 
 * CONSTANTS
 * All constants are defaulted within the current file.
 * - LOGGING_BASEDIR - Basedir for the Logging-utility codebase.    
 * - LOG_DIR - the dir where all logs are written to. Should be 0777. Defaults to $_SERVER{'DOCUMENT_ROOT'].'/logs/';
 * - LOGGING_ACTIVE - if set to false, all logging will be disabled. Useful for generic speedups
 * - LOG_ROTATION_INTERVAL - The Logger-utility provides for automatic logfile rotation. 
 * 		When the file reaches a specified age or size, it will be renamed - prepending the current date to the file
 * 		OPTIONS:
 * 			- day    : max file age is one day (24h)
 * 			- week   : max file age is one week (7d)
 * 			- month  : max file age is one month(30d)
 * 			- size:# : max file size is #bytes (no abbreviation like MB or so, just the numbers!)
 * 
 * EXTENDING
 * You can extend the BaseLogger to create your own logfiles. For an example, see the AccessLogger. 
 * Copy that file AND class to something matching your requirements and enter your own filename.
 * 
 * @license General Public License
 * @author Bart Stroeken
 * @package Practisse Utilities
 * @subpackage LoggingUtil
 */
date_default_timezone_set('Europe/Amsterdam');
if (!defined('LOG_DIR')){
	define ('LOG_DIR', $_SERVER['DOCUMENT_ROOT'].'/logs');
}
define('LOGGING_BASEDIR', dirname(__FILE__));
define('LOGGING_ACTIVE', true);
define('LOG_ROTATION_INTERVAL', 'week');

require_once LOGGING_BASEDIR.'/Logging/LogFactory.php';
