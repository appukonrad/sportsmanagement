<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      statstypelist.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage fields
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Form\FormHelper;

jimport('joomla.filesystem.folder');
FormHelper::loadFieldClass('list');


/**
 * FormFieldStatstypelist
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class FormFieldStatstypelist extends FormField
{
	/**
	 * field type
	 * @var string
	 */
	public $type = 'statstypelist';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		// Initialize some field attributes.
		//$filter = (string) $this->element['filter'];
		//$exclude = (string) $this->element['exclude'];
		//$hideNone = (string) $this->element['hide_none'];
		//$hideDefault = (string) $this->element['hide_default'];

		// Get the path in which to search for file options.
		$files = JFolder::files(JPATH_COMPONENT_ADMINISTRATOR.DS.'statistics', 'php$');
		$options = array();
		foreach ($files as $file)
		{
			$parts = explode('.', $file);
			if ($parts[0] != 'base') {
				$options[] = JHtml::_('select.option', $parts[0], $parts[0]);
			}
		}
		
		/*
		// check for statistic in extensions
		$extensions = sportsmanagementHelper::getExtensions(0);		
		foreach ($extensions as $type)
		{
			$path = JLG_PATH_SITE.DS.'extensions'.DS.$type.DS.'admin'.DS.'statistics';
			if (!file_exists($path)) {
				continue;
			}
			$files = JFolder::files($path, 'php$');
			foreach ($files as $file)
			{
				$parts = explode('.', $file);
				if ($parts[0] != 'base') {
					$options[] = JHtml::_('select.option', $parts[0], $parts[0]);
				}
			}	
		}
		*/
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
