<?php
/**
 * @version		$Id: permissions.php 1267 2011-10-27 15:52:11Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.parameter');

class LPDHelperPermissions {

	function setPermissions() {
		$params = &LPDHelperUtilities::getParams('com_lpd');
		$user = &JFactory::getUser();
		if ($user->guest){
			return;
		}
		$LPDUser = LPDHelperPermissions::getLPDUser($user->id);
		if (!is_object($LPDUser)){
			return;
		}
		$LPDUserGroup = LPDHelperPermissions::getLPDUserGroup($LPDUser->group);
		if (is_null($LPDUserGroup)){
			return;
		}
		$LPDPermissions = &LPDPermissions::getInstance();
		$permissions = new JParameter($LPDUserGroup->permissions);
		$LPDPermissions->permissions = $permissions;
		if ($permissions->get('categories') == 'none') {
			return;
		}
		else if ($permissions->get('categories') == 'all') {
			if ($permissions->get('add') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
				$LPDPermissions->actions[] = 'add.category.all';
				$LPDPermissions->actions[] = 'tag';
				$LPDPermissions->actions[] = 'extraFields';
			}
			if ($permissions->get('editOwn') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
				$LPDPermissions->actions[] = 'editOwn.item.'.$user->id;
				$LPDPermissions->actions[] = 'tag';
				$LPDPermissions->actions[] = 'extraFields';
			}
			if ($permissions->get('editAll') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
				$LPDPermissions->actions[] = 'editAll.category.all';
				$LPDPermissions->actions[] = 'tag';
				$LPDPermissions->actions[] = 'extraFields';
			}
			if ($permissions->get('publish') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
				$LPDPermissions->actions[] = 'publish.category.all';
			}
			if ($permissions->get('comment')) {
				$LPDPermissions->actions[] = 'comment.category.all';
			}
		}
		else {
			$selectedCategories = $permissions->get('categories', NULL);
			if (is_string($selectedCategories)){
				$searchIDs[] = $selectedCategories;
			}
			else {
				$searchIDs = $selectedCategories;
			}
			if ($permissions->get('inheritance')) {
				JLoader::register('LPDModelItemlist', JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'models'.DS.'itemlist.php');
				$categories = LPDModelItemlist::getCategoryTree($searchIDs);
			}
			else {
				$categories = $searchIDs;
			}
			if (is_array($categories) && count($categories)) {
				foreach ($categories as $category) {
					if ($permissions->get('add') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
						$LPDPermissions->actions[] = 'add.category.'.$category;
						$LPDPermissions->actions[] = 'tag';
						$LPDPermissions->actions[] = 'extraFields';
					}
					if ($permissions->get('editOwn') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
						$LPDPermissions->actions[] = 'editOwn.item.'.$user->id.'.'.$category;
						$LPDPermissions->actions[] = 'tag';
						$LPDPermissions->actions[] = 'extraFields';
					}
					if ($permissions->get('editAll') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
						$LPDPermissions->actions[] = 'editAll.category.'.$category;
						$LPDPermissions->actions[] = 'tag';
						$LPDPermissions->actions[] = 'extraFields';
					}
					if ($permissions->get('publish') && $permissions->get('frontEdit') && $params->get('frontendEditing')) {
						$LPDPermissions->actions[] = 'publish.category.'.$category;
					}
					if ($permissions->get('comment')) {
						$LPDPermissions->actions[] = 'comment.category.'.$category;
					}
				}
			}
		}
		return;
	}

	function checkPermissions() {
		$view = JRequest::getCmd('view');
		if ($view != 'item'){
			return;
		}
		$task = JRequest::getCmd('task');

		switch ($task) {

			case 'add':
				if (!LPDHelperPermissions::canAddItem())
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				break;

			case 'edit':
			case 'deleteAttachment':
			case 'checkin':
				$cid = JRequest::getInt('cid');
				if (!$cid)
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));

				JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
				$item = &JTable::getInstance('LPDItem', 'Table');
				$item->load($cid);

				if (!LPDHelperPermissions::canEditItem($item->created_by, $item->catid))
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				break;

			case 'save':
				$cid = JRequest::getInt('id');
				if ($cid) {

					JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
					$item = &JTable::getInstance('LPDItem', 'Table');
					$item->load($cid);

					if (!LPDHelperPermissions::canEditItem($item->created_by, $item->catid))
					JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				}
				else {
					if (!LPDHelperPermissions::canAddItem())
					JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				}

				break;

			case 'tag':
				if (!LPDHelperPermissions::canAddTag())
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				break;

			case 'extraFields':
				if (!LPDHelperPermissions::canRenderExtraFields())
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
				break;

		}
	}

	function getLPDUser($userID) {

		$db = &JFactory::getDBO();
		$query = "SELECT * FROM #__lpd_users WHERE userID = ".(int)$userID;
		$db->setQuery($query);
		$row = $db->loadObject();
		return $row;
	}

	function getLPDUserGroup($id) {

		$db = &JFactory::getDBO();
		$query = "SELECT * FROM #__lpd_user_groups WHERE id = ".(int)$id;
		$db->setQuery($query);
		$row = $db->loadObject();
		return $row;
	}

	function canAddItem($category = false) {

		$user = &JFactory::getUser();
		$LPDPermissions = &LPDPermissions::getInstance();
		if(in_array('add.category.all', $LPDPermissions->actions)){
			return true;
		}
		if($category){
			return in_array('add.category.'.$category, $LPDPermissions->actions);
		}
		$db = &JFactory::getDBO();
		$query = "SELECT * FROM #__lpd_categories WHERE published=1 AND trash=0";
		if(LPD_JVERSION == '16'){
			$query .= " AND access IN(".implode(',', $user->authorisedLevels()).")";
		}
		else {
			$aid = (int) $user->get('aid');
			$query .= " AND access<={$aid}";
		}
		$db->setQuery($query);
		$categories = $db->loadObjectList();
		foreach ($categories as $category) {
			if(in_array('add.category.'.$category->id, $LPDPermissions->actions)){
				return true;
			}
		}

		return false;
	}

	function canAddToAll(){
		$LPDPermissions = &LPDPermissions::getInstance();
		return in_array('add.category.all', $LPDPermissions->actions);
	}

	function canEditItem($itemOwner, $itemCategory) {
		$LPDPermissions = &LPDPermissions::getInstance();
		if(
		in_array('editAll.category.all', $LPDPermissions->actions) ||
		in_array('editOwn.item.'.$itemOwner, $LPDPermissions->actions) ||
		in_array('editOwn.item.'.$itemOwner.'.'.$itemCategory, $LPDPermissions->actions) ||
		in_array('editAll.category.'.$itemCategory, $LPDPermissions->actions)
		)
		{
			return true;
		}
		else {
			return false;
		}
	}
	
	function canPublishItem($itemCategory) {
		$LPDPermissions = &LPDPermissions::getInstance();
		if(in_array('publish.category.all', $LPDPermissions->actions) || in_array('publish.category.'.$itemCategory, $LPDPermissions->actions)){
			return true;
		}
		else {
			return false;
		}
	}

	function canAddTag() {
		$LPDPermissions = &LPDPermissions::getInstance();
		return in_array('tag', $LPDPermissions->actions);
	}

	function canRenderExtraFields() {
		$LPDPermissions = &LPDPermissions::getInstance();
		return in_array('extraFields', $LPDPermissions->actions);
	}

	function canAddComment($itemCategory) {
		$LPDPermissions = &LPDPermissions::getInstance();
		return in_array('comment.category.all', $LPDPermissions->actions) || in_array('comment.category.'.$itemCategory, $LPDPermissions->actions);
	}


}

class LPDPermissions {
	var $actions = array();
	var $permissions = null;
	function & getInstance() {
		static $instance;
		if(!is_object($instance)){
			$instance = new LPDPermissions();
		}
		return $instance;
	}
}