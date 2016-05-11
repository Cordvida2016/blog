<?php
/**
 * @version		$Id: default.php 1345 2011-11-25 16:48:07Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<?php $ordering = ($this->lists['order'] == 'ordering'); ?>

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
		<?php echo $this->lists['type']; ?>
		<?php echo $this->lists['group']; ?>
		<?php echo $this->lists['state']; ?>
      </td>
    </tr>
  </table>
  <table class="adminlist">
    <thead>
      <tr>
        <th>#</th>
        <th><input id="jToggler" type="checkbox" name="toggle" value="" /></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_NAME', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_GROUP', 'groupname', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_ORDER', 'ordering', @$this->lists['order_Dir'], @$this->lists['order']); ?> <?php if ($ordering) echo JHTML::_('grid.order',  $this->rows ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_TYPE', 'type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_ID', 'exf.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->rows as $key=>$row): ?>
      <tr class="row<?php echo ($key%2); ?>">
        <td width="20" align="center"><?php echo $key+1; ?></td>
        <td width="20" align="center"><?php $row->checked_out = 0; echo JHTML::_('grid.checkedout', $row, $key ); ?></td>
        <td><a href="<?php echo JRoute::_('index.php?option=com_lpd&view=extrafield&cid='.$row->id); ?>"><?php echo $row->name; ?></a></td>
        <td align="center"><?php echo $row->groupname; ?></td>
        <td class="order">
        	<span><?php echo $this->page->orderUpIcon($key, ($row->group == @$this->rows[$key-1]->group), 'orderup', 'Move Up', $ordering); ?></span>
        	<span><?php echo $this->page->orderDownIcon($key, count($this->rows), ($row->group == @$this->rows[$key+1]->group), 'orderdown', 'Move Down', $ordering); ?></span>
          	<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
          	<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
        </td>
        <td align="center"><?php echo JText::_('LPD_EXTRA_FIELD_'.JString::strtoupper($row->type)); ?></td>
        <td align="center"><?php echo JHTML::_('grid.published', $row, $key ); ?></td>
        <td align="center"><?php echo $row->id; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="8"><?php echo $this->page->getListFooter(); ?></td>
      </tr>
    </tfoot>
  </table>
  <input type="hidden" name="option" value="com_lpd" />
  <input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
  <input type="hidden" name="task" value="" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
  <input type="hidden" name="boxchecked" value="0" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>