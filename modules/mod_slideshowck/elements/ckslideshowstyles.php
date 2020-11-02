<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldCkslideshowstyles extends JFormField {

    protected $type = 'ckslideshowstyles';

    protected function getInput() {
		$end = $this->element['end'];
		$styles = $this->element['styles'];
		$imageurl = 'url('.$this->getPathToElements() . '/images/slideshowck_styles.png)';
        
        // load the form
        $identifier = 'params';//var_dump($this->form);die();
        $form = JForm::getInstance('com_modules.module');
        // JForm::addFormPath(JPATH_SITE . '/modules/mod_slideshowck/elements/ckslideshowstyles');
        // if (!$formexists = $form->loadFile('ckslideshowstyles', false)) {
            // echo '<p style="color:red">'.JText::_('Problem loading the file : '.$identifier.'.xml').'</p>';
            // return '';
        // }
        // $this->setJsFunction();
        $fields = $form->getFieldset();
        // var_dump($fields);
        $html = '';
        $html .= '<input name="' . $this->name . '" id="ckslideshowstyles" type="hidden" value="' . $this->value . '" />';
        $html .= '<div style="position:relative;">';
        foreach ($fields as $key => $field) {
        // var_dump($key);
        // var_dump($field->fieldname);//die();
        // $html .=  $form->getInput('height','params');
            // $html .= $form->getLabel(str_replace($identifier."_","",$key), $identifier);
            // $html .= $form->getInput(str_replace($identifier."_","",$key), $identifier);
        }
        // $html .=  $form->getInput('height','params',NULL);
        // $html .=  $form->getInput('params_height');
        $html .= '</div>';
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
    
    protected function setJsFunction() {
        $js = "alert('ok');";
        $document = JFactory::getDocument();
        $document->addScriptDeclaration($js);
    }

}

