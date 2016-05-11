<?php
/**
 * @version		$Id: items.php 1118 2011-10-11 15:26:20Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class LPDModelItems extends JModel {

	function getData() {

		$mainframe = &JFactory::getApplication();
		$params = &JComponentHelper::getParams('com_lpd');
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$db = &JFactory::getDBO();
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = $mainframe->getUserStateFromRequest($option.$view.'.limitstart', 'limitstart', 0, 'int');
		$filter_order = $mainframe->getUserStateFromRequest($option.$view.'filter_order', 'filter_order', 'i.id', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.$view.'filter_order_Dir', 'filter_order_Dir', 'DESC', 'word');
		$filter_trash = $mainframe->getUserStateFromRequest($option.$view.'filter_trash', 'filter_trash', 0, 'int');
		$filter_featured = $mainframe->getUserStateFromRequest($option.$view.'filter_featured', 'filter_featured', -1, 'int');
		$filter_category = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', 0, 'int');
		$filter_author = $mainframe->getUserStateFromRequest($option.$view.'filter_author', 'filter_author', 0, 'int');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		$tag = $mainframe->getUserStateFromRequest($option.$view.'tag', 'tag', 0, 'int');
		$language = $mainframe->getUserStateFromRequest($option.$view.'language', 'language', '', 'string');

		$query = "SELECT i.*, g.name AS groupname, c.name AS category, v.name AS author, w.name as moderator, u.name AS editor FROM #__lpd_items as i";

		$query .= " LEFT JOIN #__lpd_categories AS c ON c.id = i.catid"." LEFT JOIN #__groups AS g ON g.id = i.access"." LEFT JOIN #__users AS u ON u.id = i.checked_out"." LEFT JOIN #__users AS v ON v.id = i.created_by"." LEFT JOIN #__users AS w ON w.id = i.modified_by";

		if($params->get('showTagFilter') && $tag){
			$query .= " LEFT JOIN #__lpd_tags_xref AS tags_xref ON tags_xref.itemID = i.id";
		}

		$query .= " WHERE i.trash={$filter_trash}";

		if ($search) {

			$search = JString::str_ireplace('*', '', $search);
			$words = explode(' ', $search);
			for($i=0; $i<count($words); $i++){
				$words[$i]= '+'.$words[$i];
				$words[$i].= '*';
			}
			$search = implode(' ', $words);
			$search = $db->Quote($db->getEscaped($search, true), false);

			if($params->get('adminSearch')=='full')
			$query .= " AND MATCH(i.title, i.introtext, i.`fulltext`, i.extra_fields_search, i.image_caption,i.image_credits,i.video_caption,i.video_credits,i.metadesc,i.metakey)";
			else
			$query .= " AND MATCH( i.title )";

			$query.= " AGAINST ({$search} IN BOOLEAN MODE)";
		}

		if ($filter_state > - 1) {
			$query .= " AND i.published={$filter_state}";
		}

		if ($filter_featured > - 1) {
			$query .= " AND i.featured={$filter_featured}";
		}

		if ($filter_category > 0) {
			if ($params->get('showChildCatItems')) {
				require_once (JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'models'.DS.'itemlist.php');
				$categories = LPDModelItemlist::getCategoryTree($filter_category);
				$sql = @implode(',', $categories);
				$query .= " AND i.catid IN ({$sql})";
			} else {
				$query .= " AND i.catid={$filter_category}";
			}

		}

		if ($filter_author > 0) {
			$query .= " AND i.created_by={$filter_author}";
		}

		if($params->get('showTagFilter') && $tag){
			$query .= " AND tags_xref.tagID = {$tag}";
		}
		
		if ($language) {
			$query .= " AND i.language = ".$db->Quote($language);
		}

		if ($filter_order == 'i.ordering') {
			$query .= " ORDER BY i.catid, i.ordering {$filter_order_Dir}";
		} else {
			$query .= " ORDER BY {$filter_order} {$filter_order_Dir} ";
		}

		if(LPD_JVERSION=='16'){
			$query = JString::str_ireplace('#__groups', '#__viewlevels', $query);
			$query = JString::str_ireplace('g.name', 'g.title', $query);
		}

		$db->setQuery($query, $limitstart, $limit);
		$rows = $db->loadObjectList();
		return $rows;

	}

	function getTotal() {

		$mainframe = &JFactory::getApplication();
		$params = &JComponentHelper::getParams('com_lpd');
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$db = &JFactory::getDBO();
		$filter_trash = $mainframe->getUserStateFromRequest($option.$view.'filter_trash', 'filter_trash', 0, 'int');
		$filter_featured = $mainframe->getUserStateFromRequest($option.$view.'filter_featured', 'filter_featured', -1, 'int');
		$filter_category = $mainframe->getUserStateFromRequest($option.$view.'filter_category', 'filter_category', 0, 'int');
		$filter_author = $mainframe->getUserStateFromRequest($option.$view.'filter_author', 'filter_author', 0, 'int');
		$filter_state = $mainframe->getUserStateFromRequest($option.$view.'filter_state', 'filter_state', -1, 'int');
		$search = $mainframe->getUserStateFromRequest($option.$view.'search', 'search', '', 'string');
		$search = JString::strtolower($search);
		$tag = $mainframe->getUserStateFromRequest($option.$view.'tag', 'tag', 0, 'int');
		$language = $mainframe->getUserStateFromRequest($option.$view.'language', 'language', '', 'string');


		$query = "SELECT COUNT(*) FROM #__lpd_items AS i ";

		if($params->get('showTagFilter') && $tag){
			$query .= " LEFT JOIN #__lpd_tags_xref AS tags_xref ON tags_xref.itemID = i.id";
		}

		$query.= " WHERE trash={$filter_trash} ";

		if ($search) {

			$search = JString::str_ireplace('*', '', $search);
			$words = explode(' ', $search);
			for($i=0; $i<count($words); $i++){
				$words[$i]= '+'.$words[$i];
				$words[$i].= '*';
			}
			$search = implode(' ', $words);
			$search = $db->Quote($db->getEscaped($search, true), false);

			if($params->get('adminSearch')=='full')
			$query .= " AND MATCH(title, introtext, `fulltext`, extra_fields_search, image_caption, image_credits, video_caption, video_credits, metadesc, metakey)";
			else
			$query .= " AND MATCH( title )";

			$query.= " AGAINST ({$search} IN BOOLEAN MODE)";
		}

		if ($filter_state > - 1) {
			$query .= " AND published={$filter_state}";
		}

		if ($filter_featured > - 1) {
			$query .= " AND featured={$filter_featured}";
		}

		if ($filter_category > 0) {
			if ($params->get('showChildCatItems')) {
				require_once (JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'models'.DS.'itemlist.php');
				$categories = LPDModelItemlist::getCategoryTree($filter_category);
				$sql = @implode(',', $categories);
				$query .= " AND catid IN ({$sql})";
			} else {
				$query .= " AND catid={$filter_category}";
			}

		}

		if ($filter_author > 0) {
			$query .= " AND created_by={$filter_author}";
		}

		if($params->get('showTagFilter') && $tag){
			$query .= " AND tags_xref.tagID = {$tag}";
		}
		
		if ($language) {
			$query .= " AND language = ".$db->Quote($language);
		}

		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;

	}

	function publish() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->publish($id, 1);
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items');
	}

	function unpublish() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->publish($id, 0);
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items');
	}

	function saveorder() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');
		$total = count($cid);
		$order = JRequest::getVar('order', array(0), 'post', 'array');
		JArrayHelper::toInteger($order, array(0));
		$row = &JTable::getInstance('LPDItem', 'Table');
		$groupings = array();
		for ($i = 0; $i < $total; $i++) {
			$row->load((int) $cid[$i]);
			$groupings[] = $row->catid;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg());
				}
			}
		}
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering')){
			$groupings = array_unique($groupings);
			foreach ($groupings as $group) {
				$row->reorder('catid = '.(int) $group.' AND trash=0');
			}
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function orderup() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		$row->load($cid[0]);
		$row->move(-1, 'catid = '.(int) $row->catid.' AND trash=0');
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering'))
		$row->reorder('catid = '.(int) $row->catid.' AND trash=0');
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function orderdown() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		$row->load($cid[0]);
		$row->move(1, 'catid = '.(int) $row->catid.' AND trash=0');
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering'))
		$row->reorder('catid = '.(int) $row->catid.' AND trash=0');
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function savefeaturedorder() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid', array(0), 'post', 'array');
		$total = count($cid);
		$order = JRequest::getVar('order', array(0), 'post', 'array');
		JArrayHelper::toInteger($order, array(0));
		$row = &JTable::getInstance('LPDItem', 'Table');
		$groupings = array();
		for ($i = 0; $i < $total; $i++) {
			$row->load((int) $cid[$i]);
			$groupings[] = $row->catid;
			if ($row->featured_ordering != $order[$i]) {
				$row->featured_ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError(500, $db->getErrorMsg());
				}
			}
		}
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering')){
			$groupings = array_unique($groupings);
			foreach ($groupings as $group) {
				$row->reorder('featured = 1 AND trash=0', 'featured_ordering');
			}
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_FEATURED_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function featuredorderup() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		$row->load($cid[0]);
		$row->move(-1, 'featured=1 AND trash=0', 'featured_ordering');
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering'))
		$row->reorder('featured=1 AND trash=0', 'featured_ordering');
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function featuredorderdown() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		$row->load($cid[0]);
		$row->move(1, 'featured=1 AND trash=0', 'featured_ordering');
		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('disableCompactOrdering'))
		$row->reorder('featured=1 AND trash=0', 'featured_ordering');
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ORDERING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function accessregistered() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$row = &JTable::getInstance('LPDItem', 'Table');
		$cid = JRequest::getVar('cid');
		$row->load($cid[0]);
		$row->access = 1;
		if (!$row->check()) {
			return $row->getError();
		}
		if (!$row->store()) {
			return $row->getError();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ACCESS_SETTING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function accessspecial() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$row = &JTable::getInstance('LPDItem', 'Table');
		$cid = JRequest::getVar('cid');
		$row->load($cid[0]);
		$row->access = 2;
		if (!$row->check()) {
			return $row->getError();
		}
		if (!$row->store()) {
			return $row->getError();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ACCESS_SETTING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function accesspublic() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$row = &JTable::getInstance('LPDItem', 'Table');
		$cid = JRequest::getVar('cid');
		$row->load($cid[0]);
		$row->access = 0;
		if (!$row->check()) {
			return $row->getError();
		}
		if (!$row->store()) {
			return $row->getError();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$msg = JText::_('LPD_NEW_ACCESS_SETTING_SAVED');
		$mainframe->redirect('index.php?option=com_lpd&view=items', $msg);
	}

	function copy() {

		$mainframe = &JFactory::getApplication();
		jimport('joomla.filesystem.file');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');
		$params = &JComponentHelper::getParams('com_lpd');
		$itemModel = new LPDModelItem;
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		JArrayHelper::toInteger($cid);
		$row = &JTable::getInstance('LPDItem', 'Table');

		$nullDate = $db->getNullDate();

		foreach ($cid as $id) {

			//Load source item
			$item = &JTable::getInstance('LPDItem', 'Table');
			$item->load($id);
			$item->id = (int) $item->id;

			//Source images
			$sourceImage = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'src'.DS.md5("Image".$item->id).'.jpg';
			$sourceImageXS = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XS.jpg';
			$sourceImageS = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg';
			$sourceImageM = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg';
			$sourceImageL = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg';
			$sourceImageXL = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg';
			$sourceImageGeneric = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_Generic.jpg';

			//Source gallery
			$sourceGallery = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'galleries'.DS.$item->id;
			$sourceGalleryTag = $item->gallery;

			//Source video
			preg_match_all("#^{(.*?)}(.*?){#", $item->video, $matches, PREG_PATTERN_ORDER);
			$videotype = $matches[1][0];
			$videofile = $matches[2][0];

			if ($videotype == 'flv' || $videotype == 'swf' || $videotype == 'wmv' || $videotype == 'mov' || $videotype == 'mp4' || $videotype == '3gp' || $videotype == 'divx') {
				if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$videofile.'.'.$videotype)) {
					$sourceVideo = $videofile.'.'.$videotype;
					//$row->video='{'.$videotype.'}'.$row->id.'{/'.$videotype.'}';
				}
			}

			//Source tags
			$query = "SELECT * FROM #__lpd_tags_xref WHERE itemID={$item->id}";
			$db->setQuery($query);
			$sourceTags = $db->loadObjectList();

			//Source Attachments
			$sourceAttachments = $itemModel->getAttachments($item->id);

			//Save target item
			$row = &JTable::getInstance('LPDItem', 'Table');
			$row = $item;
			$row->id = NULL;
			$row->title = JText::_('LPD_COPY_OF').' '.$item->title;
			$row->hits = 0;
			$row->published = 0;
			$datenow = &JFactory::getDate();
			$row->created = $datenow->toMySQL();
			$row->modified = $nullDate;
			$row->store();

			//Target images
			if (JFile::exists($sourceImage))
			JFile::copy($sourceImage, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'src'.DS.md5("Image".$row->id).'.jpg');
			if (JFile::exists($sourceImageXS))
			JFile::copy($sourceImageXS, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XS.jpg');
			if (JFile::exists($sourceImageS))
			JFile::copy($sourceImageS, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_S.jpg');
			if (JFile::exists($sourceImageM))
			JFile::copy($sourceImageM, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_M.jpg');
			if (JFile::exists($sourceImageL))
			JFile::copy($sourceImageL, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg');
			if (JFile::exists($sourceImageXL))
			JFile::copy($sourceImageXL, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XL.jpg');
			if (JFile::exists($sourceImageGeneric))
			JFile::copy($sourceImageGeneric, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_Generic.jpg');

			//Target gallery
			if ($sourceGalleryTag){
				$row->gallery = '{gallery}'.$row->id.'{/gallery}';
				if (JFolder::exists($sourceGallery))
				JFolder::copy($sourceGallery, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'galleries'.DS.$row->id);
			}

			//Target video
			if (isset($sourceVideo) && JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$sourceVideo)) {
				JFile::copy(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$sourceVideo, JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$row->id.'.'.$videotype);
				$row->video = '{'.$videotype.'}'.$row->id.'{/'.$videotype.'}';
			}

			//Target attachments
			$path = $params->get('attachmentsFolder', NULL);
			if (is_null($path))
			$savepath = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'attachments';
			else
			$savepath = $path;

			foreach ($sourceAttachments as $attachment) {
				if (JFile::exists($savepath.DS.$attachment->filename)) {
					JFile::copy($savepath.DS.$attachment->filename, $savepath.DS.$row->id.'_'.$attachment->filename);
					$attachmentRow = &JTable::getInstance('LPDAttachment', 'Table');
					$attachmentRow->itemID = $row->id;
					$attachmentRow->title = $attachment->title;
					$attachmentRow->titleAttribute = $attachment->titleAttribute;
					$attachmentRow->filename = $row->id.'_'.$attachment->filename;
					$attachmentRow->hits = 0;
					$attachmentRow->store();
				}
			}

			//Target tags
			foreach ($sourceTags as $tag) {
				$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {intval($tag->tagID)}, {intval($row->id)})";
				$db->setQuery($query);
				$db->query();
			}

			$row->store();
		}

		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_COPY_COMPLETED'));
	}

	function featured() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			if ($row->featured == 1)
			$row->featured = 0;
			else {
				$row->featured = 1;
				$row->featured_ordering = 1;
			}
			$row->store();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_ITEMS_CHANGED'));
	}

	function trash() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		JArrayHelper::toInteger($cid);
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->trash = 1;
			$row->store();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_ITEMS_MOVED_TO_TRASH'));

	}

	function restore() {

		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		$warning = false;
		foreach ($cid as $id) {
			$row->load($id);
			$query = "SELECT COUNT(*) FROM #__lpd_categories WHERE id=".(int)$row->catid." AND trash = 0";
			$db->setQuery($query);
			$result = $db->loadResult();
			if ($result) {
				$row->trash = 0;
				$row->store();
			} else {
				$warning = true;
			}

		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		if ($warning)
		$mainframe->enqueueMessage(JText::_('LPD_SOME_OF_THE_ITEMS_HAVE_NOT_BEEN_RESTORED_BECAUSE_THEY_BELONG_TO_A_CATEGORY_WHICH_IS_IN_TRASH'), 'notice');
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_ITEMS_RESTORED'));

	}

	function remove() {

		$mainframe = &JFactory::getApplication();
		jimport('joomla.filesystem.file');
		$params = &JComponentHelper::getParams('com_lpd');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');
		$itemModel = new LPDModelItem;
		$db = &JFactory::getDBO();
		$cid = JRequest::getVar('cid');
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->id = (int) $row->id;
			//Delete images
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'src'.DS.md5("Image".$row->id).'.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'src'.DS.md5("Image".$row->id).'.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XS.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XS.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_S.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_S.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_M.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_M.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_L.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XL.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XL.jpg');
			}
			if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_Generic.jpg')) {
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_Generic.jpg');
			}

			//Delete gallery
			if (JFolder::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'galleries'.DS.$row->id))
			JFolder::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'galleries'.DS.$row->id);

			//Delete video
			preg_match_all("#^{(.*?)}(.*?){#", $row->video, $matches, PREG_PATTERN_ORDER);
			$videotype = $matches[1][0];
			$videofile = $matches[2][0];

			if ($videotype == 'flv' || $videotype == 'swf' || $videotype == 'wmv' || $videotype == 'mov' || $videotype == 'mp4' || $videotype == '3gp' || $videotype == 'divx') {
				if (JFile::exists(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$videofile.'.'.$videotype))
				JFile::delete(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos'.DS.$videofile.'.'.$videotype);
			}

			//Delete attachments
			$path = $params->get('attachmentsFolder', NULL);
			if (is_null($path))
			$savepath = JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'attachments';
			else
			$savepath = $path;

			$attachments = $itemModel->getAttachments($row->id);

			foreach ($attachments as $attachment) {
				if (JFile::exists($savepath.DS.$attachment->filename))
				JFile::delete($savepath.DS.$attachment->filename);
			}

			$query = "DELETE FROM #__lpd_attachments WHERE itemID={$row->id}";
			$db->setQuery($query);
			$db->query();

			//Delete tags
			$query = "DELETE FROM #__lpd_tags_xref WHERE itemID={$row->id}";
			$db->setQuery($query);
			$db->query();
			
			//Delete comments
			$query = "DELETE FROM #__lpd_comments WHERE itemID={$row->id}";
			$db->setQuery($query);
			$db->query();
			
			$row->delete($id);
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_DELETE_COMPLETED'));
	}

	function import() {

		$mainframe = &JFactory::getApplication();
		jimport('joomla.filesystem.file');
		$db = &JFactory::getDBO();
		$query = "SELECT * FROM #__sections";
		$db->setQuery($query);
		$sections = $db->loadObjectList();

		$query = "SELECT COUNT(*) FROM #__lpd_items";
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result)
		$preserveItemIDs = false;
		else
		$preserveItemIDs = true;

		$xml = new JSimpleXML;
		$xml->loadFile(JPATH_COMPONENT.DS.'models'.DS.'category.xml');
		$categoryParams = new JParameter('');

		foreach ($xml->document->params as $paramGroup) {
			foreach ($paramGroup->param as $param) {
				if ($param->attributes('type') != 'spacer' && $param->attributes('name')) {
					$categoryParams->set($param->attributes('name'), $param->attributes('default'));
				}
			}
		}
		$categoryParams = $categoryParams->toString();

		$xml = new JSimpleXML;
		$xml->loadFile(JPATH_COMPONENT.DS.'models'.DS.'item.xml');
		$itemParams = new JParameter('');

		foreach ($xml->document->params as $paramGroup) {
			foreach ($paramGroup->param as $param) {
				if ($param->attributes('type') != 'spacer' && $param->attributes('name')) {
					$itemParams->set($param->attributes('name'), $param->attributes('default'));
				}
			}
		}
		$itemParams = $itemParams->toString();

		$query = "SELECT id, name FROM #__lpd_tags";
		$db->setQuery($query);
		$tags = $db->loadObjectList();

		if(is_null($tags))
		$tags = array();

		foreach ($sections as $section) {
			$LPDCategory = &JTable::getInstance('LPDCategory', 'Table');
			$LPDCategory->name = $section->title;
			$LPDCategory->alias = $section->title;
			$LPDCategory->description = $section->description;
			$LPDCategory->parent = 0;
			$LPDCategory->published = $section->published;
			$LPDCategory->access = $section->access;
			$LPDCategory->ordering = $section->ordering;
			$LPDCategory->image = $section->image;
			$LPDCategory->trash = 0;
			$LPDCategory->params = $categoryParams;
			$LPDCategory->check();
			$LPDCategory->store();
			if (JFile::exists(JPATH_SITE.DS.'images'.DS.'stories'.DS.$section->image)) {
				JFile::copy(JPATH_SITE.DS.'images'.DS.'stories'.DS.$section->image, JPATH_SITE.DS.'media'.DS.'lpd'.DS.'categories'.DS.$LPDCategory->image);
			}
			$query = "SELECT * FROM #__categories WHERE section = ".(int)$section->id;
			$db->setQuery($query);
			$categories = $db->loadObjectList();

			foreach ($categories as $category) {
				$LPDSubcategory = &JTable::getInstance('LPDCategory', 'Table');
				$LPDSubcategory->name = $category->title;
				$LPDSubcategory->alias = $category->title;
				$LPDSubcategory->description = $category->description;
				$LPDSubcategory->parent = $LPDCategory->id;
				$LPDSubcategory->published = $category->published;
				$LPDSubcategory->access = $category->access;
				$LPDSubcategory->ordering = $category->ordering;
				$LPDSubcategory->image = $category->image;
				$LPDSubcategory->trash = 0;
				$LPDSubcategory->params = $categoryParams;
				$LPDSubcategory->check();
				$LPDSubcategory->store();
				if (JFile::exists(JPATH_SITE.DS.'images'.DS.'stories'.DS.$category->image)) {
					JFile::copy(JPATH_SITE.DS.'images'.DS.'stories'.DS.$category->image, JPATH_SITE.DS.'media'.DS.'lpd'.DS.'categories'.DS.$LPDSubcategory->image);
				}

				$query = "SELECT article.*, xref.content_id
				FROM #__content AS article 
				LEFT JOIN #__content_frontpage AS xref ON article.id = xref.content_id 
				WHERE catid = ".(int)$category->id;
				$db->setQuery($query);
				$items = $db->loadObjectList();

				foreach ($items as $item) {

					$LPDItem = &JTable::getInstance('LPDItem', 'Table');
					$LPDItem->title = $item->title;
					$LPDItem->alias = $item->title;
					$LPDItem->catid = $LPDSubcategory->id;
					if ($item->state < 0) {
						$LPDItem->trash = 1;
					} else {
						$LPDItem->trash = 0;
						$LPDItem->published = $item->state;
					}
					$LPDItem->featured = ($item->content_id)?1:0;
					$LPDItem->introtext = $item->introtext;
					$LPDItem->fulltext = $item->fulltext;
					$LPDItem->created = $item->created;
					$LPDItem->created_by = $item->created_by;
					$LPDItem->created_by_alias = $item->created_by_alias;
					$LPDItem->modified = $item->modified;
					$LPDItem->modified_by = $item->modified_by;
					$LPDItem->publish_up = $item->publish_up;
					$LPDItem->publish_down = $item->publish_down;
					$LPDItem->access = $item->access;
					$LPDItem->ordering = $item->ordering;
					$LPDItem->hits = $item->hits;
					$LPDItem->metadesc = $item->metadesc;
					$LPDItem->metadata = $item->metadata;
					$LPDItem->metakey = $item->metakey;
					$LPDItem->params = $itemParams;
					$LPDItem->check();
					if($preserveItemIDs){
						$LPDItem->id = $item->id;
						$db->insertObject('#__lpd_items', $LPDItem);
					}
					else {
						$LPDItem->store();
					}


					if(!empty($item->metakey)){
						$itemTags = explode(',', $item->metakey);
						foreach($itemTags as $itemTag){
							$itemTag = JString::trim($itemTag);
							if(in_array($itemTag ,JArrayHelper::getColumn($tags, 'name'))){

								$query = "SELECT id FROM #__lpd_tags WHERE name=".$db->Quote($itemTag);
								$db->setQuery($query);
								$id = $db->loadResult();
								$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$id}, {$LPDItem->id})";
								$db->setQuery($query);
								$db->query();
							}
							else {
								$LPDTag = &JTable::getInstance('LPDTag', 'Table');
								$LPDTag->name = $itemTag;
								$LPDTag->published = 1;
								$LPDTag->store();
								$tags[]=$LPDTag;
								$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$LPDTag->id}, {$LPDItem->id})";
								$db->setQuery($query);
								$db->query();
							}
						}
					}
				}

			}

		}

		// Handle uncategorized articles
		$query = "SELECT * FROM #__content WHERE sectionid = 0";
		$db->setQuery($query);
		$items = $db->loadObjectList();

		if($items){
			$LPDUncategorised = &JTable::getInstance('LPDCategory', 'Table');
			$LPDUncategorised->name = 'Uncategorized';
			$LPDUncategorised->alias = 'Uncategorized';
			$LPDUncategorised->parent = 0;
			$LPDUncategorised->published = 1;
			$LPDUncategorised->access = 0;
			$LPDUncategorised->ordering = 0;
			$LPDUncategorised->trash = 0;
			$LPDUncategorised->params = $categoryParams;
			$LPDUncategorised->check();
			$LPDUncategorised->store();

			foreach ($items as $item) {

				$LPDItem = &JTable::getInstance('LPDItem', 'Table');
				$LPDItem->title = $item->title;
				$LPDItem->alias = $item->title;
				$LPDItem->catid = $LPDUncategorised->id;
				if ($item->state < 0) {
					$LPDItem->trash = 1;
				} else {
					$LPDItem->trash = 0;
					$LPDItem->published = $item->state;
				}
				$LPDItem->introtext = $item->introtext;
				$LPDItem->fulltext = $item->fulltext;
				$LPDItem->created = $item->created;
				$LPDItem->created_by = $item->created_by;
				$LPDItem->created_by_alias = $item->created_by_alias;
				$LPDItem->modified = $item->modified;
				$LPDItem->modified_by = $item->modified_by;
				$LPDItem->publish_up = $item->publish_up;
				$LPDItem->publish_down = $item->publish_down;
				$LPDItem->access = $item->access;
				$LPDItem->ordering = $item->ordering;
				$LPDItem->hits = $item->hits;
				$LPDItem->metadesc = $item->metadesc;
				$LPDItem->metadata = $item->metadata;
				$LPDItem->metakey = $item->metakey;
				$LPDItem->params = $itemParams;
				$LPDItem->check();
				if($preserveItemIDs){
					$LPDItem->id = $item->id;
					$db->insertObject('#__lpd_items', $LPDItem);
				}
				else {
					$LPDItem->store();
				}

				if(!empty($item->metakey)){
					$itemTags = explode(',', $item->metakey);
					foreach($itemTags as $itemTag){
						$itemTag = JString::trim($itemTag);
						if(in_array($itemTag ,JArrayHelper::getColumn($tags, 'name'))){

							$query = "SELECT id FROM #__lpd_tags WHERE name=".$db->Quote($itemTag);
							$db->setQuery($query);
							$id = $db->loadResult();
							$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$id}, {$LPDItem->id})";
							$db->setQuery($query);
							$db->query();
						}
						else {
							$LPDTag = &JTable::getInstance('LPDTag', 'Table');
							$LPDTag->name = $itemTag;
							$LPDTag->published = 1;
							$LPDTag->store();
							$tags[]=$LPDTag;
							$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$LPDTag->id}, {$LPDItem->id})";
							$db->setQuery($query);
							$db->query();
						}
					}
				}
			}
		}
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_IMPORT_COMPLETED'));
	}


	function importJ16() {

		jimport('joomla.filesystem.file');
		jimport('joomla.html.parameter');
		jimport( 'joomla.utilities.xmlelement' );
		$mainframe = &JFactory::getApplication();
		$db = &JFactory::getDBO();

		$query = "SELECT COUNT(*) FROM #__lpd_items";
		$db->setQuery($query);
		$result = $db->loadResult();
		if($result) {
			$preserveItemIDs = false;
		}
		else {
			$preserveItemIDs = true;
		}
		$xml = new JXMLElement(JFile::read(JPATH_COMPONENT.DS.'models'.DS.'category.xml'));
		$categoryParams = new JParameter('');
		foreach ($xml->params as $paramGroup) {
			foreach ($paramGroup->param as $param) {
				if ($param->getAttribute('type') != 'spacer' && $param->getAttribute('name')) {
					$categoryParams->set($param->getAttribute('name'), $param->getAttribute('default'));
				}
			}
		}
		$categoryParams = $categoryParams->toString();

		$xml = new JXMLElement(JFile::read(JPATH_COMPONENT.DS.'models'.DS.'item.xml'));
		$itemParams = new JParameter('');
		foreach ($xml->params as $paramGroup) {
			foreach ($paramGroup->param as $param) {
				if ($param->getAttribute('type') != 'spacer' && $param->getAttribute('name')) {
					$itemParams->set($param->getAttribute('name'), $param->getAttribute('default'));
				}
			}
		}
		$itemParams = $itemParams->toString();

		$query = "SELECT id, name FROM #__lpd_tags";
		$db->setQuery($query);
		$tags = $db->loadObjectList();

		if(is_null($tags))
		$tags = array();

		$query = "SELECT * FROM #__categories WHERE extension = 'com_content'";
		$db->setQuery($query);
		$categories = $db->loadObjectList();
		$mapping = array();
		foreach ($categories as $category) {
			$category->params = json_decode($category->params);
			$category->image = $category->params->image;
			$LPDCategory = &JTable::getInstance('LPDCategory', 'Table');
			$LPDCategory->name = $category->title;
			$LPDCategory->alias = $category->title;
			$LPDCategory->description = $category->description;
			$LPDCategory->parent = $category->parent_id;
			if($LPDCategory->parent==1){
				$LPDCategory->parent = 0;
			}
			$LPDCategory->published = $category->published;
			$LPDCategory->access = $category->access;
			$LPDCategory->ordering = $LPDCategory->getNextOrder('parent='.(int)$category->parent_id);
			$LPDCategory->image = basename($category->image);
			$LPDCategory->trash = 0;
			$LPDCategory->language = $category->language;
			$LPDCategory->params = $categoryParams;
			$LPDCategory->check();
			if($preserveItemIDs){
				$LPDCategory->id = $category->id;
				$db->insertObject('#__lpd_categories', $LPDCategory);
			}
			else {
				$LPDCategory->store();
				$mapping[$category->id]= $LPDCategory->id;

			}

			if ($LPDCategory->image && JFile::exists(realpath(JPATH_SITE.DS.$category->image))) {
				JFile::copy(realpath(JPATH_SITE.DS.$category->image), JPATH_SITE.DS.'media'.DS.'lpd'.DS.'categories'.DS.$LPDCategory->image);
			}
			$query = "SELECT article.*, xref.content_id
				FROM #__content AS article 
				LEFT JOIN #__content_frontpage AS xref ON article.id = xref.content_id 
				WHERE catid = ".(int)$category->id;
			$db->setQuery($query);
			$items = $db->loadObjectList();

			foreach ($items as $item) {

				$LPDItem = &JTable::getInstance('LPDItem', 'Table');
				$LPDItem->title = $item->title;
				$LPDItem->alias = $item->title;
				$LPDItem->catid = $LPDCategory->id;
				if ($item->state < 0) {
					$LPDItem->trash = 1;
				} else {
					$LPDItem->trash = 0;
				}
				$LPDItem->published = 1;
				if ($item->state == 0) {
					$LPDItem->published = 0;
				}
				$LPDItem->published = $item->state;
				$LPDItem->featured = ($item->content_id)?1:0;
				$LPDItem->introtext = $item->introtext;
				$LPDItem->fulltext = $item->fulltext;
				$LPDItem->created = $item->created;
				$LPDItem->created_by = $item->created_by;
				$LPDItem->created_by_alias = $item->created_by_alias;
				$LPDItem->modified = $item->modified;
				$LPDItem->modified_by = $item->modified_by;
				$LPDItem->publish_up = $item->publish_up;
				$LPDItem->publish_down = $item->publish_down;
				$LPDItem->access = $item->access;
				$LPDItem->ordering = $item->ordering;
				$LPDItem->hits = $item->hits;
				$LPDItem->metadesc = $item->metadesc;
				$LPDItem->metadata = $item->metadata;
				$LPDItem->metakey = $item->metakey;
				$LPDItem->params = $itemParams;
				$LPDItem->language = $item->language;
				$LPDItem->check();
				if($preserveItemIDs){
					$LPDItem->id = $item->id;
					$db->insertObject('#__lpd_items', $LPDItem);
				}
				else {
					$LPDItem->store();
				}

				if(!empty($item->metakey)){
					$itemTags = explode(',', $item->metakey);
					foreach($itemTags as $itemTag){
						$itemTag = JString::trim($itemTag);
						if(in_array($itemTag ,JArrayHelper::getColumn($tags, 'name'))){

							$query = "SELECT id FROM #__lpd_tags WHERE name=".$db->Quote($itemTag);
							$db->setQuery($query);
							$id = $db->loadResult();
							$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$id}, {$LPDItem->id})";
							$db->setQuery($query);
							$db->query();
						}
						else {
							$LPDTag = &JTable::getInstance('LPDTag', 'Table');
							$LPDTag->name = $itemTag;
							$LPDTag->published = 1;
							$LPDTag->store();
							$tags[]=$LPDTag;
							$query = "INSERT INTO #__lpd_tags_xref (`id`, `tagID`, `itemID`) VALUES (NULL, {$LPDTag->id}, {$LPDItem->id})";
							$db->setQuery($query);
							$db->query();
						}
					}
				}
			}

		}

		foreach($mapping as $oldID=>$newID){
			$query = "UPDATE #__lpd_categories SET parent=".$newID." WHERE parent=".$oldID;
			$db->setQuery($query);
			$db->query();
		}

		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_IMPORT_COMPLETED'));
	}

	function move() {

		$mainframe = &JFactory::getApplication();
		$cid = JRequest::getVar('cid');
		$catid = JRequest::getInt('category');
		$row = &JTable::getInstance('LPDItem', 'Table');
		foreach ($cid as $id) {
			$row->load($id);
			$row->catid = $catid;
			$row->ordering = $row->getNextOrder('catid = '.$row->catid.' AND published = 1');
			$row->store();
		}
		$cache = &JFactory::getCache('com_lpd');
		$cache->clean();
		$mainframe->redirect('index.php?option=com_lpd&view=items', JText::_('LPD_MOVE_COMPLETED'));

	}

	function getItemsAuthors(){
		$db = &$this->getDBO();
		$query = "SELECT DISTINCT(created_by) FROM #__lpd_items";
		$db->setQuery($query);
		$userIDs = $db->loadResultArray();
		JArrayHelper::toInteger($userIDs);
		$query = "SELECT id, name, block FROM #__users";
		if(count($userIDs)){
			$query.=" WHERE id IN(".implode(',', $userIDs).") ";
		}
		$query.=" ORDER BY name";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}

}
