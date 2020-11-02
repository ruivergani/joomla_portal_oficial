<?php
/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

// définit la largeur du slideshow
$width = ($params->get('width') AND $params->get('width') != 'auto') ? ' style="width:' . $params->get('width') . 'px;"' : '';
$needJModal = false;
?>
<!-- debut Slideshow CK -->
<div class="slideshowck<?php echo $params->get('moduleclass_sfx'); ?> camera_wrap <?php echo $params->get('skin'); ?>" id="camera_wrap_<?php echo $module->id; ?>"<?php echo $width; ?>>
	<?php
	// for ($i = 0; $i < count($items); ++$i) {
	foreach ($items as $i => $item) {
		if ($params->get('displayorder', 'normal') == 'shuffle' && $params->get('limitslides', '') && $i >= $params->get('limitslides', ''))
			break;
		// $item = $items[$i];
		if ($item->imgalignment != 'default') {
			$dataalignment = ' data-alignment="' . $item->imgalignment . '"';
		} else {
			$dataalignment = '';
		}
		$datacaptiontitle = str_replace("|dq|", "\"", $item->imgtitle);
		$datacaptiondesc = str_replace("|dq|", "\"", $item->imgcaption);
		$datacaptionforlightbox = $datacaptiontitle . ( $datacaptiondesc ? '::' . $datacaptiondesc : '');
		$imgtarget = ($item->imgtarget == 'default') ? $params->get('imagetarget') : $item->imgtarget;
		$datatitle = ($params->get('lightboxcaption', 'caption') != 'caption') ? 'data-title="' . htmlspecialchars(str_replace("\"", "&quot;", str_replace(">", "&gt;", str_replace("<", "&lt;", $datacaptionforlightbox)))) . '" ' : '';
		$dataalbum = ($params->get('lightboxgroupalbum', '0')) ? '[albumslideshowck' .$module->id .']' : '';
		$datarel = ($imgtarget == 'lightbox') ? 'data-rel="lightbox' . $dataalbum . '" ' : '';
		$datatime = ($item->imgtime) ? ' data-time="' . $item->imgtime . '"' : '';
		if ($imgtarget == 'lightbox' && $params->get('lightboxtype', 'mediaboxck') == 'squeezebox') $needJModal = true;

		if ($params->get('articlelink', 'readmore') == 'image' && $item->article->link) {
			$item->imglink = $item->article->link;
		} else if ($params->get('lightboxautolinkimages', '0') == '1') {
			$item->imglink = $item->imgname;
		}
		?>
		<div <?php echo $datarel . $datatitle; ?>data-thumb="<?php echo $item->imgthumb; ?>" data-src="<?php echo $item->imgname; ?>" <?php if ($item->imglink) echo 'data-link="' . $item->imglink . '" data-target="' . $imgtarget . '"'; echo $dataalignment . $datatime; ?>>
			<?php if ($item->imgvideo) { ?>
				<iframe src="<?php echo $item->imgvideo; ?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php
			}
			if (($item->imgtitle || $item->imgcaption || $item->article) && (($params->get('lightboxcaption', 'caption') != 'title' || $imgtarget != 'lightbox') || !$item->imglink)) {
			?>
				<?php if ($params->get('usecaption', '1')) { ?>
				<div class="camera_caption <?php echo $params->get('captioneffect', 'moveFromBottom')?>">
					<div class="camera_caption_title">
						<?php echo str_replace("|dq|", "\"", $item->imgtitle); ?>
						<?php
						if ($item->article && $params->get('showarticletitle', '1') == '1') {
							if ($params->get('articlelink', 'readmore') == 'title')
								echo '<a href="' . $item->article->link . '">';
							echo $item->article->title;
							if ($params->get('articlelink', 'readmore') == 'title')
								echo '</a>';
						}
						?>
					</div>
					<?php if ($params->get('usecaptiondesc', '1')) { ?>
					<div class="camera_caption_desc">
						<?php echo str_replace("|dq|", "\"", $item->imgcaption); ?>
						<?php
						if ($item->article) {
							echo $item->article->text;
							if ($params->get('articlelink', 'readmore') == 'readmore')
								echo '<a href="' . $item->article->link . '">' . JText::_('COM_CONTENT_READ_MORE_TITLE') . '</a>';
						}
						?>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			<?php
			}
			?>
		</div>
<?php }
if ($needJModal) JHtml::_('behavior.modal');
?>
</div>
<div style="clear:both;"></div>
<!-- fin Slideshow CK -->
