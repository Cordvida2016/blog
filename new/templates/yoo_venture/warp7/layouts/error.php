<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>" class="uk-height-100">

<head>
	<title><?php echo $error; ?> - <?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo ($this['config']->get('direction') == 'ltr' ? $this['path']->url('css:theme.css') : $this['path']->url('css:theme-rtl.css')); ?>">
</head>

<body class="uk-height-100 uk-vertical-align uk-text-center">

	<div class="uk-vertical-align-middle uk-container-center">

		<i class="tm-error-icon uk-icon-frown"></i>

		<h1 class="tm-error-headline"><?php echo $error; ?></h1>

		<h2 class="uk-h3 uk-text-muted"><?php echo $title; ?></h2>
		
		<p><?php echo $message; ?></p>

	</div>

</body>
</html>