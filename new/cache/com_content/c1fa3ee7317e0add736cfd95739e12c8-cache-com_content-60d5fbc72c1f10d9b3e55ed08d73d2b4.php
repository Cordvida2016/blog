<?php die("Access Denied"); ?>#x#a:4:{s:4:"body";s:5728:"
<div id="system">

	
	<article class="item">

		
				<header>

										
								
			<h1 class="title">Lightbox</h1>

			
		</header>
			
		
		<div class="content clearfix">

		
<p>The Widgetkit Lightbox allows you to view images, HTML and multi-media content on a dark dimmed overlay without having to leave the current page.</p>

<h2>Features</h2>

<ul class="check">
	<li>Display images, videos, HTML, Iframes, Ajax requests and SWF</li>
	<li>Supports YouTube, Vimeo, MP4 (h.264), WebM and FLV movies</li>
	<li>Group lightboxes and mix different content types</li>
	<li>Responsive design to fit all device resolutions</li>
	<li>Load other widgets in lightbox</li>
	<li>3 different opening and closing transitions</li>
	<li>4 different caption styles</li>
	<li>Keyboard and mouse scroll wheel navigation</li>
	<li>Build on the latest jQuery version</li>
	<li>Works with Joomla and WordPress</li>
</ul>

<h2>Examples</h2>

<p>Different animations - <code>fade</code>, <code>elastic</code> and <code>none</code></p>
<p class="gallery">
	<a data-lightbox="transitionIn:fade;transitionOut:fade;" href="images/yootheme/widgetkit/lightbox/image1_lightbox.jpg"><img src="images/yootheme/widgetkit/lightbox/image1.jpg" width="180" height="120" alt="Lightbox Image" /></a>
	<a data-lightbox="transitionIn:elastic;transitionOut:elastic;" href="images/yootheme/widgetkit/lightbox/image2_lightbox.jpg"><img src="images/yootheme/widgetkit/lightbox/image2.jpg" width="180" height="120" alt="Lightbox Image" /></a>
	<a data-lightbox="transitionIn:none;transitionOut:none;" href="images/yootheme/widgetkit/lightbox/image3_lightbox.jpg"><img src="images/yootheme/widgetkit/lightbox/image3.jpg" width="180" height="120" alt="Lightbox Image" /></a>
</p>

<p>Different title positions - <code>float</code>, <code>inside</code> and <code>over</code></p>
<p class="gallery">
	<a data-lightbox="group:mygroup1;titlePosition:float" href="images/yootheme/widgetkit/lightbox/image4_lightbox.jpg" title="Title Position: Float"><img src="images/yootheme/widgetkit/lightbox/image4.jpg" width="180" height="120" alt="Lightbox Image" /></a>
	<a data-lightbox="group:mygroup1;titlePosition:inside" href="images/yootheme/widgetkit/lightbox/image5_lightbox.jpg" title="Title Position: Inside"><img src="images/yootheme/widgetkit/lightbox/image5.jpg" width="180" height="120" alt="Lightbox Image" /></a>
	<a data-lightbox="group:mygroup1;titlePosition:over;padding:0" href="images/yootheme/widgetkit/lightbox/image6_lightbox.jpg" title="Title Position: Over and Padding set to 0"><img src="images/yootheme/widgetkit/lightbox/image6.jpg" width="180" height="120" alt="Lightbox Image" /></a>
</p>

<p>Various examples in one gallery (try also using the keyboard and mouse scroll wheel)</p>
<ul>
	<li><a data-lightbox="group:mygroup2" href="http://www.youtube.com/watch?v=R55e-uHQna0" title="YouTube Video">YouTube</a></li>
	<li><a data-lightbox="group:mygroup2" href="http://vimeo.com/15261921" title="Vimeo Video">Vimeo</a></li>
	<li><a data-lightbox="group:mygroup2;autoplay:true;" href="http://www.yootheme.com/videos/mediaplayer.mp4" title="MP4 (h.264)">MP4 (h.264)</a></li>
	<li><a data-lightbox="group:mygroup2" href="http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf" title="Flash Swf">Swf</a></li>
	<li><a data-lightbox="group:mygroup2" href="#inline" title="Inline Content from the Website">Inline</a></li>
	<li><a data-lightbox="group:mygroup2;width:1000;height:600" title="Iframe" href="http://www.wikipedia.org">Iframe</a></li>
