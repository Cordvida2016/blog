<?php
/**
 * @version		$Id: move.php 1251 2011-10-19 17:50:13Z joomlaworks $
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
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (\$LPD.trim(\$LPD('#category').val()) == '') {
			alert( '".JText::_('LPD_YOU_MUST_SELECT_A_PARENT_CATEGORY', true)."' );
		} else {
			submitform( pressbutton );
		}
	}
");

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset>
		<legend><?php echo JText::_('LPD_PARENT_CATEGORY'); ?></legend>
		<?php echo $this->lists['categories']; ?>
	</fieldset>
	<fieldset>
		<legend><?php echo JText::_('LPD_CATEGORIES_BEING_MOVED'); ?></legend>
		<ol>
			<?php foreach ($this->rows as $row): ?>
			<li><?php echo $row->name; ?><input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" /></li>
			<?php endforeach; ?>
		</ol>
	</fieldset>
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="<?php echo JRequest::getVar('view'); ?>" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
</form>
