<?php
/**
 * @version		$Id: move.php 1203 2011-10-17 19:15:39Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset style="float:left;">
		<legend><?php echo JText::_('LPD_TARGET_JOOMLA_USER_GROUP'); ?></legend>
		<?php echo $this->lists['group']; ?>
	</fieldset>
	<fieldset style="float:left;">
		<legend><?php echo JText::_('LPD_TARGET_LPD_USER_GROUP'); ?></legend>
		<?php echo $this->lists['lpdgroup']; ?>
	</fieldset>
	<fieldset style="clear:both;">
		<legend><?php echo JText::_('LPD_USERS_BEING_MOVED'); ?></legend>
		<ol>
			<?php foreach ($this->rows as $row): ?>
			<li>
				<?php echo $row->name; ?>
				<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
			</li>
			<?php endforeach; ?>
		</ol>
	</fieldset>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
