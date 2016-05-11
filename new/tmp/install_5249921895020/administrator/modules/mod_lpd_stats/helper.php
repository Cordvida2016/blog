<?php
/**
 * @version		$Id: helper.php 1220 2011-10-18 13:11:26Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modLPDStatsHelper {

	function getLatestItems() {
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'models');
		$model = &JModel::getInstance('cpanel', 'LPDModel');
		return $model->getLatestItems();
	}

	function getPopularItems() {
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'models');
		$model = &JModel::getInstance('cpanel', 'LPDModel');
		return $model->getPopularItems();
	}

	function getMostCommentedItems() {
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'models');
		$model = &JModel::getInstance('cpanel', 'LPDModel');
		return $model->getMostCommentedItems();
	}

	function getLatestComments() {
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'models');
		$model = &JModel::getInstance('cpanel', 'LPDModel');
		return $model->getLatestComments();
	}

	function getStatistics() {
		JModel::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'models');
		$model = &JModel::getInstance('cpanel', 'LPDModel');
		$statistics = new JObject();
		$statistics->numOfItems = $model->countItems();
		$statistics->numOfTrashedItems = $model->countTrashedItems();
		$statistics->numOfFeaturedItems = $model->countFeaturedItems();
		$statistics->numOfComments = $model->countComments();
		$statistics->numOfCategories = $model->countCategories();
		$statistics->numOfTrashedCategories = $model->countTrashedCategories();
		$statistics->numOfUsers = $model->countUsers();
		$statistics->numOfUserGroups = $model->countUserGroups();
		$statistics->numOfTags = $model->countTags();
		return $statistics;
	}

}
