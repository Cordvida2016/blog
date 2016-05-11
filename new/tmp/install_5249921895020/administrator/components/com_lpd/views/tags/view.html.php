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

class LPDViewTags extends JView
{

	function display($tpl = null) {

		$mainframe = &JFactory::getApplication();
		$user = & JFactory::getUser();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', 'id', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', 'DESC', 'word');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		$model = & $this->getModel();

		$tags = $model->getData();

		$this->assignRef('rows', $tags);
		$total = $model->getTotal();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		$this->assignRef('page', $pageNav);

		$lists = array ();
		$lists['search'] = $search;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		$filter_state_options[] = JHTML::_('select.option', -1, JText::_('LPD_SELECT_STATE'));
		$filter_state_options[] = JHTML::_('select.option', 1, JText::_('LPD_PUBLISHED'));
		$filter_state_options[] = JHTML::_('select.option', 0, JText::_('LPD_UNPUBLISHED'));
		$lists['state'] = JHTML::_('select.genericlist', $filter_state_options, 'filter_state', '', 'value', 'text', $filter_state);

		$this->assignRef('lists', $lists);

		JToolBarHelper::title(JText::_('LPD_TAGS'), 'lpd.png');

		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
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
