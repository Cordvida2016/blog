<?php
/**
 * @version		$Id: lpdplugin.php 1331 2011-11-25 11:41:27Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

JLoader::register('LPDParameter', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'lpdparameter.php');

class LPDPlugin extends JPlugin {

	/**
	 * Below we list all available BACKEND events, to trigger LPD plugins and generate additional fields in the item, category and user forms.
	 */

	/* ------------ Functions to render plugin parameters in the backend - no need to change anything ------------ */
	function onRenderAdminForm( & $item, $type, $tab='') {
	
		$mainframe = &JFactory::getApplication();
		$manifest = (LPD_JVERSION == '15')? JPATH_SITE.DS.'plugins'.DS.'lpd'.DS.$this->pluginName.'.xml': JPATH_SITE.DS.'plugins'.DS.'lpd'.DS.$this->pluginName.DS.$this->pluginName.'.xml';
		if ( !empty ($tab)) {
			$path = $type.'-'.$tab;
		}
		else {
			$path = $type;
		}
		$form = new LPDParameter($item->plugins, $manifest, $this->pluginName);
		$fields = $form->render('plugins', $path);
		if ($fields){
			$plugin = new JObject;
			$plugin->set('name', $this->pluginNameHumanReadable);
			$plugin->set('fields', $fields);
			return $plugin;	
		}
	}

}
