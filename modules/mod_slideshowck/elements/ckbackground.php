<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldCkbackground extends JFormField {

    protected $type = 'ckbackground';

    protected function getInput() {
		$styles = $this->element['styles'];
		$background = $this->element['background'] ? 'background: url('.$this->getPathToElements() . '/images/' . $this->element['background'].') left top no-repeat;' : '';

		$html = '<p style="'.$background.$styles.'" ></p>';
        return $html;
    }

    protected function getLabel() {
        return '';
    }
	
	protected function getPathToElements() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoimages;
    }

}

