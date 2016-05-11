<?php
/**
 * @version		$Id: users.php 1351 2011-11-25 17:04:53Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(LPD_JVERSION=='16'){
	jimport('joomla.form.formfield');
	class JFormFieldUsers extends JFormField {

		var	$type = 'users';

		function getInput(){
			return JElementUsers::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}
	}
}

jimport('joomla.html.parameter.element');

class JElementUsers extends JElement
{

	var	$_name = 'users';

	function fetchElement($name, $value, &$node, $control_name){
		JHTML::_('behavior.modal');

		$params = &JComponentHelper::getParams('com_lpd');
		
		$document = &JFactory::getDocument();
		
		if(version_compare(JVERSION,'1.6.0','ge')) {
			JHtml::_('behavior.framework');
		} else {
			JHTML::_('behavior.mootools');
		}

		$backendJQueryHandling = $params->get('backendJQueryHandling','remote');
		if($backendJQueryHandling=='remote'){
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');
			$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
		} else {
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-1.7.1.min.js');
			$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-ui-1.8.16.custom.min.js');
		}
		
		$mainframe = &JFactory::getApplication();

		if(LPD_JVERSION=='16'){
			$fieldName = $name;
			if(!$node->getAttribute('multiple')){
				$fieldName .= '[]';
			}
			$image = JURI::root(true).'/administrator/templates/'.$mainframe->getTemplate().'/images/admin/publish_x.png';
		}
		else {
			$fieldName = $control_name.'['.$name.'][]';
			$image = JURI::root(true).'/administrator/images/publish_x.png';
		}

		$js = "
		var \$LPD = jQuery.noConflict();
		function jSelectUser(id, title, object) {
			var exists = false;
			\$LPD('#usersList input').each(function(){
					if(\$LPD(this).val()==id){
						alert('".JText::_('LPD_THE_SELECTED_USER_IS_ALREADY_IN_THE_LIST', true)."');
						exists = true;
					}
			});
			if(!exists){
				var container = \$LPD('<li/>').appendTo(\$LPD('#usersList'));
				var img = \$LPD('<img/>',{class:'remove', src:'".$image."'}).appendTo(container);
				img.click(function(){\$LPD(this).parent().remove();});
				var span = \$LPD('<span/>',{class:'handle'}).html(title).appendTo(container);
				var input = \$LPD('<input/>',{value:id, type:'hidden', name:'".$fieldName."'}).appendTo(container);
				var div = \$LPD('<div/>',{style:'clear:both;'}).appendTo(container);
				\$LPD('#usersList').sortable('refresh');
				alert('".JText::_('LPD_USER_ADDED_IN_THE_LIST', true)."');
			}
		}

		\$LPD(document).ready(function(){
			\$LPD('#usersList').sortable({
				containment: '#usersList',
				items: 'li',
				handle: 'span.handle'
			});
			\$LPD('body').css('overflow-y', 'scroll');
			\$LPD('#usersList .remove').click(function(){
				\$LPD(this).parent().remove();
			});
		});
		";

		$document->addScriptDeclaration($js);
		$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.modules.css');

		$current = array();
		if(is_string($value) && !empty($value)){
			$current[]=$value;
		}
		if(is_array($value)){
			$current=$value;
		}


		$output = '<ul id="usersList">';
		foreach($current as $id){
			$row=&JFactory::getUser($id);
			$output.='
			<li>
				<img class="remove" src="'.$image.'" alt="'.JText::_('LPD_REMOVE_ENTRY_FROM_LIST').'" />
				<span class="handle">'.$row->name.'</span>
				<input type="hidden" value="'.$row->id.'" name="'.$fieldName.'"/>
				<div style="clear:both;"></div>
			</li>
			';
		}
		$output.='</ul>';
		return $output;
	}
}
