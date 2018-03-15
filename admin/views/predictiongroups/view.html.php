<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHRLEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/**
 * sportsmanagementViewpredictiongroups
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewpredictiongroups extends sportsmanagementView
{
	
	/**
	 * sportsmanagementViewpredictiongroups::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
		//$app = JFactory::getApplication();
		//$jinput = $app->input;
		//$option = $jinput->getCmd('option');
		//$model	= $this->getModel();
		//$uri = JFactory::getURI();
        
		//$this->state = $this->get('State'); 
		//$this->sortDirection = $this->state->get('list.direction');
		//$this->sortColumn = $this->state->get('list.ordering');



		//$items = $this->get('Items');
		//$total = $this->get('Total');
		//$pagination = $this->get('Pagination');
        
		$table = JTable::getInstance('predictiongroup', 'sportsmanagementTable');
		$this->table	= $table;
        
        if ( !$this->items )
        {
        $this->app->enqueueMessage(JText::_('COM_SPORTSMANAGEMENT_ADMIN_PGAMES_NO_GROUPS'),'Error');    
        }

		//$this->user	= JFactory::getUser();
		//$this->lists	= $lists;
		//$this->items	= $items;
		//$this->pagination	= $pagination;
		//$this->request_url	= $uri->toString();
        
       		
	}
	
	/**
	* Add the page title and toolbar.
	*
	* @since	1.7
	*/
	protected function addToolbar()
	{ 
		//// Get a refrence of the page instance in joomla
//		$document	= JFactory::getDocument();
//        $stylelink = '<link rel="stylesheet" href="'.JURI::root().'administrator/components/com_sportsmanagement/assets/css/jlextusericons.css'.'" type="text/css" />' ."\n";
//        $document->addCustomTag($stylelink);
//        

        // Set toolbar items for the page
		$this->title = JText::_('COM_SPORTSMANAGEMENT_ADMIN_PREDICTIONGROUPS_TITLE');
		$this->icon = 'predgroups';

		JToolbarHelper::addNew('predictiongroup.add');
		JToolbarHelper::editList('predictiongroup.edit');
		JToolbarHelper::custom('predictiongroup.import','upload','upload',JText::_('JTOOLBAR_UPLOAD'),false);
		JToolbarHelper::archiveList('predictiongroup.export',JText::_('JTOOLBAR_EXPORT'));
		JToolbarHelper::deleteList('','predictiongroups.delete', 'JTOOLBAR_DELETE');
		JToolbarHelper::checkin('predictiongroups.checkin');
	parent::addToolbar();
	
	}
}
?>
