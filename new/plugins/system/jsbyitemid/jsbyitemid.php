<?php
/*------------------------------------------------------------------------
# jsbyitemid.php - CSS by itemid (plugin)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Eric Schneider for Craziation Designs, LLC
# copyright 	Copyright (c) 2012 Craziation Designs, LLC. All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website 		http://craziation.com/ 
-------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.event.plugin');

class plgSystemJsByItemId extends JPlugin
{
	// Constructor
	function plgSystemJsByItemId( &$subject, $params ) {
		parent::__construct( $subject, $params );
	}
	function onAfterDispatch() {
		$app = JFactory::getApplication();
		if ($app->isAdmin()) return;
		$document = JFactory::getDocument();
		if ($document->getType() != 'html') return;
		$itemid = JRequest::getInt('Itemid', 0);
		$items = $this->params->get('items', '');
		if($items && $itemid) {
			$items = explode("\n",$items);
			foreach($items as $item) {
				if($item) {
					$item = explode("|",$item);
					$item[0] = array_map('trim', explode(",", $item[0]));
					$item[1] = trim($item[1]);
					if($item[0] && $item[1] && (in_array($itemid, $item[0]) || in_array("*", $item[0]))) {
						if(strripos($item[1], ".js") == (strlen($item[1]) - 3)) {
							if(dirname($item[1]) == ".") $item[1] = JURI :: base(1).'/plugins/system/jsbyitemid/js/'.$item[1];
							if($item[1]) $document->addScript($item[1]);
						}
					}
				}
			}
		}
		return true;
	}
}
?>