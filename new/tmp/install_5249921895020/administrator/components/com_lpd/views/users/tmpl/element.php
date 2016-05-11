<?php
/**
 * @version		$Id: element.php 1203 2011-10-17 19:15:39Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<h1><?php echo JText::_('LPD_SELECT_USERS'); ?></h1>
	<table class="lpdAdminTableFilters">
		<tr>
			<td class="lpdAdminTableFiltersSearch">
				<?php echo JText::_('LPD_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_NAME'); ?>" />
				<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
				<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
			</td>
			<td class="lpdAdminTableFiltersSelects">
				<?php echo $this->lists['filter_group_lpd']; ?> <?php echo $this->lists['filter_group']; ?> <?php echo $this->lists['status']; ?>
			</td>
		</tr>
	</table>
	<table class="adminlist">
		<thead>
			<tr>
				<th>
					<?php echo JText::_('LPD_NUM'); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_NAME', 'juser.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_USER_NAME', 'juser.username', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ENABLED', 'juser.block', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_GROUP', 'juser.usertype', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_LPD_GROUP', 'groupname', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th>
					<?php echo JHTML::_('grid.sort', 'LPD_ID', 'juser.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="7">
					<?php echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach($this->rows as $key => $row): ?>
			<tr class="row<?php echo ($key%2); ?>">
				<td class="lpdCenter">
					<?php echo $key+1; ?>
				</td>
				<td>
					<a class="lpdListItemDisabled" title="<?php echo JText::_('LPD_CLICK_TO_ADD_THIS_ITEM'); ?>"	onclick="window.parent.jSelectUser('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', 'id');"><?php echo $row->name; ?></a>
				</td>
				<td class="lpdCenter">
					<?php echo $row->username; ?>
				</td>
				<td class="lpdCenter">
					<?php $row->published = ($row->block)? 0:1; echo strip_tags(JHTML::_('grid.published', $row, $key ), '<img>'); ?>
				</td>
				<td class="lpdCenter">
					<?php echo $row->usertype; ?>
				</td>
				<td class="lpdCenter">
					<?php echo $row->groupname; ?>
				</td>
				<td class="lpdCenter">
					<?php echo $row->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" name="option" value="com_lpd" />
	<?php if ($this->isAdmin): ?>
	<input type="hidden" name="view" value="users" />
	<input type="hidden" name="task" value="element" />
	<?php else: ?>
	<input type="hidden" name="view" value="item" />
	<input type="hidden" name="task" value="users" />
	<?php endif; ?>
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
