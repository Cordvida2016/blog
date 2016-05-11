<?php
/**
 * @version		$Id: view.html.php 1204 2011-10-17 19:43:49Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewUsers extends JView
{

	function display($tpl = null) {

		$mainframe = &JFactory::getApplication();
		$document = &JFactory::getDocument();
		
		$params = &JComponentHelper::getParams('com_lpd');
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', '', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$filter_status = $mainframe->getUserStateFromRequest($option.$view.'filter_status', 'filter_status', -1, 'int');
		$filter_group = $mainframe->getUserStateFromRequest($option.$view.'filter_group', 'filter_group', 1, 'filter_group');
		$filter_group_lpd = $mainframe->getUserStateFromRequest($option.$view.'filter_group_lpd', 'filter_group_lpd', '', 'filter_group_lpd');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		JModel::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');
		$model = & JModel::getInstance('Users', 'LPDModel');

		$users = $model->getData();

		for ($i=0; $i<sizeof($users); $i++){

			$users[$i]->loggedin = $model->checkLogin($users[$i]->id);
			$users[$i]->profileID = $model->hasProfile($users[$i]->id);

			if ($users[$i]->lastvisitDate == "0000-00-00 00:00:00") {
				$users[$i]->lvisit = false;
			}
			else {
				$users[$i]->lvisit = $users[$i]->lastvisitDate;
			}
			$users[$i]->link = JRoute::_('index.php?option=com_lpd&view=user&cid='.$users[$i]->id);

		}

		$this->assignRef('rows', $users);
		$total = $model->getTotal();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		$this->assignRef('page', $pageNav);

		$lists = array ();
		$lists['search'] = $search;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		$filter_status_options[] = JHTML::_('select.option', -1, JText::_('LPD_SELECT_STATE'));
		$filter_status_options[] = JHTML::_('select.option', 0, JText::_('LPD_ENABLED'));
		$filter_status_options[] = JHTML::_('select.option', 1, JText::_('LPD_BLOCKED'));
		$lists['status'] = JHTML::_('select.genericlist', $filter_status_options, 'filter_status', '', 'value', 'text', $filter_status);

		$userGroups = $model->getUserGroups();
		$groups[] = JHTML::_('select.option', '0', JText::_('LPD_SELECT_JOOMLA_GROUP'));

		foreach ($userGroups as $userGroup) {
			$groups[] = JHTML::_('select.option', $userGroup->value, $userGroup->text);
		}

		$lists['filter_group'] = JHTML::_('select.genericlist', $groups, 'filter_group', '', 'value', 'text', $filter_group);


		$LPDuserGroups = $model->getUserGroups('lpd');
		$LPDgroups[] = JHTML::_('select.option', '0', JText::_('LPD_SELECT_LPD_GROUP'));

		foreach ($LPDuserGroups as $LPDuserGroup) {
			$LPDgroups[] = JHTML::_('select.option', $LPDuserGroup->id, $LPDuserGroup->name);
		}

		$lists['filter_group_lpd'] = JHTML::_('select.genericlist', $LPDgroups, 'filter_group_lpd', '', 'value', 'text', $filter_group_lpd);

		$this->assignRef('lists', $lists);
		
		if(LPD_JVERSION == '16') {
			$dateFormat = JText::_('LPD_J16_DATE_FORMAT');
		}
		else {
			$dateFormat = JText::_('LPD_DATE_FORMAT');
		}
		$this->assignRef('dateFormat', $dateFormat);
		
		$template = $mainframe->getTemplate();
		$this->assignRef('template', $template);

		if($mainframe->isAdmin()) {
			JToolBarHelper::title(JText::_('LPD_USERS'), 'lpd.png');
			JToolBarHelper::customX( 'move', 'move.png', 'move_f2.png', 'LPD_MOVE' );
			JToolBarHelper::deleteList('LPD_WARNING_YOU_ARE_ABOUT_TO_DELETE_THE_SELECTED_USERS_PERMANENTLY_FROM_THE_SYSTEM', 'delete', 'LPD_DELETE');
			JToolBarHelper::publishList('enable', 'LPD_ENABLE');
			JToolBarHelper::unpublishList('disable', 'LPD_DISABLE');
			JToolBarHelper::editList();
			JToolBarHelper::deleteList('LPD_ARE_YOU_SURE_YOU_WANT_TO_RESET_SELECTED_USERS', 'remove', 'LPD_RESET_USER_DETAILS');
	
			$toolbar=& JToolBar::getInstance('toolbar');
	
			if(LPD_JVERSION == '16'){
				JToolBarHelper::preferences('com_lpd', 550, 875, 'LPD_PARAMETERS');
			}
			else {
				$toolbar->appendButton('Popup', 'config', 'LPD_PARAMETERS', 'index.php?option=com_lpd&view=settings');
			}
		
			$this->loadHelper('html');
			LPDHelperHTML::subMenu();
			
			$user = & JFactory::getUser();
			if ($user->gid > 23) {
				if (!$params->get('hideImportButton')){
					$buttonUrl = JURI::base().'index.php?option=com_lpd&amp;view=users&amp;task=import';
					$buttonText = JText::_('LPD_IMPORT_JOOMLA_USERS');
					$button	= '<a id="LPDImportUsersButton" href="'.$buttonUrl.'"><span class="icon-32-archive" title="'.$buttonText.'"></span>'.$buttonText.'</a>';
					$toolbar->appendButton('Custom', $button);
				}
			}
		}
		$isAdmin = $mainframe->isAdmin();
		$this->assignRef('isAdmin', $isAdmin);
		
		if($mainframe->isSite()){
			// CSS
			$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.frontend.css');
			$document->addStyleSheet(JURI::root(true).'/templates/system/css/general.css');
			$document->addStyleSheet(JURI::root(true).'/templates/system/css/system.css');
			if(LPD_JVERSION == '16') {
				$document->addStyleSheet(JURI::root(true).'/administrator/templates/bluestork/css/template.css');
				$document->addStyleSheet(JURI::root(true).'/media/system/css/system.css');
			} else {
				$document->addStyleSheet(JURI::root(true).'/administrator/templates/khepri/css/general.css');
			}
		}
		
		parent::display($tpl);
	}

	function move(){

		$mainframe = &JFactory::getApplication();
		JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
		$cid = JRequest::getVar('cid');
		JArrayHelper::toInteger($cid);
		
		foreach ($cid as $id) {
			$row = &JFactory::getUser($id);
			$rows[]=$row;
		}
		$this->assignRef('rows',$rows);

		$model = & $this->getModel('users');
		$lists = array ();
		$userGroups = $model->getUserGroups();
		$groups[] = JHTML::_('select.option', '', JText::_('LPD_DO_NOT_CHANGE'));
		foreach ($userGroups as $userGroup) {
			$groups[] = JHTML::_('select.option', $userGroup->value, JText::_($userGroup->text));
		}
		$fieldName = 'group';
		$attributes = 'size="10"';
		if(LPD_JVERSION == '16') {
			$attributes .= 'multiple="multiple"';
			$fieldName .= '[]';
		}
		
		$lists['group'] = JHTML::_('select.genericlist', $groups, $fieldName, $attributes, 'value', 'text', '');

		$LPDuserGroups = $model->getUserGroups('lpd');
		$LPDgroups[] = JHTML::_('select.option', '0', JText::_('LPD_DO_NOT_CHANGE'));
		foreach ($LPDuserGroups as $LPDuserGroup) {
			$LPDgroups[] = JHTML::_('select.option', $LPDuserGroup->id, $LPDuserGroup->name);
		}
		$lists['lpdgroup'] = JHTML::_('select.genericlist', $LPDgroups, 'lpdgroup', 'size="10"', 'value', 'text', 0);

		$this->assignRef('lists', $lists);

		JToolBarHelper::title( JText::_('LPD_MOVE_USERS'), 'lpd.png' );
		JToolBarHelper::custom('saveMove','save.png','save_f2.png','LPD_SAVE', false);
		JToolBarHelper::cancel();

		parent::display();
	}

}
