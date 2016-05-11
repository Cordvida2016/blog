<?php
/**
 * @version		$Id: profile.php 1206 2011-10-17 21:09:08Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!-- LPD user profile form -->
<form action="<?php echo JRoute::_('index.php'); ?>" enctype="multipart/form-data" method="post" name="userform" autocomplete="off" class="form-validate">
	<?php if($this->params->def('show_page_title',1)): ?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>
	<div id="lpdContainer" class="lpdAccountPage">
		<table class="admintable" cellpadding="0" cellspacing="0">
			<tr>
				<th colspan="2" class="lpdProfileHeading">
					<?php echo JText::_('LPD_ACCOUNT_DETAILS'); ?>
				</th>
			</tr>
			<tr>
				<td class="key">
					<label for="username"><?php echo JText::_('LPD_USER_NAME'); ?></label>
				</td>
				<td>
					<span><b><?php echo $this->user->get('username'); ?></b></span>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="namemsg" for="name"><?php echo JText::_('LPD_NAME'); ?></label>
				</td>
				<td>
					<input type="text" name="<?php echo (LPD_JVERSION=='16')?'jform[name]':'name'?>" id="name" size="40" value="<?php echo $this->escape($this->user->get( 'name' )); ?>" class="inputbox required" maxlength="50" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="emailmsg" for="email"><?php echo JText::_('LPD_EMAIL'); ?></label>
				</td>
				<td>
					<input type="text" id="email" name="<?php echo (LPD_JVERSION=='16')?'jform[email1]':'email'?>" size="40" value="<?php echo $this->escape($this->user->get( 'email' )); ?>" class="inputbox required validate-email" maxlength="100" />
				</td>
			</tr>
			<?php if(LPD_JVERSION == '16'): ?>
			<tr>
				<td class="key">
					<label id="email2msg" for="email2"><?php echo JText::_('LPD_CONFIRM_EMAIL'); ?></label>
				</td>
				<td>
					<input type="text" id="email2" name="jform[email2]" size="40" value="<?php echo $this->escape($this->user->get( 'email' )); ?>" class="inputbox required validate-email" maxlength="100" />
					*
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="key">
					<label id="pwmsg" for="password"><?php echo JText::_('LPD_PASSWORD'); ?></label>
				</td>
				<td>
					<input class="inputbox validate-password" type="password" id="password" name="<?php echo (LPD_JVERSION=='16')?'jform[password1]':'password'?>" size="40" value="" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="pw2msg" for="password2"><?php echo JText::_('LPD_VERIFY_PASSWORD'); ?></label>
				</td>
				<td>
					<input class="inputbox validate-passverify" type="password" id="password2" name="<?php echo (LPD_JVERSION=='16')?'jform[password2]':'password2'?>" size="40" value="" />
				</td>
			</tr>
			<tr>
				<th colspan="2" class="lpdProfileHeading">
					<?php echo JText::_('LPD_PERSONAL_DETAILS'); ?>
				</th>
			</tr>
			<!-- LPD attached fields -->
			<tr>
				<td class="key">
					<label id="gendermsg" for="gender"><?php echo JText::_('LPD_GENDER'); ?></label>
				</td>
				<td>
					<?php echo $this->lists['gender']; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="descriptionmsg" for="description"><?php echo JText::_('LPD_DESCRIPTION'); ?></label>
				</td>
				<td>
					<?php echo $this->editor; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="imagemsg" for="image"><?php echo JText::_( 'LPD_USER_IMAGE_AVATAR' ); ?></label>
				</td>
				<td>
					<input type="file" id="image" name="image"/>
					<?php if ($this->LPDUser->image): ?>
					<img class="lpdAccountPageImage" src="<?php echo JURI::root(true).'/media/lpd/users/'.$this->LPDUser->image; ?>" alt="<?php echo $this->user->name; ?>" />
					<input type="checkbox" name="del_image" id="del_image" />
					<label for="del_image"><?php echo JText::_('LPD_CHECK_THIS_BOX_TO_DELETE_CURRENT_IMAGE_OR_JUST_UPLOAD_A_NEW_IMAGE_TO_REPLACE_THE_EXISTING_ONE'); ?></label>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<label id="urlmsg" for="url"><?php echo JText::_('LPD_URL'); ?></label>
				</td>
				<td>
					<input type="text" size="50" value="<?php echo $this->LPDUser->url; ?>" name="url" id="url"/>
				</td>
			</tr>
			<?php if(count(array_filter($this->LPDPlugins))): ?>
			<!-- LPD Plugin attached fields -->
			<tr>
				<th colspan="2" class="lpdProfileHeading">
					<?php echo JText::_('LPD_ADDITIONAL_DETAILS'); ?>
				</th>
			</tr>
			<?php foreach($this->LPDPlugins as $LPDPlugin): ?>
			<?php if(!is_null($LPDPlugin)): ?>
			<tr>
				<td colspan="2">
					<?php echo $LPDPlugin->fields; ?>
				</td>
			</tr>
			<?php endif; ?>
			<?php endforeach; ?>
			<?php endif; ?>
			<?php if(isset($this->params) && LPD_JVERSION=='15'): ?>
			<tr>
				<th colspan="2" class="lpdProfileHeading">
					<?php echo JText::_('LPD_ADMINISTRATIVE_DETAILS'); ?>
				</th>
			</tr>
			<tr>
				<td colspan="2" id="userAdminParams">
					<?php echo $this->params->render('params'); ?>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<div class="lpdAccountPageUpdate">
			<button class="button validate" type="submit" onclick="submitbutton( this.form );return false;">
				<?php echo JText::_('LPD_SAVE'); ?>
			</button>
		</div>
	</div>
	<input type="hidden" name="<?php echo (LPD_JVERSION=='16')?'jform[username]':'username'?>" value="<?php echo $this->user->get('username'); ?>" />
	<input type="hidden" name="<?php echo (LPD_JVERSION=='16')?'jform[id]':'id'?>" value="<?php echo $this->user->get('id'); ?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid'); ?>" />
	<input type="hidden" name="option" value="<?php echo (LPD_JVERSION=='16')?'com_users':'com_user'?>" />
	<input type="hidden" name="task" value="<?php echo (LPD_JVERSION=='16')?'profile.save':'save'?>" />
	<input type="hidden" name="LPDUserForm" value="1" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
