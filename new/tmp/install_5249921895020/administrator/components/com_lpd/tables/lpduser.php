<?php
/**
 * @version		$Id: lpduser.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableLPDUser extends JTable
{

	var $id = null;
	var $userID = null;
	var $userName = null;
	var $gender = null;
	var $description = null;
	var $image = null;
	var $url = null;
	var $group = null;
	var $plugins = null;

	function __construct( & $db) {
	
		parent::__construct('#__lpd_users', 'id', $db);
	}
	
	function check() {
	
		if (trim($this->url) != '' && substr($this->url, 0, 7) != 'http://')
		$this->url = 'http://'.$this->url;
		return true;
	}
	
	function bind($array, $ignore = '')	{
	
		if (key_exists('plugins', $array) && is_array($array['plugins'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['plugins']);
			$array['plugins'] = $registry->toString();
		}
		
		return parent::bind($array, $ignore);
	}
	
}
