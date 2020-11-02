/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */

// pour gestion editeur d'images
function jInsertEditorText(text, editor) {
	var valeur = jQuery(text).attr('src');
	jQuery('#'+editor).val(valeur);
	addthumbnail(valeur, '#'+editor);
}

function addthumbnail(imgsrc, editor) {
	var slideimg = jQuery(editor).parent().find('img');
	var testurl = 'http';
	if (imgsrc.toLowerCase().indexOf(testurl.toLowerCase()) != -1) {
		slideimg.attr('src', imgsrc);
	} else {
		slideimg.attr('src', JURI + imgsrc);
	}

	slideimg.attr('width', '64px');
	slideimg.attr('height', '64px');
}

function addslideck(imgname, imgcaption, imgthumb, imglink, imgtarget, imgvideo, slideselect, imgalignment, articleid, imgtime, articlename, imgtitle, state, imgstartdate, imgenddate) {
	if (!imgstartdate)
		imgstartdate = '';
	if (!imgenddate)
		imgenddate = '';
	if (!imgtitle)
		imgtitle = '';
	if (!articleid)
		articleid = '';
	if (!articlename)
		articlename = '';
	if (!imgtime)
		imgtime = '';
	if (!imgname)
		imgname = '';
	if (!imgthumb) {
		imgthumb = '../modules/mod_slideshowck/elements/ckslidesmanager/unknown.png';
	} else {
		imgthumb = JURI + imgname;
	}
	if (!imgcaption)
		imgcaption = '';
	imgcaption = imgcaption.replace(/\|dq\|/g, "&quot;");
	if (!imglink)
		imglink = '';
	if (!imgvideo)
		imgvideo = '';
	if (!imgtarget || imgtarget == 'default') {
		imgtarget = '';
		imgtargetoption = '<option value="default" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('MOD_SLIDESHOWCK_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('MOD_SLIDESHOWCK_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('MOD_SLIDESHOWCK_LIGHTBOX', 'in a Lightbox') + '</option>';
	} else {
		if (imgtarget == '_parent') {
			imgtargetoption = '<option value="default">' + Joomla.JText._('MOD_SLIDESHOWCK_DEFAULT', 'default') + '</option><option value="_parent" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('MOD_SLIDESHOWCK_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('MOD_SLIDESHOWCK_LIGHTBOX', 'in a Lightbox') + '</option>';
		} else if (imgtarget == 'lightbox') {
			imgtargetoption = '<option value="default">' + Joomla.JText._('MOD_SLIDESHOWCK_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('MOD_SLIDESHOWCK_SAMEWINDOW', 'same window') + '</option><option value="_blank">' + Joomla.JText._('MOD_SLIDESHOWCK_NEWWINDOW', 'new window') + '</option><option value="lightbox" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_LIGHTBOX', 'in a Lightbox') + '</option>';
		} else {
			imgtargetoption = '<option value="default">' + Joomla.JText._('MOD_SLIDESHOWCK_DEFAULT', 'default') + '</option><option value="_parent">' + Joomla.JText._('MOD_SLIDESHOWCK_SAMEWINDOW', 'same window') + '</option><option value="_blank" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_NEWWINDOW', 'new window') + '</option><option value="lightbox">' + Joomla.JText._('MOD_SLIDESHOWCK_LIGHTBOX', 'in a Lightbox') + '</option>';
		}
	}
	if (!slideselect) {
		slideselect = '';
		slideselectoption = '<option value="image" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_IMAGE', 'Image') + '</option><option value="video">' + Joomla.JText._('MOD_SLIDESHOWCK_VIDEO', 'Video') + '</option>';
	} else {
		if (slideselect == 'image') {
			slideselectoption = '<option value="image" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_IMAGE', 'Image') + '</option><option value="video">' + Joomla.JText._('MOD_SLIDESHOWCK_VIDEO', 'Video') + '</option>';
		} else {
			slideselectoption = '<option value="image">' + Joomla.JText._('MOD_SLIDESHOWCK_IMAGE', 'Image') + '</option><option value="video" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_VIDEO', 'Video') + '</option>';
		}
	}

	if (!imgalignment) {
		imgalignment = '';
		imgdataalignmentoption = '<option value="default" selected="selected">Default</option>'
				+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
				+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
				+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
				+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
				+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
				+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
				+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
				+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
				+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
	} else {
		if (imgalignment == 'topLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'topCenter') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'topRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'centerLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'center') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'centerRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomLeft') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomCenter') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else if (imgalignment == 'bottomRight') {
			imgdataalignmentoption = '<option value="default">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight" selected="selected">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		} else {
			imgdataalignmentoption = '<option value="default" selected="selected">Default</option>'
					+ '<option value="topLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPLEFT', 'top left') + '</option>'
					+ '<option value="topCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPCENTER', 'top center') + '</option>'
					+ '<option value="topRight">' + Joomla.JText._('MOD_SLIDESHOWCK_TOPRIGHT', 'top right') + '</option>'
					+ '<option value="centerLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLELEFT', 'center left') + '</option>'
					+ '<option value="center">' + Joomla.JText._('MOD_SLIDESHOWCK_CENTER', 'center') + '</option>'
					+ '<option value="centerRight">' + Joomla.JText._('MOD_SLIDESHOWCK_MIDDLERIGHT', 'center right') + '</option>'
					+ '<option value="bottomLeft">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMLEFT', 'bottom left') + '</option>'
					+ '<option value="bottomCenter">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMCENTER', 'bottom center') + '</option>'
					+ '<option value="bottomRight">' + Joomla.JText._('MOD_SLIDESHOWCK_BOTTOMRIGHT', 'bottom right') + '</option>';
		}
	}
	if (!state || state == '1') {
		state = '1';
		statetxt = 'ON';
	} else {
		state = '0';
		statetxt = 'OFF';
	}

	index = checkIndex(0);
	var ckslide = jQuery('<li class="ckslide" id="ckslide' + index + '" />');

	ckslide.html('<div class="ckslidehandle"><div class="ckslidenumber">' + index + '</div></div>'
			+'<div class="ckslidetoggle" data-state="' + state + '"><div class="ckslidetoggler">' + statetxt + '</div></div>'
			+'<div class="ckslidecontainer">'
			+ '<input name="ckslidedelete' + index + '" class="ckslidedelete" type="button" value="' + Joomla.JText._('MOD_SLIDESHOWCK_REMOVE2', '') + '" onclick="javascript:removeslide(this.getParent().getParent());" />'
			+ '<div class="cksliderow"><div class="ckslideimgcontainer"><img src="' + imgthumb + '" width="64" height="64"/></div>'

			+ '<input name="ckslideimgname' + index + '" id="ckslideimgname' + index + '" class="ckslideimgname hasTip hasTooltip" title="Image::This is the main image for the slide, it will also be used to create the thumbnail" type="text" value="' + imgname + '" onchange="javascript:addthumbnail(this.value, this);" />'

			+ '<a class="modal ckselectimg" href="' + JURIBASE + 'index.php?option=com_media&view=images&tmpl=component&e_name=ckslideimgname' + index + '&asset=com_config" rel="{handler: \'iframe\', size: {x: 800, y: 500}}" >' + Joomla.JText._('MOD_SLIDESHOWCK_SELECTIMAGE', 'select image') + '</a></div>'
			+ '<div class="cksliderow2">'
			// + '<span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_USETOSHOW', 'Display') + '</span><select class="ckslideselect">' + slideselectoption + '</select>'
			+ '<span><img src="' + JURI + '/modules/mod_slideshowck/elements/images/hourglass.png" style="float: none; padding-top: 5px;" align="top" class="hasTip hasTooltip" title="' + Joomla.JText._('MOD_SLIDESHOWCK_SLIDETIME', 'enter a specific time value for this slide, else it will be the default time') + '"/><input name="ckslideimgtime' + index + '" class="ckslideimgtime" type="text" value="' + imgtime + '" onchange="javascript:storesetwarning();" style="width:25px;" /></span><span>ms</span>'
			+ '</div>'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_TITLE', 'Title') + '</span><input name="ckslidetitletext' + index + '" class="ckslidetitletext" type="text" value="' + imgtitle + '" onchange="javascript:storesetwarning();" /></div>'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_CAPTION', 'Caption') + '</span><input name="ckslidecaptiontext' + index + '" class="ckslidecaptiontext" type="text" value="' + imgcaption + '" onchange="javascript:storesetwarning();" /></div>'

			+ '<div class="cksliderow"><div id="ckslideaccordion' + index + '">'
			+ '<span class="ckslideaccordeonbutton">' + Joomla.JText._('MOD_SLIDESHOWCK_IMAGEOPTIONS', 'Image options') + '</span>'
			+ '<span class="ckslideaccordeonbutton">' + Joomla.JText._('MOD_SLIDESHOWCK_LINKOPTIONS', 'Link options') + '</span>'
			+ '<span class="ckslideaccordeonbutton">' + Joomla.JText._('MOD_SLIDESHOWCK_VIDEOOPTIONS', 'Video options') + '</span>'
			+ '<span class="ckslideaccordeonbutton">' + Joomla.JText._('MOD_SLIDESHOWCK_ARTICLEOPTIONS', 'Article options') + '</span>'
			+ '<span class="ckslideaccordeonbutton">' + Joomla.JText._('MOD_SLIDESHOWCK_DATESOPTIONS', 'Dates') + '</span>'
			+ '<div style="clear:both;"></div>'
			+ '<div class="ckslideaccordeoncontent">'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_ALIGNEMENT_LABEL', 'Image alignment') + '</span><select name="ckslidedataalignmenttext' + index + '" class="ckslidedataalignmenttext" >' + imgdataalignmentoption + '</select></div>'
			+ '</div>'
			+ '<div class="ckslideaccordeoncontent">'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_LINK', 'Link url') + '</span><input name="ckslidelinktext' + index + '" class="ckslidelinktext" type="text" value="' + imglink + '" onchange="javascript:storesetwarning();" /></div>'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_TARGET', 'Target') + '</span><select name="ckslidetargettext' + index + '" class="ckslidetargettext" >' + imgtargetoption + '</select></div>'
			+ '</div>'
			+ '<div class="ckslideaccordeoncontent">'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_VIDEOURL', 'Video url') + '</span><input name="ckslidevideotext' + index + '" class="ckslidevideotext" type="text" value="' + imgvideo + '" onchange="javascript:storesetwarning();" /></div>'
			+ '</div>'
			+ '<div class="ckslideaccordeoncontent">'
			+ '<div class="cksliderow" id="cksliderowarticle' + index + '"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_ARTICLE_ID', 'Article ID') + '</span><input name="ckslidearticleid' + index + '" class="ckslidearticleid input-medium" id="ckslidearticleid' + index + '" style="width:20px" type="text" value="' + articleid + '" disabled="disabled" onchange="javascript:storesetwarning();" /><input name="ckslidearticlename' + index + '" class="ckslidearticlename input-medium" id="ckslidearticlename' + index + '" type="text" value="' + articlename + '" disabled="disabled" /><a id="ckslidearticlebuttonSelect" class="modal btn" href="index.php?option=com_content&amp;layout=modal&amp;view=articles&amp;tmpl=component&amp;function=jSelectArticle_ckslidearticleid' + index + '" rel="{handler: \'iframe\', size: {x: 800, y: 450}}" style="display:inline-block;margin:0 5px 0 5px;">' + Joomla.JText._('MOD_SLIDESHOWCK_SELECT', 'Select') + '</a><a class="btn" href="javascript:void(0)" onclick="document.getElementById(\'ckslidearticleid' + index + '\').value=\'\';document.getElementById(\'ckslidearticlename' + index + '\').value=\'\';">' + Joomla.JText._('MOD_SLIDESHOWCK_CLEAR', 'Clear') + '</a>'
			+(articleid != '' ? '<a id="ckslidearticlebuttonSelect" class="modal btn" href="index.php?option=com_content&layout=modal&tmpl=component&task=article.edit&id='+articleid+'" rel="{handler: \'iframe\', size: {x: 800, y: 450}}">'+Joomla.JText._('MOD_SLIDESHOWCK_EDIT', 'Edit')+'</a>' : '')
			+'</div>'
			+ '</div>'
			+ '<div class="ckslideaccordeoncontent">'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_STARTDATE', 'Start date') + '</span><input name="ckslidestartdate' + index + '" class="ckslidestartdate ckdatepicker" type="text" value="' + imgstartdate + '" /></div>'
			+ '<div class="cksliderow"><span class="ckslidelabel">' + Joomla.JText._('MOD_SLIDESHOWCK_ENDDATE', 'End date') + '</span><input name="ckslideenddate' + index + '" class="ckslideenddate ckdatepicker" type="text" value="' + imgenddate + '" /></div>'
			+ '</div>'
			+ '</div></div>'
			+ '</div><div style="clear:both;"></div>');

	jQuery('#ckslideslist').append(ckslide);
	
	script = document.createElement("script");
	script.setAttribute('type', 'text/javascript');
	script.text = "function jSelectArticle_ckslidearticleid" + index + "(id, title, catid, object) {"
			+ "document.getElementById('ckslidearticleid" + index + "').value = id;"
			+ "document.getElementById('ckslidearticlename" + index + "').value = title;"
			+ "SqueezeBox.close();"
			+ "}";

	document.body.appendChild(script);

	storeslideck();
	makesortables();
	SqueezeBox.initialize({});
	SqueezeBox.assign(jQuery('#ckslide' + index + ' a.modal'), {
		parse: 'rel'
	});
	create_tabs_in_slide(jQuery('#ckslide' + index));
	jQuery('#ckslide' + index + ' .ckdatepicker').datepicker({"dateFormat": "d MM yy"});

	// add code to toggle the slide state
	jQuery('#ckslide' + index + ' .ckslidetoggle').click(function() {
		if (jQuery(this).attr('data-state') == '0') {
			jQuery(this).attr('data-state', '1');
			jQuery(this).find('.ckslidetoggler').text('ON');
		} else {
			jQuery(this).attr('data-state', '0');
			jQuery(this).find('.ckslidetoggler').text('OFF');
		}
	});
}

