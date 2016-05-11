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

$document = & JFactory::getDocument();
$document->addScriptDeclaration("
	Joomla.submitbutton = function(pressbutton){
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if (\$LPD.trim(\$LPD('#name').val())=='') {
			alert( '".JText::_('LPD_TAG_CANNOT_BE_EMPTY', true)."' );
		} else {
			submitform( pressbutton );
		}
	}
");

?>

<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table class="admintable">
		<tr>
			<td class="key"><?php echo JText::_('LPD_NAME'); ?></td>
			<td><input class="text_area lpdTitleBox" type="text" name="name" id="name" value="<?php echo $this->row->name; ?>" size="50" maxlength="250" /></td>
		</tr>
		<tr>
			<td class="key"><?php	echo JText::_('LPD_PUBLISHED');	?></td>
			<td><?php echo $this->lists['published']; ?></td>
		</tr>
	</table>

	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="tag" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
