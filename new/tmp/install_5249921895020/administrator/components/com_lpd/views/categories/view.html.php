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

class LPDViewCategories extends JView
{

	function display($tpl = null)
	{

		$mainframe = &JFactory::getApplication();
		$user = & JFactory::getUser();
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', 'c.ordering', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$filter_trash = $mainframe->getUserStateFromRequest($option.$view.'filter_trash', 'filter_trash', 0, 'int');
		$filter_category = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', 0, 'int');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$language = $mainframe->getUserStateFromRequest($option.$view.'language', 'language', '', 'string');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		$model = & $this->getModel();

		$categories = $model->getData();
		require_once(JPATH_COMPONENT.DS.'models'.DS.'category.php');
		$categoryModel= new LPDModelCategory;

		$params = & JComponentHelper::getParams('com_lpd');
		$this->assignRef('params', $params);
		if ($params->get('showItemsCounterAdmin')){
			for ($i=0; $i<sizeof($categories); $i++){
				$categories[$i]->numOfItems=$categoryModel->countCategoryItems($categories[$i]->id);
			}
		}

		$this->assignRef('rows', $categories);
		$total = $model->getTotal();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		$this->assignRef('page', $pageNav);

		$lists = array ();
		$lists['search'] = $search;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		$filter_trash_options[] = JHTML::_('select.option', 0, JText::_('LPD_CURRENT'));
		$filter_trash_options[] = JHTML::_('select.option', 1, JText::_('LPD_TRASHED'));
		$lists['trash'] = JHTML::_('select.genericlist', $filter_trash_options, 'filter_trash', '', 'value', 'text', $filter_trash);

		$filter_state_options[] = JHTML::_('select.option', -1, JText::_('LPD_SELECT_STATE'));
		$filter_state_options[] = JHTML::_('select.option', 1, JText::_('LPD_PUBLISHED'));
		$filter_state_options[] = JHTML::_('select.option', 0, JText::_('LPD_UNPUBLISHED'));
		$lists['state'] = JHTML::_('select.genericlist', $filter_state_options, 'filter_state', '', 'value', 'text', $filter_state);

		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			$languages = JHTML::_('contentlanguage.existing', true, true);
			array_unshift($languages, JHTML::_('select.option', '', JText::_('LPD_SELECT_LANGUAGE')));
			$lists['language'] = JHTML::_('select.genericlist', $languages, 'language', '', 'value', 'text', $language);
		}
		$this->assignRef('lists', $lists);

		JToolBarHelper::title(JText::_('LPD_CATEGORIES'), 'lpd.png');

		if ($filter_trash == 1) {
			JToolBarHelper::custom('restore','restore.png','restore_f2.png','LPD_RESTORE', true);
			JToolBarHelper::deleteList('LPD_ARE_YOU_SURE_YOU_WANT_TO_DELETE_SELECTED_CATEGORIES', 'remove', 'LPD_DELETE');
		}
		else {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::customX( 'move', 'move.png', 'move_f2.png', 'LPD_MOVE' );
			JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'LPD_COPY' );
			JToolBarHelper::editList();
			JToolBarHelper::addNew();
			JToolBarHelper::trash('trash');
		}

		/*if(LPD_JVERSION == '16'){
			JToolBarHelper::preferences('com_lpd', 550, 875, 'LPD_PARAMETERS');
		}
		else {
			$toolbar=& JToolBar::getInstance('toolbar');
        	$toolbar->appendButton('Popup', 'config', 'Parameters', 'index.php?option=com_lpd&view=settings');			
		}*/

		$this->loadHelper('html');
		LPDHelperHTML::subMenu();
		
		$this->assignRef('filter_trash', $filter_trash);
		$template = $mainframe->getTemplate();
		$this->assignRef('template', $template);
		$ordering = ( ($this->lists['order'] == 'c.ordering' || $this->lists['order'] == 'c.parent, c.ordering') && (!$this->filter_trash) );
		$this->assignRef('ordering', $ordering);
		parent::display($tpl);

	}

	function move(){

		$mainframe = &JFactory::getApplication();
		JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');
		$cid = JRequest::getVar('cid');

		foreach ($cid as $id) {
			$row = & JTable::getInstance('LPDCategory', 'Table');
			$row->load($id);
			$rows[]=$row;
		}

		require_once(JPATH_COMPONENT.DS.'models'.DS.'categories.php');
		$categoriesModel= new LPDModelCategories;
		$categories_option[]=JHTML::_('select.option', 0, JText::_('LPD_NONE_ONSELECTLISTS'));
		$categories = $categoriesModel->categoriesTree(NULL, true);
		$categories_options=@array_merge($categories_option, $categories);
		foreach($categories_options as $option){
			if(in_array($option->value, $cid))
				$option->disable = true;
		}
		$lists['categories'] = JHTML::_('select.genericlist', $categories_options, 'category', 'class="inputbox" size="8"', 'value', 'text');

		$this->assignRef('rows',$rows);
		$this->assignRef('lists',$lists);

		JToolBarHelper::title( JText::_('LPD_MOVE_CATEGORIES'), 'lpd.png' );

		JToolBarHelper::custom('saveMove','save.png','save_f2.png','LPD_SAVE', false);
		JToolBarHelper::cancel();

		parent::display();
	}

}
