<?php
/*
# ------------------------------------------------------------------------
# SlideShow Pro SP2 module for Joomla 2.5.x and 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# Author: JoomShaper.com
# Websites:  http://www.joomshaper.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
jimport( 'joomla.plugin.helper');
JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modSlideShowSP2Helper
{
	public static function getList($params, $uniqid){
		
		$app	= JFactory::getApplication();
		$db		= JFactory::getDbo();
		
		/*Parameters*/
		$count		    = $params->get('max_article',3); 
		$thumbratio		= $params->get('thumbratio', 1) ? true : false;
		$thumbwidth		= trim($params->get('thumbwidth', 50));
		$thumbheight	= trim($params->get('thumbheight', 50));
		$titleas		= $params->get('titleas');
		$desclimitas	= $params->get('desclimitas');
		$titlelimit		= (int) $params->get('titlelimit');
		$desclimit		= (int) $params->get('desclimit');
		$c_titleas		= $params->get('c_titleas');
		$c_desclimitas	= $params->get('c_desclimitas');		
		$c_titlelimit	= (int) $params->get('c_titlelimit');
		$c_desclimit	= (int) $params->get('c_desclimit');
		$catids			= $params->get('catid', array());
		
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
		
		// Set application parameters in model
		$appParams = $app->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', 0);
		$model->setState('list.limit', (int) $count);
		$model->setState('filter.published', 1);
		
		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);				
		
		// Category filter
		$model->setState('filter.category_id', $catids);		

		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;

			case '0':
				break;

			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}


		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());		

		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}
		
		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
			
		$ordering 			= JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.ordering');
		$ordering_direction	= $params->get('ordering_direction', 'ASC');

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $ordering_direction);

		$items = $model->getItems();
		
		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug 		= $item->catid.':'.$item->category_alias;
			$author 			= JFactory::getUser($item->created_by);
			
			$item->author 		= $author->name;	
			$item->created 		= JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3'));
			$item->hits 		= $item->hits;
			
			$item->image 		= JURI::base().self::getImage($item->introtext,$item->images);
			$item->thumb 		= modSlideShowSP2CommonHelper::thumb($item->image,$thumbwidth,$thumbheight,$thumbratio,$uniqid);
			$item->none 		= 'modules/mod_slideshow_pro_sp2/assets/images/none.gif';
			$item->title 		= modSlideShowSP2CommonHelper::cText(htmlspecialchars($item->title),$titlelimit,$titleas);
			$item->text 		= modSlideShowSP2CommonHelper::cText(JHtml::_('content.prepare', $item->introtext),$desclimit,$desclimitas);	
			$item->c_title 		= modSlideShowSP2CommonHelper::cText(htmlspecialchars($item->title),$c_titlelimit,$c_titleas);
			$item->c_text 		= modSlideShowSP2CommonHelper::cText(JHtml::_('content.prepare', $item->introtext),$c_desclimit,$c_desclimitas);
			$item->link 		= JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
		}	
		
		return $items;
	}	

	private static function getImage($text, $image_src="") {
		$image_src = json_decode($image_src);		
		if (JVERSION>=2.5 && @$image_src->image_intro) {
			return $image_src->image_intro;
		} elseif (JVERSION>=2.5 && @$image_src->image_fulltext) {
			return $image_src->image_fulltext;
		} else {
			preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $text, $matches);	
			if (isset($matches[1])) {
				return $matches[1];
			} else {
				return 'modules/mod_slideshow_pro_sp2/assets/images/no-image.jpg';
			}			
		}
	}
}