<?php
/**
 * @version		$Id: view.html.php 1329 2011-11-25 09:55:32Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class LPDViewUser extends JView
{

	function display($tpl = null) {
	
		JRequest::setVar('hidemainmenu', 1);
		$model = & $this->getModel();
		$user = $model->getData();
		if(LPD_JVERSION=='15'){
		    JFilterOutput::objectHTMLSafe( $user );
		}
		else {
		    JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, array('params', 'plugins') );
		}
		$joomlaUser = & JUser::getInstance(JRequest::getInt('cid'));
	
		$user->name = $joomlaUser->name;
		$user->userID = $joomlaUser->id;
		$this->assignRef('row', $user);
	
		$wysiwyg = & JFactory::getEditor();
		$editor = $wysiwyg->display('description', $user->description, '480px', '250px', '', '', false);
		$this->assignRef('editor', $editor);
	
		$lists = array ();
		$genderOptions[] = JHTML::_('select.option', 'm', JText::_('LPD_MALE'));
		$genderOptions[] = JHTML::_('select.option', 'f', JText::_('LPD_FEMALE'));
		$lists['gender'] = JHTML::_('select.radiolist', $genderOptions, 'gender','','value','text',$user->gender);
		
		$userGroupOptions=$model->getUserGroups();
		$lists['userGroup']=JHTML::_('select.genericlist', $userGroupOptions, 'group', 'class="inputbox"', 'id', 'name', $user->group);
		
		$this->assignRef('lists', $lists);
	
		$params = & JComponentHelper::getParams('com_lpd');
		$this->assignRef('params', $params);
		
		JPluginHelper::importPlugin ( 'lpd' );
		$dispatcher = &JDispatcher::getInstance ();
		$LPDPlugins=$dispatcher->trigger('onRenderAdminForm', array (&$user, 'user' ) );
		$this->assignRef('LPDPlugins', $LPDPlugins);
	
		JToolBarHelper::title(JText::_('LPD_USER'), 'lpd.png');
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();
		$toolbar=JToolBar::getInstance('toolbar');
		if(LPD_JVERSION == '16'){
			$link = JURI::base().'index.php?option=com_users&view=user&task=user.edit&id='.$user->userID;
		}
		else {
			$link = JURI::base().'index.php?option=com_users&view=user&task=edit&cid[]='.$user->userID;
		}
		$toolbar->prependButton('Link', 'edit', 'LPD_EDIT_JOOMLA_USER', $link);
	
		parent::display($tpl);
	}

}
