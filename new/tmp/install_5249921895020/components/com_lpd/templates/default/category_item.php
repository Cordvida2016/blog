<?php
/**
 * @version		$Id: category_item.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Define default image size (do not change)
LPDHelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>

<!-- Start LPD Item Layout -->
<div class="catItemView group<?php echo ucfirst($this->item->itemGroup); ?><?php echo ($this->item->featured) ? ' catItemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- LPD Plugins: LPDBeforeDisplay -->
	<?php echo $this->item->event->LPDBeforeDisplay; ?>

	<div class="catItemHeader">
		<?php if($this->item->params->get('catItemDateCreated')): ?>
		<!-- Date created -->
		<span class="catItemDateCreated">
			<?php echo JHTML::_('date', $this->item->created , JText::_('LPD_DATE_FORMAT_LC2')); ?>
		</span>
		<?php endif; ?>

	  <?php if($this->item->params->get('catItemTitle')): ?>
	  <!-- Item title -->
	  <h3 class="catItemTitle">
			<?php if(isset($this->item->editLink)): ?>
			<!-- Item edit link -->
			<span class="catItemEditLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
					<?php echo JText::_('LPD_EDIT_ITEM'); ?>
				</a>
			</span>
			<?php endif; ?>

	  	<?php if ($this->item->params->get('catItemTitleLinked')): ?>
			<a href="<?php echo $this->item->link; ?>">
	  		<?php echo $this->item->title; ?>
	  	</a>
	  	<?php else: ?>
	  	<?php echo $this->item->title; ?>
	  	<?php endif; ?>

	  	<?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
	  	<!-- Featured flag -->
	  	<span>
		  	<sup>
		  		<?php echo JText::_('LPD_FEATURED'); ?>
		  	</sup>
	  	</span>
	  	<?php endif; ?>
	  </h3>
	  <?php endif; ?>

		<?php if($this->item->params->get('catItemAuthor')): ?>
		<!-- Item Author -->
		<span class="catItemAuthor">
			<?php echo LPDHelperUtilities::writtenBy($this->item->author->profile->gender); ?> <a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
		</span>
		<?php endif; ?>
  </div>

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- LPD Plugins: LPDAfterDisplayTitle -->
  <?php echo $this->item->event->LPDAfterDisplayTitle; ?>

	<?php if($this->item->params->get('catItemRating')): ?>
	<!-- Item Rating -->
	<div class="catItemRatingBlock">
		<span><?php echo JText::_('LPD_RATE_THIS_ITEM'); ?></span>
		<div class="itemRatingForm">
			<ul class="itemRatingList">
				<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('LPD_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('LPD_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('LPD_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('LPD_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('LPD_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
			</ul>
			<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

  <div class="catItemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- LPD Plugins: LPDBeforeDisplayContent -->
	  <?php echo $this->item->event->LPDBeforeDisplayContent; ?>

	  <?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="catItemImageBlock">
		  <span class="catItemImage">
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo LPDHelperUtilities::cleanHtml($this->item->image_caption); else echo LPDHelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo LPDHelperUtilities::cleanHtml($this->item->image_caption); else echo LPDHelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" />
		    </a>
		  </span>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('catItemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="catItemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>

	  <?php if($this->item->params->get('catItemExtraFields') && count($this->item->extra_fields)): ?>
	  <!-- Item extra fields -->
	  <div class="catItemExtraFields">
	  	<h4><?php echo JText::_('LPD_ADDITIONAL_INFO'); ?></h4>
	  	<ul>
			<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
			<?php if($extraField->value): ?>
			<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
				<span class="catItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
				<span class="catItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
			</li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
	    <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- LPD Plugins: LPDAfterDisplayContent -->
	  <?php echo $this->item->event->LPDAfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

  <?php if(
  $this->item->params->get('catItemHits') ||
  $this->item->params->get('catItemCategory') ||
  $this->item->params->get('catItemTags') ||
  $this->item->params->get('catItemAttachments')
  ): ?>
  <div class="catItemLinks">

		<?php if($this->item->params->get('catItemHits')): ?>
		<!-- Item Hits -->
		<div class="catItemHitsBlock">
			<span class="catItemHits">
				<?php echo JText::_('LPD_READ'); ?> <b><?php echo $this->item->hits; ?></b> <?php echo JText::_('LPD_TIMES'); ?>
			</span>
		</div>
		<?php endif; ?>

		<?php if($this->item->params->get('catItemCategory')): ?>
		<!-- Item category name -->
		<div class="catItemCategory">
			<span><?php echo JText::_('LPD_PUBLISHED_IN'); ?></span>
			<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
		</div>
		<?php endif; ?>

	  <?php if($this->item->params->get('catItemTags') && count($this->item->tags)): ?>
	  <!-- Item tags -->
	  <div class="catItemTagsBlock">
		  <span><?php echo JText::_('LPD_TAGGED_UNDER'); ?></span>
		  <ul class="catItemTags">
		    <?php foreach ($this->item->tags as $tag): ?>
		    <li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
		    <?php endforeach; ?>
		  </ul>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

	  <?php if($this->item->params->get('catItemAttachments') && count($this->item->attachments)): ?>
	  <!-- Item attachments -->
	  <div class="catItemAttachmentsBlock">
		  <span><?php echo JText::_('LPD_DOWNLOAD_ATTACHMENTS'); ?></span>
		  <ul class="catItemAttachments">
		    <?php foreach ($this->item->attachments as $attachment): ?>
		    <li>
			    <a title="<?php echo LPDHelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
			    	<?php echo $attachment->title ; ?>
			    </a>
			    <?php if($this->item->params->get('catItemAttachmentsCounter')): ?>
			    <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('LPD_DOWNLOAD') : JText::_('LPD_DOWNLOADS'); ?>)</span>
			    <?php endif; ?>
		    </li>
		    <?php endforeach; ?>
		  </ul>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>
  </div>
  <?php endif; ?>

	<div class="clr"></div>

  <?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <div class="catItemVideoBlock">
  	<h3><?php echo JText::_('LPD_RELATED_VIDEO'); ?></h3>
		<?php if($this->item->videoType=='embedded'): ?>
		<div class="catItemVideoEmbedded">
			<?php echo $this->item->video; ?>
		</div>
		<?php else: ?>
		<span class="catItemVideo"><?php echo $this->item->video; ?></span>
		<?php endif; ?>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)): ?>
  <!-- Item image gallery -->
  <div class="catItemImageGallery">
	  <h4><?php echo JText::_('LPD_IMAGE_GALLERY'); ?></h4>
	  <?php echo $this->item->gallery; ?>
  </div>
  <?php endif; ?>

  <div class="clr"></div>

	<?php if($this->item->params->get('catItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
	<!-- Anchor link to comments below -->
	<div class="catItemCommentsLink">
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

	<?php if ($this->item->params->get('catItemReadMore')): ?>
	<!-- Item "read more..." link -->
	<div class="catItemReadMore">
		<a class="lpdReadMore" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('LPD_READ_MORE'); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="clr"></div>

	<?php if($this->item->params->get('catItemDateModified')): ?>
	<!-- Item date modified -->
	<?php if($this->item->modified != $this->nullDate && $this->item->modified != $this->item->created ): ?>
	<span class="catItemDateModified">
		<?php echo JText::_('LPD_LAST_MODIFIED_ON'); ?> <?php echo JHTML::_('date', $this->item->modified, JText::_('LPD_DATE_FORMAT_LC2')); ?>
	</span>
	<?php endif; ?>
	<?php endif; ?>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- LPD Plugins: LPDAfterDisplay -->
  <?php echo $this->item->event->LPDAfterDisplay; ?>

	<div class="clr"></div>
</div>
<!-- End LPD Item Layout -->