function create_tabs_in_slide(slide) {
	jQuery('.ckslideaccordeoncontent', slide).hide();
	jQuery('.ckslideaccordeonbutton', slide).each( function(i, button) {
		this.tab = jQuery('.ckslideaccordeoncontent', slide).eq(i);
		jQuery(button).click(function(){
			if (jQuery(this).hasClass('open')) {
				// if is opened
				jQuery(this).removeClass('open');
				jQuery('.ckslideaccordeoncontent', slide).hide();
			} else {
				// if is closed
				jQuery('.ckslideaccordeonbutton', slide).removeClass('open');
				jQuery(this).addClass('open');
				jQuery('.ckslideaccordeoncontent', slide).hide();
				this.tab.fadeIn();
			}
		});
	});
}

function checkIndex(i) {
	while (jQuery('#ckslide' + i).length)
		i++;
	return i;
}


function removeslide(slide) {
	if (confirm(Joomla.JText._('MOD_SLIDESHOWCK_REMOVE', 'Remove this slide') + ' ?')) {
		jQuery(slide).remove();
		storeslideck();
	}
}

function storesetwarning() {
// $('ckstoreslide').setStyle('background-color', 'red');
}

function storeremovewarning() {
// $('ckstoreslide').setStyle('background-color', 'white');
}

