<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
defined('JPATH_PLATFORM') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldCkradio2 extends JFormField {


    /**
     * @var string
     */
    protected $type = 'ckradio2';

    /**
     * @return string
     */
    protected function getInput() {

        // Load the script and stylesheet
        $path = $this->getPathToElements() . '/ckradio2/';
        JHTML::_('script', 'ckradio2.js', $path);
        JHTML::_('stylesheet', 'ckradio2.css', $path);

        // Initialize variables.
        $html = array();
		// var_dump($this->element);
        $icon = $this->element['icon'];
		$styles = $this->element['styles'];
        $optionstyles = $this->element['optionstyles'];
		$suffixstyles = $this->element['suffixstyles'];
        $suffix = $this->element['suffixck'];

        // Initialize some field attributes.
        $class = $this->element['class'] ? ' class="radio ckradio2 ' . (string) $this->element['class'] . '"' : ' class="radio ckradio2"';

        // Start the radio field output.
        $html[] = $icon ? '<img src="' . $this->getPathToElements() . '/images/' . $icon . '" style="margin-right:5px;" />' : '<div style="float:left;width:15px;margin-right:5px;">&nbsp;</div>';
        $html[] = '<fieldset id="' . $this->id . '-fieldset" '.$class.'  style="padding-left:0px;'.$styles.'" >';
        $html[] = '<input type="hidden" isradio="1" id="' . $this->id . '" class="' . $this->element['class'] . '" value="'.$this->value.'" />';

        // Get the field options.
        $options = $this->getOptions();

        // Build the radio field output.
        foreach ($options as $i => $option) {
            if (stristr($option->text,"img:")) $option->text = '<img src="' . $this->getPathToElements() . '/images/' . str_replace("img:","",$option->text) . '" style="margin:0; float:none;" />';
            // Initialize some option attributes.
            $checked = ((string) $option->value == (string) $this->value) ? ' checked="checked"' : '';
            $checkedclass = ((string) $option->value == (string) $this->value) ? ' coche' : '';
            $class = !empty($option->class) ? ' class="radio radioClass ' . $option->class . '"' : ' class="radio radioClass"';
            $labelclass = !empty($option->class) ? ' class="' . $option->class . '"' : '';
            $disabled = !empty($option->disable) ? ' disabled="disabled"' : '';

            // Initialize some JavaScript option attributes.
            $onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
            //$onclick2 = ' onclick="$(\''.$this->id.'\').setProperty(\'value\',this.value);"' ;

            $html[] = '<span class="boutonRadio' . $checkedclass . '" style="' . $optionstyles .'" identifier="'.$this->id.'"><input type="radio" id="' . $this->id . $i . '" name="' . $this->name . '"' .
                    ' value="' . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"'
                    . $checked . $class . $onclick . $disabled . ' style="margin-left:5px;" />';
            // $html[] = $optionicon ? '<img src="' . $this->getPathToElements() . '/images/' . $optionicon . '" style="float:none;" />' : '';
            $html[] = '<span' . $labelclass . '>' . JText::alt($option->text, preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)) . '</span>';
            $html[] = '</span>';
        }

        // End the radio field output.
        $html[] = '</fieldset>';

        return implode($html);
    }

    /**
     * @return mixed
     */
    protected function getPathToElements() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoimages = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoimages;
    }


    /**
     * @return array
     */
    protected function getOptions() {
        // Initialize variables.
        $options = array();

        foreach ($this->element->children() as $option) {

            // Only add <option /> elements.
            if ($option->getName() != 'option') {
                continue;
            }

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_('select.option', (string) $option['value'], trim((string) $option), 'value', 'text', ((string) $option['disabled'] == 'true'));

            // Set some option attributes.
            $tmp->class = (string) $option['class'];

            // Set some JavaScript option attributes.
            $tmp->onclick = (string) $option['onclick'];

            // Add the option object to the result set.
            $options[] = $tmp;
        }

        reset($options);

        return $options;
    }

    /**
     * @return string
     */
    protected function getLabel() {
        $label = '';
		$labelstyles = $this->element['labelstyles'];
        // Get the label text from the XML element, defaulting to the element name.
        $text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
        $text = JText::_($text);

        // Build the class for the label.
        $class = !empty($this->description) ? 'hasTip hasTooltip' : '';

        $label .= '<label id="' . $this->id . '-lbl" for="' . $this->id . '" class="' . $class . '"';

        // If a description is specified, use it to build a tooltip.
        if (!empty($this->description)) {
            $label .= ' title="' . htmlspecialchars(trim($text, ':') . '<br />' .
                            JText::_($this->description), ENT_COMPAT, 'UTF-8') . '"';
        }
// var_dump($this->element);
        $label .= ' style="min-width:150px;max-width:150px;width:150px;display:block;float:left;padding:1px;'.$labelstyles.'">' . $text . '</label>';

        return $label;
    }

}
