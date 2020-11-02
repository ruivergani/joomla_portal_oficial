<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Maximenu CK
 * @license		GNU/GPL
 * */
defined('JPATH_BASE') or die;
jimport('joomla.filesystem.file');

if (JFolder::exists(JPATH_ROOT . '/administrator/components/com_virtuemart')) {
    if (!class_exists('VmConfig')) {
		if (JFile::exists(JPATH_ROOT . '/administrator/components/com_virtuemart/helpers/config.php')) 
			require(JPATH_ROOT .  '/administrator/components/com_virtuemart/helpers/config.php');
	}
    if (!class_exists('ShopFunctions')) {
        if (JFile::exists(JPATH_VM_ADMINISTRATOR . '/helpers/shopfunctions.php')) 
			require(JPATH_VM_ADMINISTRATOR . '/helpers/shopfunctions.php');
	}
    if (!class_exists('TableCategories')) {
        if (JFile::exists(JPATH_VM_ADMINISTRATOR . '/tables/categories.php')) 
			require(JPATH_VM_ADMINISTRATOR . '/tables/categories.php');
	}
}
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('cklist');

class JFormFieldCkvmcategory extends JFormFieldCklist {

    protected $type = 'Ckvmcategory';

    protected function getOptions() {
		VmConfig::loadConfig();
        // if VM is not installed
        if (!JFolder::exists(JPATH_ROOT . '/administrator/components/com_virtuemart')
			OR !class_exists('ShopFunctions')) {
            // add the root item
            $option = new stdClass();
            $option->text = JText::_('MOD_SLIDESHOWCK_VIRTUEMART_NOTFOUND');
            $option->value = '0';
            $options[] = $option;
            // Merge any additional options in the XML definition.
            $options = array_merge(parent::getOptions(), $options);

            return $options;
        }
        $categorylist = ShopFunctions::categoryListTree();
		// $categorylist = 'testced';
        $categorylist = trim($categorylist, '</option>');
        $categorylist = explode("</option><option", $categorylist);
        // add the root item
        $option = new stdClass();
        $option->text = JText::_('MOD_SLIDESHOWCK_VIRTUEMART_ROOTNODE');
        $option->value = '0';
        $options[] = $option;
        foreach ($categorylist as $cat) {
            $option = new stdClass();
            $text = explode(">", $cat);
            $option->text = trim($text[1]);
            $option->value = strval(trim(trim(trim($text[0]), '"'), 'value="'));
            $options[] = $option;
        }
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }

}
