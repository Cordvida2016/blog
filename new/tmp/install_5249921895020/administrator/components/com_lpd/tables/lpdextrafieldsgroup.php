<?php
/**
 * @version		$Id: lpdextrafieldsgroup.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class TableLPDExtraFieldsGroup extends JTable
{

	var $id = null;
	var $name = null;

	function __construct( & $db) {
		parent::__construct('#__lpd_extra_fields_groups', 'id', $db);
	}
	
	function check() {
		if (trim($this->name) == '') {
			$this->setError(JText::_('LPD_GROUP_MUST_HAVE_A_NAME'));
			return false;
		}
		return true;
	}

}
