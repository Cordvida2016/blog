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
	<h1><?php echo JText::_('LPD_SELECT_CATEGORIES'); ?></h1>
	<table class="lpdAdminTableFilters">
		<tr>
			<td class="lpdAdminTableFiltersSearch">
				<?php echo JText::_('LPD_FILTER'); ?>
				<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_TITLE'); ?>"/>
				<button id="lpdSubmitButton"><?php echo JText::_('LPD_GO'); ?></button>
				<button id="lpdResetButton"><?php echo JText::_('LPD_RESET'); ?></button>
			</td>
			<td class="lpdAdminTableFiltersSelects">
				<?php echo $this->lists['state']; ?>
			</td>
		</tr>
	</table>
	<table class="adminlist">
    	<thead>
	      	<tr>
		        <th>#</th>
		        <th> <?php echo JHTML::_('grid.sort', 'LPD_TITLE', 'c.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
		        <th><?php echo JHTML::_('grid.sort', 'LPD_ASSOCIATED_EXTRA_FIELD_GROUPS', 'extra_fields_group', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
		        <th><?php echo JHTML::_('grid.sort', 'LPD_ACCESS_LEVEL', 'c.access', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
		        <th><?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'c.published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
		        <th><?php echo JHTML::_('grid.sort', 'LPD_ID', 'c.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
	      	</tr>
		</thead>
		<tbody>
		<?php foreach ($this->rows as $key => $row): ?>
			<tr class="row<?php echo ($key%2); ?>">
        		<td><?php echo $key+1; ?></td>
        		<td><a class="lpdListItemDisabled" title="<?php echo JText::_('LPD_CLICK_TO_ADD_THIS_ITEM'); ?>" onclick="window.parent.jSelectCategory('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', 'id');"><?php echo $row->treename; ?></a></td>
        		<td class="lpdCenter"><?php echo $row->extra_fields_group; ?></td>
        		<td class="lpdCenter"><?php echo strip_tags(JHTML::_('grid.access', $row, $key )); ?></td>
        		<td class="lpdCenter"><?php echo strip_tags(JHTML::_('grid.published', $row, $key ), '<img>'); ?></td>
        		<td><?php echo $row->id; ?></td>
      		</tr>
      	<?php endforeach; ?>
		</tbody>
	    <tfoot>
			<tr>
				<td colspan="6"><?php echo $this->page->getListFooter(); ?></td>
			</tr>
		</tfoot>
	</table>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
	<input type="hidden" name="task" value="element" />
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>