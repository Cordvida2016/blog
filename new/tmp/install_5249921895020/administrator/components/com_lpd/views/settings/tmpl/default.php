<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<form action="index.php" method="post" name="adminForm">
	<fieldset>
		<div style="float:right;">
			<button onclick="submitbutton('save');window.top.setTimeout('window.parent.document.getElementById(\'sbox-window\').close()', 700);" type="button"><?php echo JText::_('LPD_SAVE'); ?></button>
			<button onclick="window.parent.document.getElementById('sbox-window').close();" type="button"><?php echo JText::_('LPD_CANCEL'); ?></button>
		</div>
		<div class="configuration">
			<?php echo JText::_('LPD_PARAMETERS')?>
		</div>
		<div class="clr"></div>
	</fieldset>
	<?php echo $this->pane->startPane('settings'); ?>
	<?php foreach($this->params->getGroups() as $group=>$value): ?>
	<?php echo $this->pane->startPanel(JText::_($group), $group.'-tab'); ?>
	<?php echo $this->params->render('params', $group); ?>
	<?php echo $this->pane->endPanel(); ?>
	<?php endforeach; ?>
	<?php echo $this->pane->endPane(); ?>
	
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="settings" />
	<input type="hidden" id="task" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>
