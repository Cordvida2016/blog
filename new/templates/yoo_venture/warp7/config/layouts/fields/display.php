<?php
/**
* @package   Warp Theme Framework
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/
    $show_medium = isset($value['medium']) ? $value['medium'] : "1";
    $show_small  = isset($value['small']) ? $value['small'] : "1";
    $show_mini   = isset($value['mini']) ? $value['mini'] : "1";
?>
<ul data-list-devices class="uk-list tm-list-devices">
    <li class="tm-icon-medium"><a href="#"><input type="hidden" name="<?php echo $name."[medium]";?>" value="<?php echo $show_medium;?>"></a></li>
    <li class="tm-icon-small"><a class="" href="#"><input type="hidden" name="<?php echo $name."[small]";?>" value="<?php echo $show_small;?>"></a></li>
    <li class="tm-icon-mini"><a href="#"><input type="hidden" name="<?php echo $name."[mini]";?>" value="<?php echo $show_mini;?>"></a></li>
</ul>