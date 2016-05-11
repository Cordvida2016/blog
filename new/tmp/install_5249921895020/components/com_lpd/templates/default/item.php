<?php
/**
 * @version		$Id: item.php 2012-01-01 00:00:00 audox $
 * @package		LPD (based on K2)
 * @author		Audox Ingeniería Ltda http://www.audox.cl
 * @copyright	Copyright (c) 2012 Audox Ingeniería Ltda. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>


<!-- Start Landing/Conversion Page Layout -->
<?php if($this->item->typeid==0) : ?>

<!-- Start GWO Control Script -->
<?php echo $this->item->gwocontrolscript; ?>

<!-- End GWO Control Script -->
<?php endif; ?>

<!-- Start Item Text -->
<?php echo $this->item->introtext; ?>

<!-- End Item Text -->

<?php if($this->item->typeid==0) : ?>
<!-- Start GWO Tracking Script -->
<?php echo $this->item->gwotrackingscript; ?>

<!-- End GWO Tracking Script -->
<?php endif; ?>
<?php if($this->item->typeid==1) : ?>
<!-- Start GWO Conversion Script -->
<?php echo $this->item->gwoconversionscript; ?>

<!-- End GWO Conversion Script -->
<?php endif; ?>

<!-- End Landing/Conversion Page Layout -->
