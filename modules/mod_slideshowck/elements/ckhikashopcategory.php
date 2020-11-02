<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * @license		GNU/GPL
 * */
defined('JPATH_BASE') or die;
jimport('joomla.filesystem.file');
jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('cklist');

class JFormFieldCkhikashopcategory extends JFormFieldCklist {

	protected $type = 'ckhikashopcategory';

	protected function getOptions() {
		// if the component is not installed
		if (!JFolder::exists(JPATH_ROOT . '/administrator/components/com_hikashop')) {
			// add the root item
			$option = new stdClass();
			$option->text = JText::_('MOD_SLIDESHOWCKHIKASHOP_HIKASHOP_NOTFOUND');
			$option->value = '0';
			$options[] = $option;
			// Merge any additional options in the XML definition.
			$options = array_merge(parent::getOptions(), $options);

			return $options;
		}

		// get the categories
		$cats = $this->getCategories();

		// add the root item
		$option = new stdClass();
		$option->text = JText::_('MOD_SLIDESHOWCKHIKASHOP_HIKASHOP_PRODUCT_CATEGORY');
		$option->value = '2';
		$options[] = $option;
		foreach ($cats as $cat) {
			$option = new stdClass();
			$option->text = str_repeat(" - ", $cat->level) . $cat->name;
			$option->value = $cat->id;
			$options[] = $option;
		}
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
	
	protected function getCategories() {

		$db = JFactory::getDBO();
		$query = "SELECT category_name as name,"
				. " #__hikashop_category.category_id as id,"
				. " #__hikashop_category.category_depth-1 as level,"
				. " #__hikashop_category.category_parent_id as parent,"
				. " #__hikashop_category.category_ordering as ordering"
				. " FROM #__hikashop_category"
				. " WHERE #__hikashop_category.category_type = 'product'"
				. " AND #__hikashop_category.category_published = 1"
				. " AND #__hikashop_category.category_depth > 1"
				. " ORDER BY parent DESC, ordering ASC";

		$db->setQuery($query);

		if ($db->query()) {
			$rows = $db->loadObjectList('id');
		} else {
			echo '<p style="color:red;font-weight:bold;">Error loading SQL data : loading the hikashop categories in Maximenu CK</p>';
			return false;
		}

		$level = 0;
		$items = array();
		$i = 0;

		foreach ($rows as $k => &$item) {

			// saves childs into parents items
			if ($item->level > 1) {
				$rows[$item->parent]->haschild = 'yes';
				if (isset($item->haschild)) {
					$rows[$item->parent]->enfants.=$item->id . '|' . $item->enfants;
				} else {
					$rows[$item->parent]->enfants.=$item->id . '|';
				}
			}
			// create childs after respective parent
			if ($item->level == 1) { //gestion des droits des parents niveau 0
				$items[$i] = $item;
				if (isset($active_category_id) && $active_category_id == $item->id) {
					// $active_path[] = $item->id;
				}
				$item->path = array();
				$item->path[] = $item->id;
				if (isset($item->haschild)) {
					$childs = explode("|", $item->enfants);
					foreach ($childs as $c) {
						if ($c) {
							$i++;
							$item->path[] = $rows[$c]->id;
							$rows[$c]->path = $item->path;
							$items[$i] = $rows[$c];
						}
					}
				}
			} else {
				$i--;
			}
			$i++;
		}

		return $items;
	}
}
