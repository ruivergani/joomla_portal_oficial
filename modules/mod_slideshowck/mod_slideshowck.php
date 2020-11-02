<?php

/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;
// JHtml::_('behavior.modal');
require_once dirname(__FILE__) . '/helper.php';

if ($params->get('slideshowckhikashop_enable', '0') == '1') {
	if (JFile::exists(JPATH_ROOT . '/plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php')) {
		require_once JPATH_ROOT . '/plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php';
		$items = modSlideshowckhikashopHelper::getItems($params);
	} else {
		echo '<p style="color:red;font-weight:bold;">File /plugins/system/slideshowckhikashop/helper/helper_slideshowckhikashop.php not found ! Please download the patch for Slideshow CK - Hikashop on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
		return false;
	}
} else if ($params->get('slideshowckjoomgallery_enable', '0') == '1') {
	if (JFile::exists(JPATH_ROOT . '/plugins/system/slideshowckjoomgallery/helper/helper_slideshowckjoomgallery.php')) {
		require_once JPATH_ROOT . '/plugins/system/slideshowckjoomgallery/helper/helper_slideshowckjoomgallery.php';
		$items = modSlideshowckjoomgalleryHelper::getItems($params);
	} else {
		echo '<p style="color:red;font-weight:bold;">File /plugins/system/slideshowckjoomgallery/helper/helper_slideshowckjoomgallery.php not found ! Please download the patch for Slideshow CK - Joomgallery on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
		return false;
	}
} else if ($params->get('slideshowckvirtuemart_enable', '0') == '1') {
	if (JFile::exists(JPATH_ROOT . '/plugins/system/slideshowckvirtuemart/helper/helper_slideshowckvirtuemart.php')) {
		require_once JPATH_ROOT . '/plugins/system/slideshowckvirtuemart/helper/helper_slideshowckvirtuemart.php';
		$items = modSlideshowckvirtuemartHelper::getItems($params);
	} else {
		echo '<p style="color:red;font-weight:bold;">File /plugins/system/slideshowckvirtuemart/helper/helper_slideshowckvirtuemart.php not found ! Please download the patch for Slideshow CK - Virtuemart on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
		return false;
	}
} else if ($params->get('slideshowckk2_enable', '0') == '1') {
	if (JFile::exists(JPATH_ROOT . '/plugins/system/slideshowckk2/helper/helper_slideshowckk2.php')) {
		require_once JPATH_ROOT . '/plugins/system/slideshowckk2/helper/helper_slideshowckk2.php';
		$items = modSlideshowckk2Helper::getItems($params);
	} else {
		echo '<p style="color:red;font-weight:bold;">File /plugins/system/slideshowckk2/helper/helper_slideshowckk2.php not found ! Please download the patch for Slideshow CK - K2 on <a href="http://www.joomlack.fr">http://www.joomlack.fr</a></p>';
		return false;
	}
} else {
	switch ($params->get('slidesssource', 'slidesmanager')) {
		case 'folder':
			$items = modSlideshowckHelper::getItemsFromfolder($params);

			break;
		case 'autoloadfolder':
			$items = modSlideshowckHelper::getItemsAutoloadfolder($params);

			break;
		case 'autoloadarticlecategory':
			$items = modSlideshowckHelper::getItemsAutoloadarticlecategory($params);
			break;
		case 'flickr':
			$items = modSlideshowckHelper::getItemsAutoloadflickr($params);
			break;
		default:
			$items = modSlideshowckHelper::getItems($params);
			break;
	}

	if ($params->get('displayorder', 'normal') == 'shuffle')
		shuffle($items);
}

$document = JFactory::getDocument();
JHTML::_("jquery.framework", true);
if ($params->get('loadjqueryeasing', '1')) {
	$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.easing.1.3.js');
}

$debug = false;
if ($debug) {
	$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/camera.js');
} else {
	$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/camera.min.js');
}

