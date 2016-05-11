<?php
/**
 * @version		$Id: default.php 1190 2011-10-17 14:31:26Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$document = & JFactory::getDocument();
$document->addScriptDeclaration("
	Joomla.submitbutton = function(pressbutton) {
		if (pressbutton == 'trash') {
			var answer = confirm('".JText::_('LPD_WARNING_YOU_ARE_ABOUT_TO_TRASH_THE_SELECTED_CATEGORIES_THEIR_CHILDREN_CATEGORIES_AND_ALL_THEIR_INCLUDED_ITEMS', true)."')
			if (answer){
				submitform( pressbutton );
			} else {
				return;
			}
		} else {
			submitform( pressbutton );
		}
	}
");

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<table class="lpdAdminTableFilters">
		<tr>
			<td class="lpdAdminTableFiltersSearch">
				<?php echo JText::_('LPD_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_TITLE'); ?>"/>
				<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
				<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
			</td>
			<td class="lpdAdminTableFiltersSelects">
				<?php echo $this->lists['trash']; ?> <?php echo $this->lists['state']; ?>
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
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_TITLE', 'c.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ORDER', 'c.ordering', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> <?php echo $this->ordering ?JHTML::_('grid.order',  $this->rows ,'filesave.png' ):''; ?>
				</th>
<!--				<th>
					<?php echo JText::_('LPD_PARAMETER_INHERITANCE'); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ASSOCIATED_EXTRA_FIELD_GROUPS', 'extra_fields_group', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>-->
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ACCESS_LEVEL', 'c.access', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'c.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
<!--				<th>
					<?php echo JText::_('LPD_IMAGE'); ?>
				</th>-->
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ID', 'c.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach ($this->rows as $key => $row) :	?>
			<tr class="row<?php echo ($key%2); ?>">
				<td>
					<?php echo $key+1; ?>
				</td>
				<td class="lpdCenter">
					<?php if(!$this->filter_trash || $row->trash) { $row->checked_out = 0; echo JHTML::_('grid.checkedout', $row, $key );}?>
				</td>
				<td>
					<?php if ($this->filter_trash): ?>
					<?php if ($row->trash): ?>
					<strong><?php echo $row->treename; ?></strong>
					<?php else: ?>
					<?php echo $row->treename; ?>
					<?php endif; ?>
					<?php else: ?>
					<a href="<?php echo JRoute::_('index.php?option=com_lpd&view=category&cid='.$row->id); ?>"><?php echo $row->treename; ?>
					<?php if($this->params->get('showItemsCounterAdmin')): ?>
					(<?php echo $row->numOfItems; ?>)
					<?php endif; ?>
					</a>
					<?php endif; ?>
				</td>
				<td class="order lpdOrder">
					<span><?php echo $this->page->orderUpIcon( $key, $row->parent == 0 || $row->parent == @$this->rows[$key-1]->parent, 'orderup', 'LPD_MOVE_UP', $this->ordering); ?></span> <span><?php echo $this->page->orderDownIcon( $key, count($this->rows), $row->parent == 0 || $row->parent == @$this->rows[$key+1]->parent, 'orderdown', 'LPD_MOVE_DOWN', $this->ordering ); ?></span>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo ($this->ordering)?'':'disabled="disabled"'; ?> class="text_area lpdOrderBox" />
				</td>
<!--				<td class="lpdCenter">
					<?php echo $row->inheritFrom; ?>
				</td>
				<td class="lpdCenter">
					<?php echo $row->extra_fields_group; ?>
				</td>-->
				<td class="lpdCenter">
					<?php echo ($this->filter_trash || LPD_JVERSION=='16')?strip_tags(JHTML::_('grid.access', $row, $key )):JHTML::_('grid.access', $row, $key ); ?>
				</td>
				<td class="lpdCenter">
					<?php echo ($this->filter_trash)?strip_tags(JHTML::_('grid.published', $row, $key ),'<img>'):JHTML::_('grid.published', $row, $key ); ?>
				</td>
<!--				<td class="lpdCenter">
					<?php if($row->image): ?>
					<a href="<?php echo JURI::root().'media/lpd/categories/'.$row->image; ?>" class="modal">
						<img src="templates/<?php echo $this->template; ?>/images/menu/icon-16-media.png" alt="<?php echo JText::_('LPD_PREVIEW_IMAGE'); ?>" />
					</a>
					<?php endif; ?>
				</td>-->
				<td class="lpdCenter">
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
