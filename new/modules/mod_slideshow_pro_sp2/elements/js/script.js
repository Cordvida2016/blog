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
jQuery.noConflict();
jQuery(document).ready(function(){
	showhide();
	jQuery('#jform_params_content_source').change(function() {showhide()});
	jQuery('#jform_params_content_source').blur(function() {showhide()});
	function showhide(){
		if (jQuery("#jform_params_content_source").val()=="k2") {
			jQuery("#jform_params_catid").parent().css("display", "none");
			jQuery("#jformparamsk2catids").parent().css("display", "block");
		} else {
			jQuery("#jform_params_catid").parent().css("display", "block");	
			jQuery("#jformparamsk2catids").parent().css("display", "none");		
		}
		
		jQuery('.pane-slider').css("height", "auto");
	}
	var empty = jQuery('#jform_params___field1-lbl');
	if (empty) empty.parent().remove();
});