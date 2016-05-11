<?php
/**
 * @version		$Id: default.php 1336 2011-11-25 14:45:04Z lefteris.kavadas $
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
		if (\$LPD.trim(\$LPD('#name').val()) == '') {
			alert( '".JText::_('LPD_A_CATEGORY_MUST_AT_LEAST_HAVE_A_TITLE', true)."' );
		} else {
			submitform( pressbutton );
		}
	}
");

?>

<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
	<table cellspacing="0" cellpadding="0" border="0" class="adminFormLPDContainer adminLPDCategory">
		<tbody>
			<tr>
				<td>
					<table class="adminFormLPD">
						<tr>
							<td class="adminLPDLeftCol">
								<label for="name"><?php echo JText::_('LPD_TITLE'); ?></label>
							</td>
							<td class="adminLPDRightCol">
								<input class="text_area lpdTitleBox" type="text" name="name" id="name" value="<?php echo $this->row->name; ?>" maxlength="250" />
							</td>
						</tr>
						<tr>
							<td class="adminLPDLeftCol">
								<label for="alias"><?php echo JText::_('LPD_TITLE_ALIAS'); ?></label>
							</td>
							<td class="adminLPDRightCol">
								<input class="text_area lpdTitleAliasBox" type="text" name="alias" value="<?php echo $this->row->alias; ?>" maxlength="250" />
							</td>
						</tr>
						<tr>
							<td class="adminLPDLeftCol">
								<label for="parent"><?php echo JText::_('LPD_PARENT_CATEGORY'); ?></label>
							</td>
							<td class="adminLPDRightCol">
								<?php echo $this->lists['parent']; ?>
							</td>
						</tr>
						<tr>
							<td class="adminLPDLeftCol">
								<label><?php echo JText::_('LPD_PUBLISHED');	?></label>
							</td>
							<td class="adminLPDRightCol lpdRadioButtonContainer">
								<?php echo $this->lists['published']; ?>
							</td>
						</tr>
						<tr>
							<td class="adminLPDLeftCol">
								<label for="access"><?php echo JText::_('LPD_ACCESS_LEVEL'); ?></label>
							</td>
							<td class="adminLPDRightCol">
								<?php echo $this->lists['access']; ?>
							</td>
						</tr>
						<?php if(isset($this->lists['language'])): ?>
						<tr>
							<td class="adminLPDLeftCol">
								<label><?php echo JText::_('LPD_LANGUAGE'); ?></label>
							</td>
							<td class="adminLPDRightCol">
								<?php echo $this->lists['language']; ?>
							</td>
						</tr>
						<?php endif; ?>
					</table>
					
					<!-- Tabs start here -->
					<div class="simpleTabs" id="lpdTabs">
						
						<!-- Tab content -->
						<div class="simpleTabsContent" id="lpdTab1">
							<div class="lpdItemFormEditor"> <span class="lpdItemFormEditorTitle"> <?php echo JText::_('LPD_CATEGORY_DESCRIPTION'); ?> </span> <?php echo $this->editor; ?>
								<div class="dummyHeight"></div>
								<div class="clr"></div>
							</div>
							<div class="clr"></div>
						</div>
						
					</div>
					<!-- Tabs end here --> 
					
					<div class="clr"></div>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
	<input type="hidden" name="option" value="com_lpd" />
	<input type="hidden" name="view" value="category" />
	<input type="hidden" name="task" value="<?php echo JRequest::getVar('task'); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
