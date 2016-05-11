<?php
/**
 * @version		$Id: latest_item.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!-- Start LPD Item Layout -->
<div class="latestItemView">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- LPD Plugins: LPDBeforeDisplay -->
	<?php echo $this->item->event->LPDBeforeDisplay; ?>

	<div class="latestItemHeader">
	  <?php if($this->item->params->get('latestItemTitle')): ?>
	  <!-- Item title -->
	  <h2 class="latestItemTitle">
	  	<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
			<a href="<?php echo $this->item->link; ?>">
	  		<?php echo $this->item->title; ?>
	  	</a>
	  	<?php else: ?>
	  	<?php echo $this->item->title; ?>
	  	<?php endif; ?>
	  </h2>
	  <?php endif; ?>
  </div>
  
	<?php if($this->item->params->get('latestItemDateCreated')): ?>
	<!-- Date created -->
	<span class="latestItemDateCreated">
		<?php echo JHTML::_('date', $this->item->created , JText::_('LPD_DATE_FORMAT_LC2')); ?>
	</span>
	<?php endif; ?>

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- LPD Plugins: LPDAfterDisplayTitle -->
  <?php echo $this->item->event->LPDAfterDisplayTitle; ?>

  <div class="latestItemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- LPD Plugins: LPDBeforeDisplayContent -->
	  <?php echo $this->item->event->LPDBeforeDisplayContent; ?>

	  <?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="latestItemImageBlock">
		  <span class="latestItemImage">
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo LPDHelperUtilities::cleanHtml($this->item->image_caption); else echo LPDHelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo LPDHelperUtilities::cleanHtml($this->item->image_caption); else echo LPDHelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
		    </a>
		  </span>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('latestItemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="latestItemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- LPD Plugins: LPDAfterDisplayContent -->
	  <?php echo $this->item->event->LPDAfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

  <?php if($this->item->params->get('latestItemCategory') || $this->item->params->get('latestItemTags')): ?>
  <div class="latestItemLinks">

		<?php if($this->item->params->get('latestItemCategory')): ?>
		<!-- Item category name -->
		<div class="latestItemCategory">
			<span><?php echo JText::_('LPD_PUBLISHED_IN'); ?></span>
			<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
		</div>
		<?php endif; ?>

	  <?php if($this->item->params->get('latestItemTags') && count($this->item->tags)): ?>
	  <!-- Item tags -->
	  <div class="latestItemTagsBlock">
		  <span><?php echo JText::_('LPD_TAGGED_UNDER'); ?></span>
		  <ul class="latestItemTags">
		    <?php foreach ($this->item->tags as $tag): ?>
		    <li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
		    <?php endforeach; ?>
		  </ul>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>
  </div>
  <?php endif; ?>

	<div class="clr"></div>

  <?php if($this->params->get('latestItemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <div class="latestItemVideoBlock">
  	<h3><?php echo JText::_('LPD_RELATED_VIDEO'); ?></h3>
	  <span class="latestItemVideo<?php if($this->item->videoType=='embedded'): ?> embedded<?php endif; ?>"><?php echo $this->item->video; ?></span>
  </div>
  <?php endif; ?>

	<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
	<!-- Anchor link to comments below -->
	<div class="latestItemCommentsLink">
		<?php if(!empty($this->item->event->LPDCommentsCounter)): ?>
			<!-- LPD Plugins: LPDCommentsCounter -->
			<?php echo $this->item->event->LPDCommentsCounter; ?>
		<?php else: ?>
			<?php if($this->item->numOfComments > 0): ?>
			<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
				<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('LPD_COMMENTS') : JText::_('LPD_COMMENT'); ?>
			</a>
			<?php else: ?>
			<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
				<?php echo JText::_('LPD_BE_THE_FIRST_TO_COMMENT'); ?>
			</a>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php endif; ?>

	<?php if ($this->item->params->get('latestItemReadMore')): ?>
	<!-- Item "read more..." link -->
	<div class="latestItemReadMore">
		<a class="lpdReadMore" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('LPD_READ_MORE'); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="clr"></div>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- LPD Plugins: LPDAfterDisplay -->
  <?php echo $this->item->event->LPDAfterDisplay; ?>

	<div class="clr"></div>
</div>
<!-- End LPD Item Layout -->
