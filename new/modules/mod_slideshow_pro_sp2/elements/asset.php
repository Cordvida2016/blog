<?php
/*
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# Author: JoomShaper.com
# Websites:  http://www.joomshaper.com
# ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField
{
	protected	$type = 'Asset';
	
	protected function getInput() {
		$doc = JFactory::getDocument();
		if (JVERSION<3) {
			$doc->addScript(JURI::root(true).'/modules/mod_slideshow_pro_sp2/elements/js/jquery.js');
			$doc->addScript(JURI::root(true).'/modules/mod_slideshow_pro_sp2/elements/js/script.js');
			$doc->addStylesheet(JURI::root(true).'/modules/mod_slideshow_pro_sp2/elements/css/style.css');
		} else {
			JHtml::_('jquery.framework');
			$doc->addScript(JURI::root(true).'/modules/mod_slideshow_pro_sp2/elements/js/script_j3.js');
		}
		
		return null;
	}
}