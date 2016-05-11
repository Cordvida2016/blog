<?php
/**
 * @version		$Id: category.php 1109 2011-10-10 17:42:58Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class LPDModelCategory extends JModel
{

	function getData() {

		$cid = JRequest::getVar('cid');
		$row = & JTable::getInstance('LPDCategory', 'Table');
		$row->load($cid);
		return $row;
	}

	function save() {

		$mainframe = &JFactory::getApplication();
		jimport('joomla.filesystem.file');
		require_once (JPATH_COMPONENT.DS.'lib'.DS.'class.upload.php');
		$row = & JTable::getInstance('LPDCategory', 'Table');
		$params = & JComponentHelper::getParams('com_lpd');
		if (!$row->bind(JRequest::get('post'))) {
			$mainframe->redirect('index.php?option=com_lpd&view=categories', $row->getError(), 'error');
		}

		$row->description = JRequest::getVar('description', '', 'post', 'string', 2);
		if($params->get('xssFiltering')){
			$filter = new JFilterInput(array(), array(), 1, 1, 0);
			$row->description = $filter->clean( $row->description );
		}

		if (!$row->id) {
			$row->ordering = $row->getNextOrder('parent = '.$row->parent.' AND trash=0');
		}

		if (!$row->check()) {
			$mainframe->redirect('index.php?option=com_lpd&view=category&cid='.$row->id, $row->getError(), 'error');
		}

		if (!$row->store()) {
			$mainframe->redirect('index.php?option=com_lpd&view=categories', $row->getError(), 'error');
		}

		if(!$params->get('disableCompactOrdering'))
		$row->reorder('parent = '.$row->parent.' AND trash=0');

		
		if((int)$params->get('imageMemoryLimit')) {
			ini_set('memory_limit', (int)$params->get('imageMemoryLimit').'M');
		}
		
		$files = JRequest::get('files');

		$savepath = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'categories'.DS;

		$existingImage = JRequest::getVar('existingImage');
		if ( ($files['image']['error'] === 0 || $existingImage) && !JRequest::getBool('del_image')) {
			if($files['image']['error'] === 0){
				$image = $files['image'];
			}
			else{
				$image = JPATH_SITE.DS.JPath::clean($existingImage);
			}
				
			$handle = new Upload($image);
			if ($handle->uploaded) {
				$handle->file_auto_rename = false;
				$handle->jpeg_quality = $params->get('imagesQuality', '85');
				$handle->file_overwrite = true;
				$handle->file_new_name_body = $row->id;
				$handle->image_resize = true;
				$handle->image_ratio_y = true;
				$handle->image_x = $params->get('catImageWidth', '100');
				$handle->Process($savepath);
				$handle->Clean();
			}
			else {
				$mainframe->redirect('index.php?option=com_lpd&view=categories', $handle->error, 'error');
			}
			$row->image = $handle->file_dst_name;
		}


		if (JRequest::getBool('del_image')) {
			$currentRow = & JTable::getInstance('LPDCategory', 'Table');
			$currentRow->load($row->id);
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'categories'.DS.$currentRow->image)) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'categories'.DS.$currentRow->image);
			}
			$row->image = '';
		}

		if (!$row->store()) {
			$mainframe->redirect('index.php?option=com_lpd&view=categories', $row->getError(), 'error');
		}

		$cache = & JFactory::getCache('com_lpd');
		$cache->clean();

		switch(JRequest::getCmd('task')) {
			case 'apply':
				$msg = JText::_('LPD_CHANGES_TO_CATEGORY_SAVED');
				$link = 'index.php?option=com_lpd&view=category&cid='.$row->id;
				break;
			case 'saveAndNew':
				$msg = JText::_('LPD_CATEGORY_SAVED');
				$link = 'index.php?option=com_lpd&view=category';
				break;
			case 'save':
			default:
				$msg = JText::_('LPD_CATEGORY_SAVED');
				$link = 'index.php?option=com_lpd&view=categories';
				break;
		}
		$mainframe->redirect($link, $msg);
	}

	function countCategoryItems($catid) {

		$db = & JFactory::getDBO();
		$catid = (int)$catid;
		$query = "SELECT COUNT(*) FROM #__lpd_items WHERE catid={$catid} AND trash=0 ";
		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;

	}

}
