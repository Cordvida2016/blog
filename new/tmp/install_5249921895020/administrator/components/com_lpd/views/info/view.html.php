<?php
/**
 * @version		$Id: view.html.php 1112 2011-10-11 14:34:53Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewInfo extends JView
{

	function display($tpl = null) {

		jimport ( 'joomla.filesystem.file' );
		$user = & JFactory::getUser();
		$db = & JFactory::getDBO();
		$db_version = $db->getVersion();
		$php_version = phpversion();
		$server = $this->get_server_software();
		$gd_check = extension_loaded('gd');
		$mb_check = extension_loaded('mbstring');

		$media_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd');
		$attachments_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'attachments');
		$categories_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'categories');
		$galleries_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'galleries');
		$items_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'items');
		$users_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'users');
		$videos_folder_check = is_writable(JPATH_ROOT.DS.'media'.DS.'lpd'.DS.'videos');
		$cache_folder_check = is_writable(JPATH_ROOT.DS.'cache');

		$this->assignRef('server',$server);
		$this->assignRef('php_version',$php_version);
		$this->assignRef('db_version',$db_version);
		$this->assignRef('gd_check',$gd_check);
		$this->assignRef('mb_check',$mb_check);

		$this->assignRef('media_folder_check',$media_folder_check);
		$this->assignRef('attachments_folder_check',$attachments_folder_check);
		$this->assignRef('categories_folder_check',$categories_folder_check);
		$this->assignRef('galleries_folder_check',$galleries_folder_check);
		$this->assignRef('items_folder_check',$items_folder_check);
		$this->assignRef('users_folder_check',$users_folder_check);
		$this->assignRef('videos_folder_check',$videos_folder_check);
		$this->assignRef('cache_folder_check',$cache_folder_check);

		JToolBarHelper::title(JText::_('LPD_INFORMATION'), 'lpd.png');

		if(LPD_JVERSION == '16'){
			JToolBarHelper::preferences('com_lpd', 550, 875, 'LPD_PARAMETERS');
		}
		else {
			$toolbar=& JToolBar::getInstance('toolbar');
        	$toolbar->appendButton('Popup', 'config', 'Parameters', 'index.php?option=com_lpd&view=settings');			
		}

		$this->loadHelper('html');
		LPDHelperHTML::subMenu();

		parent::display($tpl);
	}

	function get_server_software()
	{
		if (isset($_SERVER['SERVER_SOFTWARE'])) {
			return $_SERVER['SERVER_SOFTWARE'];
		} else if (($sf = getenv('SERVER_SOFTWARE'))) {
			return $sf;
		} else {
			return JText::_('LPD_NA');
		}
	}

}
