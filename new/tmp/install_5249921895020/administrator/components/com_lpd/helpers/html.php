<?php
/**
 * @version		$Id: html.php 1193 2011-10-17 15:51:26Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class LPDHelperHTML {

	function subMenu() {
		$user = &JFactory::getUser();
		$view = JRequest::getCmd('view');
		$view = JString::strtolower($view);
		$params = & JComponentHelper::getParams('com_lpd');
		JSubMenuHelper::addEntry(JText::_('LPD_ITEMS'), 'index.php?option=com_lpd&view=items', $view == 'items');
		JSubMenuHelper::addEntry(JText::_('LPD_CATEGORIES'), 'index.php?option=com_lpd&view=categories', $view == 'categories');
	}

	function stateToggler(&$row, $key, $property = 'published', $tasks = array('publish', 'unpublish'), $labels = array('LPD_PUBLISH', 'LPD_UNPUBLISH')) {
		$task = $row->$property ? $tasks[1] : $tasks[0];
		$action = $row->$property ? JText::_($labels[1]) : JText::_($labels[0]);
		$class = 'lpdToggler';
		$status = $row->$property ? 'lpdActive':'lpdInactive';
		$href = '<a class="'.$class.' '.$status.'" href="javascript:void(0);" onclick="return listItemTask(\'cb'. $key .'\',\''. $task .'\')" title="'. $action .'">'.$action.'</a>';
		return $href;
	}
	
}