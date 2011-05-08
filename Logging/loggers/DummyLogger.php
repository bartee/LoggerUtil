<?php
/**
 * Dummy logger
 * When logging is disabled, this logger will be used
 * 
 * @author bartstroeken
 * @package Practisse Utilities
 * @subpackage LoggingUtil
 */
class DummyLogger extends BaseLogger {
	
	/**
	 * @see BaseLogger
	 */
	public function __construct() {
		
	}
	
	/**
	 * Overwrite for the log-method.
	 * 
	 * (non-PHPdoc)
	 * @see BaseLogger::log()
	 */
	public function log($message){
		return;
	}
}