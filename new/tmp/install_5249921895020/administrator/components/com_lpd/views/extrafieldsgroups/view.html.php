<?php
/**
 * @version		$Id: view.html.php 1112 2011-10-11 14:34:53Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewExtraFieldsGroups extends JView
{

	function display($tpl = null) {

		$mainframe = &JFactory::getApplication();
		$user = & JFactory::getUser();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', '', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', '', 'word');

		$model = & $this->getModel();
		$extraFieldGroups = $model->getGroups();

		$this->assignRef('rows', $extraFieldGroups);
		$total = $model->getTotalGroups();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		$this->assignRef('page', $pageNav);


		JToolBarHelper::title(JText::_('LPD_EXTRA_FIELD_GROUPS'), 'lpd.png');

		JToolBarHelper::deleteList('', 'remove', 'LPD_DELETE');
		JToolBarHelper::editList();
		JToolBarHelper::addNew();

		if(LPD_JVERSION == '16'){
			JToolBarHelper::preferences('com_lpd', 550, 875, 'LPD_PARAMETERS');
		}
		else {
			$toolbar=& JToolBar::getInstance('toolbar');
			$toolbar->appendButton('Popup', 'config', 'Parameters', 'index.php?option=com_lpd&view=settings');
		}

		$this->loadHelper('html');
		LPDHelperHTML::subMenu();

		parent::display($tpl);
	}

}
