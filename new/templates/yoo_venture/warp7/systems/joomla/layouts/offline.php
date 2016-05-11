<?php 
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;
$app = JFactory::getApplication();

?>

<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>" class="uk-height-100">

<head>
	<title><?php echo $error; ?> - <?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo ($this['config']->get('direction') == 'ltr' ? $this['path']->url('css:theme.css') : $this['path']->url('css:theme-rtl.css')); ?>">
</head>

<body class="uk-height-100 uk-vertical-align uk-text-center">

	<div class="tm-offline uk-panel uk-panel-box uk-vertical-align-middle uk-container-center">

		<h1><?php echo $error; ?></h1>

		<p class="uk-text-large uk-text-muted"><?php echo $title; ?></p>

		<?php if ($app->getCfg('display_offline_message', 1) == 1 && str_replace(' ', '', $app->getCfg('offline_message')) != '') : ?>
			
			<p><?php echo $app->getCfg('offline_message'); ?></p>

		<?php elseif ($app->getCfg('display_offline_message', 1) == 2 && str_replace(' ', '', $message) != '') : ?>
			
			<p><?php echo $message; ?></p>

		<?php endif; ?>

		<form class="uk-form" action="<?php echo JRoute::_('index.php', true); ?>" method="post">

			<div class="uk-form-row">
				<input class="uk-width-100" type="text" name="username" placeholder="<?php echo JText::_('JGLOBAL_USERNAME') ?>">
			</div>

			<div class="uk-form-row">
				<input class="uk-width-100" type="password" name="password" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>">
			</div>

			<div class="uk-form-row">
				<input class="uk-button uk-button-primary uk-width-100" type="submit" name="Submit" value="<?php echo JText::_('JLOGIN') ?>">
			</div>

			<div class="uk-form-row">
				<div class="uk-form-controls">
					<input type="checkbox" name="remember" value="yes" placeholder="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>">
					<label for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
				</div>
			</div>

			<input type="hidden" name="option" value="com_users">
			<input type="hidden" name="task" value="user.login">
			<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>">
			<?php echo JHtml::_('form.token'); ?>

		</form>

	</div>

</body>
</html>