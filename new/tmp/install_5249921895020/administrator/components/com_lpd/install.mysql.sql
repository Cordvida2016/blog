CREATE TABLE IF NOT EXISTS `#__lpd_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `titleAttribute` text NOT NULL,
  `hits` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `itemID` (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `extraFieldsGroup` int(11) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `trash` smallint(6) NOT NULL DEFAULT '0',
  `plugins` text NOT NULL,
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`published`,`access`,`trash`),
  KEY `parent` (`parent`),
  KEY `ordering` (`ordering`),
  KEY `published` (`published`),
  KEY `access` (`access`),
  KEY `trash` (`trash`),
  KEY `language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `commentDate` datetime NOT NULL,
  `commentText` text NOT NULL,
  `commentEmail` varchar(255) NOT NULL,
  `commentURL` varchar(255) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `itemID` (`itemID`),
  KEY `userID` (`userID`),
  KEY `published` (`published`),
  KEY `latestComments` (`published`,`commentDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_extra_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `group` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `published` (`published`),
  KEY `ordering` (`ordering`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_extra_fields_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `typeid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `video` text,
  `gallery` varchar(255) DEFAULT NULL,
  `extra_fields` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `extra_fields_search` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `trash` smallint(6) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `featured` smallint(6) NOT NULL DEFAULT '0',
  `featured_ordering` int(11) NOT NULL DEFAULT '0',
  `image_caption` text NOT NULL,
  `image_credits` varchar(255) NOT NULL,
  `video_caption` text NOT NULL,
  `video_credits` varchar(255) NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  `metadesc` text NOT NULL,
  `metadata` text NOT NULL,
  `metakey` text NOT NULL,
  `customcss` text NOT NULL,
  `customjs` text NOT NULL,
  `googleanalyticsscript` text NOT NULL,
  `gwocontrolscript` text NOT NULL,
  `gwotrackingscript` text NOT NULL,
  `gwoconversionscript` text NOT NULL,
  `plugins` text NOT NULL,
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`published`,`publish_up`,`publish_down`,`trash`,`access`),
  KEY `catid` (`catid`),
  KEY `created_by` (`created_by`),
  KEY `ordering` (`ordering`),
  KEY `featured` (`featured`),
  KEY `featured_ordering` (`featured_ordering`),
  KEY `hits` (`hits`),
  KEY `created` (`created`),
  KEY `language` (`language`),
  FULLTEXT KEY `search` (`title`,`introtext`,`fulltext`,`extra_fields_search`,`image_caption`,`image_credits`,`video_caption`,`video_credits`,`metadesc`,`metakey`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_rating` (
  `itemID` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(11) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(11) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`itemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `published` (`published`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_tags_xref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tagID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagID` (`tagID`),
  KEY `itemID` (`itemID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `gender` enum('m','f') NOT NULL DEFAULT 'm',
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `group` int(11) NOT NULL DEFAULT '0',
  `plugins` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `group` (`group`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__lpd_user_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__lpd_categories` (`id`, `name`, `alias`, `description`, `parent`, `extraFieldsGroup`, `published`, `access`, `ordering`, `image`, `params`, `trash`, `plugins`, `language`) VALUES
(1, 'Templates', 'templates', '', 0, 0, 1, 1, 1, '', '', 0, '', '');

INSERT IGNORE INTO `#__lpd_items` (`id`, `name`, `title`, `alias`, `typeid`, `catid`, `published`, `introtext`, `fulltext`, `video`, `gallery`, `extra_fields`, `extra_fields_search`, `created`, `created_by`, `created_by_alias`, `checked_out`, `checked_out_time`, `modified`, `modified_by`, `publish_up`, `publish_down`, `trash`, `access`, `ordering`, `featured`, `featured_ordering`, `image_caption`, `image_credits`, `video_caption`, `video_credits`, `hits`, `params`, `metadesc`, `metadata`, `metakey`, `customcss`, `customjs`, `googleanalyticsscript`, `gwocontrolscript`, `gwotrackingscript`, `gwoconversionscript`, `plugins`, `language`) VALUES
(1, 'My First Landing Page', 'My First Landing Page', 'my-first-landing-page', 0, 1, 1, '
<table border="0" align="center" style="width: 760px; background-color: #ffffff;" cellspacing="10">
<tbody>
<tr>
<td style="text-align: right;">
<p><strong><span style="font-size: 38pt; line-height: 1.25em;">&iquest;Necesitas<br />una P&aacute;gina<br />Web?</span></strong></p>
<p><strong><span style="line-height: 1em; font-size: 18pt;">&iexcl;Nosotros te ayudamos!</span></strong></p>
</td>
<td style="text-align: center;"><img src="media/lpd/items/src/lp.jpg" style="display: block; margin-left: auto; margin-right: auto;" /></td>
</tr>
</tbody>
</table>
<div style="background-image: url(\'media/lpd/items/src/lp1.png\'); background-position: center top; background-repeat: repeat-x; margin: 0; position: relative; width: 100%; height: 40px; border-top-style: solid; border-top-color: #CCC; border-width: 1px;">
<div style="margin: auto; width: 760px; height: 40px;" class="lp-pom-block-content"></div>
</div>
<table border="0" align="center" style="width: 760px;">
<tbody>
<tr>
<td style="width: 50%;">
<p style="line-height: 2em; text-align: center;"><span style="font-size: 14pt;"><strong>AUTOADMINISTRABLE +</strong></span><br /><span style="font-size: 14pt;"><strong>DISE&Ntilde;O +</strong>&nbsp;<strong>HOSTING +</strong></span><br /><span style="font-size: 14pt;"><strong>CORREOS ELECTRONICOS</strong></span></p>
<p><img src="media/lpd/items/src/lp2.png" style="display: block; margin-left: auto; margin-right: auto;" /></p>
<ul>
<li>Sistema Auto Administrable (Curso Incluido)<br />(Tu mismo actualizas tu p&aacute;gina tan r&aacute;pido y tantas veces como quieras evitando pagos adicionales y demoras por cada actualizaci&oacute;n)<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Ideal para Pymes, Peque&ntilde;os Negocios y Personas Independientes (Todo Incluido)<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Publicaci&oacute;n en los primeros resultados de Google<br /><span style="color: #ffffff;">.</span></li>
<li>Gran Capacidad de Almacenamiento<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Cuentas de Correo en la Suite Google Apps<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Integrado con Facebook y Twitter<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Soporte t&eacute;cnico y asesor&iacute;a todo el a&ntilde;o<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>Forma de pago hasta en 24 cuotas<br /><span style="color: #ffffff;">.</span>&nbsp;</li>
<li>* Audox es una empresa creada gracias&nbsp;al Patrocinio de DICTUC y Financiamiento Corfo</li>
</ul>
<p>&nbsp;</p>
<ul></ul>
<p style="text-align: center;"><span style="font-size: 12pt;"><strong><span style="text-align: center;">ATENCI&Oacute;N PERSONALIZADA<br />FONO: (2) 581 3799</span></strong></span><br style="text-align: center;" /><a style="text-align: center;" href="skype:audox.ingenieria?call"><img style="border: none;" src="http://download.skype.com/share/skypebuttons/buttons/call_blue_white_124x52.png" width="124" height="52" alt="Skype Me!" /></a></p>
<ul></ul>
</td>
<td>
<div style="background-color: #295e96; border: 1px solid #CCC; padding: 10px;">
<p><strong><span style="font-size: 14pt;"><span style="color: #ffffff;">&iexcl; MIRA NUESTOS DISE&Ntilde;OS !</span></span></strong></p>
<p><strong><span style="color: #ffffff;">Ingresa tus datos y recibir&aacute;s en tu correo electr&oacute;nico nuestro cat&aacute;logo completo con m&aacute;s de 600 dise&ntilde;os auto administrables y una cotizaci&oacute;n personalizada</span></strong></p>
</div>
<div style="background-color: #f4f4f4; border: 1px solid #CCC; padding: 10px;"><img height="250" width="63" src="media/lpd/items/src/reddownarrow.png" alt="right" style="float: right;" /><form method="post" id="userForm" enctype="multipart/form-data" action="http://www.audox.cl/index.php?option=com_lpd&amp;view=item&amp;id=3">
<div>
<div class="formField rsform-block rsform-block-firstname">Nombre (*)<br /> <input type="text" value="" size="20" name="form[FirstName]" id="FirstName" class="rsform-input-box" /><br /><br /></div>
<div class="formField rsform-block rsform-block-lastname">Apellidos (*)<br /> <input type="text" value="" size="20" name="form[LastName]" id="LastName" class="rsform-input-box" /><br /><br /></div>
<div class="formField rsform-block rsform-block-email">Correo electr&oacute;nico (*)<br /> <input type="text" value="" size="20" name="form[Email]" id="Email" class="rsform-input-box" /><br /><br /></div>
<div class="formField rsform-block rsform-block-mobilephone">Celular (*)<br /> <input type="text" value="" size="20" name="form[MobilePhone]" id="MobilePhone" class="rsform-input-box" /><br /><br /></div>
<div class="formField rsform-block rsform-block-message">Cu&eacute;ntanos por favor de tu negocio y qu&eacute; necesitas<br /> <textarea cols="30" rows="3" name="form[Message]" id="Message" class="rsform-text-box"></textarea></div>
<div class="formField rsform-block rsform-block-submit"><br /> <input type="submit" value="Ver los Dise&ntilde;os !" name="form[Submit]" id="Submit" class="rsform-submit-button" /><br /><br /><br /><br /></div>
</div>
<input type="hidden" name="form[formId]" value="18" /></form></div>
<p style="text-align: center;">Nunca venderemos tu informaci&oacute;n ni te enviaremos spam. Promesa.</p>
<p>&nbsp;</p>
</td>
</tr>
</tbody>
</table>
<div style="background-image: url(\'media/lpd/items/src/lp3.png\'); background-position: center bottom; background-repeat: no-repeat; position: relative; width: 900px; height: 40px; border-bottom-style: solid; border-bottom-color: #CCC; border-width: 1px; margin: 0 auto 0 auto;"></div>
<table border="0" align="center" style="width: 760px;">
<tbody>
<tr>
<td>
<p><img alt="multimexcl" height="52" style="float: left;" src="media/lpd/items/src/multimexcl.png" width="200" /><span style="font-size: 10pt; line-height: 1.5em;">"Me gust&oacute; la r&aacute;pido que trabajan. Los ejecutivos son muy amables y educados, cumplen con los acuerdos y ayudan a buscar soluciones, a&uacute;n despu&eacute;s de entregada la p&aacute;gina." Francisca Pinto. Multimex S.A.</span></p>
</td>
</tr>
<tr>
<td>
<p><img alt="maxofficecl" height="37" style="float: right;" src="media/lpd/items/src/maxofficecl.jpg" width="200" /><span style="font-size: 10pt; line-height: 1.5em;">"Me gust&oacute; la seriedad del servicio, la disponibilidad del dise&ntilde;ador, el apoyo constante, excelencia en el trabajo. Se recomienda en un 100%. Muy conforme!" Patricia Mej&iacute;as. MaxOffice Ltda.</span></p>
</td>
</tr>
</tbody>
</table>
<table border="0" align="center" style="width: 100%; background-color: #0d0e0f;">
<tbody>
<tr>
<td style="text-align: center;"><span style="color: #aaaaaa;">&copy; 2012 Audox Ingenier&iacute;a Ltda. Todos los Derechos Reservados.</span></td>
</tr>
</tbody>
</table>
', '', NULL, NULL, '[]', '', '2012-01-01 00:00:00', 42, '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 42, '2012-01-01 00:00:00', '0000-00-00 00:00:00', 0, 1, 1, 1, 0, '', '', '', '', 0, '', 'Description', 'robots=index, follow\nauthor=Author', 'Keywords', '
body {
margin: 0px;
background: #FFFFFF!important;
text-align: left!important;
}
table {
margin: auto;
border-color: white;
}
body, td, th, div, p, label, input {
color:#666666;
font:normal 12px/18px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
', '\r\n\r\nfunction open_win()\r\n{\r\nalert(\'JavaScript Example\')\r\n};', '<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-0000000-00\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>', '<script>Control Script</script>', '<script>Tracking Script</script>', '<script>Conversion Script</script>', '', '');
