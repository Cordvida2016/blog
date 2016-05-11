<?php
/**
 * @version		$Id: default.php 1352 2011-11-25 17:07:15Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(pressbutton) {
		if (pressbutton == 'remove') {
			if (document.adminForm.boxchecked.value==0){
				alert('<?php echo JText::_('LPD_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO_DELETE', true); ?>');
				return false;
			}
			if (confirm('<?php echo JText::_('LPD_ARE_YOU_SURE_YOU_WANT_TO_DELETE_SELECTED_COMMENTS', true); ?>')){
				submitform( pressbutton );
			} 
		} else if (pressbutton == 'deleteUnpublished') {
			if (confirm('<?php echo JText::_('LPD_THIS_WILL_PERMANENTLY_DELETE_ALL_UNPUBLISHED_COMMENTS_ARE_YOU_SURE', true); ?>')){
				submitform( pressbutton );
			} 
		} else if (pressbutton == 'publish') {
			if (document.adminForm.boxchecked.value==0){
				alert('<?php echo JText::_('LPD_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO_PUBLISH', true); ?>');
				return false;
			}
			submitform( pressbutton );
		} else if (pressbutton == 'unpublish') {
			if (document.adminForm.boxchecked.value==0){
				alert('<?php echo JText::_('LPD_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST_TO_UNPUBLISH', true); ?>');
				return false;
			}
			submitform( pressbutton );
		}  else { 
			submitform( pressbutton );
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if($this->mainframe->isSite()): ?>
	<div id="lpdFrontendContainer">
		<div id="lpdFrontend">
			<table class="lpdFrontendToolbar" cellpadding="2" cellspacing="4">
				<tr>
					<td id="toolbar-publish" class="button">
						<a class="toolbar" onclick="Joomla.submitbutton('publish'); return false;" href="#"><?php echo JText::_('LPD_PUBLISH'); ?></a>
					</td>
					<td id="toolbar-unpublish" class="button">
						<a class="toolbar" onclick="Joomla.submitbutton('unpublish'); return false;" href="#"><?php echo JText::_('LPD_UNPUBLISH'); ?></a>
					</td>
					<td id="toolbar-delete" class="button">
						<a class="toolbar" onclick="Joomla.submitbutton('remove'); return false;" href="#"><?php echo JText::_('LPD_DELETE'); ?></a>
					</td>
					<td id="toolbar-Link" class="button">
						<a onclick="Joomla.submitbutton('deleteUnpublished'); return false;" href="#"><?php echo JText::_('LPD_DELETE_ALL_UNPUBLISHED'); ?></a>
					</td>
				</tr>
			</table>
			<div id="lpdFrontendEditToolbar">
				<h2 class="header icon-48-lpd"><?php echo JText::_('LPD_MODERATE_COMMENTS_TO_MY_ITEMS'); ?></h2>
			</div>
			<div class="clr"></div>
			<hr class="sep" />
			<?php endif; ?>
			<table class="lpdAdminTableFilters">
				<tr>
					<td class="lpdAdminTableFiltersSearch">
						<?php echo JText::_('LPD_FILTER'); ?>
						<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_COMMENT'); ?>"/>
						<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
						<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
					</td>
					<td class="lpdAdminTableFiltersSelects">
						<?php echo $this->lists['categories']; ?>
						<?php if($this->mainframe->isAdmin()): ?>
						<?php echo $this->lists['authors']; ?>
						<?php endif; ?>
						<?php echo $this->lists['state']; ?>
					</td>
				</tr>
			</table>
			<table class="adminlist">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							<input id="jToggler" type="checkbox" name="toggle" value="" />
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_COMMENT', 'c.commentText', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'c.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_NAME', 'c.userName', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_EMAIL', 'c.commentEmail', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_URL', 'c.commentURL', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_ITEM', 'i.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_CATEGORY', 'cat.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JText::_('LPD_AUTHOR'); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_DATE', 'c.commentDate', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
						<th>
							<?php echo JHTML::_('grid.sort', 'LPD_ID', 'c.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
						</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="12">
							<div class="lpdCommentsPagination"><?php echo $this->page->getListFooter(); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach ($this->rows as $key=>$row): ?>
					<tr class="row<?php echo ($key%2); ?>">
						<td>
							<?php echo $key+1; ?>
						</td>
						<td>
							<?php $row->checked_out = 0; echo JHTML::_('grid.checkedout', $row, $key ); ?>
						</td>
						<td id="lpdComment<?php echo $row->id; ?>">
							<div class="commentText"><?php echo $row->commentText; ?></div>
							<div class="commentToolbar"> <span class="lpdCommentsLog"></span> <a href="#" rel="<?php echo $row->id; ?>" class="editComment"><?php echo JText::_('LPD_EDIT'); ?></a> <a href="#" rel="<?php echo $row->id; ?>" class="saveComment"><?php echo JText::_('LPD_SAVE'); ?></a> <a href="#" rel="<?php echo $row->id; ?>" class="closeComment"><?php echo JText::_('LPD_CANCEL'); ?></a>
								<div class="clr"></div>
							</div>
							<input type="hidden" name="currentValue[]" value="<?php echo $row->commentText; ?>" />
						</td>
						<td class="lpdCenter">
							<?php echo ($this->mainframe->isSite())? LPDHelperHTML::stateToggler($row, $key) : JHTML::_('grid.published', $row, $key ); ?>
						</td>
						<td>
							<?php if($this->mainframe->isAdmin() && $row->userID): ?>
							<a href="<?php echo $this->userEditLink.$row->userID;?>"><?php echo $row->userName; ?></a>
							<?php else :?>
							<?php echo $row->userName; ?>
							<?php endif; ?>
						</td>
						<td>
							<?php echo $row->commentEmail; ?>
						</td>
						<td>
							<a target="_blank" href="<?php echo JFilterOutput::cleanText($row->commentURL); ?>"><?php echo $row->commentURL; ?></a>
						</td>
						<td>
							<a class="modal" rel="{handler: 'iframe', size: {x: 1000, y: 600}}"	href="<?php echo JURI::root().LPDHelperRoute::getItemRoute($row->itemID.':'.urlencode($row->itemAlias),$row->catid.':'.urlencode($row->catAlias)); ?>"><?php echo $row->title; ?></a>
						</td>
						<td>
							<?php echo $row->catName; ?>
						</td>
						<td>
							<?php $user = &JFactory::getUser($row->created_by); echo $user->name; ?>
						</td>
						<td class="lpdDate">
							<?php echo JHTML::_('date', $row->commentDate , $this->dateFormat); ?>
						</td>
						<td>
							<?php echo $row->id; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<input type="hidden" name="isSite" value="<?php echo (int)$this->mainframe->isSite(); ?>" />
			<input type="hidden" name="option" value="com_lpd" />
			<input type="hidden" name="view" value="<?php echo JRequest::getCmd('view'); ?>" />
			<input type="hidden" id="task" name="task" value="" />
			<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" id="commentID" name="commentID" value="" />
			<input type="hidden" id="commentText" name="commentText" value="" />
			<?php echo JHTML::_( 'form.token' ); ?>
			<?php if($this->mainframe->isSite()): ?>
		</div>
	</div>
	<?php endif; ?>
</form>
