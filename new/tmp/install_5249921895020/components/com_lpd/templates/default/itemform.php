<?php
/**
 * @version		$Id: itemform.php 1377 2011-12-02 10:43:01Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
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
		if (\$LPD.trim(\$LPD('#title').val()) == '') {
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
										<label for="title"><?php echo JText::_('LPD_TITLE'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<input class="text_area lpdTitleBox" type="text" name="title" id="title" maxlength="250" value="<?php echo $this->row->title; ?>" />
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
										<label><?php echo JText::_('LPD_CATEGORY'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<?php echo $this->lists['categories']; ?>
									</td>
								</tr>
								<tr>
									<td class="adminLPDLeftCol">
										<label><?php echo JText::_('LPD_TAGS'); ?></label>
									</td>
									<td class="adminLPDRightCol">
										<?php if($this->params->get('taggingSystem')): ?>
										<!-- Free tagging -->
										<ul class="tags">
											<?php if(isset($this->row->tags) && count($this->row->tags)): ?>
											<?php foreach($this->row->tags as $tag): ?>
											<li class="tagAdded">
												<?php echo $tag->name; ?>
												<span title="<?php echo JText::_('LPD_CLICK_TO_REMOVE_TAG'); ?>" class="tagRemove">x</span>
												<input type="hidden" name="tags[]" value="<?php echo $tag->name; ?>" />
											</li>
											<?php endforeach; ?>
											<?php endif; ?>
											<li class="tagAdd">
												<input type="text" id="search-field" />
											</li>
											<li class="clr"></li>
										</ul>
										<span class="lpdNote"> <?php echo JText::_('LPD_WRITE_A_TAG_AND_PRESS_RETURN_OR_COMMA_TO_ADD_IT'); ?> </span>
										<?php else: ?>
										<!-- Selection based tagging -->
										<?php if( !$this->params->get('lockTags') || $this->user->gid>23): ?>
										<div style="float:left;">
											<input type="text" name="tag" id="tag" />
											<input type="button" id="newTagButton" value="<?php echo JText::_('LPD_ADD'); ?>" />
										</div>
										<div id="tagsLog"></div>
										<div class="clr"></div>
										<span class="lpdNote"> <?php echo JText::_('LPD_WRITE_A_TAG_AND_PRESS_ADD_TO_INSERT_IT_TO_THE_AVAILABLE_TAGS_LISTNEW_TAGS_ARE_APPENDED_AT_THE_BOTTOM_OF_THE_AVAILABLE_TAGS_LIST_LEFT'); ?> </span>
										<?php endif; ?>
										<table cellspacing="0" cellpadding="0" border="0" id="tagLists">
											<tr>
												<td id="tagListsLeft">
													<span><?php echo JText::_('LPD_AVAILABLE_TAGS'); ?></span> <?php echo $this->lists['tags'];	?>
												</td>
												<td id="tagListsButtons">
													<input type="button" id="addTagButton" value="<?php echo JText::_('LPD_ADD'); ?> &raquo;" />
													<br />
													<br />
													<input type="button" id="removeTagButton" value="&laquo; <?php echo JText::_('LPD_REMOVE'); ?>" />
												</td>
												<td id="tagListsRight">
													<span><?php echo JText::_('LPD_SELECTED_TAGS'); ?></span> <?php echo $this->lists['selectedTags']; ?>
												</td>
											</tr>
										</table>
										<?php endif; ?>
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
								<?php endif; ?>
							</table>
							
							<!-- Tabs start here -->
							<div class="simpleTabs" id="lpdTabs">
								<ul class="simpleTabsNavigation">
									<li id="tabContent"><a href="#lpdTab1"><?php echo JText::_('LPD_CONTENT'); ?></a></li>
									<?php if ($this->params->get('showImageTab')): ?>
									<li id="tabImage"><a href="#lpdTab2"><?php echo JText::_('LPD_IMAGE'); ?></a></li>
									<?php endif; ?>
									<?php if ($this->params->get('showImageGalleryTab')): ?>
									<li id="tabImageGallery"><a href="#lpdTab3"><?php echo JText::_('LPD_IMAGE_GALLERY'); ?></a></li>
									<?php endif; ?>
									<?php if ($this->params->get('showVideoTab')): ?>
									<li id="tabVideo"><a href="#lpdTab4"><?php echo JText::_('LPD_MEDIA'); ?></a></li>
									<?php endif; ?>
									<?php if ($this->params->get('showExtraFieldsTab')): ?>
									<li id="tabExtraFields"><a href="#lpdTab5"><?php echo JText::_('LPD_EXTRA_FIELDS'); ?></a></li>
									<?php endif; ?>
									<?php if ($this->params->get('showAttachmentsTab')): ?>
									<li id="tabAttachments"><a href="#lpdTab6"><?php echo JText::_('LPD_ATTACHMENTS'); ?></a></li>
									<?php endif; ?>
									<?php if(count(array_filter($this->LPDPluginsItemOther)) && $this->params->get('showLPDPlugins')): ?>
									<li id="tabPlugins"><a href="#lpdTab7"><?php echo JText::_('LPD_PLUGINS'); ?></a></li>
									<?php endif; ?>
								</ul>
								
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
								<?php if ($this->params->get('showImageTab')): ?>
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
								<?php if ($this->params->get('showImageGalleryTab')): ?>
								<!-- Tab image gallery -->
								<div class="simpleTabsContent" id="lpdTab3">
									<?php if ($this->lists['checkSIG']): ?>
									<table class="admintable" id="item_gallery_content">
										<tr>
											<td align="right" valign="top" class="key">
												<?php echo JText::_('LPD_UPLOAD_A_ZIP_FILE_WITH_IMAGES'); ?>
											</td>
											<td valign="top">
												<input type="file" name="gallery" class="fileUpload" />
												<i>(<?php echo JText::_('LPD_MAX_UPLOAD_SIZE'); ?>: <?php echo ini_get('upload_max_filesize'); ?>)</i>
												<br />
												<br />
												<?php echo JText::_('LPD_OR_ENTER_A_FLICKR_SET_URL'); ?>
												<input type="text" name="flickrGallery" size="50" value="<?php echo ($this->row->galleryType == 'flickr')? $this->row->galleryValue : ''; ?>" />
												<?php if (!empty($this->row->gallery)): ?>
												<div id="itemGallery"> <?php echo $this->row->gallery; ?>
													<input type="checkbox" name="del_gallery" id="del_gallery"/>
													<label for="del_gallery"><?php echo JText::_('LPD_CHECK_THIS_BOX_TO_DELETE_CURRENT_IMAGE_GALLERY_OR_JUST_UPLOAD_A_NEW_IMAGE_GALLERY_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
												</div>
												<?php endif; ?>
											</td>
										</tr>
									</table>
									<?php else: ?>
									<dl id="system-message">
										<dt class="notice"><?php echo JText::_('LPD_NOTICE'); ?></dt>
										<dd class="notice message fade">
											<ul>
												<li><?php echo JText::_('LPD_NOTICE_PLEASE_INSTALL_JOOMLAWORKS_SIMPLE_IMAGE_GALLERY_PRO_PLUGIN_IF_YOU_WANT_TO_USE_THE_IMAGE_GALLERY_FEATURES_OF_LPD'); ?></li>
											</ul>
										</dd>
									</dl>
									<?php endif; ?>
									<?php if (count($this->LPDPluginsItemGallery)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemGallery as $LPDPlugin): ?>
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
								<?php if ($this->params->get('showVideoTab')): ?>
								<!-- Tab video -->
								<div class="simpleTabsContent" id="lpdTab4">
									<?php if ($this->lists['checkAllVideos']): ?>
									<table class="admintable" id="item_video_content">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_SOURCE'); ?>
											</td>
											<td>
												<div id="lpdVideoTabs" class="simpleTabs">
													<ul class="simpleTabsNavigation">
														<li><a href="#lpdVideoTab1"><?php echo JText::_('LPD_UPLOAD'); ?></a></li>
														<li><a href="#lpdVideoTab2"><?php echo JText::_('LPD_BROWSE_SERVERUSE_REMOTE_MEDIA'); ?></a></li>
														<li><a href="#lpdVideoTab3"><?php echo JText::_('LPD_MEDIA_USE_ONLINE_VIDEO_SERVICE'); ?></a></li>
														<li><a href="#lpdVideoTab4"><?php echo JText::_('LPD_EMBED'); ?></a></li>
													</ul>
													<div id="lpdVideoTab1" class="simpleTabsContent">
														<div class="panel" id="Upload_video">
															<input type="file" name="video" class="fileUpload" />
															<i>(<?php echo JText::_('LPD_MAX_UPLOAD_SIZE'); ?>: <?php echo ini_get('upload_max_filesize'); ?>)</i> </div>
													</div>
													<div id="lpdVideoTab2" class="simpleTabsContent">
														<div class="panel" id="Remote_video"> <a id="lpdMediaBrowseServer" href="index.php?option=com_lpd&view=media&type=video&tmpl=component&fieldID=remoteVideo"><?php echo JText::_('LPD_BROWSE_VIDEOS_ON_SERVER')?></a> <?php echo JText::_('LPD_OR'); ?> <?php echo JText::_('LPD_PASTE_REMOTE_VIDEO_URL'); ?>
															<br />
															<br />
															<input type="text" size="50" name="remoteVideo" id="remoteVideo" value="<?php echo $this->lists['remoteVideo'] ?>" />
														</div>
													</div>
													<div id="lpdVideoTab3" class="simpleTabsContent">
														<div class="panel" id="Video_from_provider"> <?php echo JText::_('LPD_SELECT_VIDEO_PROVIDER'); ?> <?php echo $this->lists['providers']; ?> <?php echo JText::_('LPD_AND_ENTER_VIDEO_ID'); ?>
															<input type="text" name="videoID" value="<?php echo $this->lists['providerVideo'] ?>" />
															<br />
															<br />
															<a class="modal" rel="{handler: 'iframe', size: {x: 990, y: 600}}" href="http://www.joomlaworks.gr/allvideos-documentation"><?php echo JText::_('LPD_READ_THE_ALLVIDEOS_DOCUMENTATION_FOR_MORE'); ?></a> </div>
													</div>
													<div id="lpdVideoTab4" class="simpleTabsContent">
														<div class="panel" id="embedVideo">
															<?php echo JText::_('LPD_PASTE_HTML_EMBED_CODE_BELOW'); ?>
															<br />
															<textarea name="embedVideo" rows="5" cols="50" class="textarea"><?php echo $this->lists['embedVideo']; ?></textarea>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_CAPTION'); ?>
											</td>
											<td>
												<input type="text" name="video_caption" size="50" class="text_area" value="<?php echo $this->row->video_caption; ?>" />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_CREDITS'); ?>
											</td>
											<td>
												<input type="text" name="video_credits" size="50" class="text_area" value="<?php echo $this->row->video_credits; ?>" />
											</td>
										</tr>
										<?php if($this->row->video): ?>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_PREVIEW'); ?>
											</td>
											<td>
												<?php echo $this->row->video; ?>
												<br />
												<input type="checkbox" name="del_video" id="del_video" />
												<label for="del_video"><?php echo JText::_('LPD_CHECK_THIS_BOX_TO_DELETE_CURRENT_VIDEO_OR_USE_THE_FORM_ABOVE_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
											</td>
										</tr>
										<?php endif; ?>
									</table>
									<?php else: ?>
									<dl id="system-message">
										<dt class="notice"><?php echo JText::_('LPD_NOTICE'); ?></dt>
										<dd class="notice message fade">
											<ul>
												<li><?php echo JText::_('LPD_NOTICE_PLEASE_INSTALL_JOOMLAWORKS_ALLVIDEOS_PLUGIN_IF_YOU_WANT_TO_USE_THE_FULL_VIDEO_FEATURES_OF_LPD'); ?></li>
											</ul>
										</dd>
									</dl>
									<table class="admintable" id="item_video_content">
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_SOURCE'); ?>
											</td>
											<td>
												<div id="lpdVideoTabs" class="simpleTabs">
													<ul class="simpleTabsNavigation">
														<li><a href="#lpdVideoTab4"><?php echo JText::_('LPD_EMBED'); ?></a></li>
													</ul>
													<div class="simpleTabsContent" id="lpdVideoTab4">
														<div class="panel" id="embedVideo">
															<?php echo JText::_('LPD_PASTE_HTML_EMBED_CODE_BELOW'); ?>
															<br />
															<textarea name="embedVideo" rows="5" cols="50" class="textarea"><?php echo $this->lists['embedVideo']; ?></textarea>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_CAPTION'); ?>
											</td>
											<td>
												<input type="text" name="video_caption" size="50" class="text_area" value="<?php echo $this->row->video_caption; ?>" />
											</td>
										</tr>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_CREDITS'); ?>
											</td>
											<td>
												<input type="text" name="video_credits" size="50" class="text_area" value="<?php echo $this->row->video_credits; ?>" />
											</td>
										</tr>
										<?php if($this->row->video): ?>
										<tr>
											<td align="right" class="key">
												<?php echo JText::_('LPD_MEDIA_PREVIEW'); ?>
											</td>
											<td>
												<?php echo $this->row->video; ?>
												<br />
												<input type="checkbox" name="del_video" id="del_video" />
												<label for="del_video"><?php echo JText::_('LPD_USE_THE_FORM_ABOVE_TO_REPLACE_THE_EXISTING_VIDEO_OR_CHECK_THIS_BOX_TO_DELETE_CURRENT_VIDEO'); ?></label>
											</td>
										</tr>
										<?php endif; ?>
									</table>
									<?php endif; ?>
									<?php if (count($this->LPDPluginsItemVideo)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemVideo as $LPDPlugin): ?>
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
								<?php if ($this->params->get('showExtraFieldsTab')): ?>
								<!-- Tab extra fields -->
								<div class="simpleTabsContent" id="lpdTab5">
									<div id="extraFieldsContainer">
										<?php if (count($this->extraFields)): ?>
										<table class="admintable" id="extraFields">
											<?php foreach($this->extraFields as $extraField): ?>
											<tr>
												<td align="right" class="key">
													<?php echo $extraField->name; ?>
												</td>
												<td>
													<?php echo $extraField->element; ?>
												</td>
											</tr>
											<?php endforeach; ?>
										</table>
										<?php else: ?>
										<dl id="system-message">
											<dt class="notice"><?php echo JText::_('LPD_NOTICE'); ?></dt>
											<dd class="notice message fade">
												<ul>
													<li><?php echo JText::_('LPD_PLEASE_SELECT_A_CATEGORY_FIRST_TO_RETRIEVE_ITS_RELATED_EXTRA_FIELDS'); ?></li>
												</ul>
											</dd>
										</dl>
										<?php endif; ?>
									</div>
									<?php if (count($this->LPDPluginsItemExtraFields)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemExtraFields as $LPDPlugin): ?>
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
								<?php if ($this->params->get('showAttachmentsTab')): ?>
								<!-- Tab attachements -->
								<div class="simpleTabsContent" id="lpdTab6">
									<div class="itemAttachments">
										<?php if (count($this->row->attachments)): ?>
										<table class="adminlist">
											<tr>
												<th>
													<?php echo JText::_('LPD_FILENAME'); ?>
												</th>
												<th>
													<?php echo JText::_('LPD_TITLE'); ?>
												</th>
												<th>
													<?php echo JText::_('LPD_TITLE_ATTRIBUTE'); ?>
												</th>
												<th>
													<?php echo JText::_('LPD_DOWNLOADS'); ?>
												</th>
												<th>
													<?php echo JText::_('LPD_OPERATIONS'); ?>
												</th>
											</tr>
											<?php foreach($this->row->attachments as $attachment): ?>
											<tr>
												<td class="attachment_entry">
													<?php echo $attachment->filename; ?>
												</td>
												<td>
													<?php echo $attachment->title; ?>
												</td>
												<td>
													<?php echo $attachment->titleAttribute; ?>
												</td>
												<td>
													<?php echo $attachment->hits; ?>
												</td>
												<td>
													<a href="<?php echo $attachment->link; ?>"><?php echo JText::_('LPD_DOWNLOAD'); ?></a> <a class="deleteAttachmentButton" href="<?php echo JURI::base(true); ?>/index.php?option=com_lpd&amp;view=item&amp;task=deleteAttachment&amp;id=<?php echo $attachment->id?>&amp;cid=<?php echo $this->row->id; ?>"><?php echo JText::_('LPD_DELETE'); ?></a>
												</td>
											</tr>
											<?php endforeach; ?>
										</table>
										<?php endif; ?>
									</div>
									<div id="addAttachment">
										<input type="button" id="addAttachmentButton" value="<?php echo JText::_('LPD_ADD_ATTACHMENT_FIELD'); ?>" />
										<i>(<?php echo JText::_('LPD_MAX_UPLOAD_SIZE'); ?>: <?php echo ini_get('upload_max_filesize'); ?>)</i> </div>
									<div id="itemAttachments"></div>
									<?php if (count($this->LPDPluginsItemAttachments)): ?>
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemAttachments as $LPDPlugin): ?>
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
								<?php if(count(array_filter($this->LPDPluginsItemOther)) && $this->params->get('showLPDPlugins')): ?>
								<!-- Tab other plugins -->
								<div class="simpleTabsContent" id="lpdTab7">
									<div class="itemPlugins">
										<?php foreach($this->LPDPluginsItemOther as $LPDPlugin): ?>
										<?php if(!is_null($LPDPlugin)): ?>
										<fieldset>
											<legend><?php echo $LPDPlugin->name; ?></legend>
											<?php echo $LPDPlugin->fields; ?>
										</fieldset>
										<?php endif; ?>
										<?php endforeach; ?>
									</div>
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
								<tr>
									<td>
										<strong><?php echo JText::_('LPD_RATING'); ?></strong>
									</td>
									<td>
										<?php echo $this->row->ratingCount; ?> <?php echo JText::_('LPD_VOTES'); ?>
										<?php if($this->row->ratingCount): ?>
										<br />
										(<?php echo JText::_('LPD_AVERAGE_RATING'); ?>: <?php echo number_format(($this->row->ratingSum/$this->row->ratingCount),2); ?>/5.00)
										<?php endif; ?>
										<input id="resetRatingButton" type="button" value="<?php echo JText::_('LPD_RESET'); ?>" class="button" name="resetRating" />
									</td>
								</tr>
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
								<?php if($this->mainframe->isAdmin()): ?>
								<h3><a href="#"><?php echo JText::_('LPD_ITEM_VIEW_OPTIONS_IN_CATEGORY_LISTINGS'); ?></a></h3>
								<div>
									<?php if(version_compare( JVERSION, '1.6.0', 'ge' )): ?>
									<fieldset class="panelform">
										<ul class="adminformlist">
											<?php foreach($this->form->getFieldset('item-view-options-listings') as $field): ?>
											<li>
												<?php if($field->type=='header'): ?>
												<div class="paramValueHeader"><?php echo $field->input; ?></div>
												<?php elseif($field->type=='Spacer'): ?>
												<div class="paramValueSpacer">&nbsp;</div>
												<div class="clr"></div>
												<?php else: ?>
												<div class="paramLabel"><?php echo $field->label; ?></div>
												<div class="paramValue"><?php echo $field->input; ?></div>
												<div class="clr"></div>
												<?php endif; ?>
											</li>
											<?php endforeach; ?>
										</ul>
									</fieldset>
									<?php else: ?>
									<?php echo $this->form->render('params', 'item-view-options-listings'); ?>
									<?php endif; ?>
								</div>
								<h3><a href="#"><?php echo JText::_('LPD_ITEM_VIEW_OPTIONS'); ?></a></h3>
								<div>
									<?php if(version_compare( JVERSION, '1.6.0', 'ge' )): ?>
									<fieldset class="panelform">
										<ul class="adminformlist">
											<?php foreach($this->form->getFieldset('item-view-options') as $field): ?>
											<li>
												<?php if($field->type=='header'): ?>
												<div class="paramValueHeader"><?php echo $field->input; ?></div>
												<?php elseif($field->type=='Spacer'): ?>
												<div class="paramValueSpacer">&nbsp;</div>
												<div class="clr"></div>
												<?php else: ?>
												<div class="paramLabel"><?php echo $field->label; ?></div>
												<div class="paramValue"><?php echo $field->input; ?></div>
												<div class="clr"></div>
												<?php endif; ?>
											</li>
											<?php endforeach; ?>
										</ul>
									</fieldset>
									<?php else: ?>
									<?php echo $this->form->render('params', 'item-view-options'); ?>
									<?php endif; ?>
								</div>
								<?php endif; ?>
								<?php if($this->aceAclFlag): ?>
								<h3><a href="#"><?php echo JText::_('AceACL') . ' ' . JText::_('COM_ACEACL_COMMON_PERMISSIONS'); ?></a></h3>
								<div><?php AceaclApi::getWidget('com_lpd.item.'.$this->row->id, true); ?></div>
								<?php endif; ?>
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
