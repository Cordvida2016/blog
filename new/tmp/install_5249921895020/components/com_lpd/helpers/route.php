<?php
/**
 * @version		$Id: route.php 1339 2011-11-25 16:00:20Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.helper');

class LPDHelperRoute
{

	function getItemRoute($id, $catid = 0) {
		$needles = array (
			'item'=>(int)$id,
			'category'=>(int)$catid,
		);
		$link = 'index.php?option=com_lpd&view=item&id='.$id;
		if ($item = LPDHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item->id;
		}
		return $link;
	}

	function getCategoryRoute($catid)	{
		$needles = array (
			'category'=>(int)$catid
		);
		$link = 'index.php?option=com_lpd&view=itemlist&task=category&id='.$catid;
		if ($item = LPDHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item->id;
		}
		return $link;
	}

	function getUserRoute($userID) {
		$needles = array (
			'user'=>(int)$userID
		);
		$user = &JFactory::getUser($userID);
		if(LPD_JVERSION == '16' && JFactory::getConfig()->get('unicodeslugs') == 1) {
			$alias = JApplication::stringURLSafe($user->name);
		}
		else if(JPluginHelper::isEnabled('system', 'unicodeslug') || JPluginHelper::isEnabled('system', 'jw_unicodeSlugsExtended')){
			$alias = JFilterOutput::stringURLSafe($user->name);
		} else {
			mb_internal_encoding("UTF-8");
			mb_regex_encoding("UTF-8");
			$alias = trim(mb_strtolower($user->name));
			$alias = str_replace('-', ' ', $alias);
			$alias = mb_ereg_replace('[[:space:]]+', ' ', $alias);
			$alias = trim(str_replace(' ', '', $alias));
			$alias = str_replace('.', '', $alias);

			$stripthese = ',|~|!|@|%|^|(|)|<|>|:|;|{|}|[|]|&|`|â€ž|â€¹|â€™|â€˜|â€œ|â€�|â€¢|â€º|Â«|Â´|Â»|Â°|«|»|…';
			$strips = explode('|', $stripthese);
			foreach ($strips as $strip) {
				$alias = str_replace($strip, '', $alias);
			}
			$params = &LPDHelperUtilities::getParams('com_lpd');
			$SEFReplacements = array();
			$items = explode(',', $params->get('SEFReplacements', NULL));
			foreach ($items as $item) {
				if (! empty($item)) {
					@list($src, $dst) = explode('|', trim($item));
					$SEFReplacements[trim($src)] = trim($dst);
				}
			}
			foreach ($SEFReplacements as $key=>$value) {
				$alias = str_replace($key, $value, $alias);
			}
			$alias = trim($alias, '-.');
			if (trim(str_replace('-', '', $alias)) == '') {
				$datenow = &JFactory::getDate();
				$alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
			}
		}
		$link = 'index.php?option=com_lpd&view=itemlist&task=user&id='.$userID.':'.$alias;
		if ($item = LPDHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item->id;
		}
		return $link;
	}

	function getTagRoute($tag) {
		$needles = array (
			'tag'=>$tag
		);
		$link = 'index.php?option=com_lpd&view=itemlist&task=tag&tag='.urlencode($tag);
		if ($item = LPDHelperRoute::_findItem($needles)) {
			$link .= '&Itemid='.$item->id;
		}
		return $link;
	}

	function _findItem($needles)	{
		$component = & JComponentHelper::getComponent('com_lpd');
		$menus = & JApplication::getMenu('site', array ());
		if(LPD_JVERSION=='16'){
			$items = $menus->getItems('component_id', $component->id);
		} else {
			$items = $menus->getItems('componentid', $component->id);
		}
		$match = null;
		foreach ($needles as $needle=>$id) {
			if (count($items)){
				foreach ($items as $item) {
					if ($needle=='user' || $needle == 'category') {
						if ((@$item->query['task'] == $needle) && (@$item->query['id'] == $id)) {
							$match = $item;
							break;
						}
					} else if ($needle=='tag') {
						if ((@$item->query['task'] == $needle) && (@$item->query['tag'] == $id)) {
							$match = $item;
							break;
						}
					} else {
						if ((@$item->query['view'] == $needle) && (@$item->query['id'] == $id)) {
							$match = $item;
							break;
						}
					}
					if (!is_null($match)) {
						break;
					}
				}
				// Second pass [START]
				// Only for multiple categories links. Triggered only if we do not have find any match (link to direct category)
				if(is_null($match)) {
					foreach ($items as $item) {
						if ($needle=='category') {
							if(!isset($item->LPDCategories)) {
								if(LPD_JVERSION == '15') {
									$menuparams = explode("\n", $item->params);
									foreach($menuparams as $param) {
										if(strpos($param, 'categories=')===0) {
											$array = explode('categories=', $param);
											$item->LPDCategories = explode('|', $array[1]);
										}
									}
								} else {
									$menuparams = json_decode($item->params);
									$item->LPDCategories = isset($menuparams->categories)? $menuparams->categories: array();
								}
							}
							if(isset($item->LPDCategories) && is_array($item->LPDCategories)) {
								foreach ($item->LPDCategories as $catid)	{
									if ((@$item->query['view'] == 'itemlist') && (@$item->query['task'] == '') && (@(int)$catid == $id)) {
										$match = $item;
										break;
									}
								}
							}
						}
						if (!is_null($match)) {
							break;
						}
					}
				}
				// Second pass [END]
			}
			if (!is_null($match)) {
				break;
			}
		}
		return $match;
	}
}
