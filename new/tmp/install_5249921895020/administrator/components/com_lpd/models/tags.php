<?php
/**
 * @version		$Id: tags.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class LPDModelTags extends JModel
{

	function getData() {

		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$db = & JFactory::getDBO();
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', 'id', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', 'DESC', 'word');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);

		$query = "SELECT * FROM #__lpd_tags WHERE id>0";

		if ($filter_state > -1) {
			$query .= " AND published={$filter_state}";
		}

		if ($search) {
			$query .= " AND LOWER( name ) LIKE ".$db->Quote('%'.$db->getEscaped($search, true).'%', false);
		}

		if (!$filter_order) {
			$filter_order = "name";
		}

		$query .= " ORDER BY {$filter_order} {$filter_order_Dir}";

		$db->setQuery($query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		return $rows;
	}

	function getTotal() {

		$mainframe = &JFactory::getApplication();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$db = & JFactory::getDBO();
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', 1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);

		$query = "SELECT COUNT(*) FROM #__lpd_tags WHERE id>0";

		if ($filter_state > -1) {
			$query .= " AND published={$filter_state}";
		}

		if ($search) {
			$query .= " AND LOWER( name ) LIKE ".$db->Quote('%'.$db->getEscaped($search, true).'%', false);
		}

		$db->setQuery($query);
		$total = $db->loadresult();
		return $total;
	}

	function publish() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = & JTable::getInstance('LPDTag', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->publish($id, 1);
		}
		$cache = & JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=tags');
	}

	function unpublish() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = & JTable::getInstance('LPDTag', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->publish($id, 0);
		}
		$cache = & JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=tags');
	}

	function remove() {

		$mainframe = &JFactory::getApplication();
		$db = & JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		$row = & JTable::getInstance('LPDTag', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->delete($id);
		}
		$cache = & JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=tags', JText::_('LPD_DELETE_COMPLETED'));
	}
	
	function getFilter(){
	    
	    $db = & JFactory::getDBO();
	    $query = "SELECT name, id FROM #__lpd_tags ORDER BY name";
		$db->setQuery($query, 0 , 1000);
		$rows = $db->loadObjectList();
		return $rows;

	}

}
