<?php
/**
 * @version		$Id: view.html.php 1113 2011-10-11 14:39:02Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewMedia extends JView {

	function display($tpl = null) {
		$mainframe = &JFactory::getApplication();
		$user = &JFactory::getUser();
		$document = &JFactory::getDocument();
		$document->addStyleSheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css');
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/theme.css');
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/elfinder.full.css');
		$document->addScript(JURI::root(true).'/media/lpd/assets/js/elfinder.min.js');
		$type = JRequest::getCmd('type');
		$fieldID = JRequest::getCmd('fieldID');
		if($type=='video'){
			$mimes = "'video','audio'";
		}
		elseif ($type == 'image'){
			$mimes = "'image'";
		}
		else {
			$mimes = '';
		}
		$this->assignRef('mimes', $mimes);
		$this->assignRef('type', $type);
		$this->assignRef('fieldID', $fieldID);
		if($mainframe->isAdmin()) {
			$toolbar=& JToolBar::getInstance('toolbar');
			if(LPD_JVERSION == '16'){
				JToolBarHelper::preferences('com_lpd', 550, 875, 'LPD_PARAMETERS');
			}
			else {
				$toolbar->appendButton('Popup', 'config', 'LPD_PARAMETERS', 'index.php?option=com_lpd&view=settings');
			}
			JToolBarHelper::title(JText::_('LPD_MEDIA_MANAGER'), 'lpd.png');
			$this->loadHelper('html');
			LPDHelperHTML::subMenu();
		}
		parent::display($tpl);

	}

}
