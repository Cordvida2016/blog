<?php
/**
 * @version		$Id: view.html.php 1129 2011-10-11 16:53:02Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewUserGroup extends JView
{

	function display($tpl = null) {

		JHTML::_( 'behavior.tooltip' );
		JRequest::setVar('hidemainmenu', 1);
		$model = & $this->getModel();
		$userGroup = $model->getData();
		if(LPD_JVERSION=='15'){
		    JFilterOutput::objectHTMLSafe( $userGroup );
		}
		else {
		    JFilterOutput::objectHTMLSafe( $userGroup, ENT_QUOTES, 'permissions' );
		}
		$this->assignRef('row', $userGroup);

		if(LPD_JVERSION=='15'){
    		$form = new JParameter('', JPATH_COMPONENT.DS.'models'.DS.'usergroup.xml');
    		$form->loadINI($userGroup->permissions);
    		$appliedCategories = $form->get('categories');
    		$inheritance = $form->get('inheritance');
		}
		else {
			jimport('joomla.form.form');
			$form = JForm::getInstance('permissions', JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'usergroup.xml');
			$values = array('params'=>json_decode($userGroup->permissions));
			$form->bind($values);
			$inheritance = isset($values['params']->inheritance)? $values['params']->inheritance:0 ;
			$appliedCategories = isset($values['params']->categories)? $values['params']->categories: '';
		}
		$this->assignRef('form', $form);
		$this->assignRef('categories', $appliedCategories);

		$lists = array ();
		require_once(JPATH_COMPONENT.DS.'models'.DS.'categories.php');
		$categoriesModel= new LPDModelCategories;
		$categories = $categoriesModel->categoriesTree(NULL, true);
		$categories_options=@array_merge($categories_option, $categories);
		$lists['categories'] = JHTML::_('select.genericlist', $categories, 'params[categories][]', 'multiple="multiple" size="15"', 'value', 'text',$appliedCategories);
		$lists['inheritance'] = JHTML::_('select.booleanlist', 'params[inheritance]', NULL, $inheritance);
		$this->assignRef('lists',$lists);
		(JRequest::getInt('cid'))? $title = JText::_('LPD_EDIT_USER_GROUP') : $title = JText::_('LPD_ADD_USER_GROUP');
		JToolBarHelper::title($title, 'lpd.png');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();

		parent::display($tpl);
	}

}
