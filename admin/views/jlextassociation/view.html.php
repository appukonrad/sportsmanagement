<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage jlextassociastion
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/**
 * sportsmanagementViewJlextassociation
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewJlextassociation extends sportsmanagementView
{
	

	/**
	 * sportsmanagementViewJlextassociation::init()
	 * 
	 * @return
	 */
	public function init ()
	{
		
        $starttime = microtime(); 
                       
        if ( COM_SPORTSMANAGEMENT_SHOW_QUERY_DEBUG_INFO )
        {
        $app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' Ausfuehrungszeit query<br><pre>'.print_r(sportsmanagementModeldatabasetool::getQueryTime($starttime, microtime()),true).'</pre>'),'Notice');
        }
        
		 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
        

	}
 
	
	/**
	 * sportsmanagementViewJlextassociation::addToolBar()
	 * 
	 * @return void
	 */
	protected function addToolBar() 
	{
        
		$app	= JFactory::getApplication();
		$jinput	= $app->input;
		$jinput->set('hidemainmenu', true);
		parent::addToolbar();
	}
    
	
}
