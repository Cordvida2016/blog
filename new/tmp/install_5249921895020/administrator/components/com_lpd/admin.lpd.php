<?php
/**
 * @version		$Id: admin.lpd.php 1390 2011-12-08 22:27:55Z joomlaworks@gmail.com $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
$user = & JFactory::getUser();
$view = JRequest::getWord('view', 'items');
$view = JString::strtolower($view);
$task = JRequest::getCmd('task');
$params = &JComponentHelper::getParams('com_lpd');

if(LPD_JVERSION=='15'){
    if(($params->get('lockTags') && $user->gid<=23 && ($view=='tags' || $view=='tag')) || ($user->gid <= 23) && (
    			$view=='extrafield' ||
    			$view=='extrafields' ||
    			$view=='extrafieldsgroup' ||
    			$view=='extrafieldsgroups' ||
    			$view=='user' ||
    			($view=='users' && $task != 'element') ||
    			$view=='usergroup' ||
    			$view=='usergroups'
    		)
    	)
    	{
    		JError::raiseError( 403, JText::_('LPD_ALERTNOTAUTH') );
    	}
}
else {
    
	JLoader::register('LPDHelperPermissions', JPATH_SITE.DS.'components'.DS.'com_lpd'.DS.'helpers'.DS.'permissions.j16.php');
	LPDHelperPermissions::checkPermissions();
	
	// Compatibility for gid variable
    if($user->authorise('core.admin', 'com_lpd')){
        $user->gid = 1000;
    }
    else {
    	 $user->gid = 1;
    }
        
    if(	($params->get('lockTags') && !$user->authorise('core.admin', 'com_lpd') && ($view=='tags' || $view=='tag')) ||
    		(!$user->authorise('core.admin', 'com_lpd')) && (
    		$view=='extrafield' ||
    		$view=='extrafields' ||
    		$view=='extrafieldsgroup' ||
    		$view=='extrafieldsgroups' ||
    		$view=='user' ||
    		$view=='users' ||
    		$view=='usergroup' ||
    		$view=='usergroups'
    		)
    	)
    	{
    		JError::raiseError( 403, JText::_('LPD_ALERTNOTAUTH') );
    	}
}

$document = &JFactory::getDocument();

if(version_compare(JVERSION,'1.6.0','ge')) {
	JHtml::_('behavior.framework');
} else {
	JHTML::_('behavior.mootools');
}

// CSS
$document->addStyleSheet(JURI::root(true).'/media/lpd/assets/css/lpd.css');

// JS
$backendJQueryHandling = $params->get('backendJQueryHandling','remote');
if($backendJQueryHandling=='remote'){
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');
	$document->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');
} else {
	$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-1.7.1.min.js');
	$document->addScript(JURI::root(true).'/media/lpd/assets/js/jquery-ui-1.8.16.custom.min.js');
}
$document->addScript(JURI::root(true).'/media/lpd/assets/js/lpd.js?v=252');

$uservoicetag='
  var uvOptions = {};
  (function() {
    var uv = document.createElement(\'script\'); uv.type = \'text/javascript\'; uv.async = true;
    uv.src = (\'https:\' == document.location.protocol ? \'https://\' : \'http://\') + \'widget.uservoice.com/93HveRQbCM89E2mtPwVEw.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(uv, s);
  })();
';
$document->addScriptDeclaration($uservoicetag);

if( JRequest::getWord('task')!='deleteAttachment' && JRequest::getWord('task')!='connector' && JRequest::getWord('task')!='tag' && JRequest::getWord('task')!='extrafields' && JRequest::getWord('task')!='download' && JRequest::getWord('task')!='saveComment'): ?>
<!--[if lt IE 7]>
<div style="border:1px solid #F7941D;background:#FEEFDA;text-align:center;clear:both;height:75px;position:relative;margin-bottom:16px;">
  <div style="position:absolute;right:3px;top:3px;font-family:courier new;font-weight:bold;">
  	<a href="#" onclick="javascript:this.parentNode.parentNode.style.display='none';return false;"><img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-cornerx.jpg" style="border:none;" alt="<?php echo JText::_('LPD_CLOSE_THIS_NOTICE'); ?>"/></a>
  </div>
  <div style="width:640px;margin:0 auto;text-align:left;padding:0;overflow:hidden;color:black;">
    <div style="width:75px;float:left;">
    	<img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-warning.jpg" alt="<?php echo JText::_('LPD_WARNING'); ?>"/>
    </div>
    <div style="width:275px;float:left;font-family:Arial,sans-serif;">
      <div style="font-size:14px;font-weight:bold;margin-top:12px;">
      	<?php echo JText::_('LPD_YOU_ARE_USING_AN_OUTDATED_BROWSER'); ?>
      </div>
      <div style="font-size:12px;margin-top:6px;line-height:12px;">
      	<?php echo JText::_('LPD_FOR_A_BETTER_EXPERIENCE_USING_THIS_SITE_PLEASE_UPGRADE_TO_A_MODERN_WEB_BROWSER'); ?>
      </div>
    </div>
    <div style="width:75px;float:left;"><a href="http://www.firefox.com" target="_blank"><img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-firefox.jpg" style="border:none;" alt="<?php echo JText::_('LPD_GET_FIREFOX_35'); ?>"/></a></div>
    <div style="width:75px;float:left;"><a href="http://www.browserforthebetter.com/download.html" target="_blank"><img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-ie8.jpg" style="border:none;" alt="<?php echo JText::_('LPD_GET_INTERNET_EXPLORER_8'); ?>"/></a></div>
    <div style="width:73px;float:left;"><a href="http://www.apple.com/safari/download/" target="_blank"><img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-safari.jpg" style="border:none;" alt="<?php echo JText::_('LPD_GET_SAFARI_4'); ?>"/></a></div>
    <div style="float:left;"><a href="http://www.google.com/chrome" target="_blank"><img src="<?php echo JURI::root(true); ?>/media/lpd/assets/images/ie6nomore/ie6nomore-chrome.jpg" style="border:none;" alt="<?php echo JText::_('LPD_GET_GOOGLE_CHROME'); ?>"/></a></div>
  </div>
</div>
<![endif]-->
<div id="lpdAdminContainer" class="LPDAdminView<?php echo ucfirst($view); ?><?php if(LPD_JVERSION=='16') echo ' isJ16orLater'; ?>">
<?php endif;

$controller = JRequest::getWord('view', 'items');
$controller = JString::strtolower($controller);
require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
$classname = 'LPDController'.$controller;
$controller = new $classname();
$controller->registerTask('saveAndNew', 'save');
$controller->execute(JRequest::getWord('task'));
$controller->redirect();

if( JRequest::getWord('task')!='deleteAttachment' && JRequest::getWord('task')!='connector' && JRequest::getWord('task')!='tag' && JRequest::getWord('task')!='extrafields' && JRequest::getWord('task')!='download' && JRequest::getWord('task')!='saveComment'): ?>
</div>
<div id="lpdAdminFooter">
	<a target="_blank" href="http://www.landingpagesdesigner.com/">Landing Pages Designer</a> | Copyright &copy; 2012 <a target="_blank" href="http://www.audox.cl/">Audox Ingenier&iacute;a Ltda.</a>
</div>
<?php endif;
