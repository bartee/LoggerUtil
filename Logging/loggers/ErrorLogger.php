<?php
/**
 * Error logger
 * 
 * @author bartstroeken
 * @package Practisse Utilities
 * @subpackage Logger
 */
class ErrorLogger extends BaseLogger {
	
	/**
	 * @see BaseLogger
	 */
	public function __construct() {
		$this->_filename = 'error.log';
	}
}