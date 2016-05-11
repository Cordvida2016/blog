<?php
/**
 * @version		$Id: element.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<h1><?php echo JText::_('LPD_SELECT_ITEMS'); ?></h1>
	<table class="lpdAdminTableFilters">
    	<tr>
			<td class="lpdAdminTableFiltersSearch">
				<?php echo JText::_('LPD_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_TITLE'); ?>"/>
				<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
				<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
        	</td>
			<td class="lpdAdminTableFiltersSelects">
				<?php echo $this->lists['trash']; ?>
				<?php echo $this->lists['featured']; ?>&nbsp;|
				<?php echo $this->lists['categories']; ?>
				<?php if(isset($this->lists['tag'])): ?>
					<?php echo $this->lists['tag']; ?>
				<?php endif; ?>
				<?php echo $this->lists['authors']; ?>
				<?php echo $this->lists['state']; ?>
				<?php if(isset($this->lists['language'])): ?>
					<?php echo $this->lists['language']; ?>
				<?php endif; ?>
			</td>
		</tr>
	</table>
	<table class="adminlist">
		<thead>
			<tr>
				<th><?php echo JText::_('LPD_NUM'); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_TITLE', 'i.title', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_CATEGORY', 'category', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_AUTHOR', 'author', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_ACCESS_LEVEL', 'i.access', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_CREATED', 'i.created', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'LPD_ID', 'i.id', @$this->lists['order_Dir'], @$this->lists['order']); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($this->rows as $key => $row): ?>
			<tr class="row<?php echo ($key%2); ?>">
				<td><?php echo $key+1; ?></td>
				<td><a class="lpdListItemDisabled" title="<?php echo JText::_('LPD_CLICK_TO_ADD_THIS_ITEM'); ?>" onclick="window.parent.jSelectItem('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->title); ?>', '<?php echo JRequest::getCmd('object', 'id'); ?>');"><?php echo $row->title; ?></a></td>
				<td><?php echo $row->category; ?></td>
				<td><?php echo $row->author; ?></td>
				<td class="lpdCenter"><?php echo $row->groupname; ?></td>
				<td class="lpdDate"><?php echo $row->created; ?></td>
				<td><?php echo $row->id; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="7"><?php echo $this->page->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="items" />
	<input type="hidden" name="task" value="element" />
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>