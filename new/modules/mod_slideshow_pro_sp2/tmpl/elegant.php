<?php
/*
# ------------------------------------------------------------------------
# SlideShow Pro SP2 module for Joomla 2.5.x and 3.x
# ------------------------------------------------------------------------
# Copyright (C) 2010 - 2013 JoomShaper.com. All Rights Reserved.
# @license - PHP files are GNU/GPL V2. CSS / JS are Copyrighted Commercial,
# Author: JoomShaper.com
# Websites:  http://www.joomshaper.com
# Redistribution, Modification or Re-licensing of this file in part of full, 
# is bound by the License applied. 
# ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$pre_src='';
?>
<script type="text/javascript">
//<![CDATA[
window.addEvent('domready', function() {
	var spSlide<?php echo $uniqid ?> = new slideshow_sp2($('sp-slide<?php echo $uniqid ?>'), {
		size: {width: <?php echo $width; ?>, height: <?php echo $slide_height; ?>},
		interval: <?php echo $interval ?>,
		fxOptions: {duration:  <?php echo $speed; ?>, transition: Fx.Transitions.<?php echo $transition; ?>},
		transition: <?php echo "'" .$effects. "'"; ?>,
		walkers: {
			container: $('handlers<?php echo $uniqid ?>'),
			depth:<?php echo $thumb_width ?>,
			wmode:'horizontal',
			mouse_wheel: <?php echo $mouse_wheel ?>,
			display:<?php echo $maxitem ?>
		},
		
		descriptions: {
			items: document.getElements('#sp-slide<?php echo $uniqid ?> div.sp-slide-desc'),
			descmode:'horizontal'
		},
		
		onWalk: function (i, j) {
			this.walkers.items.removeClass('active');
			this.walkers.items[i].addClass('active');
		},
		onInitialized: function () {
			this.walkers.items[0].addClass('active');
		}		
	});

	var images = [
		<?php 
			foreach ($list as $item) {
				$pre_src .= '"' . $item->image . '",';
			}		
			$pre_src=rtrim($pre_src,',');
			echo $pre_src;
		?>	
	];
	var images_elements = document.getElements('#sp-slide<?php echo $uniqid ?> img');

	var loader = Asset.images(images, {
		onComplete: function () {
			document.id('sp-preload<?php echo $uniqid ?>').style.visibility='hidden';
			spSlide<?php echo $uniqid ?>.play();
		},

		onProgress: function (i) {
			images_elements[i-1].src = images[i-1];
		}
	});
	<?php if ($showarrows) {?>
		spSlide<?php echo $uniqid ?>.addPlayerControls('previous', [$('prev<?php echo $uniqid;?>')]);
		spSlide<?php echo $uniqid ?>.addPlayerControls('next', [$('next<?php echo $uniqid;?>')]);
	<?php } ?>		
	
});
//]]>
</script>
<div class="sp-slide" style="position:relative;height:<?php echo $height ?>px">
	<div id="sp-preload<?php echo $uniqid ?>" class="preload" style="position:absolute;height:<?php echo $height ?>px;width:<?php echo $width ?>px"></div>
	<div id="sp-slide<?php echo $uniqid ?>" style="overflow:hidden;position:relative;height:<?php echo $height ?>px;width:<?php echo $width ?>px">
		<?php foreach ($list as $item): ?>
			<div class="sp-slide-content">
				<div class="image-block" style="width:<?php echo $width ?>px;height:<?php echo $slide_height ?>px">
					<?php if($imagelinked) { ?>
						<a href="<?php echo $item->link ?>"><img src="<?php echo $item->none ?>" alt="" style="width:<?php echo $width ?>px;height:<?php echo $slide_height ?>px" /></a>
					<?php } else { ?>
						<img src="<?php echo $item->none ?>" alt="" style="width:<?php echo $width ?>px;height:<?php echo $slide_height ?>px" />
					<?php } ?>			
				</div>
				<div class="sp-slide-desc">
					<div class="sp-slide-inner">
						<?php if($showtitle) { ?>
							<?php if($titlelinked) { ?>
								<h2 class="sp-slide-title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h2>
							<?php } else { ?>
								<h2 class="sp-slide-title"><?php echo $item->title; ?></h2>
							<?php } ?>	
						<?php } ?>		
					
						<?php if($showdate) { ?>
							<span class="created"><?php echo $item->created; ?></span><br />
						<?php } ?>
						
						<?php if($showarticle) { ?>
							<p class="sp-slide-intro"><?php echo $item->text; ?></p>
						<?php } ?>
						
						<?php if($showmore) { ?>
							<br /><a class="sp-slide-morein" href="<?php echo $item->link; ?>"><span><?php echo $moretext ?></span></a>
						<?php } ?>
					</div>	
				</div>					
			</div>
		<?php endforeach; ?>
	</div>
	<div id="handlers<?php echo $uniqid ?>" class="controllers" style="<?php echo 'width:' .$cwidth. 'px;left:' .$left. 'px;height:' . ($itemheight+20) . 'px;' ?>">
		<?php foreach ($list as $item) { ?>
			<div class="handles" style="<?php echo 'width:' . $thumb_width. 'px;height:' .  ($itemheight+20) . 'px'?>">
				<div class="thumb_arrow" style="<?php echo 'width:' . $thumb_width. 'px;height:20px'?>"></div>
				<div class="thumb_bg" style="<?php echo 'width:' . $thumb_width. 'px;height:' . $itemheight . 'px'?>">
					<div class="thumb_bg2" style="<?php echo 'width:' . $thumb_width. 'px;height:' . $itemheight . 'px'?>">
						<div class="sp-slide-inside">
							<?php if ($showthumb) { ?>
							<img class="sp-slide-image" src="<?php echo $item->thumb; ?>" width="<?php echo $thumbwidth ?>" height="<?php echo $thumbheight ?>" alt="" />
							<?php } ?>
							<?php if ($show_c_title) echo '<h4 class="title">' . $item->c_title . '</h4>'; ?>
							<?php if ($show_c_desc) echo '<p class="thumb-intro">' . $item->c_text . '</p>';?>	
						</div>
					</div>
				</div>
			</div>	
		<?php } ?>	
	</div>
	<?php if ($showarrows) {?>
		<div id="prev<?php echo $uniqid;?>" style="<?php echo 'height:' . $itemheight . 'px'?>" class="sp_slide_prev"></div>
		<div id="next<?php echo $uniqid;?>" style="<?php echo 'height:' . $itemheight . 'px'?>" class="sp_slide_next"></div>
	<?php } ?>	
</div>
