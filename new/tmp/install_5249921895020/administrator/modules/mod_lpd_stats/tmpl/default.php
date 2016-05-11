<?php
/**
* @version		$Id: default.php 1341 2011-11-25 16:30:00Z lefteris.kavadas $
* @package		LPD (based on K2)
* @author		JoomlaWorks http://www.joomlaworks.gr
* @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.pane'); 

?>

<?php $pane =& JPane::getInstance('Tabs'); ?>

<div class="clr"></div>

<?php echo $pane->startPane('myPane'); ?>

<?php if($params->get('latestItems', 1)): ?>
<?php echo $pane->startPanel(JText::_('LPD_LATEST_ITEMS'), 'latestItemsTab'); ?>
<!--[if lte IE 7]>
<br class="ie7fix" />
<![endif]-->
<table class="adminlist">
	<thead>
		<tr>
			<td class="title"><?php echo JText::_('LPD_TITLE'); ?></td>
			<td class="title"><?php echo JText::_('LPD_CREATED'); ?></td>
			<td class="title"><?php echo JText::_('LPD_AUTHOR'); ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($latestItems as $latest): ?>
		<tr>
			<td><a href="<?php echo JRoute::_('index.php?option=com_lpd&view=item&cid='.$latest->id); ?>"><?php echo $latest->title; ?></a></td>
			<td><?php echo JHTML::_('date', $latest->created , JText::_('LPD_DATE_FORMAT')); ?></td>
			<td><?php echo $latest->author; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php echo $pane->endPanel(); ?>
<?php endif; ?>

<?php if($params->get('popularItems', 1)): ?>
<?php echo $pane->startPanel(JText::_('LPD_POPULAR_ITEMS'), 'popularItemsTab'); ?>
<!--[if lte IE 7]>
<br class="ie7fix" />
<![endif]-->
<table class="adminlist">
	<thead>
		<tr>
			<td class="title"><?php echo JText::_('LPD_TITLE'); ?></td>
			<td class="title"><?php echo JText::_('LPD_HITS'); ?></td>
			<td class="title"><?php echo JText::_('LPD_CREATED'); ?></td>
			<td class="title"><?php echo JText::_('LPD_AUTHOR'); ?></td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($popularItems as $popular): ?>
		<tr>
			<td><a href="<?php echo JRoute::_('index.php?option=com_lpd&view=item&cid='.$popular->id); ?>"><?php echo $popular->title; ?></a></td>
			<td><?php echo $popular->hits; ?></td>
			<td><?php echo JHTML::_('date', $popular->created , JText::_('LPD_DATE_FORMAT')); ?></td>
			<td><?php echo $popular->author; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php echo $pane->endPanel(); ?>
<?php endif; ?>

<?php if($params->get('statistics', 1)): ?>
<?php echo $pane->startPanel(JText::_('LPD_STATISTICS'), 'statsTab'); ?>
<!--[if lte IE 7]>
<br class="ie7fix" />
<![endif]-->
<table class="adminlist">
	<thead>
		<tr>
			<td class="title"><?php echo JText::_('LPD_TYPE'); ?></td>
			<td class="title"><?php echo JText::_('LPD_COUNT'); ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo JText::_('LPD_ITEMS'); ?></td>
			<td><?php echo $statistics->numOfItems; ?> (<?php echo $statistics->numOfFeaturedItems.' '.JText::_('LPD_FEATURED').' - '.$statistics->numOfTrashedItems.' '.JText::_('LPD_TRASHED'); ?>)</td>
		</tr>
		<tr>
			<td><?php echo JText::_('LPD_CATEGORIES'); ?></td>
			<td><?php echo $statistics->numOfCategories; ?> (<?php echo $statistics->numOfTrashedCategories.' '.JText::_('LPD_TRASHED'); ?>)</td>
		</tr>
	</tbody>
</table>
<?php echo $pane->endPanel(); ?>
<?php endif; ?>

<?php echo $pane->endPane(); ?>
