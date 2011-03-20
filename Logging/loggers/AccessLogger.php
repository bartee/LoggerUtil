<?php
/**
 * Access logger
 * 
 * @author bartstroeken
 * @package Practisse Utilities
 * @subpackage Logger
 */
class AccessLogger extends BaseLogger {
	
	/**
	 * @see BaseLogger
	 */
	public function __construct() {
		$this->_filename = 'access.log';
	}
}