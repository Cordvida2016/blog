<?php
/**
 * @version		$Id: default.php 2012-01-01 00:00:00 audox $
 * @package		LPD (based on K2)
 * @author		Audox Ingeniería Ltda. http://www.audox.cl
 * @copyright	Copyright (c) 2012 Audox Ingeniería Ltda. All rights reserved. Some parts of the code taken of K2 by JoomlaWorks.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$document = & JFactory::getDocument();
$document->addScriptDeclaration("
	Joomla.submitbutton = function(pressbutton){
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (\$LPD.trim(\$LPD('#name').val()) == '') {
			alert( '".JText::_('LPD_ITEM_MUST_HAVE_A_NAME', true)."' );
		}
		else if (\$LPD.trim(\$LPD('#title').val()) == '') {
			alert( '".JText::_('LPD_ITEM_MUST_HAVE_A_TITLE', true)."' );
		}
		else if (\$LPD.trim(\$LPD('#catid').val()) == '0') {
			alert( '".JText::_('LPD_PLEASE_SELECT_A_CATEGORY', true)."' );
		}
		else {
			syncExtraFieldsEditor();
			\$LPD('#selectedTags option').attr('selected', 'selected');
			submitform( pressbutton );
		}
	}
");

?>

<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<?php if($this->mainframe->isSite()): ?>
	<div id="lpdFrontendContainer">
		<div id="lpdFrontend">
			<table class="lpdFrontendToolbar" cellpadding="2" cellspacing="4">
				<tr>
					<td id="toolbar-save" class="button">
						<a class="toolbar" href="#" onclick="javascript: submitbutton('save'); return false;"> <span title="<?php echo JText::_('LPD_SAVE'); ?>" class="icon-32-save"></span> <?php echo JText::_('LPD_SAVE'); ?> </a>
					</td>
					<td id="toolbar-cancel" class="button">
						<a class="toolbar" href="#"> <span title="<?php echo JText::_('LPD_CANCEL'); ?>" class="icon-32-cancel"></span> <?php echo JText::_('LPD_CLOSE'); ?> </a>
					</td>
				</tr>
			</table>
			<div id="lpdFrontendEditToolbar">
				<h2 class="header icon-48-lpd">
					<?php echo (JRequest::getInt('cid')) ? JText::_('LPD_EDIT_ITEM') : JText::_('LPD_ADD_ITEM'); ?>
				</h2>
			</div>
			<div class="clr"></div>
			<hr class="sep" />
			<?php if(!$this->permissions->get('publish')): ?>
			<div id="lpdFrontendPermissionsNotice">
				<p><?php echo JText::_('LPD_FRONTEND_PERMISSIONS_NOTICE'); ?></p>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div id="lpdToggleSidebarContainer"> <a href="#" id="lpdToggleSidebar"><?php echo JText::_('LPD_TOGGLE_SIDEBAR'); ?></a> </div>
			<table cellspacing="0" cellpadding="0" border="0" class="adminFormLPDContainer">
				<tbody>
					<tr>
						<td>
							<table class="adminFormLPD">
								<tr>
									<td class="adminLPDLeftCol">
										<label for="name"><?php echo JText::_('LPD_NAME'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<input class="text_area lpdTitleAliasBox" type="text" name="name" id="name" maxlength="250" value="<?php echo $this->row->name; ?>" />
									</td>
								</tr><tr>
									<td class="adminLPDLeftCol">
										<label for="title"><?php echo JText::_('LPD_TITLE'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<input class="text_area lpdTitleAliasBox" type="text" name="title" id="title" maxlength="250" value="<?php echo $this->row->title; ?>" />
									</td>
								</tr>
								<tr>
									<td class="adminLPDLeftCol">
										<label for="alias"><?php echo JText::_('LPD_TITLE_ALIAS'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<input class="text_area lpdTitleAliasBox" type="text" name="alias" id="alias" maxlength="250" value="<?php echo $this->row->alias; ?>" />
									</td>
								</tr>
								<tr>
									<td class="adminLPDLeftCol">
										<label><?php echo JText::_('LPD_TYPE'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<select name="typeid" id="typeid" style="font-size: 14px;">
											<option value="0" <?php if($this->row->typeid==0) echo "selected"; ?>><?php echo JText::_('LPD_LANDING_PAGE'); ?></option>
											<option value="1" <?php if($this->row->typeid==1) echo "selected"; ?>><?php echo JText::_('LPD_CONVERSION_PAGE'); ?></option>
										</select>
									</td>
								<tr>
									<td class="adminLPDLeftCol">
										<label><?php echo JText::_('LPD_CATEGORY'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<?php echo $this->lists['categories']; ?>
									</td>
								</tr>
								<?php if($this->mainframe->isAdmin() || ($this->mainframe->isSite() && $this->permissions->get('publish'))): ?>
								<tr>
									<td class="adminLPDLeftCol">
										<label for="featured"><?php echo JText::_('LPD_IS_IT_FEATURED'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<?php echo $this->lists['featured']; ?>
									</td>
								</tr>
								<tr>
									<td class="adminLPDLeftCol">
										<label><?php echo JText::_('LPD_PUBLISHED'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<?php echo $this->lists['published']; ?>
									</td>
								</tr>
									<?php if($this->row->id): ?>
								<tr>
									<td class="adminLPDLeftCol">
										<label><?php echo JText::_('LPD_PREVIEW'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										&nbsp;<a href="../index.php?option=com_lpd&view=item&id=<?php echo $this->row->id; ?>" target="_blank"><?php echo JText::_('LPD_PREVIEW'); ?></a>
									</td>
								</tr>
									<?php endif; ?>
								<?php endif; ?>
							</table>
							
							<!-- Tabs start here -->
							<div class="simpleTabs" id="lpdTabs">								
								<!-- Tab content -->
								<div class="simpleTabsContent" id="lpdTab1">
									<?php if($this->params->get('mergeEditors')): ?>
									<div class="lpdItemFormEditor"> <?php echo $this->text; ?>
										<div class="dummyHeight"></div>
										<div class="clr"></div>
									</div>
									<?php else: ?>
									<div class="lpdItemFormEditor"> <span class="lpdItemFormEditorTitle"> <?php echo JText::_('LPD_INTROTEXT_TEASER_CONTENTEXCERPT'); ?> </span> <?php echo $this->introtext; ?>
										<div class="dummyHeight"></div>
										<div class="clr"></div>
									</div>
									<div class="lpdItemFormEditor"> <span class="lpdItemFormEditorTitle"> <?php echo JText::_('LPD_FULLTEXT_MAIN_CONTENT'); ?> </span> <?php echo $this->fulltext; ?>
										<div class="dummyHeight"></div>
										<div class="clr"></div>
									</div>
									<?php endif; ?>
									<?php if (count($this->LPDPluginsItemContent)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemContent as $LPDPlugin): ?>
										<?php if(!is_null($LPDPlugin)): ?>
										<fieldset>
											<legend><?php echo $LPDPlugin->name; ?></legend>
											<?php echo $LPDPlugin->fields; ?>
										</fieldset>
										<?php endif; ?>
										<?php endforeach; ?>
									</div>
									<?php endif; ?>
									<div class="clr"></div>
								</div>
								<?php if (!$this->params->get('showImageTab')): ?>
								<!-- Tab image -->
								<div class="simpleTabsContent" id="lpdTab2">
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ITEM_IMAGE'); ?>
											</td>
											<td>
												<input type="file" name="image" class="fileUpload" />
												<i>(<?php echo JText::_('LPD_MAX_UPLOAD_SIZE'); ?>: <?php echo ini_get('upload_max_filesize'); ?>)</i>
												<br />
												<br />
												<input type="text" name="existingImage" id="existingImageValue" class="text_area" readonly />
												<input type="button" value="<?php echo JText::_('LPD_BROWSE_SERVER'); ?>" id="lpdImageBrowseServer"  />
												<br />
												<br />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ITEM_IMAGE_CAPTION'); ?>
											</td>
											<td>
												<input type="text" name="image_caption" size="30" class="text_area" value="<?php echo $this->row->image_caption; ?>" />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ITEM_IMAGE_CREDITS'); ?>
											</td>
											<td>
												<input type="text" name="image_credits" size="30" class="text_area" value="<?php echo $this->row->image_credits; ?>" />
											</td>
										</tr>
										<?php if (!empty($this->row->image)): ?>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ITEM_IMAGE_PREVIEW'); ?>
											</td>
											<td>
												<a class="modal" rel="{handler: 'image'}" href="<?php echo $this->row->image; ?>" title="<?php echo JText::_('LPD_CLICK_ON_IMAGE_TO_PREVIEW_IN_ORIGINAL_SIZE'); ?>"> <img alt="<?php echo $this->row->title; ?>" src="<?php echo $this->row->thumb; ?>" class="lpdAdminImage"/> </a>
												<input type="checkbox" name="del_image" id="del_image" />
												<label for="del_image"><?php echo JText::_('LPD_CHECK_THIS_BOX_TO_DELETE_CURRENT_IMAGE_OR_JUST_UPLOAD_A_NEW_IMAGE_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
											</td>
										</tr>
										<?php endif; ?>
									</table>
									<?php if (count($this->LPDPluginsItemImage)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemImage as $LPDPlugin): ?>
										<?php if(!is_null($LPDPlugin)): ?>
										<fieldset>
											<legend><?php echo $LPDPlugin->name; ?></legend>
											<?php echo $LPDPlugin->fields; ?>
										</fieldset>
										<?php endif; ?>
										<?php endforeach; ?>
									</div>
									<?php endif; ?>
								</div>
								<?php endif; ?>
							</div>
							<!-- Tabs end here -->
							
							<input type="hidden" name="isSite" value="<?php echo (int)$this->mainframe->isSite(); ?>" />
							<?php if($this->mainframe->isSite()): ?>
							<input type="hidden" name="lang" value="<?php echo JRequest::getCmd('lang'); ?>" />
							<?php endif; ?>
							<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
							<input type="hidden" name="option" value="com_lpd" />
							<input type="hidden" name="view" value="item" />
							<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
							<input type="hidden" name="Itemid" value="<?php echo JRequest::getInt('Itemid'); ?>" />
							<?php echo JHTML::_('form.token'); ?>
						</td>
						<td id="adminFormLPDSidebar"<?php if($this->mainframe->isSite() && !$this->params->get('sideBarDisplayFrontend')): ?> style="display:none;"<?php endif; ?> class="xmlParamsFields">
							<?php if($this->row->id): ?>
							<table class="sidebarDetails">
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_ITEM_ID'); ?></strong>
									</td>
									<td>
										<?php echo $this->row->id; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_PUBLISHED'); ?></strong>
									</td>
									<td>
										<?php echo ($this->row->published > 0) ? JText::_('LPD_YES') : JText::_('LPD_NO'); ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_FEATURED'); ?></strong>
									</td>
									<td>
										<?php echo ($this->row->featured > 0) ? JText::_('LPD_YES'):	JText::_('LPD_NO'); ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_CREATED_DATE'); ?></strong>
									</td>
									<td>
										<?php echo $this->lists['created']; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_CREATED_BY'); ?></strong>
									</td>
									<td>
										<?php echo $this->row->author; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_MODIFIED_DATE'); ?></strong>
									</td>
									<td>
										<?php echo $this->lists['modified']; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_MODIFIED_BY'); ?></strong>
									</td>
									<td>
										<?php echo $this->row->moderator; ?>
									</td>
								</tr>
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_HITS'); ?></strong>
									</td>
									<td>
										<?php echo $this->row->hits; ?>
										<?php if($this->row->hits): ?>
										<input id="resetHitsButton" type="button" value="<?php echo JText::_('LPD_RESET'); ?>" class="button" name="resetHits" />
										<?php endif; ?>
									</td>
								</tr>
								<?php endif; ?>
								<?php if($this->row->id): ?>
							</table>
							<?php endif; ?>
							<div id="lpdAccordion">
								<h3><a href="#"><?php echo JText::_('LPD_AUTHOR_PUBLISHING_STATUS'); ?></a></h3>
								<div>
									<table class="admintable">
										<?php if(isset($this->lists['language'])): ?>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_LANGUAGE'); ?>
											</td>
											<td>
												<?php echo $this->lists['language']; ?>
											</td>
										</tr>
										<?php endif; ?>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_AUTHOR'); ?>
											</td>
											<td id="lpdAuthorOptions">
												<span id="lpdAuthor"><?php echo $this->row->author; ?></span>
												<?php if($this->mainframe->isAdmin() || ($this->mainframe->isSite() && $this->permissions->get('editAll'))): ?>
												<a class="modal" rel="{handler:'iframe', size: {x: 800, y: 460}}" href="index.php?option=com_lpd&amp;view=users&amp;task=element&amp;tmpl=component"><?php echo JText::_('LPD_CHANGE'); ?></a>
												<input type="hidden" name="created_by" value="<?php echo $this->row->created_by; ?>" />
												<?php endif; ?>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_AUTHOR_ALIAS'); ?>
											</td>
											<td>
												<input class="text_area" type="text" name="created_by_alias" maxlength="250" value="<?php echo $this->row->created_by_alias; ?>" />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ACCESS_LEVEL'); ?>
											</td>
											<td>
												<?php echo $this->lists['access']; ?>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_CREATION_DATE'); ?>
											</td>
											<td class="lpdItemFormDateField">
												<?php echo $this->lists['createdCalendar']; ?>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_START_PUBLISHING'); ?>
											</td>
											<td class="lpdItemFormDateField">
												<?php echo $this->lists['publish_up']; ?>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_FINISH_PUBLISHING'); ?>
											</td>
											<td class="lpdItemFormDateField">
												<?php echo $this->lists['publish_down']; ?>
											</td>
										</tr>
									</table>
								</div>
								<h3><a href="#"><?php echo JText::_('LPD_METADATA_INFORMATION'); ?></a></h3>
								<div>
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_DESCRIPTION'); ?>
											</td>
											<td>
												<textarea name="metadesc" rows="5" cols="20"><?php echo $this->row->metadesc; ?></textarea>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_KEYWORDS'); ?>
											</td>
											<td>
												<textarea name="metakey" rows="5" cols="20"><?php echo $this->row->metakey; ?></textarea>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_ROBOTS'); ?>
											</td>
											<td>
												<input type="text" name="meta[robots]" value="<?php echo $this->lists['metadata']->get('robots'); ?>" />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_AUTHOR'); ?>
											</td>
											<td>
												<input type="text" name="meta[author]" value="<?php echo $this->lists['metadata']->get('author'); ?>" />
											</td>
										</tr>
									</table>
								</div>
								<h3><a href="#"><?php echo JText::_('Custom CSS Style'); ?></a></h3>
								<div>
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Custom CSS'); ?>
											</td>
											<td>
												<textarea name="customcss" rows="10" cols="20"><?php echo $this->row->customcss; ?></textarea>
											</td>
										</tr>
									</table>
								</div>
								<h3><a href="#"><?php echo JText::_('Custom JavaScript'); ?></a></h3>
								<div>
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Custom JavaScript'); ?>
											</td>
											<td>
												<textarea name="customjs" rows="5" cols="20"><?php echo $this->row->customjs; ?></textarea>
											</td>
										</tr>
									</table>
								</div>
								<h3><a href="#"><?php echo JText::_('Google Analytics'); ?></a></h3>
								<div>
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Google Analytics Script'); ?>
											</td>
											<td>
												<textarea name="googleanalyticsscript" rows="5" cols="20"><?php echo $this->row->googleanalyticsscript; ?></textarea>
											</td>
										</tr>
									</table>
								</div>
								<h3><a href="#"><?php echo JText::_('Google Website Optimizer'); ?></a></h3>
								<div>
									<table class="admintable">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Control Script'); ?>
											</td>
											<td>
												<textarea name="gwocontrolscript" rows="5" cols="20"><?php echo $this->row->gwocontrolscript; ?></textarea>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Tracking Script'); ?>
											</td>
											<td>
												<textarea name="gwotrackingscript" rows="5" cols="20"><?php echo $this->row->gwotrackingscript; ?></textarea>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('Conversion Script'); ?>
											</td>
											<td>
												<textarea name="gwoconversionscript" rows="5" cols="20"><?php echo $this->row->gwoconversionscript; ?></textarea>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="clr"></div>
			<?php if($this->mainframe->isSite()): ?>
		</div>
	</div>
	<?php endif; ?>
</form>
