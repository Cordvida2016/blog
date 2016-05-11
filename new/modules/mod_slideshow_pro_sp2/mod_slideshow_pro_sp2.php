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
$document 				= JFactory::getDocument();
$moduleName         	= basename(dirname(__FILE__));
$uniqid					= $module->id;
JHtml::_('behavior.framework', true);
require_once (dirname(__FILE__).'/common.php');//include common.php file
$content_source			= $params->get('content_source', 'joomla');
if ($content_source=="joomla") {
	require_once (dirname(__FILE__).'/helper.php');
	$list 				= modSlideShowSP2Helper::getList($params, $uniqid);
} else {
	require_once (dirname(__FILE__).'/k2helper.php');
	$list 				= modSlideShowSP2K2Helper::getList($params, $uniqid);
}
$layout					= $params->get('layout', 'default');
$showtitle				= $params->get('showtitle',1) ? true : false;
$titlelinked			= $params->get('titlelinked',1) ? true : false;
$showdate				= $params->get('showdate',1) ? true : false;
$showarticle			= $params->get('showarticle',1) ? true : false;
$showimage				= $params->get('showimage',1) ? true : false;
$imagelinked			= $params->get('imagelinked',1) ? true : false;
$showmore				= $params->get('showmore',1) ? true : false;
$showarrows				= $params->get('showarrows',1) ? true : false;
$autoplay				= $params->get('autoplay',1) ? true : false;
$thumbratio				= $params->get('thumbratio', 1) ? true : false;
$showthumb				= $params->get('showthumb', 1) ? true : false;
$moretext				= $params->get('moretext', 'Read More...');
$width					= $params->get('width', 320);
$height					= $params->get('height', 200);
$interval 				= $params->get("interval", 5000);
$speed 					= $params->get('speed', 1000);
$effects				= $params->get('effects','cover-inplace-fade');
$transition 			= $params->get("transition", "Sine.easeOut");
$thumbwidth				= $params->get('thumbwidth', 50);
$thumbheight			= $params->get('thumbheight', 50);
$itemheight				= $params->get('itemheight', 50);
$itemwidth				= $params->get('itemwidth', 50);
$show_c_title			= $params->get('show_c_title');
$show_c_desc			= $params->get('show_c_desc');
$maxitem				= $params->get('maxitem', 3);
$mouse_wheel			= $params->get('mouse_wheel', 1) ? "true" : "false";
if ($maxitem>count($list)) 
	$maxitem 			= count($list);
//Calculations
$left 					= $showarrows ? 40 : 0;
$slide_height			= $height-$itemheight;
$slide_width			= $width-$itemwidth;
$cwidth					= $showarrows ? $width-80 : $width;
$thumb_width			= round($cwidth/$maxitem);
$thumb_height			= round($height/$maxitem);

//Load Layout Style
$cssFile 				= JPATH_THEMES. '/'.$document->template.'/css/'.$moduleName.'_'.$layout.'.css';
if(file_exists($cssFile)) {
	$document->addStylesheet(JURI::base(true) . '/templates/'.$document->template.'/css/'.$moduleName.'_'.$layout.'.css');
} else {
	$document->addStylesheet(JURI::base(true) . '/modules/'.$moduleName.'/assets/css/'.$moduleName.'_'.$layout.'.css');
}
$document->addScript(JURI::base(true) . '/modules/mod_slideshow_pro_sp2/assets/js/mod_slideshow_pro_sp2.js');

require(JModuleHelper::getLayoutPath('mod_slideshow_pro_sp2', $layout));