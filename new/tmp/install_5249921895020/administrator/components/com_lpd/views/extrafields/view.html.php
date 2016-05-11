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

class LPDViewExtraFields extends JView
{

	function display($tpl = null)
	{

		$mainframe = &JFactory::getApplication();
		$user = & JFactory::getUser();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', 'groupname', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', 'ASC', 'word');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		$filter_type = $mainframe->getUserStateFromRequest($option.$view.'filter_type', 'filter_type', '', 'string');
		$filter_group = $mainframe->getUserStateFromRequest($option.$view.'filter_group', 'filter_group', '', 'string');

		$model = & $this->getModel();

		$extraFields = $model->getData();

		$this->assignRef('rows', $extraFields);
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

		$extraFieldGroups = $model->getGroups();
		$groups[] = JHTML::_('select.option', '0', JText::_('LPD_SELECT_GROUP'));

		foreach ($extraFieldGroups as $extraFieldGroup) {
			$groups[] = JHTML::_('select.option', $extraFieldGroup->id, $extraFieldGroup->name);
		}
		$lists['group'] = JHTML::_('select.genericlist', $groups, 'filter_group', '', 'value', 'text', $filter_group);

		$typeOptions[] = JHTML::_('select.option', 0, JText::_('LPD_SELECT_TYPE'));
		$typeOptions[] = JHTML::_('select.option', 'textfield', JText::_('LPD_TEXT_FIELD'));
		$typeOptions[] = JHTML::_('select.option', 'textarea', JText::_('LPD_TEXTAREA'));
		$typeOptions[] = JHTML::_('select.option', 'select', JText::_('LPD_DROPDOWN_SELECTION'));
		$typeOptions[] = JHTML::_('select.option', 'multipleSelect', JText::_('LPD_MULTISELECT_LIST'));
		$typeOptions[] = JHTML::_('select.option', 'radio', JText::_('LPD_RADIO_BUTTONS'));
		$typeOptions[] = JHTML::_('select.option', 'link', JText::_('LPD_LINK'));
		$typeOptions[] = JHTML::_('select.option', 'csv', JText::_('LPD_CSV_DATA'));
		$typeOptions[] = JHTML::_('select.option', 'labels', JText::_('LPD_SEARCHABLE_LABELS'));
		$typeOptions[] = JHTML::_('select.option', 'date', JText::_('LPD_DATE'));
		$lists['type'] = JHTML::_('select.genericlist', $typeOptions, 'filter_type', '', 'value', 'text', $filter_type);

		$this->assignRef('lists', $lists);

		JToolBarHelper::title(JText::_('LPD_EXTRA_FIELDS'), 'lpd.png');

		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
		JToolBarHelper::deleteList('LPD_ARE_YOU_SURE_YOU_WANT_TO_DELETE_SELECTED_EXTRA_FIELDS', 'remove', 'LPD_DELETE');
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