function storeslideck() {
	var i = 0;
	var slides = new Array();
	jQuery('#ckslideslist .ckslide').each(function(i, el) {
		el = jQuery(el);
		slide = new Object();
		slide['imgname'] = el.find('.ckslideimgname').val();
		slide['imgcaption'] = el.find('.ckslidecaptiontext').val();
		slide['imgcaption'] = slide['imgcaption'].replace(/"/g, "|dq|");
		slide['imgtitle'] = el.find('.ckslidetitletext').val();
		slide['imgtitle'] = slide['imgtitle'].replace(/"/g, "|dq|");
		slide['imgthumb'] = el.find('img').attr('src');
		slide['imglink'] = el.find('.ckslidelinktext').val();
		slide['imglink'] = slide['imglink'].replace(/"/g, "|dq|");
		slide['imgtarget'] = el.find('.ckslidetargettext').val();
		slide['imgalignment'] = el.find('.ckslidedataalignmenttext').val();
		slide['imgvideo'] = el.find('.ckslidevideotext').val();
		// slide['slideselect'] = el.find('.ckslideselect').val();
		slide['slidearticleid'] = el.find('.ckslidearticleid').val();
		slide['slidearticlename'] = el.find('.ckslidearticlename').val();
		slide['imgtime'] = el.find('.ckslideimgtime').val();
		slide['state'] = el.find('.ckslidetoggle').attr('data-state');
		slide['startdate'] = el.find('.ckslidestartdate').val();
		slide['enddate'] = el.find('.ckslideenddate').val();
		slides[i] = slide;
		i++;
	});

	slides = JSON.stringify(slides);
	slides = slides.replace(/"/g, "|qq|");
	jQuery('#ckslides').val(slides);

}

function callslides() {
	var slides = jQuery.parseJSON(jQuery('#ckslides').val().replace(/\|qq\|/g, "\""));
	if (slides.length) {
		jQuery(slides).each(function(i, slide) {
			addslideck(slide['imgname'],
					slide['imgcaption'],
					slide['imgthumb'],
					slide['imglink'],
					slide['imgtarget'],
					slide['imgvideo'],
					slide['slideselect'],
					slide['imgalignment'],
					slide['slidearticleid'],
					slide['imgtime'],
					slide['slidearticlename'],
					slide['imgtitle'],
					slide['state'],
					slide['startdate'],
					slide['enddate']
					);
		});
	}
}


function makesortables() {	
	jQuery("#ckslideslist").sortable({
		placeholder: "ui-state-highlight",
		handle: ".ckslidehandle",
		items: ".ckslide",
		axis: "y",
		forcePlaceholderSize: true,
		forceHelperSize: true,
		dropOnEmpty: true,
		tolerance: "pointer",
		placeholder: "placeholder",
		zIndex: 9999,
		update: function(event, ui) {
			renumber_slides();
		},
		sort: function(event, ui) {
			jQuery(ui.placeholder).height(jQuery(ui.helper).height());
		}
	});
}

function renumber_slides() {
	var index = 0;
	jQuery('.ckslide').each(function(i, slide) {
		jQuery('.ckslidenumber', jQuery(slide)).html(i);
		index++;
	});
}

jQuery(document).ready(function() {
	callslides();

	var script = document.createElement("script");
	script.setAttribute('type', 'text/javascript');
	script.text = "Joomla.submitbutton = function(task){"
			+ "storeslideck();"
			+ "var form = document.getElementById('modules-form') || document.getElementById('module-form');"
			+ "if (task == 'module.cancel' || task == 'config.cancel.modules' || document.formvalidator.isValid(form)) {	Joomla.submitform(task, form);"
			+ "if (self != top) {"
			+ "window.top.setTimeout('window.parent.SqueezeBox.close()', 1000);"
			+ "}"
			+ "} else {"
			+ "alert('Formulaire invalide');"
			+ "}}";
	document.body.appendChild(script);
	
//    jQuery( "#datepicker" ).datepicker(
//		{
//			"dateFormat": "d MM yy"
//		}
//		);
});