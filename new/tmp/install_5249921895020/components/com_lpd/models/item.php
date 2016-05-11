<?php
/**
 * @version		$Id: item.php 1376 2011-11-30 14:17:08Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class LPDModelItem extends JModel
{

	function getData() {
		$mainframe = &JFactory::getApplication();
		$id = JRequest::getInt('id');
		$db = & JFactory::getDBO();
		$query = "SELECT * FROM #__lpd_items WHERE id={$id}";
		if(LPD_JVERSION == '16') {
			$languageFilter = $mainframe->getLanguageFilter();
			if($languageFilter) {
				$languageTag = JFactory::getLanguage()->getTag();
				$query.= " AND language IN (".$db->Quote($languageTag).",".$db->Quote('*').")";
			}
		}
		$db->setQuery($query, 0, 1);
		$row = $db->loadObject();
		return $row;
	}

	function prepareItem($item, $view, $task){

		jimport('joomla.filesystem.file');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$limitstart=JRequest::getInt('limitstart');

		//Initialize params
		if ($view!='item'){

			$component = JComponentHelper::getComponent( 'com_lpd' );
			$params = new JParameter( $component->params );
			$itemid = JRequest::getInt( 'Itemid' );
			if ($itemid) {
				$menu = JSite::getMenu();
				$menuparams = $menu->getParams( $itemid );
				$params->merge( $menuparams );
			}

		}
		else {
			$params = & LPDHelperUtilities::getParams('com_lpd');
		}

		//Category
		$db = & JFactory::getDBO();
		$category = & JTable::getInstance('LPDCategory', 'Table');
		$category->load($item->catid);

		$item->category=$category;
		$item->category->link=urldecode(JRoute::_(LPDHelperRoute::getCategoryRoute($category->id.':'.urlencode($category->alias))));

		//Read more link
		$link = LPDHelperRoute::getItemRoute($item->id.':'.urlencode($item->alias),$item->catid.':'.urlencode($item->category->alias));
		$item->link=urldecode(JRoute::_($link));

		//Print link
		$item->printLink = urldecode(JRoute::_($link.'&tmpl=component&print=1'));

		//Params
		$cparams = new JParameter( $category->params );
		$iparams = new JParameter( $item->params );
		$item->params= $params;
		if ($cparams->get('inheritFrom')){
			$masterCategoryID = $cparams->get('inheritFrom');
			$masterCategory = & JTable::getInstance('LPDCategory', 'Table');
			$masterCategory->load((int)$masterCategoryID);
			$cparams = new JParameter( $masterCategory->params );
		}
		$item->params->merge($cparams);
		$item->params->merge($iparams);

		//Edit link
		if (LPDHelperPermissions::canEditItem($item->created_by,$item->catid))
		$item->editLink = JRoute::_('index.php?option=com_lpd&view=item&task=edit&cid='.$item->id.'&tmpl=component');

		//Tags
		if(
		($view=='item' && ($item->params->get('itemTags') || $item->params->get('itemRelated'))) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemTags')) ||
		($view=='itemlist' && $task=='user' && $item->params->get('userItemTags')) ||
		($view=='latest' && $params->get('latestItemTags'))
		)
		{
			$tags = LPDModelItem::getItemTags($item->id);
			for ($i=0; $i<sizeof($tags); $i++) {
				$tags[$i]->link = JRoute::_(LPDHelperRoute::getTagRoute($tags[$i]->name));
			}
			$item->tags=$tags;
		}


		//Image
		$item->imageXSmall='';
		$item->imageSmall='';
		$item->imageMedium='';
		$item->imageLarge='';
		$item->imageXLarge='';

		$date =& JFactory::getDate($item->modified);
		$timestamp = '?t='.$date->toUnix();

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XS.jpg')){
			$item->imageXSmall = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_XS.jpg';
			if($params->get('imageTimestamp')){
				$item->imageXSmall.=$timestamp;
			}
		}

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_S.jpg')){
			$item->imageSmall = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_S.jpg';
			if($params->get('imageTimestamp')){
				$item->imageSmall.=$timestamp;
			}
		}

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_M.jpg')){
			$item->imageMedium = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_M.jpg';
			if($params->get('imageTimestamp')){
				$item->imageMedium.=$timestamp;
			}
		}

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_L.jpg')){
			$item->imageLarge = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_L.jpg';
			if($params->get('imageTimestamp')){
				$item->imageLarge.=$timestamp;
			}
		}

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_XL.jpg')){
			$item->imageXLarge = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_XL.jpg';
			if($params->get('imageTimestamp')){
				$item->imageXLarge.=$timestamp;
			}
		}

		if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_Generic.jpg')){
			$item->imageGeneric = JURI::base(true).'/media/lpd/items/cache/'.md5("Image".$item->id).'_Generic.jpg';
			if($params->get('imageTimestamp')){
				$item->imageGeneric.=$timestamp;
			}
		}


		//Extra fields
		if(
		($view=='item' && $item->params->get('itemExtraFields')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemExtraFields')) ||
		($view=='itemlist' && $task=='tag' && $item->params->get('tagItemExtraFields')) ||
		($view=='itemlist' && ($task=='search' || $task=='date') && $item->params->get('genericItemExtraFields'))
		)
		{
			$item->extra_fields=LPDModelItem::getItemExtraFields($item->extra_fields);
		}

		//Attachments
		if(
		($view=='item' && $item->params->get('itemAttachments')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemAttachments'))
		)
		{
			$item->attachments=LPDModelItem::getItemAttachments($item->id);
		}


		//Rating
		if(
		($view=='item' && $item->params->get('itemRating')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemRating'))
		)
		{
			$item->votingPercentage = LPDModelItem::getVotesPercentage($item->id);
			$item->numOfvotes = LPDModelItem::getVotesNum($item->id);

		}

		//Filtering
		if ($params->get('introTextCleanup')){
			$filterTags	= preg_split( '#[,\s]+#', trim( $params->get( 'introTextCleanupExcludeTags' ) ) );
			$filterAttrs = preg_split( '#[,\s]+#', trim( $params->get( 'introTextCleanupTagAttr' ) ) );
			$filter	= new JFilterInput( $filterTags, $filterAttrs, 0, 1 );
			$item->introtext= $filter->clean( $item->introtext );
		}

		if ($params->get('fullTextCleanup')){
			$filterTags	= preg_split( '#[,\s]+#', trim( $params->get( 'fullTextCleanupExcludeTags' ) ) );
			$filterAttrs = preg_split( '#[,\s]+#', trim( $params->get( 'fullTextCleanupTagAttr' ) ) );
			$filter	= new JFilterInput( $filterTags, $filterAttrs, 0, 1 );
			$item->fulltext= $filter->clean( $item->fulltext );
		}

		if ($item->params->get('catItemIntroTextWordLimit') && $task=='category'){
			$item->introtext = LPDHelperUtilities::wordLimit($item->introtext, $item->params->get('catItemIntroTextWordLimit'));
		}

		$item->cleanTitle = $item->title;
		$item->title = htmlspecialchars($item->title, ENT_QUOTES);
		$item->image_caption = htmlspecialchars($item->image_caption, ENT_QUOTES);
		
		//Author
		if(
		($view=='item' && ($item->params->get('itemAuthorBlock') || $item->params->get('itemAuthor'))) ||
		($view=='itemlist' && ($task=='' || $task=='category') && ($item->params->get('catItemAuthorBlock') || $item->params->get('catItemAuthor')) ) ||
		($view=='itemlist' && $task=='user') ||
		($view=='relatedByTag')
		)
		{
			if (!empty($item->created_by_alias)){
				$item->author->name = $item->created_by_alias;
				$item->author->avatar = LPDHelperUtilities::getAvatar('alias');
				$item->author->link = JURI::root();
			}
			else {
				$author=&JFactory::getUser($item->created_by);
				$item->author = $author;
				$item->author->link = JRoute::_(LPDHelperRoute::getUserRoute($item->created_by));
				$item->author->profile = LPDModelItem::getUserProfile($item->created_by);
				$item->author->avatar = LPDHelperUtilities::getAvatar($author->id, $author->email, $params->get('userImageWidth'));
			}

			
			if (!isset($item->author->profile) || is_null($item->author->profile)){

				$item->author->profile = new JObject;
				$item->author->profile->gender = NULL;

			}


		}

		//Num of comments
		$user = JFactory::getUser();
		if(!$user->guest && $user->id==$item->created_by && $params->get('inlineCommentsModeration')){
			$item->numOfComments = LPDModelItem::countItemComments($item->id, false);
		}
		else {
			$item->numOfComments = LPDModelItem::countItemComments($item->id);
		}
		return $item;
	}

	function prepareFeedItem(&$item){

		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$params = & LPDHelperUtilities::getParams('com_lpd');
		$limitstart=0;

		//Category
		$category = & JTable::getInstance('LPDCategory', 'Table');
		$category->load($item->catid);
		$item->category=$category;

		//Read more link
		$item->link=urldecode(JRoute::_(LPDHelperRoute::getItemRoute($item->id.':'.$item->alias,$item->catid.':'.urlencode($item->category->alias))));

		//Filtering
		if ($params->get('introTextCleanup')){
			$filterTags	= preg_split( '#[,\s]+#', trim( $params->get( 'introTextCleanupExcludeTags' ) ) );
			$filterAttrs = preg_split( '#[,\s]+#', trim( $params->get( 'introTextCleanupTagAttr' ) ) );
			$filter	= new JFilterInput( $filterTags, $filterAttrs, 0, 1 );
			$item->introtext= $filter->clean( $item->introtext );
		}

		if ($params->get('fullTextCleanup')){
			$filterTags	= preg_split( '#[,\s]+#', trim( $params->get( 'fullTextCleanupExcludeTags' ) ) );
			$filterAttrs = preg_split( '#[,\s]+#', trim( $params->get( 'fullTextCleanupTagAttr' ) ) );
			$filter	= new JFilterInput( $filterTags, $filterAttrs, 0, 1 );
			$item->fulltext= $filter->clean( $item->fulltext );
		}

		//Description
		$item->description = '';

		//Item image
		if ($params->get('feedItemImage') && JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$item->id).'_'.$params->get('feedImgSize').'.jpg')){
			$item->description.= '<div class="LPDFeedImage"><img src="'.JURI::base(true).'/media/lpd/items/cache/'.md5('Image'.$item->id).'_'.$params->get('feedImgSize').'.jpg" alt="'.$item->title.'" /></div>';
		}

		//Item Introtext
		if($params->get('feedItemIntroText')){
			//Introtext word limit
			if ($params->get('feedTextWordLimit') && $item->introtext){
				$item->introtext=LPDHelperUtilities::wordLimit($item->introtext,$params->get('feedTextWordLimit'));
			}
			$item->description.= '<div class="LPDFeedIntroText">'.$item->introtext.'</div>';
		}

		//Item Fulltext
		if($params->get('feedItemFullText') && $item->fulltext){
			$item->description.= '<div class="LPDFeedFullText">'.$item->fulltext.'</div>';
		}

		//Item Tags
		if($params->get('feedItemTags')){
			$tags = LPDModelItem::getItemTags($item->id);
			if(count($tags)){
				$item->description.='<div class="LPDFeedTags"><ul>';
				foreach($tags as $tag){
					$item->description.='<li>'.$tag->name.'</li>';
				}
				$item->description.='<ul></div>';
			}
		}

		//Item Video
		if($params->get('feedItemVideo') && $item->video){
			if (!empty($item->video) && JString::substr($item->video, 0, 1) !== '{') {
				$item->description.= '<div class="LPDFeedVideo">'.$item->video.'</div>';
			}
			else {
				$params->set('vfolder', 'media/lpd/videos');
				$params->set('afolder', 'media/lpd/audio');
				if(JString::strpos($item->video, 'remote}')){
					preg_match("#}(.*?){/#s",$item->video, $matches);
					if(!JString::strpos($matches[1], 'http://}'))
					$item->video = str_replace($matches[1], JURI::root().$matches[1], $item->video);
				}
				$dispatcher = &JDispatcher::getInstance();
				JPluginHelper::importPlugin ('content');
				$item->text=$item->video;
				$dispatcher->trigger ( 'onPrepareContent', array (&$item, &$params, $limitstart ) );
				$item->description.= '<div class="LPDFeedVideo">'.$item->text.'</div>';
			}
		}

		//Item gallery
		if($params->get('feedItemGallery') && $item->gallery){
			$params->set('galleries_rootfolder', 'media/lpd/galleries');
			$params->set('enabledownload', '0');
			$dispatcher = &JDispatcher::getInstance();
			JPluginHelper::importPlugin ('content');
			$item->text=$item->gallery;
			$dispatcher->trigger ( 'onPrepareContent', array (&$item, &$params, $limitstart ) );
			$item->description.= '<div class="LPDFeedGallery">'.$item->text.'</div>';
		}

		//Item attachments
		if($params->get('feedItemAttachments')){
			$attachments = LPDModelItem::getItemAttachments($item->id);
			if(count($attachments)){
				$item->description.='<div class="LPDFeedAttachments"><ul>';
				foreach($attachments as $attachment){
					$item->description.='<li><a title="'.htmlentities($attachment->titleAttribute, ENT_QUOTES, 'UTF-8').'" href="'.$attachment->link.'">'.$attachment->title.'</a></li>';
				}
				$item->description.='<ul></div>';
			}
		}


		//Author
		if (!empty($item->created_by_alias)){
			$item->author->name = $item->created_by_alias;
			$item->author->email = '';
		}
		else {
			$author=&JFactory::getUser($item->created_by);
			$item->author = $author;
			$item->author->link = JRoute::_(LPDHelperRoute::getUserRoute($item->created_by));
			$item->author->profile = LPDModelItem::getUserProfile($item->created_by);
		}

		return $item;
	}

	function execPlugins($item, $view, $task){

		$params = & LPDHelperUtilities::getParams('com_lpd');
		$limitstart=JRequest::getInt('limitstart');

		//Import plugins
		$dispatcher = &JDispatcher::getInstance();
		JPluginHelper::importPlugin ('content');

		//Gallery
		if(
		($view=='item' && $item->params->get('itemImageGallery')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemImageGallery')) ||
		($view=='relatedByTag')
		)
		{
			$params->set('galleries_rootfolder', 'media/lpd/galleries');
			$params->set('enabledownload', '0');
			$item->text=$item->gallery;
			$dispatcher->trigger ( 'onPrepareContent', array (&$item, &$params, $limitstart ) );
			$item->gallery=$item->text;
		}

		//Video
		if(
		($view=='item' && $item->params->get('itemVideo')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemVideo')) ||
		($view=='latest' && $item->params->get('latestItemVideo')) ||
		($view=='relatedByTag')
		)
		{
			if (!empty($item->video) && JString::substr($item->video, 0, 1) !== '{') {
				$item->video=$item->video;
				$item->videoType='embedded';
			}
			else {
				$item->videoType='allvideos';
				$params->set('afolder', 'media/lpd/audio');
				$params->set('vfolder', 'media/lpd/videos');

				if(JString::strpos($item->video, 'remote}')){
					preg_match("#}(.*?){/#s",$item->video, $matches);
					if(JString::substr($matches[1], 0, 7)!='http://')
					$item->video = str_replace($matches[1], JURI::root().$matches[1], $item->video);
				}

				if($view=='item'){
					$params->set('vwidth', $item->params->get('itemVideoWidth'));
					$params->set('vheight', $item->params->get('itemVideoHeight'));
					$params->set('autoplay', $item->params->get('itemVideoAutoPlay'));
				}
				else if($view=='latest'){
					$params->set('vwidth', $item->params->get('latestItemVideoWidth'));
					$params->set('vheight', $item->params->get('latestItemVideoHeight'));
					$params->set('autoplay', $item->params->get('latestItemVideoAutoPlay'));
				}
				else {
					$params->set('vwidth', $item->params->get('catItemVideoWidth'));
					$params->set('vheight', $item->params->get('catItemVideoHeight'));
					$params->set('autoplay', $item->params->get('catItemVideoAutoPlay'));
				}

				$item->text=$item->video;
				$dispatcher->trigger ( 'onPrepareContent', array (&$item, &$params, $limitstart ) );
				$item->video=$item->text;
			}

		}

		//Plugins
		$item->text='';
		$params->set('vfolder', NULL);
		$params->set('afolder', NULL);
		$params->set('vwidth', NULL);
		$params->set('vheight', NULL);
		$params->set('autoplay', NULL);
		$params->set('galleries_rootfolder', NULL);
		$params->set('enabledownload', NULL);


		if ($view=='item'){

//			if ($item->params->get('itemIntroText'))
			$item->text.= $item->introtext;
//			if ($item->params->get('itemFullText'))
			$item->text.= '{LPDSplitter}'.$item->fulltext;
		}
		else {

			switch($task){
				case '':
				case 'category':
					if ($item->params->get('catItemIntroText')) $item->text.= $item->introtext;
					break;

				case 'user':
					if ($item->params->get('userItemIntroText')) $item->text.= $item->introtext;
					break;
					
				case 'tag':
					if ($item->params->get('tagItemIntroText')) $item->text.= $item->introtext;
					break;
					
				default:
					if ($item->params->get('genericItemIntroText')) $item->text.= $item->introtext;
					break;
			}

		}

		if(LPD_JVERSION == '16') {
			
			$item->event->BeforeDisplay = '';
			$item->event->AfterDisplay = '';
				
			$dispatcher->trigger('onContentPrepare', array ('com_lpd.'.$view, &$item, &$params, $limitstart));

			$results = $dispatcher->trigger('onContentAfterTitle', array('com_lpd.'.$view, &$item, &$params, $limitstart));
			$item->event->AfterDisplayTitle = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onContentBeforeDisplay', array('com_lpd.'.$view, &$item, &$params, $limitstart));
			$item->event->BeforeDisplayContent = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onContentAfterDisplay', array('com_lpd.'.$view, &$item, &$params, $limitstart));
			$item->event->AfterDisplayContent = trim(implode("\n", $results));

		}
		else {
			$results = $dispatcher->trigger('onBeforeDisplay', array ( & $item, &$params, $limitstart));
			$item->event->BeforeDisplay = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onAfterDisplay', array ( & $item, &$params, $limitstart));
			$item->event->AfterDisplay = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onAfterDisplayTitle', array ( & $item, &$params, $limitstart));
			$item->event->AfterDisplayTitle = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onBeforeDisplayContent', array ( & $item, &$params, $limitstart));
			$item->event->BeforeDisplayContent = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onAfterDisplayContent', array ( & $item, &$params, $limitstart));
			$item->event->AfterDisplayContent = trim(implode("\n", $results));

			$dispatcher->trigger('onPrepareContent', array ( & $item, &$params, $limitstart));

		}




		//LPD plugins
		$item->event->LPDBeforeDisplay = '';
		$item->event->LPDAfterDisplay = '';
		$item->event->LPDAfterDisplayTitle = '';
		$item->event->LPDBeforeDisplayContent = '';
		$item->event->LPDAfterDisplayContent = '';

		if(
		($view=='item' && $item->params->get('itemLPDPlugins')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemLPDPlugins')) ||
		($view=='itemlist' && $task=='user' && $item->params->get('userItemLPDPlugins'))
		)
		{
			JPluginHelper::importPlugin ( 'lpd' );

			$results = $dispatcher->trigger('onLPDBeforeDisplay', array ( & $item, &$params, $limitstart));
			$item->event->LPDBeforeDisplay = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onLPDAfterDisplay', array ( & $item,& $params, $limitstart));
			$item->event->LPDAfterDisplay = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onLPDAfterDisplayTitle', array ( & $item, &$params, $limitstart));
			$item->event->LPDAfterDisplayTitle = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onLPDBeforeDisplayContent', array ( & $item, &$params, $limitstart));
			$item->event->LPDBeforeDisplayContent = trim(implode("\n", $results));

			$results = $dispatcher->trigger('onLPDAfterDisplayContent', array ( & $item, &$params, $limitstart));
			$item->event->LPDAfterDisplayContent = trim(implode("\n", $results));

			$dispatcher->trigger('onLPDPrepareContent', array ( & $item, &$params, $limitstart));

		}

		if ($view=='item'){
			@list($item->introtext, $item->fulltext) = explode('{LPDSplitter}', $item->text);
		}
		else {
			$item->introtext = $item->text;
		}
		
		
		// Extra fields plugins
		if(
		($view=='item' && $item->params->get('itemExtraFields')) ||
		($view=='itemlist' && ($task=='' || $task=='category') && $item->params->get('catItemExtraFields'))
		)
		{
			if (count($item->extra_fields)) {
				foreach($item->extra_fields as $key => $extraField) {
					if($extraField->type == 'textarea' || $extraField->type == 'textfield') {
						$tmp = new JObject();
						$tmp->text = $extraField->value;
						if(LPD_JVERSION == '16') {
							$dispatcher->trigger('onContentPrepare', array ('com_lpd.'.$view, &$tmp, &$params, $limitstart));
						}
						else {
							$dispatcher->trigger('onPrepareContent', array ( & $tmp, &$params, $limitstart));
						}
						$dispatcher->trigger('onLPDPrepareContent', array ( & $tmp, &$params, $limitstart));
						$extraField->value = $tmp->text;
					}
				}
			}
		}
		return $item;

	}

	function hit($id){

		$row = & JTable::getInstance('LPDItem', 'Table');
		$row->hit($id);
	}

	function vote(){

		$mainframe = &JFactory::getApplication();
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables' );

		//Get item
		$item = & JTable::getInstance('LPDItem', 'Table');
		$item->load(JRequest::getInt('itemID'));

		//Get category
		$category = & JTable::getInstance('LPDCategory', 'Table');
		$category->load($item->catid);

		//Access check
		$user = JFactory::getUser();
		if(LPD_JVERSION=='16'){
			if (!in_array($item->access, $user->authorisedLevels()) || !in_array($category->access, $user->authorisedLevels())) {
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
			}
		}
		else {
			if ($item->access > $user->get('aid', 0) || $category->access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('LPD_ALERTNOTAUTH') );
			}
		}


		//Published check
		if (!$item->published || $item->trash ) {
			JError::raiseError( 404, JText::_('LPD_ITEM_NOT_FOUND') );
		}
		if (!$category->published || $category->trash) {
			JError::raiseError( 404, JText::_('LPD_ITEM_NOT_FOUND') );
		}


		$rate = JRequest::getVar('user_rating', 0, '', 'int');

		if ( $rate >= 1 && $rate <= 5) {
			$db = & JFactory::getDBO();
			$userIP =  $_SERVER['REMOTE_ADDR'];
			$query = "SELECT * FROM #__lpd_rating WHERE itemID =".(int)$item->id;
			$db->setQuery($query);
			$rating = $db->loadObject();

			if (!$rating) {
				$query = "INSERT INTO #__lpd_rating ( itemID, lastip, rating_sum, rating_count ) VALUES ( ".(int)$item->id.", ".$db->Quote($userIP).", {$rate}, 1 )";
				$db->setQuery($query);
				$db->query();
				echo JText::_('LPD_THANKS_FOR_RATING');

			}

			else {
				if ($userIP != ($rating->lastip)) {
					$query = "UPDATE #__lpd_rating".
					" SET rating_count = rating_count + 1, rating_sum = rating_sum + {$rate}, lastip = ".$db->Quote($userIP).
					" WHERE itemID = {$item->id}";
					$db->setQuery($query);
					$db->query();
					echo JText::_('LPD_THANKS_FOR_RATING');

				}
				else {
					echo JText::_('LPD_YOU_HAVE_ALREADY_RATED_THIS_ITEM');
				}
			}

		}
		$mainframe->close();
	}

	function getRating($id){
		$id = (int)$id;
		static $LPDRatingsInstances = array();
		if(array_key_exists($id, $LPDRatingsInstances)){
			return $LPDRatingsInstances[$id];
		}
		$db = & JFactory::getDBO();
		$query = "SELECT * FROM #__lpd_rating WHERE itemID = ".$id;
		$db->setQuery($query);
		$vote = $db->loadObject();
		$LPDRatingsInstances[$id] = $vote;
		return $LPDRatingsInstances[$id];
	}


	function getVotesNum($itemID=NULL) {

		$mainframe = &JFactory::getApplication();
		$user = JFactory::getUser();
		$xhr = false;
		if (is_null($itemID)){
			$itemID = JRequest::getInt('itemID');
			$xhr = true;
		}

		$vote = LPDModelItem::getRating($itemID);

		if (!is_null($vote)) $rating_count = intval($vote->rating_count);
		else $rating_count=0;

		if ($rating_count != 1) {
			$result="(".$rating_count." ".JText::_('LPD_VOTES').")";
		}
		else {
			$result="(".$rating_count." ".JText::_('LPD_VOTE').")";
		}
		if ($xhr){
			echo $result;
			$mainframe->close();
		}
		else return $result;
	}

	function getVotesPercentage($itemID=NULL) {

		$mainframe = &JFactory::getApplication();
		$user = JFactory::getUser();
		$db = & JFactory::getDBO();
		$xhr = false;
		$result = 0;
		if (is_null($itemID)){

			$itemID = JRequest::getInt('itemID');
			$xhr= true;
		}

		$vote = LPDModelItem::getRating($itemID);

		if (!is_null($vote) && $vote->rating_count != 0) {
			$result = number_format(intval($vote->rating_sum)/intval($vote->rating_count), 2)*20;
		}
		if ($xhr){
			echo $result;
			$mainframe->close();
		}
		else return $result;
	}

	function comment(){

		$mainframe = &JFactory::getApplication();
		jimport('joomla.mail.helper');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables' );
		$params = &LPDHelperUtilities::getParams('com_lpd');
		$user = JFactory::getUser();
		$config =& JFactory::getConfig();

		JLoader::register('Services_JSON', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');
		$json = new Services_JSON;
		$response = new JObject();


		//Get item
		$item = & JTable::getInstance('LPDItem', 'Table');
		$item->load(JRequest::getInt('itemID'));

		//Get category
		$category = & JTable::getInstance('LPDCategory', 'Table');
		$category->load($item->catid);

		//Access check
		if(LPD_JVERSION=='16'){
			if (!in_array($item->access, $user->authorisedLevels()) || !in_array($category->access, $user->authorisedLevels())) {
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
			}
		}
		else {
			if ($item->access > $user->get('aid', 0) || $category->access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('LPD_ALERTNOTAUTH') );
			}
		}

		//Published check
		if (!$item->published || $item->trash ) {
			JError::raiseError( 404, JText::_('LPD_ITEM_NOT_FOUND') );
		}
		if (!$category->published || $category->trash) {
			JError::raiseError( 404, JText::_('LPD_ITEM_NOT_FOUND') );
		}

		//Check permissions
		if ((($params->get('comments') == '2') && ($user->id > 0) && LPDHelperPermissions::canAddComment($item->catid)) || ($params->get('comments') == '1')) {

			$row = & JTable::getInstance ( 'LPDComment', 'Table' );

			if (! $row->bind ( JRequest::get ( 'post' ) )) {
				$response->message($row->getError());
				echo $json->encode($response);
				$mainframe->close();
			}

			$row->commentText = JRequest::getString('commentText', '', 'default');
			$row->commentText = strip_tags($row->commentText);
			//Strip a tags since all urls will be converted to links automatically on runtime.
			//Additionaly strip tables to avoid layout issues.
			//Also strip all attributes except src, alt and title.
			//$filter	= new JFilterInput(array('a', 'table'), array('src', 'alt', 'title'), 1);
			//$row->commentText = $filter->clean( $row->commentText );

			//Clean vars
			$filter = & JFilterInput::getInstance();
			$row->userName = $filter->clean( $row->userName, 'username' );
			if ($row->commentURL && preg_match('/^((http|https|ftp):\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}((:[0-9]{1,5})?\/.*)?$/i' , $row->commentURL)) {
				$url = preg_replace('|[^a-z0-9-~+_.?#=&;,/:]|i', '', $row->commentURL);
				$url = str_replace(';//', '://', $url);
				if ($url != '') {
					$url = (!strstr($url, '://')) ? 'http://'.$url : $url;
					$url = preg_replace('/&([^#])(?![a-z]{2,8};)/', '&#038;$1', $url);
					$row->commentURL=$url;
				}
			}
			else {
				$row->commentURL = '';
			}

			$datenow =& JFactory::getDate();
			$row->commentDate = $datenow->toMySQL();

			if (!$user->guest) {
				$row->userID = $user->id;
				$row->commentEmail = $user->email;
				$row->userName=$user->name;
			}

			$userName = trim($row->userName);
			$commentEmail = trim($row->commentEmail);
			$commentText = trim($row->commentText);
			$commentURL = trim($row->commentURL);

			if ( empty($userName) || $userName==JText::_('LPD_ENTER_YOUR_NAME') || empty($commentText) || $commentText==JText::_('LPD_ENTER_YOUR_MESSAGE_HERE') || empty($commentEmail) || $commentEmail==JText::_('LPD_ENTER_YOUR_EMAIL_ADDRESS')) {
				$response->message = JText::_('LPD_YOU_NEED_TO_FILL_IN_ALL_REQUIRED_FIELDS', true);
				echo $json->encode($response);
				$mainframe->close();
			}

			if (!JMailHelper::isEmailAddress($commentEmail)) {
				$response->message = JText::_('LPD_INVALID_EMAIL_ADDRESS', true);
				echo $json->encode($response);
				$mainframe->close();
			}


			if ($user->guest){
				$db = & JFactory::getDBO();
				$query = "SELECT COUNT(*) FROM #__users WHERE name=".$db->Quote($userName)." OR email=".$db->Quote($commentEmail);
				$db->setQuery($query);
				$result = $db->loadresult();
				if ($result>0){
					$response->message = JText::_('LPD_THE_NAME_OR_EMAIL_ADDRESS_YOU_TYPED_IS_ALREADY_IN_USE', true);
					echo $json->encode($response);
					$mainframe->close();
				}

			}


			if ($params->get('recaptcha') && $user->guest) {
				require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'recaptchalib.php');
				$privatekey = $params->get('recaptcha_private_key');
				$recaptcha_challenge_field = isset($_POST["recaptcha_challenge_field"])? $_POST["recaptcha_challenge_field"]:'';
				$recaptcha_response_field = isset($_POST["recaptcha_response_field"])? $_POST["recaptcha_response_field"]:'';
				$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);
				if (!$resp->is_valid) {
					$response->message = JText::_('LPD_THE_WORDS_YOU_TYPED_DID_NOT_MATCH_THE_ONES_DISPLAYED_PLEASE_TRY_AGAIN', true);
					echo $json->encode($response);
					$mainframe->close();
				}
			}

			if ($commentURL == JText::_('LPD_ENTER_YOUR_SITE_URL') || $commentURL == "") {
				$row->commentURL = NULL;
			}
			else {
				if (substr($commentURL, 0, 7) != 'http://') {
					$row->commentURL = 'http://'.$commentURL;
				}
			}

			if ($params->get('commentsPublishing')) {
				$row->published = 1;
			}
			else {
				$row->published = 0;
				// Auto publish comments for users with administrative permissions
				if(LPD_JVERSION == '16') {
					if($user->authorise('core.admin')) {
						$row->published = 1;
					}
				}
				else {
					if($user->gid > 23) {
						$row->published = 1;
					}
				}
			}

			if (!$row->store()) {
				$response->message = $row->getError();
				echo $json->encode($response);
				$mainframe->close();
			}

			if ($row->published) {
				if ($config->getValue( 'config.caching' )){
					$response->message = JText::_('LPD_THANK_YOU_YOUR_COMMENT_WILL_BE_PUBLISHED_SHORTLY', true);
					echo $json->encode($response);
				}
				else {
					$response->message = JText::_('LPD_COMMENT_ADDED_REFRESHING_PAGE', true);
					$response->refresh = 1;
					echo $json->encode($response);
				}

			}
			else {
				$response->message = JText::_('LPD_COMMENT_ADDED_AND_WAITING_FOR_APPROVAL', true);
				echo $json->encode($response);
			}

		}
		$mainframe->close();
	}

	function getItemTags($itemID){
		$itemID = (int)$itemID;
		static $LPDItemTagsInstances = array();
		if(isset($LPDItemTagsInstances[$itemID])){
			return $LPDItemTagsInstances[$itemID];
		}
		$db = & JFactory::getDBO();

		$query = "SELECT tag.*
		FROM #__lpd_tags AS tag 
		JOIN #__lpd_tags_xref AS xref ON tag.id = xref.tagID 
		WHERE tag.published=1 
		AND xref.itemID = ".(int)$itemID;

		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$LPDItemTagsInstances[$itemID] = $rows;
		return $LPDItemTagsInstances[$itemID];
	}

	function getItemExtraFields($itemExtraFields){
		 
		static $LPDItemExtraFieldsInstances = array();
		if(isset($LPDItemExtraFieldsInstances[$itemExtraFields])){
			return $LPDItemExtraFieldsInstances[$itemExtraFields];
		}

		jimport('joomla.filesystem.file');
		$db = & JFactory::getDBO ();
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');
		$json=new Services_JSON;
		$jsonObjects=$json->decode($itemExtraFields);
		$imgExtensions = array('jpg','jpeg','gif','png');
		$params = & LPDHelperUtilities::getParams('com_lpd');

		if (count($jsonObjects)<1)
		return NULL;

		foreach ($jsonObjects as $object){
			$extraFieldsIDs[]=$object->id;
		}
		JArrayHelper::toInteger($extraFieldsIDs);
		$condition=@implode(',',$extraFieldsIDs);

		$query="SELECT * FROM #__lpd_extra_fields WHERE published=1 AND id IN ({$condition}) ORDER BY ordering ASC";
		$db->setQuery($query);
		$rows = $db->loadObjectList();

		for ($i=0; $i<sizeof($rows); $i++){

			$value='';
			$values = array();
			foreach ($jsonObjects as $object){

				if ($rows[$i]->id==$object->id){

					if ( $rows[$i]->type=='textfield'|| $rows[$i]->type=='textarea' || $rows[$i]->type=='date'){
						$value=$object->value;
						if($rows[$i]->type == 'date') {
							$value = JHTML::_('date', $value, JText::_('LPD_DATE_FORMAT_LC'));
						}
						
					}
					else if($rows[$i]->type=='labels'){
						$labels = explode(',', $object->value);
						if(!is_array($labels)){
							$labels = (array)$labels;
						}
						$value='';
						foreach($labels as $label){
							$label = JString::trim($label);
							$label = str_replace('-',' ' ,$label);
							$value.='<a href="'.JRoute::_('index.php?option=com_lpd&view=itemlist&task=search&searchword='.urlencode($label)).'">'.$label.'</a> ';
						}


					}

					else if($rows[$i]->type=='select'|| $rows[$i]->type=='radio'){
						foreach ($json->decode($rows[$i]->value) as $option){
							if ($option->value==$object->value)
							$value.=$option->name;
						}
					}

					else if ($rows[$i]->type=='multipleSelect'){
						foreach ($json->decode($rows[$i]->value) as $option){
							if (@in_array($option->value,$object->value))
							$values[]=$option->name;
						}
						$value=@implode(', ',$values);
					}

					else if ($rows[$i]->type=='csv'){
						$array = $object->value;
						if(count($array)){
							$value.='<table cellspacing="0" cellpadding="0" class="csvTable">';
							foreach($array as $key=>$row){
								$value.='<tr>';
								foreach($row as $cell){
									$value.=($key>0)?'<td>'.$cell.'</td>':'<th>'.$cell.'</th>';
								}
								$value.='</tr>';
							}
							$value.='</table>';
						}

					}

					else {
						foreach ($json->decode($rows[$i]->value) as $option){

							switch ($object->value[2]){
								case 'same':
								default:
									$attributes='';
									break;

								case 'new':
									$attributes='target="_blank"';
									break;

								case 'popup':
									$attributes='class="classicPopup" rel="{\'x\':'.$params->get('linkPopupWidth').',\'y\':'.$params->get('linkPopupHeight').'}"';
									break;

								case 'lightbox':
									$filename = @basename($object->value[1]);
									$extension = JFile::getExt($filename);
									if (!empty($extension) && in_array($extension,$imgExtensions)) {
										$attributes='class="modal"';
									}
									else {
										$attributes='class="modal" rel="{handler:\'iframe\',size:{x:'.$params->get('linkPopupWidth').',y:'.$params->get('linkPopupHeight').'}}"';
									}
									break;

							}
							$value = ($object->value[0] && $object->value[1])? '<a href="'.$object->value[1].'" '.$attributes.'>'.$object->value[0].'</a>' : false;
						}
					}

				}

			}
			$rows[$i]->value=$value;
		}
		$LPDItemExtraFieldsInstances[$itemExtraFields] = $rows;
		return $LPDItemExtraFieldsInstances[$itemExtraFields];
	}

	function getItemAttachments($itemID){
		$itemID = (int)$itemID;
		static $LPDItemAttachmentsInstances = array();
		if(isset($LPDItemAttachmentsInstances[$itemID])){
			return $LPDItemAttachmentsInstances[$itemID];
		}

		$db = & JFactory::getDBO ();
		$query="SELECT * FROM #__lpd_attachments WHERE itemID=".$itemID;
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		foreach($rows as $row) {
			$row->link = JRoute::_('index.php?option=com_lpd&view=item&task=download&id='.$row->id.'_'.JUtility::getHash($row->id));
		}
		$LPDItemAttachmentsInstances[$itemID] = $rows;
		return $LPDItemAttachmentsInstances[$itemID];
	}

	function getItemComments($itemID ,$limitstart, $limit, $published=true){

		$params = & LPDHelperUtilities::getParams('com_lpd');
		$order=$params->get('commentsOrdering','DESC');
		$ordering = ($order=='DESC')?'DESC':'ASC';
		$db = & JFactory::getDBO ();
		$query="SELECT * FROM #__lpd_comments WHERE itemID=".(int)$itemID;
		if($published){
			$query.=" AND published=1 ";
		}
		$query.=" ORDER BY commentDate {$ordering}";
		$db->setQuery($query ,$limitstart, $limit);
		$rows = $db->loadObjectList();
		return $rows;
	}

	function countItemComments($itemID, $published=true){
		 
		$itemID = (int)$itemID;
		$index = $itemID.'_'.(int)$published;
		static $LPDItemCommentsCountInstances = array();
		if(isset($LPDItemCommentsCountInstances[$index])){
			return $LPDItemCommentsCountInstances[$index];
		}

		$db = & JFactory::getDBO ();
		$query="SELECT COUNT(*) FROM #__lpd_comments WHERE itemID=".$itemID;
		if($published){
			$query.=" AND published=1 ";
		}
		$db->setQuery($query);
		$result = $db->loadResult();
		$LPDItemCommentsCountInstances[$index] = $result;
		return $LPDItemCommentsCountInstances[$index];

	}

	function checkin(){

		$mainframe = &JFactory::getApplication();
		$id = JRequest::getInt('cid');
		$row = & JTable::getInstance('LPDItem', 'Table');
		$row->load($id);
		$row->checkin();
		$mainframe->close();
	}

	function getPreviousItem($id,$catid,$ordering){
		
		$mainframe = &JFactory::getApplication();
		$user =& JFactory::getUser();
		$id = (int) $id;
		$catid = (int) $catid;
		$ordering = (int) $ordering;
		$db = & JFactory::getDBO ();

		$jnow =& JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		
		if(LPD_JVERSION == '16') {
			$accessCondition = ' AND access IN('.implode(',', $user->authorisedLevels()).')';
		}
		else {
			$accessCondition = ' AND access <= '.$user->aid;;
		}
		
		$languageCondition = '';
		if(LPD_JVERSION == '16') {
			if($mainframe->getLanguageFilter()) {
				$languageCondition = "AND language IN (".$db->quote(JFactory::getLanguage()->getTag()).",".$db->quote('*').")";
			}
		}

		if ($ordering=="0") {
			$query="SELECT * FROM #__lpd_items WHERE id < {$id} AND catid={$catid} AND published=1 AND ( publish_up = ".$db->Quote($nullDate)." OR publish_up <= ".$db->Quote($now)." ) AND ( publish_down = ".$db->Quote($nullDate)." OR publish_down >= ".$db->Quote($now)." ) {$accessCondition} AND trash=0 {$languageCondition} ORDER BY ordering DESC";
		}
		else {
			$query="SELECT * FROM #__lpd_items WHERE id != {$id} AND catid={$catid} AND ordering < {$ordering} AND published=1 AND ( publish_up = ".$db->Quote($nullDate)." OR publish_up <= ".$db->Quote($now)." ) AND ( publish_down = ".$db->Quote($nullDate)." OR publish_down >= ".$db->Quote($now)." ) {$accessCondition} AND trash=0 {$languageCondition} ORDER BY ordering DESC";
		}

		$db->setQuery($query,0,1);
		$row = $db->loadObject();
		return $row;
	}

	function getNextItem($id,$catid,$ordering){

		$mainframe = &JFactory::getApplication();
		$user =& JFactory::getUser();
		$id = (int) $id;
		$catid = (int) $catid;
		$ordering = (int) $ordering;
		$db = & JFactory::getDBO ();

		$jnow =& JFactory::getDate();
		$now = $jnow->toMySQL();
		$nullDate = $db->getNullDate();
		
		if(LPD_JVERSION == '16') {
			$accessCondition = ' AND access IN('.implode(',', $user->authorisedLevels()).')';
		}
		else {
			$accessCondition = ' AND access <= '.$user->aid;;
		}
		
		$languageCondition = '';
		if(LPD_JVERSION == '16') {
			if($mainframe->getLanguageFilter()) {
				$languageCondition = "AND language IN (".$db->quote(JFactory::getLanguage()->getTag()).",".$db->quote('*').")";
			}
		}

		if ($ordering=="0") {
			$query="SELECT * FROM #__lpd_items WHERE id > {$id} AND catid={$catid} AND published=1 AND ( publish_up = ".$db->Quote($nullDate)." OR publish_up <= ".$db->Quote($now)." ) AND ( publish_down = ".$db->Quote($nullDate)." OR publish_down >= ".$db->Quote($now)." ) {$accessCondition} AND trash=0 {$languageCondition} ORDER BY ordering ASC";
		}
		else {
			$query="SELECT * FROM #__lpd_items WHERE id != {$id} AND catid={$catid} AND ordering > {$ordering} AND published=1 AND ( publish_up = ".$db->Quote($nullDate)." OR publish_up <= ".$db->Quote($now)." ) AND ( publish_down = ".$db->Quote($nullDate)." OR publish_down >= ".$db->Quote($now)." ) {$accessCondition} AND trash=0 {$languageCondition} ORDER BY ordering ASC";
		}
		$db->setQuery($query,0,1);
		$row = $db->loadObject();
		return $row;
	}

	function getUserProfile($id=NULL) {

		$db = & JFactory::getDBO();
		if (is_null($id)) $id = JRequest::getInt('id');

		static $LPDUsersInstances = array();
		if(isset($LPDUsersInstances[$id])){
			return $LPDUsersInstances[$id];
		}

		$query="SELECT id, gender, description, image, url, `group`, plugins FROM #__lpd_users WHERE userID={$id}";
		$db->setQuery($query);
		$row = $db->loadObject();
		$LPDUsersInstances[$id] = $row;
		return $row;
	}

}
