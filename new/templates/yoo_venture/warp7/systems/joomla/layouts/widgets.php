<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// load widgets
$widgets = $this['widgets']->load($position);
$count   = count($widgets);
$output  = array();

foreach ($widgets as $index => $widget) {

	// set widget params
	$params           = array();
	$params['count']  = $count;
	$params['order']  = $index + 1;
	$params['first']  = $params['order'] == 1;
	$params['last']   = $params['order'] == $count;
	$params['suffix'] = $widget->parameter->get('moduleclass_sfx', '');

	// pass through menu params
	if (isset($menu)) {
		$params['menu'] = $menu;
		$widget->nav_settings = array();
	}

    $params = array_merge($params, $this['config']->get('widgets.'.$widget->id, array()));

	// render widget
	$output[] = $this->render('widget', compact('widget', 'params'));
}

// render widget layout
echo (isset($layout) && $layout) ? $this->render("grid/{$layout}", array('widgets' => $output)) : implode("\n", $output);