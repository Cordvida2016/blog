<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

switch (count($widgets)) {

	case 1:
		printf('<div class="uk-width-100">%s</div>', $widgets[0]);
		break;

	case 2:
		printf('<div class="uk-width-50">%s</div>', $widgets[0]);
		printf('<div class="uk-width-50">%s</div>', $widgets[1]);
		break;

	case 3:
		printf('<div class="uk-width-33">%s</div>', $widgets[0]);
		printf('<div class="uk-width-33">%s</div>', $widgets[1]);
		printf('<div class="uk-width-33">%s</div>', $widgets[2]);
		break;

	case 4:
		printf('<div class="uk-width-25">%s</div>', $widgets[0]);
		printf('<div class="uk-width-25">%s</div>', $widgets[1]);
		printf('<div class="uk-width-25">%s</div>', $widgets[2]);
		printf('<div class="uk-width-25">%s</div>', $widgets[3]);
		break;

	case 5:
		printf('<div class="uk-width-20">%s</div>', $widgets[0]);
		printf('<div class="uk-width-20">%s</div>', $widgets[1]);
		printf('<div class="uk-width-20">%s</div>', $widgets[2]);
		printf('<div class="uk-width-20">%s</div>', $widgets[3]);
		printf('<div class="uk-width-20">%s</div>', $widgets[4]);
		break;

	default:
		echo '<div class="uk-width-100">Error: Only up to 5 widgets are supported in this layout. If you need more add your own layout.</div>';

}