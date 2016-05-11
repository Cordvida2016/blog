<?php
/**
 * @version		$Id: mod_lpd_stats.php 1385 2011-12-06 10:46:38Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

if(LPD_JVERSION == '16'){
	$language = &JFactory::getLanguage();
	$language->load('mod_lpd.j16', JPATH_ADMINISTRATOR);
}

require_once(dirname(__FILE__).DS.'helper.php');

if($params->get('latestItems', 1)){
	$latestItems = modLPDStatsHelper::getLatestItems();
}
if($params->get('popularItems', 1)){
	$popularItems = modLPDStatsHelper::getPopularItems();
}
if($params->get('mostCommentedItems', 1)){
	$mostCommentedItems = modLPDStatsHelper::getMostCommentedItems();
}
if($params->get('latestComments', 1)){
	$latestComments = modLPDStatsHelper::getLatestComments();
}
if($params->get('statistics', 1)){
	$statistics = modLPDStatsHelper::getStatistics();
}

require(JModuleHelper::getLayoutPath('mod_lpd_stats'));
