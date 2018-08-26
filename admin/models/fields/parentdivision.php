<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      parentdivision.php
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
 * FormFieldparentdivision
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class FormFieldparentdivision extends FormField
{
	/**
	 * field type
	 * @var string
	 */
	public $type = 'parentdivision';

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$option = JFactory::getApplication()->input->getCmd('option');
		$app= JFactory::getApplication();
        $project_id	= $app->getUserState( "$option.pid", '0' );
        
        // Initialize variables.
		$options = array();
        $db = JFactory::getDbo();
		$query = $db->getQuery(true);
                            
        $query->select('dv.id AS value, dv.name AS text');
        $query->from('#__'.COM_SPORTSMANAGEMENT_TABLE.'_division AS dv');
        $query->where('dv.project_id = '.$project_id .' AND dv.parent_id=0 ');
			$query->order('dv.ordering ASC');
			$db->setQuery($query);
			$options = $db->loadObjectList();
                        
        
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
