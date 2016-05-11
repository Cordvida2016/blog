<?php
/**
 * @version		$Id: default.php 1360 2011-11-25 18:27:12Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<form action="index.php" method="post" name="adminForm">
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%" id="lpdInfoPage">
		<tr>
			<td>
				<fieldset class="adminform">
					<legend><?php echo JText::_('LPD_ABOUT'); ?></legend>
					<div class="lpdTextBox"><?php echo JText::_('LPD_ABOUT_TEXT'); ?></div>
				</fieldset>

			  <fieldset class="adminform">
					<legend><?php echo JText::_('LPD_CREDITS'); ?></legend>
					<table class="adminlist">
						<thead>
			        <tr>
			        	<th><?php echo JText::_('LPD_PROVIDER'); ?></th>
			          <th><?php echo JText::_('LPD_VERSION'); ?></th>
			          <th><?php echo JText::_('LPD_TYPE'); ?></th>
			          <th><?php echo JText::_('LPD_LICENSE'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="4">&nbsp;</th>
			        </tr>
			      </tfoot>
					  <tbody>
					    <tr>
					      <td><a target="_blank" href="http://nuovext.pwsp.net/">NuoveXT</a></td>
					      <td>2.2</td>
					      <td><?php echo JText::_('LPD_ICONS'); ?></td>
					      <td><?php echo JText::_('LPD_GNUGPL'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://www.komodomedia.com/download/">Social Network Icon Pack &amp;<br />Social Media Mini Icon Pack<br />(by Komodo Media)</a></td>
					      <td><?php echo JText::_('LPD_NA'); ?></td>
					      <td><?php echo JText::_('LPD_ICONS'); ?></td>
					      <td><?php echo JText::_('LPD_CREATIVE_COMMONS_ATTRIBUTIONSHARE_ALIKE_30_UNPORTED_LICENSE'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://p.yusukekamiyamane.com/">Fugue Icons<br />(by Yusuke Kamiyamane)</a></td>
					      <td>2.9.4</td>
					      <td><?php echo JText::_('LPD_ICONS'); ?></td>
					      <td><?php echo JText::_('LPD_CREATIVE_COMMONS_ATTRIBUTION_30_LICENSE'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://www.iconarchive.com/artist/tpdkdesign.net.html">"Choose Your Sport" Icon Pack<br />(by TpdkDesign.net)</a></td>
					      <td><?php echo JText::_('LPD_NA'); ?></td>
					      <td><?php echo JText::_('LPD_ICONS'); ?></td>
					      <td><?php echo JText::_('LPD_INFO_FREE_LICENSE'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://pear.php.net/package/Services_JSON/">Services_JSON</a></td>
					      <td>1.0.1</td>
					      <td><?php echo JText::_('LPD_PHP_CLASS'); ?></td>
					      <td><?php echo JText::_('LPD_BSD'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://www.verot.net/php_class_upload.htm">class.upload.php</a></td>
					      <td>0.31</td>
					      <td><?php echo JText::_('LPD_PHP_CLASS'); ?></td>
					      <td><?php echo JText::_('LPD_GNUGPL'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://jquery.com">jQuery</a></td>
					      <td>1.5.x - 1.7.x</td>
					      <td><?php echo JText::_('LPD_JS_LIB'); ?></td>
					      <td><?php echo JText::_('LPD_MIT'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://jqueryui.com/">jQuery UI</a></td>
					      <td>1.8.16</td>
					      <td><?php echo JText::_('LPD_JS_LIB'); ?></td>
					      <td><?php echo JText::_('LPD_MIT'); ?></td>
					    </tr>
					    <tr>
					      <td><a target="_blank" href="http://elrte.org/elfinder">elFinder</a></td>
					      <td>2.0 (beta)</td>
					      <td><?php echo JText::_('LPD_INFO_FILE_MANAGER'); ?></td>
					      <td><?php echo JText::_('LPD_BSD'); ?></td>
					    </tr>
					  </tbody>
					</table>
				</fieldset>
			</td>
			<td>
			  <fieldset class="adminform">
			    <legend><?php echo JText::_('LPD_SYSTEM_INFORMATION'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('LPD_CHECK'); ?></th>
			          <th><?php echo JText::_('LPD_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_WEB_SERVER'); ?></strong></td>
			          <td><?php echo $this->server; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_PHP_VERSION'); ?></strong></td>
			          <td><?php echo $this->php_version; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_MYSQL_VERSION'); ?></strong></td>
			          <td><?php echo $this->db_version; ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_GD_IMAGE_LIBRARY'); ?></strong></td>
			          <td><?php if ($this->gd_check) {$gdinfo=gd_info(); echo $gdinfo["GD Version"];} else echo JText::_('LPD_DISABLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_MULTIBYTE_STRING_SUPPORT'); ?></strong></td>
			          <td><?php if ($this->mb_check) echo JText::_('LPD_ENABLED'); else echo JText::_('LPD_DISABLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_UPLOAD_LIMIT'); ?></strong></td>
			          <td><?php echo ini_get('upload_max_filesize'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_MEMORY_LIMIT'); ?></strong></td>
			          <td><?php echo ini_get('memory_limit'); ?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_OPEN_REMOTE_FILES_ALLOW_URL_FOPEN'); ?></strong></td>
			          <td><?php echo (ini_get('allow_url_fopen'))? JText::_('LPD_YES'):JText::_('LPD_NO'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>

			  <fieldset class="adminform">
			    <legend><?php echo JText::_('LPD_DIRECTORY_PERMISSIONS'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('LPD_CHECK'); ?></th>
			          <th><?php echo JText::_('LPD_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong>media/lpd</strong></td>
			          <td><?php if ($this->media_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/attachments</strong></td>
			          <td><?php if ($this->attachments_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/categories</strong></td>
			          <td><?php if ($this->categories_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/galleries</strong></td>
			          <td><?php if ($this->galleries_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/items</strong></td>
			          <td><?php if ($this->items_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/users</strong></td>
			          <td><?php if ($this->users_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>media/lpd/videos</strong></td>
			          <td><?php if ($this->videos_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>cache</strong></td>
			          <td><?php if ($this->cache_folder_check) echo JText::_('LPD_WRITABLE'); else echo JText::_('LPD_NOT_WRITABLE'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>

			  <fieldset class="adminform">
			    <legend><?php echo JText::_('LPD_MODULES'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('LPD_CHECK'); ?></th>
			          <th><?php echo JText::_('LPD_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong>mod_lpd_comments</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_comments')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_content</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_content')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_login</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_login')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_tools</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_tools')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_user</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_user')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_users</strong></td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_users')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_quickicons</strong> (administrator)</td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_quickicons')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>mod_lpd_stats</strong> (administrator)</td>
			          <td><?php echo (is_null(JModuleHelper::getModule('mod_lpd_stats')))?JText::_('LPD_NOT_INSTALLED'):JText::_('LPD_INSTALLED'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>

			  <fieldset class="adminform">
			    <legend><?php echo JText::_('LPD_PLUGINS'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('LPD_CHECK'); ?></th>
			          <th><?php echo JText::_('LPD_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong>System - LPD</strong></td>
			          <td><?php echo (JFile::exists(JPATH_PLUGINS.DS.'system'.DS.'lpd.php') || JFile::exists(JPATH_PLUGINS.DS.'system'.DS.'lpd'.DS.'lpd.php'))?JText::_('LPD_INSTALLED'):JText::_('LPD_NOT_INSTALLED'); ?> - <?php echo (JPluginHelper::isEnabled('system', 'lpd'))?JText::_('LPD_ENABLED'):JText::_('LPD_DISABLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>User - LPD</strong></td>
			          <td><?php echo (JFile::exists(JPATH_PLUGINS.DS.'user'.DS.'lpd.php') || JFile::exists(JPATH_PLUGINS.DS.'user'.DS.'lpd'.DS.'lpd.php'))?JText::_('LPD_INSTALLED'):JText::_('LPD_NOT_INSTALLED'); ?> - <?php echo (JPluginHelper::isEnabled('user', 'lpd'))?JText::_('LPD_ENABLED'):JText::_('LPD_DISABLED'); ?></td>
			        </tr>
			        <tr>
			          <td><strong>Search - LPD</strong></td>
			          <td><?php echo (JFile::exists(JPATH_PLUGINS.DS.'search'.DS.'lpd.php') || JFile::exists(JPATH_PLUGINS.DS.'search'.DS.'lpd'.DS.'lpd.php'))?JText::_('LPD_INSTALLED'):JText::_('LPD_NOT_INSTALLED'); ?> - <?php echo (JPluginHelper::isEnabled('search', 'lpd'))?JText::_('LPD_ENABLED'):JText::_('LPD_DISABLED'); ?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>

			  <fieldset class="adminform">
			    <legend><?php echo JText::_('LPD_THIRDPARTY_PLUGIN_INFORMATION'); ?></legend>
			    <table class="adminlist">
			      <thead>
			        <tr>
			          <th><?php echo JText::_('LPD_CHECK'); ?></th>
			          <th><?php echo JText::_('LPD_RESULT'); ?></th>
			        </tr>
			      </thead>
			      <tfoot>
			        <tr>
			          <th colspan="2">&nbsp;</th>
			        </tr>
			      </tfoot>
			      <tbody>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_ALLVIDEOS_PLUGIN'); ?></strong></td>
			          <td><?php
							if (JFile::exists(JPATH_PLUGINS.DS.'content'.DS.'jw_allvideos.php') || JFile::exists(JPATH_PLUGINS.DS.'content'.DS.'jw_allvideos'.DS.'jw_allvideos.php'))
								echo JText::_('LPD_INSTALLED');
							else
								echo JText::_('LPD_NOT_INSTALLED');
						?></td>
			        </tr>
			        <tr>
			          <td><strong><?php echo JText::_('LPD_SIMPLE_IMAGE_GALLERY_PRO_PLUGIN'); ?></strong></td>
			          <td><?php
							if (JFile::exists(JPATH_PLUGINS.DS.'content'.DS.'jw_sigpro.php') || JFile::exists(JPATH_PLUGINS.DS.'content'.DS.'jw_sigpro'.DS.'jw_sigpro.php'))
								echo JText::_('LPD_INSTALLED');
							else
								echo JText::_('LPD_NOT_INSTALLED');
						?></td>
			        </tr>
			      </tbody>
			    </table>
			  </fieldset>
			</td>
		</tr>
	</table>
</form>
