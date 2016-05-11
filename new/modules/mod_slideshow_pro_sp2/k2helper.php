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
$k2route = JPATH_SITE.'/components/com_k2/helpers/route.php';
$k2utilities = JPATH_SITE.'/components/com_k2/helpers/utilities.php';
if (file_exists($k2route))
	require_once($k2route);
	
if (file_exists($k2utilities))
	require_once($k2utilities);
	
abstract class modSlideShowSP2K2Helper {

	public static function getList($params, $uniqid){
	
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
			
			//newly added
			$catids								= $params->get('k2catids', array());
			$ordering							= $params->get('ordering', 'a.ordering');
			$ordering_direction					= $params->get('ordering_direction', 'ASC');
			$user_id							= $params->get('user_id');
			$show_featured						= $params->get('show_featured');

			$user 		= JFactory::getUser();
			$aid 		= $user->get('aid');
			$db 		= JFactory::getDBO();

			$jnow 		= JFactory::getDate();
			$now 		= $jnow->toSQL();
			$nullDate 	= $db->getNullDate();

			$query = "SELECT a.*, c.name as categoryname,c.id as categoryid, c.alias as categoryalias, c.params as categoryparams".
			" FROM #__k2_items as a".
			" LEFT JOIN #__k2_categories c ON c.id = a.catid";
			$query .= " WHERE a.published = 1 AND a.access IN(".implode(',', $user->getAuthorisedViewLevels()).") AND a.trash = 0 AND c.published = 1 AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).")  AND c.trash = 0";
			
			// User filter
			$userId = JFactory::getUser()->get('id');
			switch ($params->get('user_id'))
			{
				case 'by_me':
					$query .= ' AND (a.created_by = ' . (int) $userId . ' OR a.modified_by = ' . (int) $userId . ')';
					break;
				case 'not_me':
					$query .= ' AND (a.created_by <> ' . (int) $userId . ' AND a.modified_by <> ' . (int) $userId . ')';
					break;

				case '0':
					break;

				default:
					$query .= ' AND (a.created_by = ' . (int) $userId . ' OR a.modified_by = ' . (int) $userId . ')';
					break;				
			}

			//Added Category
			if (!is_null($catids)) {
				if (is_array($catids)) {
					JArrayHelper::toInteger($catids);
					$query .= " AND a.catid IN(".implode(',', $catids).")";
				} else {
					$query .= " AND a.catid=".(int)$catids;
				}
			}		
			
			//  Featured items filter
			if ($show_featured == '0')
			$query .= " AND a.featured != 1";

			if ($show_featured == '1')
			$query .= " AND a.featured = 1";

			// ensure should be published
			$query .= " AND ( a.publish_up = ".$db->Quote($nullDate)." OR a.publish_up <= ".$db->Quote($now)." )";
			$query .= " AND ( a.publish_down = ".$db->Quote($nullDate)." OR a.publish_down >= ".$db->Quote($now)." )";
			
			//Ordering
			$orderby = $ordering . ' ' . $ordering_direction; //ordering

			$query .= " ORDER BY ".$orderby;
			$db->setQuery($query, 0, $count);
			$items = $db->loadObjectList();
			
			require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'models'.DS.'item.php');
			$model = new K2ModelItem;
			if (count($items)) {
				foreach ($items as $item) {
				
					if (! empty($item->created_by_alias)) {
						$item->author = $item->created_by_alias;
					} else {
						$author = JFactory::getUser($item->created_by);
						$item->author = $author->name;
					}
	
					$item->created 		= JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC3'));
					$item->hits 		= $item->hits;
					
					$item->image 		= self::getImage($item->id, $item->introtext);
					$item->thumb 		= modSlideShowSP2CommonHelper::thumb($item->image, $thumbwidth, $thumbheight, $thumbratio, $uniqid);
					$item->none 		= JURI::base().'modules/mod_slideshow_pro_sp2/assets/images/none.gif';
					$item->title 		= modSlideShowSP2CommonHelper::cText(htmlspecialchars($item->title),$titlelimit,$titleas);
					$item->text 		= modSlideShowSP2CommonHelper::cText(JHtml::_('content.prepare', $item->introtext),$desclimit,$desclimitas);	
					$item->c_title 		= modSlideShowSP2CommonHelper::cText(htmlspecialchars($item->title),$c_titlelimit,$c_titleas);
					$item->c_text 		= modSlideShowSP2CommonHelper::cText(JHtml::_('content.prepare', $item->introtext),$c_desclimit,$c_desclimitas);
					$item->link 		= urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias))));
					
					$rows[] = $item;
				}
				return $rows;
			}
	}
	
	//retrive k2 image
	private static function getImage($id, $text) {
		if (JFile::exists(JPATH_SITE . '/media/k2/items/cache/' . md5("Image" . $id) . '_XL.jpg')) {
			return 'media/k2/items/cache/' . md5("Image" . $id) . '_XL.jpg';
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