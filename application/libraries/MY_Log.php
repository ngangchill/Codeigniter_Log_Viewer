<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log
{
	protected $_log_path;
	protected $_threshold	= 1;
	protected $_date_fmt	= 'Y-m-d H:i:s';
	protected $_enabled		= TRUE;
	protected $_levels		= array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');
	
	public function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------

	public function write_log($level = 'error', $msg, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if ( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
		{
			return FALSE;
		}

		$filepath = $this->_log_path.'log-'.date('Y-m-d').'.php';

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}

		$message = $level.' | '.date($this->_date_fmt).' | '.$msg."\n";

		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}

}