$theme = $params->get('theme', 'default');
$langdirection = $document->getDirection();
if ($langdirection == 'rtl' && JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_rtl.css')) {
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_rtl.css');
} else {
	$document->addStyleSheet(JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera.css');
}

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css')) {
	echo '
		<!--[if lte IE 7]>
		<link href="' . JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css')) {
	echo '
		<!--[if IE 8]>
		<link href="' . JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

// set the navigation variables
if (count($items) == 1) { // for only one slide, no navigation, no button
	$navigation = "navigationHover: false,
			mobileNavHover: false,
			navigation: false,
			playPause: false,";
} else {
	switch ($params->get('navigation', '2')) {
		case 0:
			// aucune
			$navigation = "navigationHover: false,
					mobileNavHover: false,
					navigation: false,
					playPause: false,";
			break;
		case 1:
			// toujours
			$navigation = "navigationHover: false,
					mobileNavHover: false,
					navigation: true,
					playPause: true,";
			break;
		case 2:
		default:
			// on mouseover
			$navigation = "navigationHover: true,
					mobileNavHover: true,
					navigation: true,
					playPause: true,";
			break;
	}
}


// load the slideshow script
$js = "<script type=\"text/javascript\">
		jQuery(function($){
		 $('#camera_wrap_" . $module->id . "').camera({
				 height: '" . $params->get('height', '400') . "',
				 minHeight: '" . $params->get('minheight', '150') . "',
				 pauseOnClick: false,
				 hover: " . $params->get('hover', '1') . ",
				 fx: '" . implode(",", $params->get('effect', array('linear'))) . "',
				 loader: '" . $params->get('loader', 'pie') . "',
				 pagination: " . $params->get('pagination', '1') . ",
				 thumbnails: " . $params->get('thumbnails', '1') . ",
				 thumbheight: " . $params->get('thumbnailheight', '100') . ",
				 thumbwidth: " . $params->get('thumbnailwidth', '75') . ",
				 time: " . $params->get('time', '7000') . ",
				 transPeriod: " . $params->get('transperiod', '1500') . ",
				 alignment: '" . $params->get('alignment', 'center') . "',
				 autoAdvance: " . $params->get('autoAdvance', '1') . ",
				 mobileAutoAdvance: " . $params->get('autoAdvance', '1') . ",
				 portrait: " . $params->get('portrait', '0') . ",
				 barDirection: '" . $params->get('barDirection', 'leftToRight') . "',
				 imagePath: '" . JURI::base(true) . "/modules/mod_slideshowck/images/',
				 lightbox: '" . $params->get('lightboxtype', 'mediaboxck') . "',
				 fullpage: " . $params->get('fullpage', '0') . ",
				 mobileimageresolution: '" . ($params->get('usemobileimage', '0') ? $params->get('mobileimageresolution', '640') : '0') . "',
				 " . $navigation . "
				 barPosition: '" . $params->get('barPosition', 'bottom') . "',
				 responsiveCaption: " . ($params->get('usecaptionresponsive') == '2' ? '1' : '0') . ",
				 container: '" . $params->get('container', '') . "'
		});
}); </script>";

echo $js;

$css = '';
// load some css
$css = "#camera_wrap_" . $module->id . " .camera_pag_ul li img, #camera_wrap_" . $module->id . " .camera_thumbs_cont ul li > img {height:" . modSlideshowckHelper::testUnit($params->get('thumbnailheight', '75')) . ";}";

// load the caption styles
$captioncss = modSlideshowckHelper::createCss($params, 'captionstyles');
$fontfamily = ($params->get('captionstylesusefont','0') && $params->get('captionstylestextgfont', '0')) ? "font-family:'" . $params->get('captionstylestextgfont', 'Droid Sans') . "';" : '';
if ($fontfamily) {
	$gfonturl = str_replace(" ", "+", $params->get('captionstylestextgfont', 'Droid Sans'));
	$document->addStylesheet('https://fonts.googleapis.com/css?family=' . $gfonturl);
}

$css .= "
#camera_wrap_" . $module->id . " .camera_caption {
	display: block;
	position: absolute;
}
#camera_wrap_" . $module->id . " .camera_caption > div {
	" . $captioncss['padding'] . $captioncss['margin'] . $captioncss['background'] . $captioncss['gradient'] . $captioncss['borderradius'] . $captioncss['shadow'] . $captioncss['border'] . $fontfamily . "
}
#camera_wrap_" . $module->id . " .camera_caption > div div.camera_caption_title {
	" . $captioncss['fontcolor'] . $captioncss['fontsize'] . "
}
#camera_wrap_" . $module->id . " .camera_caption > div div.camera_caption_desc {
	" . $captioncss['descfontcolor'] . $captioncss['descfontsize'] . "
}
";

if ($params->get('usecaptionresponsive') == '1' || $params->get('usecaptionresponsive') == '2') {
	$css .= "
@media screen and (max-width: " . str_replace("px", "", $params->get('captionresponsiveresolution', '480')) . "px) {
		#camera_wrap_" . $module->id . " .camera_caption {
			" . ( $params->get('captionresponsivehidecaption', '0') == '1' ? "display: none !important;" : ($params->get('usecaptionresponsive') == '1' ? "font-size: " . $params->get('captionresponsivefontsize', '0.6em') ." !important;" : "") ) . "
		}
}";
}
$document->addStyleDeclaration($css);

// display the module
require JModuleHelper::getLayoutPath('mod_slideshowck', $params->get('layout', 'default'));
