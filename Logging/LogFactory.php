<?php
/**
 * Provides instances to specific loggers.
 * Loggers are constructed using a Builder-pattern, each concrete Builder specifying only the file where all is logged
 * 
 * @author Bart Stroeken
 * @package Practisse Utilities
 * @subpackage LoggingUtil
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
		if (!is_array(self::$_loggers)){
			self::$_loggers = array();
			
			include_once LOGGING_BASEDIR.'/Logging/loggers/BaseLogger.php';
			include_once LOGGING_BASEDIR.'/Logging/loggers/DummyLogger.php';

			self::$_loggers['BaseLogger'] = new BaseLogger();
			self::$_loggers['DummyLogger'] = new DummyLogger();
		}

		if (defined('LOGGING_ACTIVE') && LOGGING_ACTIVE == false){
			/**
			 * Logging has been disabled, so return a dummy logger
			 */
			return self::$_loggers['DummyLogger'];
		}
		
		if (!key_exists($name, self::$_loggers)){
			try { 

				include_once LOGGING_BASEDIR.'/Logging/loggers/'.$name.'.php';
				self::$_loggers[$name] = new $name;
			} catch(Exception $e) {
				return self::$_loggers['BaseLogger'];
			}
		}
		return self::$_loggers[$name];
	}
}