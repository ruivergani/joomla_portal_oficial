<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldCkcontainer extends JFormField {

    protected $type = 'ckcontainer';

    protected function getInput() {
		$end = $this->element['end'];
		$styles = $this->element['styles'];
		$background = $this->element['background'] ? 'background-image: url('.$this->getPathToImages() . '/images/' . $this->element['background'].');' : '';
		$tag = $this->element['tag'];
		if ($end == '1') {
			// $html = '</li></'.$tag.'><li>';
            $html = '</'.$tag.'><div><div>';
		} else {
			// $html = '</li><'.$tag.' style="'.$background.$styles.'" ><li>';
            $html = '</div></div><'.$tag.' style="'.$background.$styles.'" >';
		}
		// var_dump($html);
        $identifier = 'menustyles';
        $form = new JForm($identifier);
        JForm::addFormPath(JPATH_SITE . '/modules/mod_slideshowck/elements/test');
        if (!$formexists = $form->loadFile($identifier, false)) {
            echo '<p style="color:red">'.JText::_('Problem loading the file : '.$identifier.'.xml').'</p>';
            return '';
        }
        $fields = $form->getFieldset();
        foreach ($fields as $key => $field) {
            // echo '<div class="ckpopup_row">';
            $html .= $form->getLabel(str_replace($identifier."_","",$key), $identifier);
            $html .= $form->getInput(str_replace($identifier."_","",$key), $identifier);
            // echo '</div>';

        }
        return $html;
    }

    protected function getLabel() {
        return '';
    }
	
	protected function getPathToImages() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoimages;
    }

}

