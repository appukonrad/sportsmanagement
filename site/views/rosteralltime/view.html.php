<?php 
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage rosteralltime
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.JSM_PATH.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'player.php');

jimport('joomla.application.component.view');

/**
 * sportsmanagementViewRosteralltime
 * 
 * @package 
 * @author abcde
 * @copyright 2015
 * @version $Id$
 * @access public
 */
class sportsmanagementViewRosteralltime extends JViewLegacy
{

	/**
	 * sportsmanagementViewRosteralltime::display()
	 * 
	 * @param mixed $tpl
	 * @return void
	 */
	function display($tpl=null)
	{
		// Get a refrence of the page instance in joomla
		$document = Factory::getDocument();
		$model = $this->getModel();
        $user = Factory::getUser();
		$config = sportsmanagementModelProject::getTemplateConfig($this->getName(),$model::$cfg_which_database);
        
        $state = $this->get('State');
		$items = $this->get('Items');
        
        $pagination	= $this->get('Pagination');

		$this->config = $config;
        $this->team = $model->getTeam();
    
    $this->playerposition = $model->getPlayerPosition();
    $this->project = sportsmanagementModelProject::getProject($model::$cfg_which_database,__METHOD__);
    $this->positioneventtypes = $model->getPositionEventTypes();

	$this->rows = $model->getTeamPlayers(1,$this->positioneventtypes,$items);
    	
        $this->items = $items;
		$this->state = $state;
		$this->user = $user;
		$this->pagination = $pagination;
        
		parent::display($tpl);
	}

}
?>