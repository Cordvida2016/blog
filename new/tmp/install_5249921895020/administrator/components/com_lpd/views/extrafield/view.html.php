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

class LPDViewExtraField extends JView
{

	function display($tpl = null)
	{
		JRequest::setVar('hidemainmenu', 1);
		$model = & $this->getModel();
		$extraField = $model->getData();
		if(!$extraField->id){
			$extraField->published=1;
		}
		$this->assignRef('row', $extraField);

		$lists = array ();
		$lists['published'] = JHTML::_('select.booleanlist', 'published', 'class="inputbox"', $extraField->published);

		$groups[] = JHTML::_('select.option', 0, JText::_('LPD_CREATE_NEW_GROUP'));

		require_once (JPATH_COMPONENT.DS.'models'.DS.'extrafields.php');
		$extraFieldModel= new LPDModelExtraFields;
		$uniqueGroups= $extraFieldModel->getGroups();
		foreach ($uniqueGroups as $group){
			$groups[] = JHTML::_('select.option', $group->id, $group->name);
		}

		$lists['group'] = JHTML::_('select.genericlist', $groups, 'groups', '', 'value', 'text', $extraField->group);

		$typeOptions[] = JHTML::_('select.option', 0, JText::_('LPD_SELECT_TYPE'));
		$typeOptions[] = JHTML::_('select.option', 'textfield', JText::_('LPD_TEXT_FIELD'));
		$typeOptions[] = JHTML::_('select.option', 'textarea', JText::_('LPD_TEXTAREA'));
		$typeOptions[] = JHTML::_('select.option', 'select', JText::_('LPD_DROPDOWN_SELECTION'));
		$typeOptions[] = JHTML::_('select.option', 'multipleSelect', JText::_('LPD_MULTISELECT_LIST'));
		$typeOptions[] = JHTML::_('select.option', 'radio', JText::_('LPD_RADIO_BUTTONS'));
		$typeOptions[] = JHTML::_('select.option', 'link', JText::_('LPD_LINK'));
		$typeOptions[] = JHTML::_('select.option', 'csv', JText::_('LPD_CSV_DATA'));
		$typeOptions[] = JHTML::_('select.option', 'labels', JText::_('LPD_SEARCHABLE_LABELS'));
		$typeOptions[] = JHTML::_('select.option', 'date', JText::_('LPD_DATE'));
		$lists['type'] = JHTML::_('select.genericlist', $typeOptions, 'type', '', 'value', 'text', $extraField->type);

		$this->assignRef('lists', $lists);
		(JRequest::getInt('cid'))? $title = JText::_('LPD_EDIT_EXTRA_FIELD') : $title = JText::_('LPD_ADD_EXTRA_FIELD');
		JToolBarHelper::title($title, 'lpd.png');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		JHTML::_('behavior.calendar');
	  
		$document = &JFactory::getDocument();
		$document->addScriptDeclaration('
		var LPDLanguage = [
		"'.JText::_('LPD_REMOVE', true).'", 
		"'.JText::_('LPD_OPTIONAL', true).'",
		"'.JText::_('LPD_COMMA_SEPARATED_VALUES', true).'",
		"'.JText::_('LPD_USE_EDITOR', true).'",
		"'.JText::_('LPD_ALL_SETTINGS_ABOVE_ARE_OPTIONAL', true).'",
		"'.JText::_('LPD_ADD_AN_OPTION', true).'",
		"'.JText::_('LPD_LINK_TEXT', true).'",
		"'.JText::_('LPD_URL', true).'",
		"'.JText::_('LPD_OPEN_IN', true).'",
		"'.JText::_('LPD_SAME_WINDOW', true).'",
		"'.JText::_('LPD_NEW_WINDOW', true).'",
		"'.JText::_('LPD_CLASSIC_JAVASCRIPT_POPUP', true).'",
		"'.JText::_('LPD_LIGHTBOX_POPUP', true).'",
		"'.JText::_('LPD_RESET_VALUE', true).'",
		"'.JText::_('LPD_CALENDAR', true).'",
		"'.JText::_('LPD_PLEASE_SELECT_A_FIELD_TYPE_FROM_THE_LIST_ABOVE', true).'",
		];');
	  
		parent::display($tpl);
	}

}
