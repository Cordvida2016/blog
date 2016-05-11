<?php
/**
 * @version		$Id: usergroup.php 1349 2011-11-25 16:56:49Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class LPDModelUserGroup extends JModel
{

	function getData() {
	
		$cid = JRequest::getVar('cid');
		$row = & JTable::getInstance('LPDUserGroup', 'Table');
		$row->load($cid);
		return $row;
	}

	function save() {
	
		$mainframe = &JFactory::getApplication();
		$row = & JTable::getInstance('LPDUserGroup', 'Table');
	
		if (!$row->bind(JRequest::get('post'))) {
			$mainframe->redirect('index.php?option=com_lpd&view=usergroups', $row->getError(), 'error');
		}
	
		if (!$row->check()) {
			$mainframe->redirect('index.php?option=com_lpd&view=usergroup&cid='.$row->id, $row->getError(), 'error');
		}
		
		if (!$row->store()) {
			$mainframe->redirect('index.php?option=com_lpd&view=usergroups', $row->getError(), 'error');
		}

		$cache = & JFactory::getCache('com_lpd');
		$cache->clean();
		
		switch(JRequest::getCmd('task')) {
			case 'apply':
			$msg = JText::_('LPD_CHANGES_TO_USER_GROUP_SAVED');
			$link = 'index.php?option=com_lpd&view=usergroup&cid='.$row->id;
			break;
			case 'save':
			default:
			$msg = JText::_('LPD_USER_GROUP_SAVED');
			$link = 'index.php?option=com_lpd&view=usergroups';
			break;
		}
		$mainframe->redirect($link, $msg);
	}
	
}
