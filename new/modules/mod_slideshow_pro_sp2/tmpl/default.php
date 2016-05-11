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
		size: {width: <?php echo $width ?>, height: <?php echo $height ?>},
		interval: <?php echo $interval ?>,
		fxOptions: {duration:  <?php echo $speed; ?>, transition: Fx.Transitions.<?php echo $transition; ?>},
		transition: <?php echo "'" .$effects. "'"; ?>
	});
	<?php if ($showimage) { ?>
	var images = [
		<?php 
			foreach ($list as $item) {
				$pre_src .= '"' . $item->thumb . '",';
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
			images_elements[(i-1)].src = images[(i-1)];
		}
	});
	<?php } else { ?>
		spSlide<?php echo $uniqid ?>.play();
	<?php } ?>
	
	<?php if ($showarrows) {?>
		spSlide<?php echo $uniqid ?>.addPlayerControls('previous', [$('sp_slide_prev<?php echo $uniqid;?>')]);
		spSlide<?php echo $uniqid ?>.addPlayerControls('next', [$('sp_slide_next<?php echo $uniqid;?>')]);
	<?php } ?>
});
//]]>
</script>
<div class="sp-slide" style="position:relative">
	<?php if ($showimage) { ?><div id="sp-preload<?php echo $uniqid ?>" class="preload" style="position:absolute;height:<?php echo $height ?>px;width:<?php echo $width ?>px"></div><?php } ?>
	<div id="sp-slide<?php echo $uniqid ?>" style="overflow:hidden;position:relative;height:<?php echo $height ?>px;width:<?php echo $width ?>px">
		<?php foreach ($list as $item): ?>
			<div class="sp-slide-content">
				<div class="sp-slide-inner">
					<?php if ($showimage) { ?>	
						<?php if($imagelinked) { ?>
							<a href="<?php echo $item->link ?>"><img src="<?php echo $item->none ?>" alt="" class="sp-slide-image" width="<?php echo $thumbwidth ?>" height="<?php echo $thumbheight ?>" /></a>
						<?php } else { ?>
							<img src="<?php echo $item->none ?>" alt="" class="sp-slide-image" width="<?php echo $thumbwidth ?>" height="<?php echo $thumbheight ?>" />
						<?php } ?>			
					<?php } ?>
					<div class="sp-slide-desc">
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
	<?php if ($showarrows) { ?>
		<div id="sp_slide_prev<?php echo $uniqid;?>" class="sp_slide_prev"></div>
		<div id="sp_slide_next<?php echo $uniqid;?>" class="sp_slide_next"></div>
	<?php } ?>	
</div>