</ul>

<div style="display: none;">
	<div id="inline" style="width: 400px; height: 100px; overflow: auto;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
</div>

<h2>Load Widgets In A Lightbox</h2>
<p>Use <code>#wk-ID</code> to load widgets like slideshows or galleries in a lightbox. For example: <a data-lightbox="width:600;height:300;" href="#wk-50" title="Widgetkit Slideshow">Widgetkit Slideshow</a></p>
<pre>&lt;a data-lightbox=&quot;width:600;height:300;&quot; href=&quot;#wk-10&quot;&gt;Lightbox&lt;/a&gt;</pre>

<h2>How To Use</h2>

<p>Use the HTML5 custom data attribute <code>data-lightbox</code> to activate the lightbox. You can set various lightbox parameters to the data attribute. For example:</p>

<pre>&lt;a data-lightbox=&quot;width:1000;height:600;&quot; href=&quot;http://www.wikipedia.org&quot;&gt;Lightbox&lt;/a&gt;</pre>

<p>Here is a list of the most common parameters:</p>

<ul>
	<li><strong>titlePosition</strong> - How should the title show up? (<code>float</code>, <code>outside</code>, <code>inside</code> or <code>over</code>)</li>
	<li><strong>transitionIn</strong> - Set a opening transition. (<code>fade</code>, <code>elastic</code>, or <code>none</code>)</li>
	<li><strong>transitionOut</strong> - Set a closing transition (<code>fade</code>, <code>elastic</code>, or <code>none</code>)</li>
	<li><strong>overlayShow</strong> - Set to <code>true</code> or <code>false</code></li>
	<li><strong>scrolling</strong> - Set to <code>yes</code> or <code>no</code></li>
	<li><strong>width</strong> - Set a width in pixel</li>
	<li><strong>height</strong> - Set a height in pixel</li>
	<li><strong>padding</strong> - Set a padding in pixel</li>
</ul> 		</div>

								
		
		
		
			
	</article>

</div>";s:4:"head";a:11:{s:5:"title";s:8:"Lightbox";s:11:"description";s:146:"The Widgetkit Lightbox allows you to view images,  HTML and multi-media content on a dark dimmed overlay without having to leave the current page.";s:4:"link";s:0:"";s:8:"metaTags";a:2:{s:10:"http-equiv";a:1:{s:12:"content-type";s:24:"text/html; charset=utf-8";}s:8:"standard";a:3:{s:8:"keywords";s:387:"células-tronco, celula tronco,  cordão umbilical, sangue, tecido cordão umbilical, células mesenquimais, criopreservação, celulas tronco, banco de cordão, tanque de armazenamento, coleta de celula tronco, banco de celula tronco, bioarchive, coleta, doenças trataveis, o que é célula tronco, sangue do cordão, diabetes tipo 1, céulas tronco no brasil, tudo sobre celula tronco";s:6:"rights";N;s:6:"author";s:10:"Super User";}}s:5:"links";a:1:{s:91:"http://cordvida.com.br/new/planos-servicos/condicoes-comerciais/2-uncategorised/15-lightbox";a:3:{s:8:"relation";s:9:"canonical";s:7:"relType";s:3:"rel";s:7:"attribs";a:0:{}}}s:11:"styleSheets";a:2:{s:57:"/new/plugins/editors/jckeditor/typography/typography2.php";a:3:{s:4:"mime";s:8:"text/css";s:5:"media";N;s:7:"attribs";a:0:{}}s:31:"/new/media/system/css/modal.css";a:3:{s:4:"mime";s:8:"text/css";s:5:"media";N;s:7:"attribs";a:0:{}}}s:5:"style";a:0:{}s:7:"scripts";a:4:{s:37:"/new/media/system/js/mootools-core.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:28:"/new/media/system/js/core.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:37:"/new/media/system/js/mootools-more.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}s:29:"/new/media/system/js/modal.js";a:3:{s:4:"mime";s:15:"text/javascript";s:5:"defer";b:0;s:5:"async";b:0;}}s:6:"script";a:1:{s:15:"text/javascript";s:142:"
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});";}s:6:"custom";a:0:{}s:10:"scriptText";a:0:{}}s:7:"pathway";s:1:"
";s:6:"module";a:0:{}}