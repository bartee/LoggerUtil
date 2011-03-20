<?php
/**
 * Provides instances to specific loggers.
 * Loggers are constructed using a Builder-pattern, each concrete Builder specifying only the file where all is logged
 * 
 * @author Bart Stroeken
 * @package Practisse Utilities
 * @subpackage Logger
 */
class LogFactory {
	
	/**
	 * All logger-instances, contained within an array
	 * 
	 * @var array
	 */
	private static $_loggers;

	/**
	 * @param string $name
	 * @return BaseLogger
	 */
	public static function get($name) {
		if (defined('LOGGING_ACTIVE') && LOGGING_ACTIVE == false){
			/**
			 * Logging has been disabled, so do nothing
			 */
			return false;
		}
		
		if (!is_array(self::$_loggers)){
			self::$_loggers = array();
			
			include_once LOGGING_BASEDIR.'/logging/loggers/BaseLogger.php';
			self::$_loggers['BaseLogger'] = new BaseLogger();
		}
		if (!key_exists($name, self::$_loggers)){
			try { 

				include_once LOGGING_BASEDIR.'/logging/loggers/'.$name.'.php';
				self::$_loggers[$name] = new $name;
			} catch(Exception $e) {
				return self::$_loggers['BaseLogger'];
			}
		}
		return self::$_loggers[$name];
	}
}