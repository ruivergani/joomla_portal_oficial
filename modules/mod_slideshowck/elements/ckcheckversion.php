<?php

/**
 * @copyright	Copyright (C) 2015 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * http://www.template-creator.com
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.form');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class JFormFieldCkcheckversion extends JFormField {

	protected $type = 'ckcheckversion';

	protected function getLabel() {

		$styles = 'background:#efefef;';
		$styles .= 'border: none;';
		$styles .= 'border-radius: 3px;';
		$styles .= 'color: #333;';
		$styles .= 'font-weight: normal;';
		$styles .= 'line-height: 24px;';
		$styles .= 'padding: 5px;';
		$styles .= 'margin: 3px 0;';
		$styles .= 'text-align: left;';
		$styles .= 'text-decoration: none;';

		$current_version = $this->get_current_version();

		$html = '<div style="' . $styles . '"><img src="' . $this->getPathToElements() . '/images/information.png" style="margin: 0 10px 0 0;" /><b>MODULE SLIDESHOW CK</b> - ' . JText::_('MOD_SLIDESHOWCK_CURRENT_VERSION') . ' : <span class="label">' . $current_version . '</span></div>';
		$html .= '<div id="'.$this->type.'updatealert"></div>';
		$html .= $this->getJs($current_version);

		return $html;
	}
	
	protected function getJs($current_version) {
		$js_checking = '<script>
			jQuery(document).ready(function (){
				// check the release notes
				updateck = function() {}; // needed to avoid errors on bad request
				jQuery.ajax({
						type: "GET",
						url: "http://update.joomlack.fr/mod_slideshowck_update.json?callback=?",
						jsonpCallback: "updateck",
						contentType: "application/json",
						dataType: "jsonp",
					}).done(function(response) {
						var latest_version = \'\';
						for (var version in response) {
							if (compareVersions(version,"' . $current_version . '")) {
								if (! latest_version) {
									latest_version = version;
								}

								if (! jQuery("#'.$this->type.'updatealert").text().length) {
									jQuery("#'.$this->type.'updatealert").append("<span class=\"label label-warning\" style=\"font-size:1em;padding:0.4em;\">' . JText::_('MOD_SLIDESHOWCK_NEW_VERSION_AVAILABLE') . ' : "+latest_version+"</span>");
									jQuery("#'.$this->type.'updatealert").append("<a href=\"http://www.joomlack.fr/en/joomla-extensions/slideshow-ck\" target=\"_blank\" class=\"pull-right btn btn-info\" style=\"font-size:1em;padding:0.2em 0.4em;margin: 0 0 0 5px;\"><i class=\"icon icon-download\"></i>' . JText::_('MOD_SLIDESHOWCK_DOWNLOAD') . '</a>");
								}
								
								// var notes = writeVersionInfo(response, version);
								// jQuery(".updatechecking").append(notes);
							}
						}
					}).fail(function( jqxhr, textStatus, error ) {
						// var err = textStatus + ", " + error;
						// console.log( "Request Failed: " + err );
					});
				
			});
			
			function compareVersions(version1, version2) {
				var a = version1.split(".");
				var b = version2.split(".");

				for (var i = 0; i < a.length; ++i) {
					a[i] = Number(a[i]);
				}
				for (var i = 0; i < b.length; ++i) {
					b[i] = Number(b[i]);
				}
				if (a.length == 2) {
					a[2] = 0;
				}

				if (a[0] > b[0]) return true;
				if (a[0] < b[0]) return false;

				if (a[1] > b[1]) return true;
				if (a[1] < b[1]) return false;

				if (a[2] > b[2]) return true;
				if (a[2] < b[2]) return false;

				return false;
			}
			
			function writeVersionInfo(response, version) {
				var txt = "<div>";
				txt += "<strong class=\"badge\">Version : " + version + "</strong>";
				txt += " - Date : " + response[version]["date"];
				txt += "</div>";
				txt += "<ul>";
				for (var note in response[version]["notes"]) {
					txt += "<li>" + response[version]["notes"][note] + "</li>";
				}
				txt += "</ul>";
				// txt += "<br />";
				return txt;
			}
		</script>';
		
		return $js_checking;
	}
	
	protected function getPathToElements() {
		$localpath = dirname(__FILE__);
		$rootpath = JPATH_ROOT;
		$httppath = trim(JURI::root(), "/");
		$path = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
		return $path;
    }

	protected function getInput() {

		return '';
	}

	/*
	 * Get a variable from the manifest file (actually, from the manifest cache).
	 * 
	 * @return the current version
	 */
	public static function get_current_version() {
		// $db = JFactory::getDbo();
		// $db->setQuery('SELECT manifest_cache FROM #__extensions WHERE element = "mod_slideshowck"');
		// $manifest = json_decode($db->loadResult(), true);
		// $installed_version = $manifest['version'];
		
		// get the version installed
		$installed_version = 'UNKOWN';
		$file_url = JPATH_SITE .'/modules/mod_slideshowck/mod_slideshowck.xml';
		if ($xml_installed = JFactory::getXML($file_url)) {
			$installed_version = (string)$xml_installed->version;
		}

		return $installed_version;
	}
}

