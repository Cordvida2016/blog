<?php
/**
 * @version		$Id: lpdextrafield.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableLPDExtraField extends JTable
{

	var $id = null;
	var $name = null;
	var $value = null;
	var $type = null;
	var $group = null;
	var $published = null;
	var $ordering = null;

	function __construct( & $db) {
		parent::__construct('#__lpd_extra_fields', 'id', $db);
	}
	
}
