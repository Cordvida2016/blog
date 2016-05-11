<?php
/**
 * @version		$Id: categorieslatest.php 1351 2011-11-25 17:04:53Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if(LPD_JVERSION=='16'){
	jimport('joomla.form.formfield');
	class JFormFieldCategoriesLatest extends JFormField {

		var	$type = 'categorieslatest';

		function getInput(){
			return JElementCategoriesLatest::fetchElement($this->name, $this->value, $this->element, $this->options['control']);
		}
	}
}

jimport('joomla.html.parameter.element');

class JElementCategoriesLatest extends JElement
{

	var	$_name = 'categorieslatest';

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
		function jSelectCategory(id, title, object) {
			var exists = false;
			\$LPD('#categoriesList input').each(function(){
					if(\$LPD(this).val()==id){
						alert('".JText::_('LPD_THE_SELECTED_CATEGORY_IS_ALREADY_IN_THE_LIST', true)."');
						exists = true;
					}
			});
			if(!exists){
				var container = \$LPD('<li/>').appendTo(\$LPD('#categoriesList'));
				var img = \$LPD('<img/>',{class:'remove', src:'".$image."'}).appendTo(container);
				img.click(function(){\$LPD(this).parent().remove();});
				var span = \$LPD('<span/>',{class:'handle'}).html(title).appendTo(container);
				var input = \$LPD('<input/>',{value:id, type:'hidden', name:'".$fieldName."'}).appendTo(container);
				var div = \$LPD('<div/>',{style:'clear:both;'}).appendTo(container);
				\$LPD('#categoriesList').sortable('refresh');
				alert('".JText::_('LPD_CATEGORY_ADDED_IN_THE_LIST', true)."');
			}
		}

		\$LPD(document).ready(function(){
			\$LPD('#categoriesList').sortable({
				containment: '#categoriesList',
				items: 'li',
				handle: 'span.handle'
			});
			\$LPD('body').css('overflow-y', 'scroll');
			\$LPD('#categoriesList .remove').click(function(){
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

		$output = '
		<div class="button2-left">
			<div class="blank">
				<a class="modal" title="' .JText::_ ( 'LPD_CLICK_TO_SELECT_ONE_OR_MORE_CATEGORIES' ). '"  href="index.php?option=com_lpd&view=categories&task=element&tmpl=component" rel="{handler: \'iframe\', size: {x: 700, y: 450}}">'.JText::_('LPD_CLICK_TO_SELECT_ONE_OR_MORE_CATEGORIES').'</a>
			</div>
		</div>
		<div style="clear:both;"></div>
		';

		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lpd'.DS.'tables');

		$output.= '<ul id="categoriesList">';
		foreach($current as $id){
			$row = & JTable::getInstance('LPDCategory', 'Table');
			$row->load($id);
			$output .= '
			<li>
				<img class="remove" src="'.$image.'"/>
				<span class="handle">'.$row->name.'</span>
				<input type="hidden" value="'.$row->id.'" name="'.$fieldName.'"/>
				<span style="clear:both;"></span>
			</li>
			';
		}
		$output.='</ul>';
		return $output;
	}
}
