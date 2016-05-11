<?php
/**
 * @version		$Id: element.php 1340 2011-11-25 16:19:55Z lefteris.kavadas $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm">
  <table class="lpdAdminTableFilters">
    <tr>
      <td class="lpdAdminTableFiltersSearch">
		<?php echo JText::_('LPD_FILTER'); ?>
		<input type="text" name="search" value="<?php echo $this->lists['search'] ?>" class="text_area" title="<?php echo JText::_('LPD_FILTER_BY_NAME'); ?>"/>
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
        <th><?php echo JText::_('LPD_NUM'); ?></th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_NAME', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> </th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_PUBLISHED', 'published', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> </th>
        <th><?php echo JHTML::_('grid.sort', 'LPD_ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?> </th>
      </tr>
    </thead>
    <tbody>
      <?php	foreach ($this->rows as $key => $row): ?>
      <tr class="row<?php echo ($key%2); ?>">
        <td><?php echo $key+1; ?></td>
        <td><a style="cursor:pointer" onclick="window.parent.jSelectTag('<?php echo urlencode($row->name); ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', 'tag');"><?php echo $row->name; ?></a></td>
        <td><?php echo JHTML::_('grid.published', $row, $key ); ?></td>
        <td class="lpdCenter"><?php echo $row->id; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4"><?php echo $this->page->getListFooter(); ?></td>
      </tr>
    </tfoot>
  </table>
  <input type="hidden" name="option" value="com_lpd" />
  <input type="hidden" name="view" value="tags" />
  <input type="hidden" name="task" value="element" />
  <input type="hidden" name="tmpl" value="component" />
  <input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
  <?php echo JHTML::_( 'form.token' ); ?>
</form>