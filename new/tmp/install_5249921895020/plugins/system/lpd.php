<?php
/**
 * @version		$Id: lpd.php 1354 2011-11-25 17:10:28Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemLPD extends JPlugin {

	function plgSystemLPD(&$subject, $config) {

		parent::__construct($subject, $config);
	}

	function onAfterRoute() {

		$mainframe = &JFactory::getApplication();
		$basepath = ($mainframe->isSite())?JPATH_SITE:JPATH_ADMINISTRATOR;
		JPlugin::loadLanguage('com_lpd', $basepath);
		if(LPD_JVERSION == '16'){
			JPlugin::loadLanguage('com_lpd.j16', JPATH_ADMINISTRATOR, null, true);
		}
		if ($mainframe->isAdmin()) {
			return;
		}
		if((JRequest::getCmd('task')=='add' || JRequest::getCmd('task')=='edit')  && JRequest::getCmd('option') == 'com_lpd') {
			return;
		}
		JHTML::_('behavior.mootools');
		JHTML::_('behavior.modal');
		$params = &JComponentHelper::getParams('com_lpd');

		$document = &JFactory::getDocument();

		// JS
		$jQueryHandling = $params->get('jQueryHandling','1.7remote');
/*		if($jQueryHandling && strpos($jQueryHandling,'remote')==true){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.str_replace('remote','',$jQueryHandling).'/jquery.min.js');
		} elseif($jQueryHandling && strpos($jQueryHandling,'remote')==false) {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-'.$jQueryHandling.'.min.js');
		}
		$document->addScript(JURI::root(true).'/components/com_lpd/js/lpd.js');
		$document->addScriptDeclaration("var LPDSitePath = '".JURI::root(true)."/';");
*/
		if(JRequest::getCmd('task')=='search' && $params->get('googleSearch')){
			$language = &JFactory::getLanguage();
			$lang = $language->getTag();
			$document->addScript('http://www.google.com/jsapi');
			$js = '
			//<![CDATA[
			google.load("search", "1", {"language" : "'.$lang.'"});

			function OnLoad(){
				var searchControl = new google.search.SearchControl();
				var siteSearch = new google.search.WebSearch();
				siteSearch.setUserDefinedLabel("'.$mainframe->getCfg('sitename').'");
				siteSearch.setUserDefinedClassSuffix("lpd");
				options = new google.search.SearcherOptions();
				options.setExpandMode(google.search.SearchControl.EXPAND_MODE_OPEN);
				siteSearch.setSiteRestriction("'.JURI::root().'");
				searchControl.addSearcher(siteSearch, options);
				searchControl.setResultSetSize(google.search.Search.LARGE_RESULTSET);
				searchControl.setLinkTarget(google.search.Search.LINK_TARGET_SELF);
				searchControl.draw(document.getElementById("'.$params->get('googleSearchContainer', 'lpdContainer').'"));
				searchControl.execute("'.JRequest::getString('searchword').'");
			}

			google.setOnLoadCallback(OnLoad);
			//]]>
 			';
			$document->addScriptDeclaration($js);
		}

		// Add related CSS to the <head>
		if ($document->getType() == 'html' && $params->get('enable_css')) {

			jimport('joomla.filesystem.file');
/*
			// lpd.css
			if(JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.'lpd.css'))
			$document->addStyleSheet(JURI::root(true).'/templates/'.$mainframe->getTemplate().'/css/lpd.css');
			else
			$document->addStyleSheet(JURI::root(true).'/components/com_lpd/css/lpd.css');

			// lpd.print.css
			if(JRequest::getInt('print')==1){
				if(JFile::exists(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'css'.DS.'lpd.print.css'))
				$document->addStyleSheet(JURI::root(true).'/templates/'.$mainframe->getTemplate().'/css/lpd.print.css','text/css','print');
				else
				$document->addStyleSheet(JURI::root(true).'/components/com_lpd/css/lpd.print.css','text/css','print');
			}
*/
		}

	}

	// Extend user forms with LPD fields
	function onAfterDispatch() {

		$mainframe = &JFactory::getApplication();

		if($mainframe->isAdmin()) return;

		$params = &JComponentHelper::getParams('com_lpd');
		if(!$params->get('LPDUserProfile'))
		return;
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd('view');
		$task = JRequest::getCmd('task');
		$layout = JRequest::getCmd('layout');
		$user = &JFactory::getUser();

		if (($option == 'com_user' && $view == 'register') || ($option == 'com_users' && $view == 'registration') ) {
			
/*			if($params->get('recaptchaOnRegistration') && $params->get('recaptcha_public_key')) {
				$document = &JFactory::getDocument();
				$document->addScript('http://api.recaptcha.net/js/recaptcha_ajax.js');
				$js = '
				function showRecaptcha(){
					Recaptcha.create("'.$params->get('recaptcha_public_key').'", "recaptcha", {
						theme: "'.$params->get('recaptcha_theme', 'clean').'"
					});
				}
				$LPD(document).ready(function() {
					showRecaptcha();
				});
				';
				$document->addScriptDeclaration($js);
			}
*/
			if(!$user->guest){
				$mainframe->redirect(JURI::root(),JText::_('LPD_YOU_ARE_ALREADY_REGISTERED_AS_A_MEMBER'),'notice');
				$mainframe->close();
			}
			if(LPD_JVERSION == '16'){
				require_once (JPATH_SITE.DS.'components'.DS.'com_users'.DS.'controller.php');
				$controller = new UsersController;

			}
			else {
				require_once (JPATH_SITE.DS.'components'.DS.'com_user'.DS.'controller.php');
				$controller = new UserController;
			}
			$view = $controller->getView($view, 'html');
			$view->addTemplatePath(JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'templates');
			$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates');
			$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd');
			$view->setLayout('register');

			$LPDUser = new JObject;

			$LPDUser->description = '';
			$LPDUser->gender = 'm';
			$LPDUser->image = '';
			$LPDUser->url = '';
			$LPDUser->plugins = '';

			$wysiwyg = &JFactory::getEditor();
			$editor = $wysiwyg->display('description', $LPDUser->description, '100%', '250px', '', '', false);
			$view->assignRef('editor', $editor);

			$lists = array();
			$genderOptions[] = JHTML::_('select.option', 'm', JText::_('LPD_MALE'));
			$genderOptions[] = JHTML::_('select.option', 'f', JText::_('LPD_FEMALE'));
			$lists['gender'] = JHTML::_('select.radiolist', $genderOptions, 'gender', '', 'value', 'text', $LPDUser->gender);

			$view->assignRef('lists', $lists);
			$view->assignRef('LPDParams', $params);

			JPluginHelper::importPlugin('lpd');
			$dispatcher = &JDispatcher::getInstance();
			$LPDPlugins = $dispatcher->trigger('onRenderAdminForm', array(&$LPDUser, 'user'));
			$view->assignRef('LPDPlugins', $LPDPlugins);

			$view->assignRef('LPDUser', $LPDUser);
			if(LPD_JVERSION == '16'){
				$view->assignRef('user', $user);
			}
			$pathway = &$mainframe->getPathway();
			$pathway->setPathway(NULL);

			ob_start();
			$view->display();
			$contents = ob_get_clean();
			$document = &JFactory::getDocument();
			$document->setBuffer($contents, 'component');

		}

		if (($option == 'com_user' && $view == 'user' && ($task == 'edit' || $layout=='form')) || ($option == 'com_users' && $view=='profile' && $layout=='edit') ) {

			if($user->guest){
				JError::raiseError(403, JText::_('LPD_ALERTNOTAUTH'));
			}

			if(LPD_JVERSION == '16'){
				require_once (JPATH_SITE.DS.'components'.DS.'com_users'.DS.'controller.php');
				$controller = new UsersController;
			}
			else {
				require_once (JPATH_SITE.DS.'components'.DS.'com_user'.DS.'controller.php');
				$controller = new UserController;
			}
			
			/*
			// TO DO - We open the profile editing page in a modal, so let's define some CSS
			$document = &JFactory::getDocument();
			$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.frontend.css');
			$document->addStyleSheet(JURI::root(true).'/templates/system/css/general.css');
			$document->addStyleSheet(JURI::root(true).'/templates/system/css/system.css');
			if(LPD_JVERSION == '16') {
				$document->addStyleSheet(JURI::root(true).'/administrator/templates/bluestork/css/template.css');
				$document->addStyleSheet(JURI::root(true).'/media/system/css/system.css');
			} else {
				$document->addStyleSheet(JURI::root(true).'/administrator/templates/khepri/css/general.css');
			}
			*/

			$view = $controller->getView($view, 'html');
			$view->addTemplatePath(JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'templates');
			$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd'.DS.'templates');
			$view->addTemplatePath(JPATH_SITE.DS.'templates'.DS.$mainframe->getTemplate().DS.'html'.DS.'com_lpd');
			$view->setLayout('profile');

			require_once (JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'models'.DS.'itemlist.php');
			$model = new LPDModelItemlist;
			$LPDUser = $model->getUserProfile($user->id);
			if (!is_object($LPDUser)) {
				$LPDUser = new Jobject;
				$LPDUser->description = '';
				$LPDUser->gender = 'm';
				$LPDUser->url = '';
				$LPDUser->image = NULL;
			}
			$wysiwyg = &JFactory::getEditor();
			$editor = $wysiwyg->display('description', $LPDUser->description, '100%', '250px', '', '', false);
			$view->assignRef('editor', $editor);

			$lists = array();
			$genderOptions[] = JHTML::_('select.option', 'm', JText::_('LPD_MALE'));
			$genderOptions[] = JHTML::_('select.option', 'f', JText::_('LPD_FEMALE'));
			$lists['gender'] = JHTML::_('select.radiolist', $genderOptions, 'gender', '', 'value', 'text', $LPDUser->gender);

			$view->assignRef('lists', $lists);

			JPluginHelper::importPlugin('lpd');
			$dispatcher = &JDispatcher::getInstance();
			$LPDPlugins = $dispatcher->trigger('onRenderAdminForm', array(&$LPDUser, 'user'));
			$view->assignRef('LPDPlugins', $LPDPlugins);

			$view->assignRef('LPDUser', $LPDUser);

			ob_start();
			if(LPD_JVERSION == '16'){
				$view->assignRef('user', $user);
				$view->display();
			}
			else {
				$view->_displayForm();
			}

			$contents = ob_get_clean();
			$document = &JFactory::getDocument();
			$document->setBuffer($contents, 'component');

		}

	}

	function onAfterInitialise() {
		$mainframe = &JFactory::getApplication();

		// Determine Joomla! version
		if(version_compare( JVERSION, '1.6.0', 'ge' )) {
			define('LPD_JVERSION','16');
		}
		else {
			define('LPD_JVERSION','15');
		}

		/*
		 if(JRequest::getCmd('option')=='com_lpd' && JRequest::getCmd('task')=='save' && !$mainframe->isAdmin()){
			$dispatcher = &JDispatcher::getInstance();
			foreach($dispatcher->_observers as $observer){
			if($observer->_name=='jfdatabase' || $observer->_name=='jfrouter' || $observer->_name=='missing_translation'){
			$dispatcher->detach($observer);
			}
			}
			}
			*/

		jimport('joomla.filesystem.file');

		if (!$mainframe->isAdmin()) {
			return;
		}

		$option = JRequest::getCmd('option');
		$task = JRequest::getCmd('task');
		$type = JRequest::getCmd('catid');

		if ($option!='com_joomfish')
		return;

		if (!JFile::exists(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php')) {
			return;
		}

		JPlugin::loadLanguage('com_lpd', JPATH_ADMINISTRATOR);

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');

		// Joom!Fish
		if ($option == 'com_joomfish' && ($task == 'translate.apply' || $task == 'translate.save') && $type == 'lpd_items') {

			$language_id = JRequest::getInt('select_language_id');
			$reference_id = JRequest::getInt('reference_id');
			$objects = array();
			$variables = JRequest::get('post');

			foreach ($variables as $key=>$value) {
				if (( bool )JString::stristr($key, 'LPDExtraField_')) {
					$object = new JObject;
					$object->set('id', JString::substr($key, 13));
					$object->set('value', $value);
					unset($object->_errors);
					$objects[] = $object;
				}
			}

			$json = new Services_JSON;
			$extra_fields = $json->encode($objects);

			$extra_fields_search = '';

			foreach ($objects as $object) {
				$extra_fields_search .= $this->getSearchValue($object->id, $object->value);
				$extra_fields_search .= ' ';
			}

			$user = &JFactory::getUser();

			$db = &JFactory::getDBO();

			$query = "SELECT COUNT(*) FROM #__jf_content WHERE reference_field = 'extra_fields' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_items'";
			$db->setQuery($query);
			$result = $db->loadResult();

			if ($result > 0) {
				$query = "UPDATE #__jf_content SET value=".$db->Quote($extra_fields)." WHERE reference_field = 'extra_fields' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_items'";
				$db->setQuery($query);
				$db->query();
			} else {
				$modified = date("Y-m-d H:i:s");
				$modified_by = $user->id;
				$published = JRequest::getVar('published', 0);
				$query = "INSERT INTO #__jf_content (`id`, `language_id`, `reference_id`, `reference_table`, `reference_field` ,`value`, `original_value`, `original_text`, `modified`, `modified_by`, `published`) VALUES (NULL, {$language_id}, {$reference_id}, 'lpd_items', 'extra_fields', ".$db->Quote($extra_fields).", '','', ".$db->Quote($modified).", {$modified_by}, {$published} )";
				$db->setQuery($query);
				$db->query();
			}

			$query = "SELECT COUNT(*) FROM #__jf_content WHERE reference_field = 'extra_fields_search' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_items'";
			$db->setQuery($query);
			$result = $db->loadResult();

			if ($result > 0) {
				$query = "UPDATE #__jf_content SET value=".$db->Quote($extra_fields_search)." WHERE reference_field = 'extra_fields_search' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_items'";
				$db->setQuery($query);
				$db->query();
			} else {
				$modified = date("Y-m-d H:i:s");
				$modified_by = $user->id;
				$published = JRequest::getVar('published', 0);
				$query = "INSERT INTO #__jf_content (`id`, `language_id`, `reference_id`, `reference_table`, `reference_field` ,`value`, `original_value`, `original_text`, `modified`, `modified_by`, `published`) VALUES (NULL, {$language_id}, {$reference_id}, 'lpd_items', 'extra_fields_search', ".$db->Quote($extra_fields_search).", '','', ".$db->Quote($modified).", {$modified_by}, {$published} )";
				$db->setQuery($query);
				$db->query();
			}

		}

		if ($option == 'com_joomfish' && ($task == 'translate.edit' || $task == 'translate.apply') && $type == 'lpd_items') {

			if ($task == 'translate.edit') {
				$cid = JRequest::getVar('cid');
				$array = explode('|', $cid[0]);
				$reference_id = $array[1];
			}

			if ($task == 'translate.apply') {
				$reference_id = JRequest::getInt('reference_id');
			}

			$item = &JTable::getInstance('LPDItem', 'Table');
			$item->load($reference_id);
			$category_id = $item->catid;
			$language_id = JRequest::getInt('select_language_id');

			$category = &JTable::getInstance('LPDCategory', 'Table');
			$category->load($category_id);
			$group = $category->extraFieldsGroup;
			$db = &JFactory::getDBO();
			$query = "SELECT * FROM #__lpd_extra_fields WHERE `group`=".$db->Quote($group)." AND published=1 ORDER BY ordering";
			$db->setQuery($query);
			$extraFields = $db->loadObjectList();

			$json = new Services_JSON;
			$output = '';
			if (count($extraFields)) {
				$output .= '<h1>'.JText::_('LPD_EXTRA_FIELDS').'</h1>';
				$output .= '<h2>'.JText::_('LPD_ORIGINAL').'</h2>';
				foreach ($extraFields as $extrafield) {
					$extraField = $json->decode($extrafield->value);
					$output .= trim($this->renderOriginal($extrafield, $reference_id));

				}
			}

			if (count($extraFields)) {
				$output .= '<h2>'.JText::_('LPD_TRANSLATION').'</h2>';
				foreach ($extraFields as $extrafield) {
					$extraField = $json->decode($extrafield->value);
					$output .= trim($this->renderTranslated($extrafield, $reference_id));
				}
			}

			$pattern = '/\r\n|\r|\n/';
			$js = "
			window.addEvent('domready', function(){
				var target = $$('table.adminform');
				target.setProperty('id', 'adminform');
				var div = new Element('div', {'id': 'LPDExtraFields'}).setHTML('".preg_replace($pattern, '', $output)."').injectInside($('adminform'));
			});
			";

			JHTML::_('behavior.mootools');
			$document = &JFactory::getDocument();
			$document->addScriptDeclaration($js);
			$document->addCustomTag('
			<style type="text/css" media="all">
				#LPDExtraFields { color:#000; font-size:11px; padding:6px 2px 4px 4px; text-align:left; }
				#LPDExtraFields h1 { font-size:16px; height:25px; }
				#LPDExtraFields h2 { font-size:14px; }
				#LPDExtraFields strong { font-style:italic; }
			</style>
			');
		}

		if ($option == 'com_joomfish' && ($task == 'translate.apply' || $task == 'translate.save') && $type == 'lpd_extra_fields') {

			$language_id = JRequest::getInt('select_language_id');
			$reference_id = JRequest::getInt('reference_id');
			$extraFieldType = JRequest::getVar('extraFieldType');

			$objects = array();
			$values = JRequest::getVar('option_value');
			$names = JRequest::getVar('option_name');
			$target = JRequest::getVar('option_target');

			for ($i = 0; $i < sizeof($values); $i++) {
				$object = new JObject;
				$object->set('name', $names[$i]);

				if ($extraFieldType == 'select' || $extraFieldType == 'multipleSelect' || $extraFieldType == 'radio') {
					$object->set('value', $i + 1);
				} elseif ($extraFieldType == 'link') {
					if (substr($values[$i], 0, 7) == 'http://') {
						$values[$i] = $values[$i];
					} else {
						$values[$i] = 'http://'.$values[$i];
					}
					$object->set('value', $values[$i]);
				} else {
					$object->set('value', $values[$i]);
				}

				$object->set('target', $target[$i]);
				unset($object->_errors);
				$objects[] = $object;
			}

			$json = new Services_JSON;
			$value = $json->encode($objects);

			$user = &JFactory::getUser();

			$db = &JFactory::getDBO();

			$query = "SELECT COUNT(*) FROM #__jf_content WHERE reference_field = 'value' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_extra_fields'";
			$db->setQuery($query);
			$result = $db->loadResult();

			if ($result > 0) {
				$query = "UPDATE #__jf_content SET value=".$db->Quote($value)." WHERE reference_field = 'value' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_extra_fields'";
				$db->setQuery($query);
				$db->query();
			} else {
				$modified = date("Y-m-d H:i:s");
				$modified_by = $user->id;
				$published = JRequest::getVar('published', 0);
				$query = "INSERT INTO #__jf_content (`id`, `language_id`, `reference_id`, `reference_table`, `reference_field` ,`value`, `original_value`, `original_text`, `modified`, `modified_by`, `published`) VALUES (NULL, {$language_id}, {$reference_id}, 'lpd_extra_fields', 'value', ".$db->Quote($value).", '','', ".$db->Quote($modified).", {$modified_by}, {$published} )";
				$db->setQuery($query);
				$db->query();
			}

		}

		if ($option == 'com_joomfish' && ($task == 'translate.edit' || $task == 'translate.apply') && $type == 'lpd_extra_fields') {

			if ($task == 'translate.edit') {
				$cid = JRequest::getVar('cid');
				$array = explode('|', $cid[0]);
				$reference_id = $array[1];
			}

			if ($task == 'translate.apply') {
				$reference_id = JRequest::getInt('reference_id');
			}

			$extraField = &JTable::getInstance('LPDExtraField', 'Table');
			$extraField->load($reference_id);
			$language_id = JRequest::getInt('select_language_id');

			if ($extraField->type == 'multipleSelect' || $extraField->type == 'select' || $extraField->type == 'radio') {
				$subheader = '<strong>'.JText::_('LPD_OPTIONS').'</strong>';
			} else {
				$subheader = '<strong>'.JText::_('LPD_DEFAULT_VALUE').'</strong>';
			}

			$json = new Services_JSON;
			$objects = $json->decode($extraField->value);
			$output = '<input type="hidden" value="'.$extraField->type.'" name="extraFieldType" />';
			if (count($objects)) {
				$output .= '<h1>'.JText::_('LPD_EXTRA_FIELDS').'</h1>';
				$output .= '<h2>'.JText::_('LPD_ORIGINAL').'</h2>';
				$output .= $subheader.'<br />';

				foreach ($objects as $object) {
					$output .= '<p>'.$object->name.'</p>';
					if ($extraField->type == 'textfield' || $extraField->type == 'textarea')
					$output .= '<p>'.$object->value.'</p>';
				}
			}

			$db = &JFactory::getDBO();
			$query = "SELECT `value` FROM #__jf_content WHERE reference_field = 'value' AND language_id = {$language_id} AND reference_id = {$reference_id} AND reference_table='lpd_extra_fields'";
			$db->setQuery($query);
			$result = $db->loadResult();

			$translatedObjects = $json->decode($result);

			if (count($objects)) {
				$output .= '<h2>'.JText::_('LPD_TRANSLATION').'</h2>';
				$output .= $subheader.'<br />';
				foreach ($objects as $key=>$value) {
					if (isset($translatedObjects[$key]))
					$value = $translatedObjects[$key];

					if ($extraField->type == 'textarea')
					$output .= '<p><textarea name="option_name[]" cols="30" rows="15"> '.$value->name.'</textarea></p>';
					else
					$output .= '<p><input type="text" name="option_name[]" value="'.$value->name.'" /></p>';
					$output .= '<p><input type="hidden" name="option_value[]" value="'.$value->value.'" /></p>';
					$output .= '<p><input type="hidden" name="option_target[]" value="'.$value->target.'" /></p>';
				}
			}

			$pattern = '/\r\n|\r|\n/';
			$js = "
			window.addEvent('domready', function(){
				var target = $$('table.adminform');
				target.setProperty('id', 'adminform');
				var div = new Element('div', {'id': 'LPDExtraFields'}).setHTML('".preg_replace($pattern, '', $output)."').injectInside($('adminform'));
			});
			";

			JHTML::_('behavior.mootools');
			$document = &JFactory::getDocument();
			$document->addScriptDeclaration($js);
		}
		return;
	}

	function getSearchValue($id, $currentValue) {

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');
		$row = &JTable::getInstance('LPDExtraField', 'Table');
		$row->load($id);

		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');
		$json = new Services_JSON;
		$jsonObject = $json->decode($row->value);

		$value = '';
		if ($row->type == 'textfield' || $row->type == 'textarea') {
			$value = $currentValue;
		} else if ($row->type == 'multipleSelect' || $row->type == 'link') {
			foreach ($jsonObject as $option) {
				if (@in_array($option->value, $currentValue))
				$value .= $option->name.' ';
			}
		} else {
			foreach ($jsonObject as $option) {
				if ($option->value == $currentValue)
				$value .= $option->name;
			}
		}
		return $value;

	}

	function renderOriginal($extraField, $itemID) {

		$mainframe = &JFactory::getApplication();
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');
		$json = new Services_JSON;
		$item = &JTable::getInstance('LPDItem', 'Table');
		$item->load($itemID);

		$defaultValues = $json->decode($extraField->value);

		foreach ($defaultValues as $value) {
			if ($extraField->type == 'textfield' || $extraField->type == 'textarea')
			$active = $value->value;
			else if ($extraField->type == 'link') {
				$active[0] = $value->name;
				$active[1] = $value->value;
				$active[2] = $value->target;
			} else
			$active = '';
		}

		if (isset($item)) {
			$currentValues = $json->decode($item->extra_fields);
			if (count($currentValues)) {
				foreach ($currentValues as $value) {
					if ($value->id == $extraField->id) {
						$active = $value->value;
					}

				}
			}

		}

		$output = '';

		switch ($extraField->type) {

			case 'textfield':
				$output = '<div><strong>'.$extraField->name.'</strong><br /><input type="text" disabled="disabled" name="OriginalLPDExtraField_'.$extraField->id.'" value="'.$active.'"/></div><br /><br />';
				break;

			case 'textarea':
				$output = '<div><strong>'.$extraField->name.'</strong><br /><textarea disabled="disabled" name="OriginalLPDExtraField_'.$extraField->id.'" rows="10" cols="40">'.$active.'</textarea></div><br /><br />';
				break;

			case 'link':
				$output = '<div><strong>'.$extraField->name.'</strong><br />';
				$output .= '&nbsp;<input disabled="disabled"	type="text" name="OriginalLPDExtraField_'.$extraField->id.'[]" value="'.$active[0].'"/><br />';
				$output .= '<br /><br /></div>';
				break;

		}

		return $output;

	}

	function renderTranslated($extraField, $itemID) {

		$mainframe = &JFactory::getApplication();
		require_once (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'lib'.DS.'JSON.php');
		$json = new Services_JSON;

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');
		$item = &JTable::getInstance('LPDItem', 'Table');
		$item->load($itemID);

		$defaultValues = $json->decode($extraField->value);

		foreach ($defaultValues as $value) {
			if ($extraField->type == 'textfield' || $extraField->type == 'textarea')
			$active = $value->value;
			else if ($extraField->type == 'link') {
				$active[0] = $value->name;
				$active[1] = $value->value;
				$active[2] = $value->target;
			} else
			$active = '';
		}

		if (isset($item)) {
			$currentValues = $json->decode($item->extra_fields);
			if (count($currentValues)) {
				foreach ($currentValues as $value) {
					if ($value->id == $extraField->id) {
						$active = $value->value;
					}

				}
			}

		}

		$language_id = JRequest::getInt('select_language_id');
		$db = &JFactory::getDBO();
		$query = "SELECT `value` FROM #__jf_content WHERE reference_field = 'extra_fields' AND language_id = {$language_id} AND reference_id = {$itemID} AND reference_table='lpd_items'";
		$db->setQuery($query);
		$result = $db->loadResult();
		$currentValues = $json->decode($result);
		if (count($currentValues)) {
			foreach ($currentValues as $value) {
				if ($value->id == $extraField->id) {
					$active = $value->value;
				}

			}
		}

		$output = '';

		switch ($extraField->type) {

			case 'textfield':
				$output = '<div><strong>'.$extraField->name.'</strong><br /><input type="text" name="LPDExtraField_'.$extraField->id.'" value="'.$active.'"/></div><br /><br />';
				break;

			case 'textarea':
				$output = '<div><strong>'.$extraField->name.'</strong><br /><textarea name="LPDExtraField_'.$extraField->id.'" rows="10" cols="40">'.$active.'</textarea></div><br /><br />';
				break;

			case 'select':
				$output = '<div style="display:none">'.JHTML::_('select.genericlist', $defaultValues, 'LPDExtraField_'.$extraField->id, '', 'value', 'name', $active).'</div>';
				break;

			case 'multipleSelect':
				$output = '<div style="display:none">'.JHTML::_('select.genericlist', $defaultValues, 'LPDExtraField_'.$extraField->id.'[]', 'multiple="multiple"', 'value', 'name', $active).'</div>';
				break;

			case 'radio':
				$output = '<div style="display:none">'.JHTML::_('select.radiolist', $defaultValues, 'LPDExtraField_'.$extraField->id, '', 'value', 'name', $active).'</div>';
				break;

			case 'link':
				$output = '<div><strong>'.$extraField->name.'</strong><br />';
				$output .= '<input type="text" name="LPDExtraField_'.$extraField->id.'[]" value="'.$active[0].'"/><br />';
				$output .= '<input type="hidden" name="LPDExtraField_'.$extraField->id.'[]" value="'.$active[1].'"/><br />';
				$output .= '<input type="hidden" name="LPDExtraField_'.$extraField->id.'[]" value="'.$active[2].'"/><br />';
				$output .= '<br /><br /></div>';
				break;
		}

		return $output;

	}
	
	function onAfterRender()
	{
		$mainframe = &JFactory::getApplication();
		
		$jdoc_name = ''.$this->params->get('jdoc_name', '');
		$jdoc_class = ''.$this->params->get('jdoc_class', '');
		
		if($mainframe->isAdmin() || strpos($_SERVER["PHP_SELF"], "index.php") === false)
		{
			return;
		}

		if(JRequest::getCmd('option')=="com_lpd"){
			$buffer = JResponse::getBody();
			$pos1=stripos($buffer, "<body");
			$pos2=stripos($buffer, "</body>");
			$doc =& JFactory::getDocument();
			$doc_buffer = $doc->getBuffer( 'component', $jdoc_name, array( 'class' => $jdoc_class ) );
			$body_tf='<body>'.$doc_buffer;
			$buffer_1=substr($buffer, 0, $pos1);
			$buffer_2=substr($buffer, $pos2, strlen($buffer)-$pos2);
			$buffer = $buffer_1.$body_tf.$buffer_2;			
			JResponse::setBody($buffer);			
			}
		
		return true;
	}

}
