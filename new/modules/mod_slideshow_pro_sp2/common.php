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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filter.output');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class modSlideShowSP2CommonHelper {

	public static function cText($text, $limit, $limitas) {//function to limit text
		
		switch ($limitas) {
			case 0 :
				$text = JFilterOutput::cleanText($text);
				$text = explode(' ',$text);
				$sep = (count($text)>$limit) ? '...' : '';
				$text=implode(' ', array_slice($text,0,$limit)) . $sep;
				break;
			case 1 :
				$text = JFilterOutput::cleanText($text);
				$sep  = (strlen($text)>$limit) ? '...' : '';
				$text =utf8_substr($text,0,$limit) . $sep;
				break;
			case 2 :
				$allowed_tags = '<p><span><b><i><a><small><h1><h2><h3><h4><h5><h6><sup><sub><em><strong><u><br><div><img>';
				$text = strip_tags( $text, $allowed_tags );
				$text = $text;
				break;
			default :
				$text = JFilterOutput::cleanText($text);
				$text = explode(' ',$text);
				$sep = (count($text)>$limit) ? '...' : '';
				$text=implode(' ', array_slice($text,0,$limit)) . $sep;
				break;
		}		
		
		return $text;
	}
	
	public static function thumb($image, $width, $height, $ratio=false, $uniqid) {

		if( substr($image,0,4)=='http' ) {//to detect externel image source
			if(strpos($image, JURI::base())===FALSE) {//externel source
				return $image;
			} else {//return internel image relative path
				$image = str_replace(JURI::base(),'',$image);
			}
		}
		
		// remove any / that begins the path
		$image = ltrim($image,'/');
		
		//cache path
		$thumb_dir = JPATH_CACHE.'/mod_slideshow_pro_sp2/thumbs/'. $uniqid;
		
		if (!JFolder::exists($thumb_dir)) {
			JFolder::create($thumb_dir, 0755);
		}

		$file_name = JFile::stripExt(basename($image));
		$file_ext = JFile::getExt($image);
		$thumb_path = $thumb_dir . DIRECTORY_SEPARATOR . $file_name . '.' . $file_ext;
		$thumb_url = basename(JPATH_CACHE) .'/mod_slideshow_pro_sp2/thumbs/'. $uniqid. '/' . $file_name . '.' . $file_ext;

		// check to see if this file exists, if so we don't need to create it
		if (function_exists("gd_info")) {
			
			//Check existing thumbnails dimensions
			if (file_exists($thumb_path)) {
				$size = GetImageSize( $thumb_path );
				$currentWidth=$size[0];
				$currentHeight=$size[1];
			}
			
			//Creating thumbnails		
			if (!file_exists($thumb_path) || $currentWidth!=$width || $currentHeight!=$height ) {
				self::crop($image, $width, $height, $ratio, $thumb_path);
			}
		}
			
		return $thumb_url;	
	}
	
	private static function crop($image_to_resize, $new_width, $new_height, $ratio, $path)
	{
		if( !file_exists( $image_to_resize ) )
		{
			exit( "File " . $image_to_resize . " does not exist." );
		}
		
		$info = GetImageSize( $image_to_resize );
		
		if( empty( $info ) )
		{
			exit( "The file " . $image_to_resize . " doesn't seem to be an image." );
		}
		
		$width = $info[ 0 ];
		$height = $info[ 1 ];
		$mime = $info[ 'mime' ];/* Keep Aspect Ratio? */
		if( $ratio )
		{
			$thumb = ( $new_width < $width && $new_height < $height ) ? true : false;// Thumbnail
			$bigger_image = ( $new_width > $width || $new_height > $height ) ? true : false;// Bigger Image
			if( $thumb )
			{
				
				if( $new_width >= $new_height )
				{
					$x = ( $width / $new_width );
					$new_height = ( $height / $x );
				}
				elseif( $new_height >= $new_width )
				{
					$x = ( $height / $new_height );
					$new_width = ( $width / $x );
				}
			}
			elseif( $bigger_image )
			{
				
				if( $new_width >= $width )
				{
					$x = ( $new_width / $width );
					$new_height = ( $height * $x );
				}
				elseif( $new_height >= $height )
				{
					$x = ( $new_height / $height );
					$new_width = ( $width * $x );
				}
			}
		}// What sort of image?
		$type = substr( strrchr( $mime, '/' ), 1 );
		
		switch( $type )
		{
		case 'jpeg':
			$image_create_func = 'ImageCreateFromJPEG';
			$image_save_func = 'ImageJPEG';
			$new_image_ext = 'jpg';
			break;
		case 'png':
			$image_create_func = 'ImageCreateFromPNG';
			$image_save_func = 'ImagePNG';
			$new_image_ext = 'png';
			break;
		case 'bmp':
			$image_create_func = 'ImageCreateFromBMP';
			$image_save_func = 'ImageBMP';
			$new_image_ext = 'bmp';
			break;
		case 'gif':
			$image_create_func = 'ImageCreateFromGIF';
			$image_save_func = 'ImageGIF';
			$new_image_ext = 'gif';
			break;
		case 'vnd.wap.wbmp':
			$image_create_func = 'ImageCreateFromWBMP';
			$image_save_func = 'ImageWBMP';
			$new_image_ext = 'bmp';
			break;
		case 'xbm':
			$image_create_func = 'ImageCreateFromXBM';
			$image_save_func = 'ImageXBM';
			$new_image_ext = 'xbm';
			break;
			default: $image_create_func = 'ImageCreateFromJPEG';
			$image_save_func = 'ImageJPEG';
			$new_image_ext = 'jpg';
		}// New Image
		
		$image_c = ImageCreateTrueColor( $new_width, $new_height );
		
		if ($type=='png') {
			imagealphablending($image_c, false);
			imagesavealpha($image_c, true);
		}
		$new_image = $image_create_func( $image_to_resize );
		if ($type=='png') {
			imagealphablending($new_image, true);
		}
		ImageCopyResampled( $image_c, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		
		$process = $image_save_func( $image_c, $path );
		return array( 'result' => $process, 'new_file_path' => $path );
	}
}