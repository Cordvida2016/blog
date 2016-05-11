/**
 * @version 	$Id: lpd.js 1381 2011-12-05 11:32:38Z lefteris.kavadas $
 * @package 	LPD
 * @author 		JoomlaWorks http://www.joomlaworks.gr
 * @copyright 	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license 	GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

var $LPD = jQuery.noConflict();

$LPD(document).ready(function(){

	// Common functions
	$LPD('#jToggler').click(function(){
		if($LPD(this).attr('checked')){
			$LPD('input[id^=cb]').attr('checked', true);
			$LPD('input[name=boxchecked]').val($LPD('input[id^=cb]:checked').length);
		}
		else {
			$LPD('input[id^=cb]').attr('checked', false);
			$LPD('input[name=boxchecked]').val('0')
		}
	});
	$LPD('#lpdSubmitButton').click(function(){
		this.form.submit();
	});
	$LPD('#lpdResetButton').click(function(event){
		event.preventDefault();
		$LPD('.lpdAdminTableFilters input').val('');
		$LPD('.lpdAdminTableFilters option').removeAttr('selected');
		this.form.submit();
	});
	$LPD('.lpdAdminTableFilters select').change(function(){
		this.form.submit();
	});

	// View specific functions
	if($LPD('#lpdAdminContainer').length > 0) {
		var view = $LPD('#lpdAdminContainer input[name=view]').val();
	}
	else {
		var view = $LPD('#lpdFrontendContainer input[name=view]').val();
	}
	
	switch(view){

		case 'comments':
			var flag = false;
			$LPD('.editComment').click(function(event){
				event.preventDefault();
				if (flag){
					alert(LPDLanguage[0]);
					return;
				}
				flag = true;
				var commentID = $LPD(this).attr('rel');
				var target = $LPD('#lpdComment'+commentID+' .commentText');
				var value = target.text();
				$LPD('#lpdComment'+commentID+' input').val(value);
				target.empty();
				var textarea = $LPD('<textarea/>', {name: 'comment', rows: '5', cols: '40'});
				textarea.html(value).appendTo(target);
				textarea.focus();
				$LPD('#lpdComment'+commentID+' .commentToolbar a').css('display','inline');
				$LPD(this).css('display','none');
			});
			$LPD('.closeComment').click(function(event){
				event.preventDefault();
				flag = false;
				var commentID = $LPD(this).attr('rel');
				var target = $LPD('#lpdComment'+commentID+' .commentText');
				var value = $LPD('#lpdComment'+commentID+' input').val();
				target.html(value);
				$LPD('#lpdComment'+commentID+' .commentToolbar a').css('display','none');
				$LPD('#lpdComment'+commentID+' .commentToolbar a.editComment').css('display','inline');

			});
			$LPD('.saveComment').click(function(event){
				event.preventDefault();
				flag = false;
				var commentID = $LPD(this).attr('rel');
				var target = $LPD('#lpdComment'+commentID+' .commentText');
				var value = $LPD('#lpdComment'+commentID+' .commentText textarea').val();
				$LPD('#task').val('saveComment');
				$LPD('#commentID').val(commentID);
				$LPD('#commentText').val(value);
				var log =  $LPD('#lpdComment'+commentID+' .lpdCommentsLog');
				log.addClass('lpdCommentsLoader');
				$LPD.ajax({
					url: 'index.php',
					type: 'post',
					dataType: 'json',
					data: $LPD('#adminForm').serialize(),
					success: function(result){
						target.html(result.comment);
						$LPD('#lpdComment'+commentID+' input').val(result.comment);
						$LPD('#task').val('');
						log.removeClass('lpdCommentsLoader').html(result.message).delay(3000).fadeOut();
					}
				});
				$LPD('#lpdComment'+commentID+' .commentToolbar a').css('display','none');
				$LPD('#lpdComment'+commentID+' .commentToolbar a.editComment').css('display','inline');
			});
			if($LPD('input[name=isSite]').val()==1){
				$LPD('.lpdCommentsPagination a').click(function(event){
					var url = $LPD(this).attr('href').split('limitstart=');
					event.preventDefault();
					$LPD('input[name=limitstart]').val(url[1]);
					Joomla.submitform();
				});
			}
			break;

		case 'extrafield':
			if ($LPD('#groups').val() > 0) {
				$LPD('#groupContainer').fadeOut(0);
			}
			$LPD('#groups').change(function() {
				var selectedValue = $LPD(this).val();
				if (selectedValue == 0) {
					$LPD('#group').val('');
					$LPD('#isNew').val('1');
					$LPD('#groupContainer').fadeIn('slow');
				} else {
					$LPD('#groupContainer').fadeOut('slow', function() {
						$LPD('#group').val(selectedValue);
						$LPD('#isNew').val('0');
					});
				}
			});
			if($LPD('input[name=id]').val()){
				newField = 0;
			}
			else {
				newField = 1;
			}
			if (!newField) {
				var values = $LPD.parseJSON($LPD('#value').val());
			} else {
				var values = new Array();
				values[0] = " ";
			}
			renderExtraFields($LPD('#type').val(), values, newField);
			$LPD('#type').change(function() {
				var selectedType = $LPD(this).val();
				$LPD('#exFieldsTypesDiv').fadeOut('slow', function() {
					$LPD('#exFieldsTypesDiv').empty();
					renderExtraFields(selectedType, values, newField);
					$LPD('#exFieldsTypesDiv').fadeIn('slow');
				});
			});
			break;

		case 'usergroup':
			var value = $LPD('input[name=categories]:checked').val();
			if(value=='all'){
				$LPD('#paramscategories').attr('disabled', 'disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).attr('disabled', 'disabled');
					$LPD(this).attr('selected', 'selected');
				});
			}
			else if(value=='none'){
				$LPD('#paramscategories').attr('disabled', 'disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).attr('disabled', 'disabled');
					$LPD(this).removeAttr('selected');
				});
			}
			else {
				$LPD('#paramscategories').removeAttr('disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).removeAttr('disabled');
				});
			}
			$LPD('#categories-all').click(function(){
				$LPD('#paramscategories').attr('disabled', 'disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).attr('disabled', 'disabled');
					$LPD(this).attr('selected', 'selected');
				});
			});
			$LPD('#categories-none').click(function(){
				$LPD('#paramscategories').attr('disabled', 'disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).attr('disabled', 'disabled');
					$LPD(this).removeAttr('selected');
				});
			});
			$LPD('#categories-select').click(function(){
				$LPD('#paramscategories').removeAttr('disabled');
				$LPD('#paramscategories option').each(function(){
					$LPD(this).removeAttr('disabled');
				});
			});
			break;

		case 'category':
			$LPD('#lpdAccordion').accordion({
				collapsible: true,
				autoHeight: false
			});
			$LPD('#lpdTabs').tabs();
			$LPD('#lpdImageBrowseServer').click(function(event){
				event.preventDefault();
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					url: LPDBasePath+'index.php?option=com_lpd&view=media&type=image&tmpl=component&fieldID=existingImageValue',
					size: {x: 800, y: 434}
				});
			});
			break;

		case 'item':
			$LPD('#lpdAccordion').accordion({
				collapsible: true,
				autoHeight: false
			});
			$LPD('#lpdTabs').tabs();
			$LPD('#lpdVideoTabs').tabs({selected: LPDActiveVideoTab});
			$LPD('#lpdToggleSidebar').click(function(event){
				event.preventDefault();
				$LPD('#adminFormLPDSidebar').toggle();
			});
			$LPD('#catid option[disabled]').css('color', '#808080');
			setTimeout(function(){ initExtraFieldsEditor(); }, 1000);
			$LPD('.deleteAttachmentButton').click(function(event){
				event.preventDefault();
				if (confirm(LPDLanguage[3])) {
					var element = $LPD(this).parent().parent();
					var url = $LPD(this).attr('href');
					$LPD.ajax({
						url: url,
						type: 'get',
						success: function(){
							$LPD(element).fadeOut('fast', function(){
								$LPD(element).remove();
							});
						}
					});
				}
			});
			$LPD('#resetHitsButton').click(function(event){
				event.preventDefault();
				Joomla.submitbutton('resetHits');
			});
			$LPD('#resetRatingButton').click(function(event){
				event.preventDefault();
				Joomla.submitbutton('resetRating');
			});
			$LPD('#addAttachmentButton').click(function(event){
				event.preventDefault();
				addAttachment();
			});
			$LPD('#newTagButton').click(function(){
				var log = $LPD('#tagsLog');
				log.empty().addClass('tagsLoading');
				var tag = $LPD('#tag').val();
				var url = 'index.php?option=com_lpd&view=item&task=tag&tag='+tag;
				$LPD.ajax({
					url: url,
					type: 'get',
					dataType: 'json',
					success: function(response){
						if (response.status=='success'){
							var option = $LPD('<option/>', {value:response.id}).html(response.name).appendTo($LPD('#tags'));
							}
						log.html(response.msg);
						log.removeClass('tagsLoading');
					}
				});
			});
			$LPD('#addTagButton').click(function(){
				$LPD('#tags option:selected').each(function() {
					$LPD(this).appendTo($LPD('#selectedTags'));
				});
			});
			$LPD('#removeTagButton').click(function(){
				$LPD('#selectedTags option:selected').each(function(el) {
					$LPD(this).appendTo($LPD('#tags'));
				});
			});
			$LPD('#catid').change(function(){
				if($LPD(this).find('option:selected').attr('disabled')){
					alert(LPDLanguage[4]);
					$LPD(this).val('0');
					return;
				}
				var selectedValue = $LPD(this).val();
				var url = LPDBasePath+'index.php?option=com_lpd&view=item&task=extraFields&cid='+selectedValue+'&id='+$LPD('input[name=id]').val();
				$LPD('#extraFieldsContainer').fadeOut('slow', function(){
					$LPD.ajax({
						url: url,
						type: 'get',
						success: function(response){
							$LPD('#extraFieldsContainer').html(response);
							initExtraFieldsEditor();
							$LPD('img.calendar').each(function(){
								inputFieldID = $LPD(this).prev().attr('id');
								imgFieldID = $LPD(this).attr('id');
								Calendar.setup({
									inputField: inputFieldID,
									ifFormat:"%Y-%m-%d",
									button:imgFieldID,
									align:"Tl",
									singleClick:true
									});
								});
							$LPD('#extraFieldsContainer').fadeIn('slow');
						}
					});
					});
			});
			$LPD('#lpdImageBrowseServer').click(function(event){
				event.preventDefault();
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					url: LPDBasePath+'index.php?option=com_lpd&view=media&type=image&tmpl=component&fieldID=existingImageValue',
					size: {x: 800, y: 434}
				});
			});
			$LPD('#lpdMediaBrowseServer').click(function(event){
				event.preventDefault();
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					url: LPDBasePath+'index.php?option=com_lpd&view=media&type=video&tmpl=component&fieldID=remoteVideo',
					size: {x: 800, y: 434}
				});
			});
			$LPD('.lpdAttachmentBrowseServer').live('click', function(event){
				event.preventDefault();
				var lpdActiveAttachmentField = $LPD(this).next();
				lpdActiveAttachmentField.attr('id', 'lpdActiveAttachment');
				SqueezeBox.initialize();
				SqueezeBox.fromElement(this, {
					handler: 'iframe',
					url: LPDBasePath+'index.php?option=com_lpd&view=media&type=attachment&tmpl=component&fieldID=lpdActiveAttachment',
					size: {x: 800, y: 434},
					onClose: function(){
						lpdActiveAttachmentField.removeAttr('id');
					}
				});
			});
			$LPD('.tagRemove').click(function(event){
				event.preventDefault();
				$LPD(this).parent().remove();
			});
			$LPD('ul.tags').click(function(){
				$LPD('#search-field').focus();
			});
			$LPD('#search-field').keypress(function(event) {
				if (event.which == '13') {
					if($LPD(this).val()!=''){
						$LPD('<li class="addedTag">'+$LPD(this).val()+'<span class="tagRemove" onclick="$LPD(this).parent().remove();">x</span><input type="hidden" value="'+$LPD(this).val()+'" name="tags[]"></li>').insertBefore('.tags .tagAdd');
						$LPD(this).val('');
					}
				}
			});
			$LPD('#search-field').autocomplete({
				source : function(request, response) {
				$LPD.ajax({
					type: 'post',
					url: LPDSitePath+'index.php?option=com_lpd&view=item&task=tags',
					data: 'q='+request.term,
					dataType: 'json',
					success: function(data) {
						$LPD('#search-field').removeClass('tagsLoading');
						response( $LPD.map( data, function( item ) {
							return item;
						}));
					}
				});
				},
				minLength: 3,
				select : function(event, ui) {
					$LPD('<li class="addedTag">'+ui.item.label+'<span class="tagRemove" onclick="$LPD(this).parent().remove();">x</span><input type="hidden" value="'+ui.item.value+'" name="tags[]"></li>').insertBefore('.tags .tagAdd');
					this.value = '';
					return false;
				},
				search: function(event, ui){
					$LPD('#search-field').addClass('tagsLoading');
				}
			});
			if($LPD('input[name=isSite]').val()==1){
				parent.$('sbox-overlay').removeEvents('click');
				parent.$('sbox-btn-close').removeEvents('click');
				var elements = [parent.$LPD('#sbox-btn-close'), $LPD('#toolbar-cancel a')];
				$LPD.each(elements, function(index, element){
					element.unbind();
					element.click(function(event){
						event.preventDefault();
						if($LPD('input[name=id]').val()){
							$LPD.ajax({
								type: 'get',
								cache: false,
								url: LPDSitePath+'index.php?option=com_lpd&view=item&task=checkin&cid='+$LPD('input[name=id]').val()+'&lang='+$LPD('input[name=lang]').val(),
								success: function() {
									if(window.opener) {
										window.opener.location.reload();
									}
									else {
										parent.window.location.reload();
									}
									if(typeof(window.parent.SqueezeBox.close=='function')){
										window.parent.SqueezeBox.close();
									}
									else {
										parent.$LPD('#sbox-window').close();
									}
									if(window.opener) {
										window.close();
									}
								}
							});
						}
						else {
							if(typeof(window.parent.SqueezeBox.close=='function')){
								window.parent.SqueezeBox.close();
							}
							else {
								parent.$LPD('#sbox-window').close();
							}
							if(window.opener) {
								window.close();
							}
						}
					});
				});
			}
			break;
	}
});

// If we are in Joomla! 1.5 define the functions for validation
if (typeof(Joomla) === 'undefined') {
	var Joomla = {};
	Joomla.submitbutton = function(pressbutton){
		submitform(pressbutton);
	}
	function submitbutton(pressbutton) {
		Joomla.submitbutton(pressbutton);
	}
}

// Media manager
function elFinderUpdate(fieldID, value) {
	$LPD('#'+fieldID).val(value);
	if(typeof(window.parent.SqueezeBox.close=='function')){
		SqueezeBox.close();
	} else {
		parent.$LPD('#sbox-window').close();
	}
}

// Extra fields
function addOption(){
	var div = $LPD('<div/>').appendTo($LPD('#select_dd_options'));
	var input = $LPD('<input/>',{name:'option_name[]',type:'text'}).appendTo(div);
	var input = $LPD('<input/>',{name:'option_value[]',type:'hidden'}).appendTo(div);
	var input = $LPD('<input/>',{value:LPDLanguage[0], type:'button'}).appendTo(div);
	input.click(function(){$LPD(this).parent().remove();})
}

function renderExtraFields(fieldType,fieldValues,isNewField){
	var target = $LPD('#exFieldsTypesDiv');
	var currentType = $LPD('#type').val();

	switch (fieldType){

	case 'textfield':
		var input = $LPD('<input/>',{name:'option_value[]',type:'text'}).appendTo(target);
		var notice = $LPD('<span/>').html('('+LPDLanguage[1]+')').appendTo(target);
		if (!isNewField && currentType==fieldType) {
			input.val(fieldValues[0].value);
		}
		break;

	case 'labels':
		var input = $LPD('<input/>',{name:'option_value[]',type:'text'}).appendTo(target);
		var notice = $LPD('<span/>').html(LPDLanguage[2]+' ('+LPDLanguage[1]+')').appendTo(target);
		if (!isNewField && currentType==fieldType) {
			input.val(fieldValues[0].value);
		}
		break;

	case 'textarea':
		var textarea = $LPD('<textarea/>', {name:'option_value[]', cols:'40', rows:'10'}).appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var label = $LPD('<label/>').html(LPDLanguage[3]).appendTo(target);
		var input = $LPD('<input/>', {name:'option_editor[]', type:'checkbox', value:'1'}).appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var notice = $LPD('<span/>').html('('+LPDLanguage[4]+')').appendTo(target);
		if (!isNewField && currentType==fieldType) {
			textarea.val(fieldValues[0].value);
			if(fieldValues[0].editor){
				input.attr('checked',true);
			}
			else {
				input.attr('checked',false);
			}
		}
		break;

	case 'select':
	case 'multipleSelect':
	case 'radio':
		var input = $LPD('<input/>',{ value:LPDLanguage[5], type:'button'}).appendTo(target);
		input.click(function(){addOption();});
		var br = $LPD('<br/>').appendTo(target);
		var div = $LPD('<div/>',{id:'select_dd_options'}).appendTo(target);
		if (isNewField || currentType!=fieldType) {
			addOption();
		}
		else {
			$LPD.each(fieldValues, function(index, value){
				var div = $LPD('<div/>').appendTo($LPD('#select_dd_options'));
				var input = $LPD('<input/>',{name:'option_name[]',type:'text',value:value.name}).appendTo(div);
				var input = $LPD('<input/>',{name:'option_value[]',type:'hidden',value:value.value}).appendTo(div);
				var input = $LPD('<input/>',{value:LPDLanguage[0],type:'button'}).appendTo(div);
				input.click(function(){$LPD(this).parent().remove();})
			});
		}
		break;

	case 'link':

		var label = $LPD('<label/>').html(LPDLanguage[6]).appendTo(target);
		var inputName = $LPD('<input/>',{name:'option_name[]',type:'text'}).appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var label = $LPD('<label/>').html(LPDLanguage[7]).appendTo(target);
		var inputValue = $LPD('<input/>',{name:'option_value[]',type:'text'}).appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var label = $LPD('<label/>').html(LPDLanguage[8]).appendTo(target);
		var select = $LPD('<select/>',{name:'option_target[]'}).appendTo(target);
		var option = $LPD('<option/>',{value:'same'}).html(LPDLanguage[9]).appendTo(select);
		var option = $LPD('<option/>',{value:'new'}).html(LPDLanguage[10]).appendTo(select);
		var option = $LPD('<option/>',{value:'popup'}).html(LPDLanguage[11]).appendTo(select);
		var option = $LPD('<option/>',{value:'lightbox'}).html(LPDLanguage[12]).appendTo(select);
		var br = $LPD('<br/>').appendTo(target);
		var br = $LPD('<br/>').appendTo(target);
		var notice = $LPD('<span/>').html('('+LPDLanguage[4]+')').appendTo(target);
		if (!isNewField && currentType==fieldType) {
			inputName.val(fieldValues[0].name);
			inputValue.val(fieldValues[0].value);
			select.children().each(function(){
				if ($LPD(this).val()==fieldValues[0].target){
					$LPD(this).attr('selected','selected');
				}
			});
		}

		break;

	case 'csv':
		var input = $LPD('<input/>',{name:'csv_file',type:'file'}).appendTo(target);
		var inputValue = $LPD('<input/>',{name:'option_value[]',type:'hidden'}).appendTo(target);
		if(!isNewField && currentType==fieldType){
			inputValue.val(JSON.stringify(fieldValues[0].value));
			var table = $LPD('<table/>', {'class':'csvTable'}).appendTo(target);
			fieldValues[0].value.each(function(row, index) {
				var tr = $LPD('<tr/>').appendTo(table);
				row.each(function(cell){
					if(index>0){
						var td = $LPD('<td/>').html(cell).appendTo(tr);
					}
					else {
						var th = $LPD('<th/>').html(cell).appendTo(tr);
					}
				})
			});
			var label = $LPD('<label/>').html(LPDLanguage[13]).appendTo(target);
			var input = $LPD('<input/>',{name:'LPDResetCSV',type:'checkbox'}).appendTo(target);
			var br = $LPD('<br/>',{'class':'clr'}).appendTo(target);
		}
		var notice = $LPD('<span/>').html('('+LPDLanguage[1]+')').appendTo(target);
		break;

	case 'date':
		var id = 'lpdDateField'+$LPD.now();
		var input = $LPD('<input/>',{name:'option_value[]',type:'text', id:id, value:fieldValues[0].value, readonly:'readonly'}).appendTo(target);
		var img = $LPD('<img/>',{id:id+'_img','class':'calendar',src:'templates/system/images/calendar.png', alt:LPDLanguage[14]}).appendTo(target);
		Calendar.setup({
			inputField: id,
			ifFormat:"%Y-%m-%d",
			button:id+'_img',
			align:"Tl",
			singleClick:true
		});
		var notice = $LPD('<span/>').html('('+LPDLanguage[1]+')').appendTo(target);
		break;

	default:
		var title = $LPD('<span/>',{'class':'notice'}).html(LPDLanguage[15]).appendTo(target);
	break;

	}

}

// JSON.stringify for browser that do not support it. Used by the extra fields functions
JSON.stringify = JSON.stringify || function(obj) {
	var t = typeof (obj);
	if (t != "object" || obj === null) {
		if (t == "string") {
			obj = '"' + obj + '"';
		}
		return String(obj);
	} else {
		var n, v, json = [], arr = (obj && obj.constructor == Array);
		for (n in obj) {
			v = obj[n];
			t = typeof (v);
			if (t == "string") {
				v = '"' + v + '"';
			} else if (t == "object" && v !== null) {
				v = JSON.stringify(v);
			}
			json.push((arr ? "" : '"' + n + '":') + String(v));
		}
		return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
	}
};

function initExtraFieldsEditor() {
	$LPD('.lpdExtraFieldEditor').each(function() {
		var id = $LPD(this).attr('id');
		if( typeof tinymce != 'undefined') {
			if(tinyMCE.get(id)) {
				tinymce.EditorManager.remove(tinyMCE.get(id));
			}
			tinyMCE.execCommand('mceAddControl', false, id);
		} else {
			new nicEditor({
				fullPanel : true,
				maxHeight : 180,
				iconsPath : LPDSitePath + 'media/lpd/assets/images/system/nicEditorIcons.gif'
			}).panelInstance($LPD(this).attr('id'));
		}
	});
}

function syncExtraFieldsEditor() {
	$LPD('.lpdExtraFieldEditor').each(function() {
		editor = nicEditors.findEditor($LPD(this).attr('id'));
		if (typeof editor != 'undefined') {
			if(editor.content == '<br>' || editor.content == '<br />'){
				editor.setContent('');
			}
			editor.saveContent();
		}
	});
}

function addAttachment(){
	var div = $LPD('<div/>', {style:'border-top: 1px dotted #ccc; margin: 4px; padding: 10px;'}).appendTo($LPD('#itemAttachments'));
	var input = $LPD('<input/>', {name:'attachment_file[]', type:'file'}).appendTo(div);
	var label = $LPD('<a/>', {href:'index.php?option=com_lpd&view=media&type=attachment&tmpl=component&fieldID=lpdActiveAttachment', 'class':'lpdAttachmentBrowseServer'}).html(LPDLanguage[5]).appendTo(div);
	var input = $LPD('<input/>', {name:'attachment_existing_file[]', type:'text'}).appendTo(div);
	var input = $LPD('<input/>', {value: LPDLanguage[0], type:'button' }).appendTo(div);
	input.click(function(){$LPD(this).parent().remove();});
	var br = $LPD('<br/>').appendTo(div);
	var label = $LPD('<label/>').html(LPDLanguage[1]).appendTo(div);
	var input = $LPD('<input/>', {name:'attachment_title[]', type:'text', 'class':'linkTitle'}).appendTo(div);
	var br = $LPD('<br/>').appendTo(div);
	var label = $LPD('<label/>').html(LPDLanguage[2]).appendTo(div);
	var textarea = $LPD('<textarea/>', {name:'attachment_title_attribute[]', cols:'30', rows:'3'}).appendTo(div);
}

function jSelectUser(id, name){
	$LPD('#lpdAuthor').html(name);
	$LPD('input[name=created_by]').val(id);
	if(typeof(window.parent.SqueezeBox.close=='function')){
		SqueezeBox.close();
	} else {
		parent.$LPD('#sbox-window').close();
	}
}

/*
// Mootools code to be converted to jQuery ???
window.addEvent('domready', function(){
	document.formvalidator.setHandler('passverify', function(value){
		return ($('password').value == value);
	});
});
*/
