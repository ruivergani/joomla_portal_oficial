<?php
/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Maximenu CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class JFormFieldCklink extends JFormField
{
    protected $type = 'cklink';

    protected function getInput()
    {
        return '';
    }
	
	protected function getLabel()
    {
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

		$label = '';
		// Get the label text from the XML element, defaulting to the element name.
		$text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
		$text = $this->translateLabel ? JText::_($text) : $text;
		$icon = $this->element['icon'];
		
		// Build the class for the label.
		$class = !empty($this->description) ? 'hasTip hasTooltip hasTooltip' : '';
		
		$label .= '<div id="'.$this->id.'-link" class="'.$class.'"';
		
		// If a description is specified, use it to build a tooltip.
		if (!empty($this->description)) {
			$label .= ' title="'.htmlspecialchars(trim($text, ':').'<br />' .
				JText::_($this->description), ENT_COMPAT, 'UTF-8').'"';
		}
		
		$label .= ' style="' . $styles . '">';
		$label .= '<img src="' . $this->getPathToElements() . '/images/'.$icon.'" style="margin: 0 10px 0 0;" />';
		$label .= '<a href="' . $this->element['url'] . '" target="_blank">'.$text.'</a></div>';

		return $label;
	}

	protected function getPathToElements() {
		$localpath = dirname(__FILE__);
		$rootpath = JPATH_ROOT;
		$httppath = trim(JURI::root(), "/");
		$pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
		return $pathtoimages;
    }
}


