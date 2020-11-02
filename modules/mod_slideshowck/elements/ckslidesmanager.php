<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

JText::script('MOD_SLIDESHOWCK_ADDSLIDE');
JText::script('MOD_SLIDESHOWCK_SELECTIMAGE');
JText::script('MOD_SLIDESHOWCK_CAPTION');
JText::script('MOD_SLIDESHOWCK_USETOSHOW');
JText::script('MOD_SLIDESHOWCK_IMAGE');
JText::script('MOD_SLIDESHOWCK_VIDEO');
JText::script('MOD_SLIDESHOWCK_IMAGEOPTIONS');
JText::script('MOD_SLIDESHOWCK_LINKOPTIONS');
JText::script('MOD_SLIDESHOWCK_VIDEOOPTIONS');
JText::script('MOD_SLIDESHOWCK_ALIGNEMENT_LABEL');
JText::script('MOD_SLIDESHOWCK_TOPLEFT');
JText::script('MOD_SLIDESHOWCK_TOPCENTER');
JText::script('MOD_SLIDESHOWCK_TOPRIGHT');
JText::script('MOD_SLIDESHOWCK_MIDDLELEFT');
JText::script('MOD_SLIDESHOWCK_CENTER');
JText::script('MOD_SLIDESHOWCK_MIDDLERIGHT');
JText::script('MOD_SLIDESHOWCK_BOTTOMLEFT');
JText::script('MOD_SLIDESHOWCK_BOTTOMCENTER');
JText::script('MOD_SLIDESHOWCK_BOTTOMRIGHT');
JText::script('MOD_SLIDESHOWCK_LINK');
JText::script('MOD_SLIDESHOWCK_TARGET');
JText::script('MOD_SLIDESHOWCK_SAMEWINDOW');
JText::script('MOD_SLIDESHOWCK_NEWWINDOW');
JText::script('MOD_SLIDESHOWCK_VIDEOURL');
JText::script('MOD_SLIDESHOWCK_REMOVE');
JText::script('MOD_SLIDESHOWCK_IMPORTFROMFOLDER');
JText::script('MOD_SLIDESHOWCK_ARTICLEOPTIONS');
JText::script('MOD_SLIDESHOWCK_SLIDETIME');
JText::script('MOD_SLIDESHOWCK_CLEAR');
JText::script('MOD_SLIDESHOWCK_SELECT');
JText::script('MOD_SLIDESHOWCK_TITLE');
JText::script('MOD_SLIDESHOWCK_STARTDATE');
JText::script('MOD_SLIDESHOWCK_ENDDATE');

class JFormFieldCkslidesmanager extends JFormField {

	protected $type = 'ckslidesmanager';

	protected function getInput() {

		$document = JFactory::getDocument();
		$document->addScriptDeclaration("JURI='" . JURI::root() . "';");
		$document->addScriptDeclaration("JURIBASE='" . JURI::base() . "';");
		$path = 'modules/mod_slideshowck/elements/ckslidesmanager/';
		JHtml::_('jquery.framework');
		JHtml::_('behavior.modal');
		JHtml::_('jquery.ui', array('core', 'sortable'));
		// JHTML::_('behavior.modal');
		JHTML::_('script', 'modules/mod_slideshowck/elements/assets/jquery-ui.min.js');
		
		JHTML::_('script', $path . 'ckslidesmanager.js');
		JHTML::_('script', $path . 'FancySortable.js');
		JHTML::_('stylesheet', 'modules/mod_slideshowck/elements/assets/jquery-ui.min.css');
		JHTML::_('stylesheet', $path . 'ckslidesmanager.css');

		$html = '<input name="' . $this->name . '" id="ckslides" type="hidden" value="' . $this->value . '" />'
				. '<input name="ckaddslide" id="ckaddslide" type="button" value="' . JText::_('MOD_SLIDESHOWCK_ADDSLIDE') . '" onclick="javascript:addslideck();"/>'
				//. '<input name="ckaddslidesfromfolder" id="ckaddslidesfromfolder" type="button" value="' . JText::_('MOD_SLIDESHOWCK_ADDSLIDESFROMFOLDER') . '" onclick="javascript:addslidesfromfolderck($(\'ckfoldername\').value);"/>'
				//. '<input name="ckfoldername" id="ckfoldername" value="modules/mod_slideshowck/slides" onclick=""/>'
				//.'<input name="ckaddfromfolder" id="ckaddfromfolder" type="button" value="Import from a folder" onclick="javascript:addfromfolderck();"/>'
				//.'<input name="ckstoreslide" id="ckstoreslide" type="button" value="Save" onclick="javascript:storeslideck();"/>'
				. '<ul id="ckslideslist" style="clear:both;"></ul>'
//				.'<p>Date: <input type="text" id="datepicker"></p>'
				. '<input name="ckaddslide" id="ckaddslide" type="button" value="' . JText::_('MOD_SLIDESHOWCK_ADDSLIDE') . '" onclick="javascript:addslideck();"/>';

		return $html;
	}

	protected function getPathToImages() {
		$localpath = dirname(__FILE__);
		$rootpath = JPATH_ROOT;
		$httppath = trim(JURI::root(), "/");
		$pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
		return $pathtoimages;
	}

	protected function getLabel() {

		return '';
	}

	protected function getArticlesList() {
		$db = & JFactory::getDBO();

		$query = "SELECT id, title FROM #__content WHERE state = 1 LIMIT 2;";
		$db->setQuery($query);
		$row = $db->loadObjectList('id');
		var_dump($row);
		return json_encode($row);
	}

}

