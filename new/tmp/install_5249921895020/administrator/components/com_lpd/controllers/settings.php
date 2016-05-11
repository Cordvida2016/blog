<?php
/**
 * @version		$Id: settings.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class LPDControllerSettings extends JController {

	function display(){
		if(LPD_JVERSION=='16'){
			$mainframe = &JFactory::getApplication();
			$mainframe->redirect('index.php?option=com_config&view=component&component=com_lpd&path=&tmpl=component');
		}
	    else {
	    	JRequest::setVar('tmpl', 'component');
			parent::display();
	    }
	}
	
	function save() {
		$mainframe = &JFactory::getApplication();
		JRequest::checkToken() or jexit('Invalid Token');
		$model = & $this->getModel('settings');
		$model->save();
		$mainframe->redirect('index.php?option=com_lpd&view=settings');
		
	}
	
}
