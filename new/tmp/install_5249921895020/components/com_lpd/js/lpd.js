/**
 * @version		$Id: lpd.js 1304 2011-10-31 13:16:09Z joomlaworks $
 * @package		LPD (based on K2)
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

var $LPD = jQuery.noConflict();

$LPD(document).ready(function(){

	// Comments
	$LPD('#comment-form').submit(function(event){
		event.preventDefault();
		$LPD('#formLog').empty().addClass('formLogLoading');
		$LPD.ajax({
			url: $LPD('#comment-form').attr('action'),
			type: 'post',
			dataType: 'json',
			data: $LPD('#comment-form').serialize(),
			success: function(response){
				$LPD('#formLog').removeClass('formLogLoading').html(response.message);
				if(typeof(Recaptcha) != "undefined"){
					Recaptcha.reload();
				}
				if (response.refresh) {
					window.location.reload();
				}
			}
		});
	});
	
	$LPD('.commentRemoveLink').click(function(event){
		event.preventDefault();
		var element = $LPD(this);
		$LPD(element).parent().addClass('commentToolbarLoading');
		$LPD.ajax({
			url: $LPD(element).attr('href'),
			type: 'post',
			data: $LPD('#comment-form input:last').serialize(),
			success: function(response){
				$LPD(element).parent().removeClass('commentToolbarLoading');
				if(response=='true'){
					$LPD(element).parent().parent().remove();
				}
			}
		});
	});
	
	$LPD('.commentApproveLink').click(function(event){
		event.preventDefault();
		var element = $LPD(this);
		$LPD(element).parent().addClass('commentToolbarLoading');
		$LPD.ajax({
			url: $LPD(element).attr('href'),
			type: 'post',
			data: $LPD('#comment-form input:last').serialize(),
			success: function(response){
				$LPD(element).parent().removeClass('commentToolbarLoading');
				if(response=='true'){
					$LPD(element).parent().parent().removeClass('unpublishedComment');
				}
			}
		});
	});
	
	$LPD('#lpdReportCommentForm').submit(function(event){
		event.preventDefault();
		$LPD('#formLog').empty().addClass('formLogLoading');
		$LPD.ajax({
			url: $LPD('#lpdReportCommentForm').attr('action'),
			type: 'post',
			data: $LPD('#lpdReportCommentForm').serialize(),
			success: function(response){
				$LPD('#formLog').removeClass('formLogLoading').html(response);
				if(typeof(Recaptcha) != "undefined"){
					Recaptcha.reload();
				}
			}
		});
	});

	// Text Resizer
	$LPD('#fontDecrease').click(function(event){
		event.preventDefault();
		$LPD('.itemFullText').removeClass('largerFontSize');
		$LPD('.itemFullText').addClass('smallerFontSize');
	});
	$LPD('#fontIncrease').click(function(event){
		event.preventDefault();
		$LPD('.itemFullText').removeClass('smallerFontSize');
		$LPD('.itemFullText').addClass('largerFontSize');
	});

	// Smooth Scroll
	$LPD('.lpdAnchor').click(function(event){
		event.preventDefault();
		var target = this.hash;
		$LPD('html, body').stop().animate({
			scrollTop: $LPD(target).offset().top
		}, 500);
	});

	// Rating
	$LPD('.itemRatingForm a').click(function(event){
		event.preventDefault();
		var itemID = $LPD(this).attr('rel');
		var log = $LPD('#itemRatingLog' + itemID).empty().addClass('formLogLoading');
		var rating = $LPD(this).html();
		$LPD.ajax({
			url: LPDSitePath+"index.php?option=com_lpd&view=item&task=vote&format=raw&user_rating=" + rating + "&itemID=" + itemID,
			type: 'get',
			success: function(response){
				log.removeClass('formLogLoading');
				log.html(response);
				$LPD.ajax({
					url: LPDSitePath+"index.php?option=com_lpd&view=item&task=getVotesPercentage&format=raw&itemID=" + itemID,
					type: 'get',
					success: function(percentage){
						$LPD('#itemCurrentRating' + itemID).css('width', percentage + "%");
						setTimeout(function(){
							$LPD.ajax({
								url: LPDSitePath+"index.php?option=com_lpd&view=item&task=getVotesNum&format=raw&itemID=" + itemID,
								type: 'get',
								success: function(response){
									log.html(response);
								}
							});
						}, 2000);
					}
				});
			}
		});
	});

	// Classic popup
	$LPD('.classicPopup').click(function(event){
		event.preventDefault();
		if($LPD(this).attr('rel')){
			var json = $LPD(this).attr('rel');
			json = json.replace(/'/g, '"');
			var options = $LPD.parseJSON(json);
		} else {
			var options = {x:900,y:600}; /* use some default values if not defined */
		}
		window.open($LPD(this).attr('href'),'LPDPopUpWindow','width='+options.x+',height='+options.y+',menubar=yes,resizable=yes');
	});
	
	// Live search
	$LPD('div.lpdLiveSearchBlock form input[name=searchword]').keyup(function(event){
		var parentElement = $LPD(this).parent().parent();
		if($LPD(this).val().length>3 && event.key!='enter'){
			$LPD(this).addClass('lpdSearchLoading');
			parentElement.find('.lpdLiveSearchResults').css('display','none').empty();
			parentElement.find('input[name=t]').val($LPD.now());
			parentElement.find('input[name=format]').val('raw');
			var url = 'index.php?option=com_lpd&view=itemlist&task=search&' + parentElement.find('form').serialize();
			parentElement.find('input[name=format]').val('html');
			$LPD.ajax({
				url: url,
				type: 'get',
				success: function(response){
					parentElement.find('.lpdLiveSearchResults').html(response);
					parentElement.find('input[name=searchword]').removeClass('lpdSearchLoading');
					parentElement.find('.lpdLiveSearchResults').css('display', 'block');
				}
			});
		} else {
			parentElement.find('.lpdLiveSearchResults').css('display','none').empty();
		}
	});

	// Calendar
	$LPD('a.calendarNavLink').live('click', function(event){
		event.preventDefault();
		var parentElement = $LPD(this).parent().parent().parent().parent();
		var url = $LPD(this).attr('href');
		parentElement.empty().addClass('lpdCalendarLoader');
		$LPD.ajax({
			url: url,
			type: 'post',
			success: function(response){
				parentElement.html(response);
				parentElement.removeClass('lpdCalendarLoader');
			}
		});
	});
	
	// Generic Element Scroller (use .lpdScroller in the container and .lpdScrollerElement for each contained element)
	$LPD('.lpdScroller').css('width',($LPD('.lpdScroller').find('.lpdScrollerElement:first').outerWidth(true))*$LPD('.lpdScroller').children('.lpdScrollerElement').length);

});

// Equal block heights for the "default" view
$LPD(window).load(function () {
	var blocks = $LPD('.subCategory, .lpdEqualHeights');
	var maxHeight = 0;
	blocks.each(function(){
		maxHeight = Math.max(maxHeight, parseInt($LPD(this).css('height')));
	});
	blocks.css('height', maxHeight);
});
