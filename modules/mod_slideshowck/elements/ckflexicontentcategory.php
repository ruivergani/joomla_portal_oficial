<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Maximenu CK
 * @license		GNU/GPL
 * */
defined('JPATH_PLATFORM') or die;
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('cklist');

class JFormFieldCkflexicontentcategory extends JFormFieldCklist {

    protected $type = 'ckflexicontentcategory';

    protected function getOptions() {
        // if flexicontent is not installed
        if (!JFolder::exists(JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_flexicontent')) {
            JPluginHelper::importPlugin('system', 'flexisystem');
            // add the root item
            $option = new stdClass();
            $option->text = JText::_('MOD_MAXIMENUCK_FLEXICONTENT_NOTFOUND');
            $option->value = '0';
            $options[] = $option;
            // Merge any additional options in the XML definition.
            $options = array_merge(parent::getOptions(), $options);

            return $options;
        }
        // For specific cache issues
        global $dump, $globalcats;

        if (empty($globalcats)) {
            if (FLEXI_SECTION || FLEXI_CAT_EXTENSION) {
                if (FLEXI_CACHE) {
                    // add the category tree to categories cache
                    $catscache = JFactory::getCache('com_flexicontent_cats');
                    $catscache->setCaching(1);   //force cache
                    $catscache->setLifeTime(84600); //set expiry to one day
                    $globalcats = $catscache->call(array('plgSystemFlexisystem', 'getCategoriesTree'));
                } else {
                    $globalcats = plgSystemFlexisystem::getCategoriesTree();
                }
            }
        }

        foreach ($globalcats as $cat) {
            $option = new stdClass();
            $option->text = str_replace("<sup>", "", str_replace("</sup>", "", $cat->treename));
            $option->value = $cat->id;
            $options[] = $option;
        }
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }

}
