<?php
/**
 * @version		$Id: settings.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class LPDModelSettings extends JModel {

	function save(){
		$mainframe = &JFactory::getApplication();
		$component =& JTable::getInstance('component');
		$component->loadByOption('com_lpd');
		$post = JRequest::get('post');
		$component->bind($post);
		if (!$component->check()) {
			$mainframe->enqueueMessage($component->getError(), 'error');
			return false;
		}
		if (!$component->store()) {
			$mainframe->enqueueMessage($component->getError(), 'error');
			return false;
		}
		return true;
	}

	function &getParams() {
		static $instance;
		if ($instance == null) {
			$component =& JTable::getInstance('component');
			$component->loadByOption( 'com_lpd' );
			$instance = new JParameter( $component->params, JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'config.xml' );
		}
		return $instance;
	}
}
