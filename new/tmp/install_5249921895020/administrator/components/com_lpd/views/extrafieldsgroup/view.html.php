<?php
/**
 * @version		$Id: view.html.php 1034 2011-10-04 17:00:00Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewExtraFieldsGroup extends JView
{

	function display($tpl = null) {
	
		JRequest::setVar('hidemainmenu', 1);
		$model = & $this->getModel();
		$extraFieldsGroup = $model->getExtraFieldsGroup();
		JFilterOutput::objectHTMLSafe( $extraFieldsGroup );
		$this->assignRef('row', $extraFieldsGroup);
		(JRequest::getInt('cid'))? $title = JText::_('LPD_EDIT_EXTRA_FIELD_GROUP') : $title = JText::_('LPD_ADD_EXTRA_FIELD_GROUP');
		JToolBarHelper::title($title, 'lpd.png');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
	
		parent::display($tpl);
	}

}
