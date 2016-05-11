<?php
/**
 * @version		$Id: lpd.php 1390 2011-12-08 22:27:55Z joomlaworks@gmail.com $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(LPD_JVERSION=='16'){
	$user = &JFactory::getUser();
	if($user->authorise('core.admin', 'com_lpd')){
		$user->gid = 1000;
	}
	else {
		$user->gid = 1;
	}
}

JLoader::register('LPDHelperRoute', JPATH_COMPONENT.DS.'helpers'.DS.'route.php');
JLoader::register('LPDHelperPermissions', JPATH_COMPONENT.DS.'helpers'.DS.'permissions.php');
JLoader::register('LPDHelperUtilities', JPATH_COMPONENT.DS.'helpers'.DS.'utilities.php');

LPDHelperPermissions::setPermissions();
LPDHelperPermissions::checkPermissions();

$controller = JRequest::getWord('view', 'itemlist');
$task = JRequest::getWord('task');

if($controller == 'media') {
	$controller = 'item';
	if($task != 'connector') {
		$task = 'media';
	}
}

if($controller == 'users') {
	$controller = 'item';
	$task = 'users';
}

jimport('joomla.filesystem.file');
jimport('joomla.html.parameter');

if (JFile::exists(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php')) {
	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
	$classname = 'LPDController'.$controller;
	$controller = new $classname();
	$controller->execute($task);
	$controller->redirect();
}
else {
	JError::raiseError(404, JText::_('LPD_NOT_FOUND'));
}

echo "\n<!-- Landing Pages Designer \"LPD\" | Learn more about LPD at http://www.landingpagesdesigner.com -->\n\n";
