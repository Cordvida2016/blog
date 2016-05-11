<?php
/**
 * @version		$Id: item.php 1354 2011-11-25 17:10:28Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class LPDControllerItem extends JController
{

	function display() {

		$model=&$this->getModel('itemlist');
		$document =& JFactory::getDocument();
		$viewType = $document->getType();
		$view = &$this->getView('item', $viewType);
		$view->setModel($model);
		JRequest::setVar('view', 'item');
		$user = &JFactory::getUser();
		if ($user->guest){
		    $cache = true;
		}
		else {
		    $cache = true;
		    JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		    $row = & JTable::getInstance('LPDItem', 'Table');
            $row->load(JRequest::getInt('id'));
		    if (LPDHelperPermissions::canEditItem($row->created_by,$row->catid)){
		        $cache = false;
		    }
		    $params = &LPDHelperUtilities::getParams('com_lpd');
		    if($row->created_by==$user->id && $params->get('inlineCommentsModeration')){
		        $cache = false;
		    }
		    if($row->access > 0){
		        $cache = false;
		    }
		    $category = & JTable::getInstance('LPDCategory', 'Table');
		    $category->load($row->catid);
		    if ($category->access > 0) {
		        $cache = false;
		    }
			if($params->get('comments') && $document->getType() == 'html') {
				$document->addScriptDeclaration("
					\$LPD(document).ready(function() {
						\$LPD('#userName').val('".$view->escape($user->name)."').attr('disabled', 'disabled');
						\$LPD('#commentEmail').val('".$user->email."').attr('disabled', 'disabled');
					});
				");
			}
		}

		parent::display($cache);
	}

	function edit() {
		JRequest::setVar('tmpl', 'component');
		$mainframe = &JFactory::getApplication();
		$params = &LPDHelperUtilities::getParams('com_lpd');
		$language = &JFactory::getLanguage();
		$language->load('com_lpd', JPATH_ADMINISTRATOR);

		$document = &JFactory::getDocument();

		if(version_compare(JVERSION,'1.6.0','ge')) {
			JHtml::_('behavior.framework');
		} else {
			JHTML::_('behavior.mootools');
		}
		
		// CSS
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.css');
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.frontend.css');
		$document->addStyleSheet(JURI::root(true).'/templates/system/css/general.css');
		$document->addStyleSheet(JURI::root(true).'/templates/system/css/system.css');
		
		// JS
		$jQueryHandling = $params->get('jQueryHandling','1.7remote');
		if($jQueryHandling && strpos($jQueryHandling,'remote')==true){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.str_replace('remote','',$jQueryHandling).'/jquery.min.js');
		} elseif($jQueryHandling && strpos($jQueryHandling,'remote')==false) {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-'.$jQueryHandling.'.min.js');
		}
		$backendJQueryHandling = $params->get('backendJQueryHandling','remote');
		if($backendJQueryHandling=='remote'){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
		} else {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-ui-1.8.16.custom.min.js');
		}
		$document->addScript(JURI::root(true).'/media/lpd/assets/js/lpd.js?v=252');

		$this->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views');
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');
		$view = & $this->getView('item', 'html');
		$view->setLayout('itemform');

		if($params->get('category')) {
			JRequest::setVar('catid', $params->get('category'));
		}

		// Look for template files in component folders
		$view->addTemplatePath(JPATH_COMPONENT.DS.'templates');
		$view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.'default');

		// Look for overrides in template folder (LPD template structure)
		$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates');
		$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates'.DS.'default');

		// Look for overrides in template folder (Joomla! template structure)
		$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'default');
		$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd');

		// Look for specific LPD theme files
		if ($params->get('theme')) {
				$view->addTemplatePath(JPATH_COMPONENT.DS.'templates'.DS.$params->get('theme'));
				$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates'.DS.$params->get('theme'));
				$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.$params->get('theme'));
		}
		$view->display();
	}

	function add() {
		$this->edit();
	}

	function cancel() {
		$this->setRedirect(JURI::root(true));
		return false;
	}

	function save() {
		$mainframe = &JFactory::getApplication();
		JRequest::checkToken() or jexit('Invalid Token');
		JRequest::setVar('tmpl', 'component');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'item.php');
		$model= new LPDModelItem;
		$model->save(true);
		$mainframe->close();

	}

	function deleteAttachment() {

		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'item.php');
		$model= new LPDModelItem;
		$model->deleteAttachment();
	}

	function tag() {

		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'tag.php');
		$model= new LPDModelTag;
		$model->addTag();
	}

	function tags() {

		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'tag.php');
		$model= new LPDModelTag;
		$model->tags();
	}

	function download(){

		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'item.php');
		$model= new LPDModelItem;
		$model->download();
	}

	function extraFields(){

		$mainframe = &JFactory::getApplication();
		$language = &JFactory::getLanguage();
		$language->load('com_lpd', JPATH_ADMINISTRATOR);
		$itemID=JRequest::getInt('id',NULL);

		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$catid = JRequest::getInt('cid');
		$category = & JTable::getInstance('LPDCategory', 'Table');
		$category->load($catid);

		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'extrafield.php');
		$extraFieldModel= new LPDModelExtraField;

		$extraFields = $extraFieldModel->getExtraFieldsByGroup($category->extraFieldsGroup);

		$output='<table class="admintable" id="extraFields">';
		$counter=0;
		if (count($extraFields)){
			foreach ($extraFields as $extraField){
				$output.='<tr><td align="right" class="key">'.$extraField->name.'</td>';
				$output.='<td>'.$extraFieldModel->renderExtraField($extraField,$itemID).'</td></tr>';
				$counter++;
			}
		}
		$output.='</table>';

		if ($counter==0) $output=JText::_('LPD_THIS_CATEGORY_DOESNT_HAVE_ASSIGNED_EXTRA_FIELDS');

		echo $output;
		$mainframe->close();
	}

	function checkin(){

		$model = & $this->getModel('item');
		$model->checkin();
	}

	function vote()	{

		$model = & $this->getModel('item');
		$model->vote();
	}

	function getVotesNum()	{

		$model = & $this->getModel('item');
		$model->getVotesNum();
	}

	function getVotesPercentage()	{

		$model = & $this->getModel('item');
		$model->getVotesPercentage();
	}

	function comment(){

		$model = & $this->getModel('item');
		$model->comment();
	}

	function resetHits(){
		JRequest::checkToken() or jexit('Invalid Token');
		JRequest::setVar('tmpl', 'component');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'item.php');
		$model= new LPDModelItem;
		$model->resetHits();

	}

	function resetRating(){
		JRequest::checkToken() or jexit('Invalid Token');
		JRequest::setVar('tmpl', 'component');
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'item.php');
		$model= new LPDModelItem;
		$model->resetRating();

	}

	function media(){
		JRequest::setVar('tmpl', 'component');
		$params = &LPDHelperUtilities::getParams('com_lpd');
		$document = &JFactory::getDocument();
		$language = &JFactory::getLanguage();
		$language->load('com_lpd', JPATH_ADMINISTRATOR);
		$user = &JFactory::getUser();
		if($user->guest){
            JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
		}
		
		// CSS
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.css');
		
		// JS
		$jQueryHandling = $params->get('jQueryHandling','1.7remote');
		if($jQueryHandling && strpos($jQueryHandling,'remote')==true){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.str_replace('remote','',$jQueryHandling).'/jquery.min.js');
		} elseif($jQueryHandling && strpos($jQueryHandling,'remote')==false) {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-'.$jQueryHandling.'.min.js');
		}
		$backendJQueryHandling = $params->get('backendJQueryHandling','remote');
		if($backendJQueryHandling=='remote'){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
		} else {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-ui-1.8.16.custom.min.js');
		}
		$document->addScript(JURI::root(true).'/media/lpd/assets/js/lpd.js');
		$this->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views');
		$view = &$this->getView('media', 'html');
		$view->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'media'.DS.'tmpl');
		$view->setLayout('default');
		$view->display();

	}
	
	function connector(){
		JRequest::setVar('tmpl', 'component');
		$user = &JFactory::getUser();
		if($user->guest){
            JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
		}
		
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'controllers'.DS.'media.php');
		$controller = new LPDControllerMedia();
		$controller->connector();
		
	}
	
    function users () {
    	
    	$itemID = JRequest::getInt('itemID');
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$item = &JTable::getInstance('LPDItem', 'Table');
		$item->load($itemID);
    	if (!LPDHelperPermissions::canAddItem() && !LPDHelperPermissions::canEditItem($item->created_by, $item->catid)) {
    		JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
    	}
    	$LPDPermissions = &LPDPermissions::getInstance();
        if (!$LPDPermissions->permissions->get('editAll')) {
    		JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
    	}
    	JRequest::setVar('tmpl', 'component');
		$mainframe = &JFactory::getApplication();
		$params = &JComponentHelper::getParams('com_lpd');
		$language = &JFactory::getLanguage();
		$language->load('com_lpd', JPATH_ADMINISTRATOR);

		$document = &JFactory::getDocument();

		if(version_compare(JVERSION,'1.6.0','ge')) {
			JHtml::_('behavior.framework');
		} else {
			JHTML::_('behavior.mootools');
		}
		
		// CSS
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.css');
		
		// JS
		$jQueryHandling = $params->get('jQueryHandling','1.7remote');
		if($jQueryHandling && strpos($jQueryHandling,'remote')==true){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.str_replace('remote','',$jQueryHandling).'/jquery.min.js');
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
		} elseif($jQueryHandling && strpos($jQueryHandling,'remote')==false) {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-'.$jQueryHandling.'.min.js');
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-ui-1.8.16.custom.min.js');
		}
		$document->addScript(JURI::root(true).'/media/lpd/assets/js/lpd.js');

		$this->addViewPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views');
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');
		$view = & $this->getView('users', 'html');
		$view->addTemplatePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'users'.DS.'tmpl');
		$view->setLayout('element');
    	$view->display();
    	
    }

}
