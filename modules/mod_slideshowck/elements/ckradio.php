<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
defined('JPATH_PLATFORM') or die;

class JFormFieldCkradio extends JFormField {

    protected $type = 'Ckradio';

    protected function getInput() {
        $html = array();

        // Initialize some field attributes.
        $class = $this->element['class'] ? ' class="radio ' . (string) $this->element['class'] . '"' : ' class="radio"';
        $icon = $this->element['icon'];

        // Start the radio field output.
        $html[] = $icon ? '<div style="display:inline-block;vertical-align:top;margin-top:5px;width:20px;"><img src="' . $this->getPathToElements() . '/images/' . $icon . '" style="margin-right:5px;" /></div>' : '<div style="display:inline-block;width:20px;"></div>';
        $html[] = '<fieldset id="' . $this->id . '-fieldset"' . $class . ' style="display:inline-block;">';
        $html[] = '<input type="hidden" isradio="1" id="' . $this->id . '" class="' . $this->element['class'] . '" value="' . $this->value . '" />';

        // Get the field options.
        $options = $this->getOptions();

        // Build the radio field output.
        foreach ($options as $i => $option) {

            if (stristr($option->text, "img:"))
                $option->text = '<img src="' . $this->getPathToElements() . '/images/' . str_replace("img:", "", $option->text) . '" style="margin:0; float:none;" />';

            // Initialize some option attributes.
            $checked = ((string) $option->value == (string) $this->value) ? ' checked="checked"' : '';
            $class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
            $disabled = !empty($option->disable) ? ' disabled="disabled"' : '';

            // Initialize some JavaScript option attributes.
            $onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
            $onclick = ' onclick="$(\'' . $this->id . '\').setProperty(\'value\',this.value);"';

            $html[] = '<input type="radio" id="' . $this->id . $i . '" name="' . $this->name . '"' . ' value="'
                    . htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $onclick . $disabled . '/>';

            $html[] = '<label for="' . $this->id . $i . '"' . $class . '>'
                    . JText::alt($option->text, preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)) . '</label>';
        }

        // End the radio field output.
        $html[] = '</fieldset>';

        return implode($html);
    }

    protected function getPathToElements() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoelements = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoelements;
    }

    /**
     * Method to get the field options for radio buttons.
     *
     * @return  array  The field option objects.
     *
     * @since   11.1
     */
    protected function getOptions() {
        $options = array();

        foreach ($this->element->children() as $option) {

            // Only add <option /> elements.
            if ($option->getName() != 'option') {
                continue;
            }

            // Create a new option object based on the <option /> element.
            $tmp = JHtml::_(
                            'select.option', (string) $option['value'], trim((string) $option), 'value', 'text',
                            ((string) $option['disabled'] == 'true')
            );

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
     * Method to get the field label markup.
     *
     * @return  string  The field label markup.
     *
     * @since   11.1
     */
    protected function getLabel() {
        $label = '';

        if ($this->hidden) {
            return $label;
        }

        // Get the label text from the XML element, defaulting to the element name.
        $text = $this->element['label'] ? (string) $this->element['label'] : (string) $this->element['name'];
        $text = $this->translateLabel ? JText::_($text) : $text;

        // Build the class for the label.
        $class = !empty($this->description) ? 'hasTip hasTooltip' : '';
        $class = $this->required == true ? $class . ' required' : $class;
        $class = !empty($this->labelClass) ? $class . ' ' . $this->labelClass : $class;

        // Add the opening label tag and main attributes attributes.
        $label .= '<label id="' . $this->id . '-lbl" for="' . $this->id . '" class="' . $class . '"';

        // If a description is specified, use it to build a tooltip.
        if (!empty($this->description)) {
            $label .= ' title="'
                    . htmlspecialchars(
                            trim($text, ':') . '<br />' . ($this->translateDescription ? JText::_($this->description) : $this->description),
                            ENT_COMPAT, 'UTF-8'
                    ) . '"';
        }
        $width = $this->element['labelwidth'] ? $this->element['labelwidth'] : '150px';
        $styles = ' style="min-width:' . $width . ';max-width:' . $width . ';width:' . $width . ';"';
        // Add the label text and closing tag.
        if ($this->required) {
            $label .= $styles . '>' . $text . '<span class="star">&#160;*</span></label>';
        } else {
            $label .= $styles . '>' . $text . '</label>';
        }

        return $label;
    }

}
