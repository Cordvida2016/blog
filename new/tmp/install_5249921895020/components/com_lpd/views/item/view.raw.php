<?php
/**
 * @version		$Id: view.raw.php 1374 2011-11-30 11:33:47Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewItem extends JView {

	function display($tpl = null) {
		$mainframe = &JFactory::getApplication();
		$user = &JFactory::getUser();
		$document = &JFactory::getDocument();
		$params = &LPDHelperUtilities::getParams('com_lpd');
		$limitstart = JRequest::getInt('limitstart', 0);
		$view = JRequest::getWord('view');
		$task = JRequest::getWord('task');

		$db = &JFactory::getDBO();
		$jnow = &JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();

		$this->setLayout('item');

		// Add link
		if (LPDHelperPermissions::canAddItem())
		$addLink = JRoute::_('index.php?option=com_lpd&view=item&task=add&tmpl=component');
		$this->assignRef('addLink', $addLink);

		// Get item
		$model = &$this->getModel();
		$item = $model->getData();
		
		// Does the item exists?
		if (!is_object($item) || !$item->id) {
			JError::raiseError(404, JText::_('LPD_ITEM_NOT_FOUND'));
		}

		// Prepare item
		$item = $model->prepareItem($item, $view, $task);
		
		// Plugins
		$item = $model->execPlugins($item, $view, $task);

		// Access check
		if ($this->getLayout() == 'form') {
			JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
		}
		if(LPD_JVERSION=='16'){
			if (!in_array($item->access, $user->authorisedLevels()) || !in_array($item->category->access, $user->authorisedLevels())) {
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
			}
		}
		else {
			if ($item->access > $user->get('aid', 0) || $item->category->access > $user->get('aid', 0)) {
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
			}
		}

		// Published check
		if (!$item->published || $item->trash) {
			JError::raiseError(404, JText::_('LPD_ITEM_NOT_FOUND'));
		}

		if ($item->publish_up != $nullDate && $item->publish_up > $now) {
			JError::raiseError(404, JText::_('LPD_ITEM_NOT_FOUND'));
		}

		if ($item->publish_down != $nullDate && $item->publish_down < $now) {
			JError::raiseError(404, JText::_('LPD_ITEM_NOT_FOUND'));
		}

		if (!$item->category->published || $item->category->trash) {
			JError::raiseError(404, JText::_('LPD_ITEM_NOT_FOUND'));
		}

		// Increase hits counter
		$model->hit($item->id);

		// Set default image
		LPDHelperUtilities::setDefaultImage($item, $view);

		// Comments
		$item->event->LPDCommentsCounter = '';
		$item->event->LPDCommentsBlock = '';
		if ($item->params->get('itemComments')) {

			// Trigger comments events
			$dispatcher = &JDispatcher::getInstance();
			JPluginHelper::importPlugin ('lpd');
			$results = $dispatcher->trigger('onLPDCommentsCounter', array ( & $item, &$params, $limitstart));
			$item->event->LPDCommentsCounter = trim(implode("\n", $results));
			$results = $dispatcher->trigger('onLPDCommentsBlock', array ( & $item, &$params, $limitstart));
			$item->event->LPDCommentsBlock = trim(implode("\n", $results));

			// Load LPD native comments system only if there are no plugins overriding it
			if(empty($item->event->LPDCommentsCounter) && empty($item->event->LPDCommentsBlock)){

				$limit = $params->get('commentsLimit');
				$comments = $model->getItemComments($item->id, $limitstart, $limit);
				$pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";

				for ($i = 0; $i < sizeof($comments); $i++) {

					$comments[$i]->commentText = nl2br($comments[$i]->commentText);
					$comments[$i]->commentText = preg_replace($pattern, '<a target="_blank" rel="nofollow" href="\0">\0</a>', $comments[$i]->commentText);
					$comments[$i]->userImage = LPDHelperUtilities::getAvatar($comments[$i]->userID, $comments[$i]->commentEmail, $params->get('commenterImgWidth'));
					if ($comments[$i]->userID>0)
					$comments[$i]->userLink = LPDHelperRoute::getUserRoute($comments[$i]->userID);
					else
					$comments[$i]->userLink = $comments[$i]->commentURL;
				}

				$item->comments = $comments;

				jimport('joomla.html.pagination');
				$total = $item->numOfComments;
				$pagination = new JPagination($total, $limitstart, $limit);
			}

		}

		// Author's latest items
		if ($params->get('itemAuthorLatest') && $item->created_by_alias == '') {
			$model = &$this->getModel('itemlist');
			$authorLatestItems = $model->getAuthorLatest($item->id, $params->get('itemAuthorLatestLimit'), $item->created_by);
			if (count($authorLatestItems)) {
				for ($i = 0; $i < sizeof($authorLatestItems); $i++) {
					$authorLatestItems[$i]->link = urldecode(JRoute::_(LPDHelperRoute::getItemRoute($authorLatestItems[$i]->id.':'.urlencode($authorLatestItems[$i]->alias), $authorLatestItems[$i]->catid.':'.urlencode($authorLatestItems[$i]->categoryalias))));
				}
				$this->assignRef('authorLatestItems', $authorLatestItems);
			}
		}

		// Related items
		if ($params->get('itemRelated') && isset($item->tags) && count($item->tags)) {
			$model = &$this->getModel('itemlist');
			$relatedItems = $model->getRelatedItems($item->id, $item->tags, $params);
			if (count($relatedItems)) {
				for ($i = 0; $i < sizeof($relatedItems); $i++) {
					$relatedItems[$i]->link = urldecode(JRoute::_(LPDHelperRoute::getItemRoute($relatedItems[$i]->id.':'.urlencode($relatedItems[$i]->alias), $relatedItems[$i]->catid.':'.urlencode($relatedItems[$i]->categoryalias))));
				}
				$this->assignRef('relatedItems', $relatedItems);
			}

		}

		// Navigation (previous and next item)
		if ($params->get('itemNavigation')) {
			$model = &$this->getModel('item');

			$nextItem = $model->getNextItem($item->id, $item->catid, $item->ordering);
			if (!is_null($nextItem)) {
				$item->nextLink = urldecode(JRoute::_(LPDHelperRoute::getItemRoute($nextItem->id.':'.urlencode($nextItem->alias), $nextItem->catid.':'.urlencode($item->category->alias))));
				$item->nextTitle = $nextItem->title;
			}

			$previousItem = $model->getPreviousItem($item->id, $item->catid, $item->ordering);
			if (!is_null($previousItem)) {
				$item->previousLink = urldecode(JRoute::_(LPDHelperRoute::getItemRoute($previousItem->id.':'.urlencode($previousItem->alias), $previousItem->catid.':'.urlencode($item->category->alias))));
				$item->previousTitle = $previousItem->title;
			}

		}

		// Absolute URL
		$uri = &JURI::getInstance();
		$item->absoluteURL = $uri->toString();

		// Email link
		$item->emailLink = JRoute::_('index.php?option=com_mailto&tmpl=component&link='.base64_encode($item->absoluteURL));

		// Twitter link (legacy code - to be removed)
		if ($params->get('itemTwitterLink',1) && $params->get('twitterUsername')) {

			switch($params->get('urlShortener',1)){
				case 1:
					$itemURLForTwitter = @file_get_contents('http://tinyurl.com/api-create.php?url='.$item->absoluteURL);
					break;
				case 2:
					$itemURLForTwitter = @file_get_contents('http://is.gd/create.php?format=simple&url='.$item->absoluteURL);
					break;
				case 3:
					$itemURLForTwitter = @file_get_contents('http://v.gd/create.php?format=simple&url='.$item->absoluteURL);
					break;
				default:
					$itemURLForTwitter = $item->absoluteURL;
			}

			$item->twitterURL = 'http://twitter.com/intent/tweet?text='.urlencode($item->title.' '.$itemURLForTwitter.' via @'.$params->get('twitterUsername'));
		}

		// Social link
		$item->socialLink = urlencode($item->absoluteURL);

		// Look for template files in component folders
		$this->_addPath('template', JPATH_COMPONENT.DS.'templates');
		$this->_addPath('template', JPATH_COMPONENT.DS.'templates'.DS.'default');

		// Look for overrides in template folder (LPD template structure)
		$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates');
		$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates'.DS.'default');

		// Look for overrides in template folder (Joomla! template structure)
		$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'default');
		$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd');

		// Look for specific LPD theme files
		if ($item->params->get('theme')) {
			$this->_addPath('template', JPATH_COMPONENT.DS.'templates'.DS.$item->params->get('theme'));
			$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates'.DS.$item->params->get('theme'));
			$this->_addPath('template', JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.$item->params->get('theme'));
		}

		// Assign data
		$this->assignRef('item', $item);
		$this->assignRef('user', $user);
		$this->assignRef('params', $item->params);
		$this->assignRef('pagination', $pagination);


		parent::display($tpl);
	}

}
