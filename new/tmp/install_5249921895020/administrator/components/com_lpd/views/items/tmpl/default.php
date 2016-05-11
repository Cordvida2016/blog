<?php
/**
 * @version		$Id: default.php 1225 2011-10-18 16:22:02Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$document = & JFactory::getDocument();
$document->addScriptDeclaration("
	\$LPD(document).ready(function(){
		\$LPD('#LPDImportContentButton').click(function(event){
			var answer = confirm('".JText::_('LPD_WARNING_YOU_ARE_ABOUT_TO_IMPORT_ALL_SECTIONS_CATEGORIES_AND_ARTICLES_FROM_JOOMLAS_CORE_CONTENT_COMPONENT_COM_CONTENT_INTO_LPD_IF_THIS_IS_THE_FIRST_TIME_YOU_IMPORT_CONTENT_TO_LPD_AND_YOUR_SITE_HAS_MORE_THAN_A_FEW_THOUSAND_ARTICLES_THE_PROCESS_MAY_TAKE_A_FEW_MINUTES_IF_YOU_HAVE_EXECUTED_THIS_OPERATION_BEFORE_DUPLICATE_CONTENT_MAY_BE_PRODUCED', true)."');
			if (!answer){
				event.preventDefault();
			}
		});
	});
");

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="lpdAdminTableFilters">
		<tr>
			<td class="lpdAdminTableFiltersSearch">
				<?php echo JText::_('LPD_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area"	title="<?php echo JText::_('LPD_FILTER_BY_TITLE'); ?>" />
				<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
				<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
			</td>
			<td class="lpdAdminTableFiltersSelects">
				<?php echo $this->lists['trash']; ?> <?php echo $this->lists['featured']; ?> &nbsp;| <?php echo $this->lists['categories']; ?>
				<?php if(isset($this->lists['tag'])): ?>
				<?php echo $this->lists['tag']; ?>
				<?php endif; ?>
				<?php echo $this->lists['authors']; ?> <?php echo $this->lists['state']; ?>
				<?php if(isset($this->lists['language'])): ?>
				<?php echo $this->lists['language']; ?>
				<?php endif; ?>
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
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'LPD_NAME', 'i.name', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'LPD_TITLE', 'i.title', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th class="title">
					<?php echo JText::_('LPD_PREVIEW'); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_FEATURED', 'i.featured', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'i.published', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php if ($this->filter_featured=='1'): ?>
					<?php echo JHTML::_('grid.sort', 'LPD_FEATURED_ORDER', 'i.featured_ordering', @$this->lists['order_Dir'], @$this->lists['order']); ?>
					<?php if ($this->ordering) {echo JHTML::_('grid.order',  $this->rows, 'filesave.png','savefeaturedorder' );} ?>
					<?php else: ?>
					<?php echo JHTML::_('grid.sort', 'LPD_ORDER', 'i.ordering', @$this->lists['order_Dir'], @$this->lists['order']); ?>
					<?php if ($this->ordering) {echo JHTML::_('grid.order',  $this->rows );} ?>
					<?php endif; ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_TYPE', 'typeid', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_CATEGORY', 'category', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_AUTHOR', 'author', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_LAST_MODIFIED_BY', 'moderator', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ACCESS_LEVEL', 'i.access', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_CREATED', 'i.created', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_MODIFIED', 'i.modified', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_HITS', 'i.hits', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
<!--				<th>
					<?php echo JText::_('LPD_IMAGE'); ?>
				</th>-->
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ID', 'i.id', @$this->lists['order_Dir'], @$this->lists['order']); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="17">
					<?php echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($this->rows as $key => $row): ?>
			<tr class="row<?php echo ($key%2); ?>">
				<td>
					<?php echo $key+1; ?>
				</td>
				<td>
					<?php echo JHTML::_('grid.checkedout', $row, $key ); ?>
				</td>
				<td>
					<?php if (JTable::isCheckedOut($this->user->get('id'), $row->checked_out )): ?>
					<?php echo $row->name; ?>
					<?php else: ?>
					<?php if(!$this->filter_trash): ?>
					<a href="<?php echo JRoute::_('index.php?option=com_lpd&view=item&cid='.$row->id); ?>"><?php echo $row->name; ?></a>
					<?php else: ?>
					<?php echo $row->name; ?>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td>
					<?php if (JTable::isCheckedOut($this->user->get('id'), $row->checked_out )): ?>
					<?php echo $row->title; ?>
					<?php else: ?>
					<?php if(!$this->filter_trash): ?>
					<a href="<?php echo JRoute::_('index.php?option=com_lpd&view=item&cid='.$row->id); ?>"><?php echo $row->title; ?></a>
					<?php else: ?>
					<?php echo $row->title; ?>
					<?php endif; ?>
					<?php endif; ?>
				</td>
				<td>
					<a href="../index.php?option=com_lpd&view=item&id=<?php echo $row->id; ?>" target="_blank"><?php echo JText::_('LPD_PREVIEW'); ?></a>
				</td>
				<td class="lpdCenter">
					<?php if(!$this->filter_trash): ?>
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $key; ?>','featured')" title="<?php echo ( $row->featured ) ? JText::_('LPD_REMOVE_FEATURED_FLAG') : JText::_('LPD_FLAG_AS_FEATURED'); ?>">
					<?php endif; ?>
					<?php $row->state = $row->published; $row->published = $row->featured; echo strip_tags(JHTML::_('grid.published', $row, $key ), '<img>'); $row->published = $row->state; ?>
					<?php if(!$this->filter_trash): ?>
					</a>
					<?php endif; ?>
				</td>
				<td class="lpdCenter">
					<?php echo ($this->filter_trash) ? strip_tags(JHTML::_('grid.published', $row, $key ),'<img>') : JHTML::_('grid.published', $row, $key ); ?>
				</td>
				<td class="order lpdOrder">
					<?php if ($this->filter_featured=='1'): ?>
					<span><?php echo $this->page->orderUpIcon($key, true, 'featuredorderup', 'LPD_MOVE_UP', $this->ordering); ?></span> <span><?php echo $this->page->orderDownIcon($key, count( $this->rows ), true, 'featuredorderdown', 'LPD_MOVE_DOWN', $this->ordering); ?></span>
					<input type="text" name="order[]" size="5" value="<?php echo $row->featured_ordering; ?>" <?php echo ($this->ordering) ?  '' : 'disabled="disabled"' ?> class="text_area lpdOrderBox" />
					<?php else: ?>
					<span><?php echo $this->page->orderUpIcon($key, ($row->catid == @$this->rows[$key-1]->catid), 'orderup', 'LPD_MOVE_UP', $this->ordering); ?></span> <span><?php echo $this->page->orderDownIcon($key, count( $this->rows ), ($row->catid == @$this->rows[$key+1]->catid), 'orderdown', 'LPD_MOVE_DOWN', $this->ordering); ?></span>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo ($this->ordering)?  '' : 'disabled="disabled"' ?> class="text_area lpdOrderBox" />
					<?php endif; ?>
				</td>
				<td>
					<?php
					if($row->typeid==0) echo JText::_('LPD_LANDING_PAGE');
					else if($row->typeid==1) echo JText::_('LPD_CONVERSION_PAGE');
					?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_lpd&view=category&cid='.$row->catid); ?>"><?php echo $row->category; ?></a>
				</td>
				<td>
					<?php if($this->user->gid>23): ?>
					<a href="<?php echo JRoute::_('index.php?option=com_users&task=edit&cid[]='.$row->created_by); ?>"><?php echo $row->author; ?></a>
					<?php else: ?>
					<?php echo $row->author; ?>
					<?php endif; ?>
				</td>
				<td>
					<?php if($this->user->gid>23): ?>
					<a href="<?php echo JRoute::_('index.php?option=com_users&task=edit&cid[]='.$row->modified_by); ?>"><?php echo $row->moderator; ?></a>
					<?php else: ?>
					<?php echo $row->moderator; ?>
					<?php endif; ?>
				</td>
				<td class="lpdCenter">
					<?php echo ($this->filter_trash || LPD_JVERSION=='16')?strip_tags(JHTML::_('grid.access', $row, $key )):JHTML::_('grid.access', $row, $key ); ?>
				</td>
				<td class="lpdDate">
					<?php echo JHTML::_('date', $row->created , $this->dateFormat); ?>
				</td>
				<td class="lpdDate">
					<?php echo ($row->modified == $this->nullDate) ? JText::_('LPD_NEVER') : JHTML::_('date', $row->modified , $this->dateFormat); ?>
				</td>
				<td>
					<?php echo $row->hits ?>
				</td>
<!--				<td class="lpdCenter">
					<?php if (JFile::exists(JPATH_SITE.DS.'media'.DS.'lpd'.DS.'items'.DS.'cache'.DS.md5("Image".$row->id).'_XL.jpg')): ?>
					<a href="<?php echo JURI::root(true).'/media/lpd/items/cache/'.md5("Image".$row->id).'_XL.jpg'; ?>" title="<?php echo JText::_('LPD_PREVIEW_IMAGE'); ?>" class="modal">
						<img src="templates/<?php echo $this->template; ?>/images/menu/icon-16-media.png" alt="<?php echo JText::_('LPD_PREVIEW_IMAGE'); ?>" />
					</a>
					<?php endif; ?>
				</td>-->
				<td>
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_('form.token'); ?>
</form>
