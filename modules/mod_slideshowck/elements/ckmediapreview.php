<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JFormFieldCkmediapreview extends JFormField {

    protected $type = 'Ckmediapreview';

    protected function getInput() {
        $source = $this->element['source'];
        echo "<script>
        window.addEvent('domready', function() {
            $('".$this->id."').src = '".JURI::root()."'+$('jform_params_".$source."').value;
            $('jform_params_".$source."').addEvent('change', function() {
                $('".$this->id."').src = '".JURI::root()."'+$('jform_params_".$source."').value;
            });
        });
        </script>";

        $path = 'modules/mod_beautifulck/elements/jscolor/';
        JHTML::_('script', 'jscolor.js', $path);
        $styles = $this->element['styles'];
        $html = '';
        // $html .= '<img src="' . $this->getPathToImages() . '/images/color.png" />';
        $html.= '<div style="clear:both;border:7px solid white;border-radius:5px;box-shadow:#000 0px 0px 3px;width:64px;height:64px;overflow:hidden;"><img id="'.$this->id.'" src="test.png" style="width:64px;height:64px;margin:0;" /></div>';
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

}

