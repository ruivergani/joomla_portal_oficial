<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
defined('JPATH_PLATFORM') or die;

jimport('joomla.html.html');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');

class JFormFieldCkmoduleLayout extends JFormField {

    protected $type = 'CkmoduleLayout';

    protected function getInput() {
        // Initialize variables.
        $icon = $this->element['icon'];

        // Get the client id.
        $clientName = $this->element['client_id'];

        // Get the client id.
        $clientId = $this->element['client_id'];

        if (is_null($clientId) && $this->form instanceof JForm) {
            $clientId = $this->form->getValue('client_id');
        }
        $clientId = (int) $clientId;

        $client = JApplicationHelper::getClientInfo($clientId);

        // Get the module.
        $module = (string) $this->element['module'];

        if (empty($module) && ($this->form instanceof JForm)) {
            $module = $this->form->getValue('module');
        }

        $module = preg_replace('#\W#', '', $module);

        // Get the template.
        $template = (string) $this->element['template'];
        $template = preg_replace('#\W#', '', $template);

        // Get the style.
        if ($this->form instanceof JForm) {
            $template_style_id = $this->form->getValue('template_style_id');
        }

        $template_style_id = preg_replace('#\W#', '', $template_style_id);

        // If an extension and view are present build the options.
        if ($module && $client) {

            // Load language file
            $lang = JFactory::getLanguage();
            $lang->load($module . '.sys', $client->path, null, false, false)
                    || $lang->load($module . '.sys', $client->path . '/modules/' . $module, null, false, false)
                    || $lang->load($module . '.sys', $client->path, $lang->getDefault(), false, false)
                    || $lang->load($module . '.sys', $client->path . '/modules/' . $module, $lang->getDefault(), false, false);

            // Get the database object and a new query object.
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);

            // Build the query.
            $query->select('element, name');
            $query->from('#__extensions as e');
            $query->where('e.client_id = ' . (int) $clientId);
            $query->where('e.type = ' . $db->quote('template'));
            $query->where('e.enabled = 1');

            if ($template) {
                $query->where('e.element = ' . $db->quote($template));
            }

            if ($template_style_id) {
                $query->join('LEFT', '#__template_styles as s on s.template=e.element');
                $query->where('s.id=' . (int) $template_style_id);
            }

            // Set the query and load the templates.
            $db->setQuery($query);
            $templates = $db->loadObjectList('element');

            // Check for a database error.
            if ($db->getErrorNum()) {
                JError::raiseWarning(500, $db->getErrorMsg());
            }

            // Build the search paths for module layouts.
            $module_path = JPath::clean($client->path . '/modules/' . $module . '/tmpl');

            // Prepare array of component layouts
            $module_layouts = array();

            // Prepare the grouped list
            $groups = array();

            // Add the layout options from the module path.
            if (is_dir($module_path) && ($module_layouts = JFolder::files($module_path, '^[^_]*\.php$'))) {
                // Create the group for the module
                $groups['_'] = array();
                $groups['_']['id'] = $this->id . '__';
                $groups['_']['text'] = JText::sprintf('JOPTION_FROM_MODULE');
                $groups['_']['items'] = array();

                foreach ($module_layouts as $file) {
                    // Add an option to the module group
                    $value = JFile::stripExt($file);
                    $text = $lang->hasKey($key = strtoupper($module . '_LAYOUT_' . $value)) ? JText::_($key) : $value;
                    $groups['_']['items'][] = JHtml::_('select.option', '_:' . $value, $text);
                }
            }

            // Loop on all templates
            if ($templates) {
                foreach ($templates as $template) {
                    // Load language file
                    $lang->load('tpl_' . $template->element . '.sys', $client->path, null, false, false)
                            || $lang->load('tpl_' . $template->element . '.sys', $client->path . '/templates/' . $template->element, null, false, false)
                            || $lang->load('tpl_' . $template->element . '.sys', $client->path, $lang->getDefault(), false, false)
                            || $lang->load('tpl_' . $template->element . '.sys', $client->path . '/templates/' . $template->element, $lang->getDefault(), false, false);

                    $template_path = JPath::clean($client->path . '/templates/' . $template->element . '/html/' . $module);

                    // Add the layout options from the template path.
                    if (is_dir($template_path) && ($files = JFolder::files($template_path, '^[^_]*\.php$'))) {
                        foreach ($files as $i => $file) {
                            // Remove layout that already exist in component ones
                            if (in_array($file, $module_layouts)) {
                                unset($files[$i]);
                            }
                        }

                        if (count($files)) {
                            // Create the group for the template
                            $groups[$template->element] = array();
                            $groups[$template->element]['id'] = $this->id . '_' . $template->element;
                            $groups[$template->element]['text'] = JText::sprintf('JOPTION_FROM_TEMPLATE', $template->name);
                            $groups[$template->element]['items'] = array();

                            foreach ($files as $file) {
                                // Add an option to the template group
                                $value = JFile::stripExt($file);
                                $text = $lang->hasKey($key = strtoupper('TPL_' . $template->element . '_' . $module . '_LAYOUT_' . $value)) ? JText::_($key) : $value;
                                $groups[$template->element]['items'][] = JHtml::_('select.option', $template->element . ':' . $value, $text);
                            }
                        }
                    }
                }
            }
            // Compute attributes for the grouped list
            $attr = $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
            $attr .= ' style="width:150px;'.$this->element['styles'].'"';

            // Prepare HTML code
            $html = array();

            // Compute the current selected values
            $selected = array($this->value);

            // Add a grouped list
            $html[] = $icon ? '<div style="display:inline-block;vertical-align:top;margin-top:5px;width:20px;"><img src="' . $this->getPathToElements() . '/images/' . $icon . '" style="margin-right:5px;" /></div>' : '<div style="display:inline-block;width:20px;"></div>';
            $html[] = JHtml::_('select.groupedlist', $groups, $this->name, array('id' => $this->id, 'group.id' => 'id', 'list.attr' => $attr, 'list.select' => $selected));

            return implode($html);
        } else {

            return '';
        }
    }

    protected function getPathToElements() {
        $localpath = dirname(__FILE__);
        $rootpath = JPATH_ROOT;
        $httppath = trim(JURI::root(), "/");
        $pathtoelements = str_replace("\\", "/", str_replace($rootpath, $httppath, $localpath));
        return $pathtoelements;
    }
    
    /**
	 * Method to get the field label markup.
	 *
	 * @return  string  The field label markup.
	 *
	 * @since   11.1
	 */
	protected function getLabel()
	{
		$label = '';

		if ($this->hidden)
		{
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
		if (!empty($this->description))
		{
			$label .= ' title="'
				. htmlspecialchars(
				trim($text, ':') . '<br />' . ($this->translateDescription ? JText::_($this->description) : $this->description),
				ENT_COMPAT, 'UTF-8'
			) . '"';
		}
        $width = $this->element['labelwidth'] ? $this->element['labelwidth'] : '150px';
        $styles = ' style="min-width:'.$width.';max-width:'.$width.';width:'.$width.';"';
		// Add the label text and closing tag.
		if ($this->required)
		{
			$label .= $styles.'>' . $text . '<span class="star">&#160;*</span></label>';
		}
		else
		{
			$label .= $styles.'>' . $text . '</label>';
		}

		return $label;
	}

}
