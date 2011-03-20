<?php
/**
 * Logger is a class preparing and writing the logging
 * Using the Builder-pattern, you can extend the logger, providing your own filename for your log
 * 
 * May seem a bit overkill to create a whole new class for each file, but in that way you prevent typos. 
 * 
 * @author bartstroeken
 * @package Practisse Utilities
 * @subpackage Logger
 */
class BaseLogger {
	
	/**
	 * The name of the file where all is logged.
	 */
	protected $_filename;
	
	/**
	 * Constructor
	 */
	public function __construct(){
		$this->_filename = 'base.log';
	}
	
	/**
	 * @param string $message
	 * @return boolean
	 */
	public function log($message){
		if (!$this->_prepare()){
			return false;
		}
		$message = date('Y-m-d H:i:s'). ' - '.$message;
		$this->_writeToFile("\n".$message, LOG_DIR.'/'.$this->_getFilename());
		return true;
	}

	/**
	 * @param string $message
	 */
	protected function _writeToFile($message, $file){
		$filehandler = fopen($file, 'a');
		fwrite($filehandler, $message);
		fclose($filehandler);
	}
	
	/**
	 * @return boolean 
	 */
	protected function _prepare(){
		if (!defined('LOG_DIR')){
			/**
			 * No log dir defined
			 */
			return false;
		}

		if (!is_dir(LOG_DIR)){
			if (!mkdir(LOG_DIR)){
				/**
				 * Base log dir cannot be found or created
				 */
				return false;
			}
		}
		$this->_checkRotateLog();
		return true;
	}
	
	/**
	 * Default filename: access.log.
	 *  
	 * When extending this logger, overwrite this method to specify your own logfile
	 * @return string
	 */
	protected function _getFilename() {
		return $this->_filename;
	}
	
	/**
	 * The logger provides for an automatic log rotation. 
	 * This method will check if the file needs to be rotated. If so, it will call _doRotateLog
	 * Old files will not be deleted, but renamed, prepended with the current date
	 * 
	 */
	protected function _checkRotateLog(){
		if (!defined("LOG_ROTATION_INTERVAL")){
			return ;
		}

		$filename = $this->_getFilename();
		if (!is_file(LOG_DIR.'/'.$filename)){
			return;
		}
		$filesize = filesize(LOG_DIR.'/'.$filename);
		$file_creation_time = filemtime(LOG_DIR.'/'.$filename);

		$rotate_log = false;
		switch (LOG_ROTATION_INTERVAL){
			case 'day':
				if ((time() - $file_creation_time) >= 3600*24){
					$rotate_log = true;
				}
				break;
			case 'week':
				if ((time() - $file_creation_time) >= 3600*24*7){
					$rotate_log = true;
				}
				break;
			case 'month':
				/**
				 * We'll round the month to thirty days
				 */
				if ((time() - $file_creation_time) >= 3600*24*30){
					$rotate_log = true;
				}
				break;
			default:
				if (strpos(LOG_ROTATION_INTERVAL, 'size') === false){
					return ;
				}
				$size = explode(':', LOG_ROTATION_INTERVAL);
				$max_size = $size[1];
				if ($max_size < $filesize){
					$rotate_log = true;
				}
				break;
		}
		
		if ($rotate_log){
			$this->_doRotateLog();
		}
		return;
	}
	
	/**
	 * Rotate the old log to the one of the current date
	 */
	protected function _doRotateLog(){
		$filename = $this->_getFilename();
		$newname = date('Ymd-His').'_'.$filename;
		
		if (!is_dir(LOG_DIR.'/rotated')){
			mkdir(LOG_DIR.'/rotated/');
		}
		rename(LOG_DIR.'/'.$filename, LOG_DIR.'/rotated/'.$newname);
	}
}