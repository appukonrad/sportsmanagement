<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage jsmgcalendars
 */

defined('_JEXEC') or die();
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * sportsmanagementViewjsmgcalendars
 * 
 * @package 
 * @author Dieter Pl�ger
 * @copyright 2015
 * @version $Id$
 * @access public
 */
class sportsmanagementViewjsmgcalendars extends sportsmanagementView 
{


/**
 * sportsmanagementViewjsmgcalendars::init()
 * 
 * @return void
 */
public function init ()
	{

        }

	/**
	 * sportsmanagementViewjsmgcalendars::addToolbar()
	 * 
	 * @return void
	 */
	protected function addToolbar() 
    {
		$jinput = Factory::getApplication()->input;
        $option = $jinput->getCmd('option');
        $canDo = jsmGCalendarUtil::getActions();
		if ($canDo->get('core.create')) {
			ToolbarHelper::addNew('jsmgcalendar.add', 'JTOOLBAR_NEW');
			ToolbarHelper::custom('jsmgcalendarimport.import', 'upload.png', 'upload.png', 'COM_SPORTSMANAGEMENT_JSMGCALENDAR_VIEW_GCALENDARS_BUTTON_IMPORT', false);
		}

       
        $this->icon = 'google-calendar-48-icon.png';
        

		parent::addToolbar();
	}

//	protected function init() 
//    {
//		$this->items = $this->get('Items');
//		$this->pagination = $this->get('Pagination');
//	}
}