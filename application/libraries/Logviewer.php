<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	
	
/**
 * CodeIgniter Log Viewer Library
 *
 * @category  Library
 * @package   CodeIgniter
 * @author    Wahyu Kristianto <w.kristories@gmail.com>
 * @copyright 2012 Wahyu Kristianto.
 * @license   MIT License http://www.opensource.org/licenses/mit-license.php
 * @version   Release: 1.0
 * @link      https://github.com/Kristories/Codeigniter-Log-Viewer-Library
 */

class Logviewer
{
	/**
	 * CI instance.
	 */
	private $_ci;
	
	/**
	 * ------------------------------------------------------------------------------------------
	 * Constructor
	 * ------------------------------------------------------------------------------------------
	 */
	public function __construct()
	{
		if (function_exists('get_instance'))
		{
			$this->_ci = get_instance();
		}
		else
		{
			$this->_ci = NULL;
		}
		
		$this->_ci->load->helper(array('file'));
		
		
	}

	/**
	 * ------------------------------------------------------------------------------------------
	 * Data
	 * ------------------------------------------------------------------------------------------
	 * @param  string $type
	 */
	public function data($type = NULL)
	{
		$file		= $this->_ci->config->item('log_path').'log-'.date('Y-m-d').'.php';
		$log 		= read_file($file);
		$messages 	= explode("\n", $log);
		array_pop($messages);
		krsort($messages);

		$fix = array();
		
		foreach($messages as $msg)
		{
			$message 				= explode(" | ", $msg);
			$data['level']			= strtolower($message[0]);
			$data['date']			= strtolower($message[1]);
			$data['description']	= strtolower($message[2]);
			
			if($type)
			{
				if($data['level'] == $type){
					$fix[]			= $data;
				}
			}
			else
			{
				$fix[]				= $data;
			}
		}
		
		return $fix;
	}
	
	/**
	 * ------------------------------------------------------------------------------------------
	 * Assets
	 * ------------------------------------------------------------------------------------------
	 * @param  string $theme
	 */
	function assets($theme)
	{
		$asset 	= $this->_ci->input->get('asset');
		
		if($asset == 'css')
		{
			$file	= $this->_ci->input->get('file') OR show_404();
			$file 	= APPPATH.'views/Logviewer/'.$theme.'/assets/css/'.$file;
		}
		elseif($asset == 'js')
		{
			$file	= $this->_ci->input->get('file') OR show_404();
			$file 	= APPPATH.'views/Logviewer/'.$theme.'/assets/js/'.$file;
		}
		elseif($asset == 'img')
		{
			$file	= $this->_ci->input->get('file') OR show_404();
			$file 	= APPPATH.'views/Logviewer/'.$theme.'/assets/img/'.$file;
		}
		else
		{
			show_404();
		}
		
		$file_info	= get_file_info($file);
		if(! $file_info)
		{
			show_404();
		}

		$mime = get_mime_by_extension($file) OR show_404();
		header('Content-Type: '.$mime);
		echo read_file($file);
		exit();
	}
	
	/**
	 * ------------------------------------------------------------------------------------------
	 * Run
	 * ------------------------------------------------------------------------------------------
	 * @param  string $theme
	 */
	public function run($theme = NULL)
	{
		if($theme == NULL)
		{
			$theme = 'default';
		}
		
		if($this->_ci->input->get('asset'))
		{
			$this->assets($theme);
		}

		$messages	= $this->level();


		$data	= array(
			'messages'	=> $messages,
		);
		
		$this->_ci->load->view('Logviewer/'.$theme.'/index', $data);
	}
}

/* End of file Logviewer.php */