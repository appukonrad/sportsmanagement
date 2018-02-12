<?php 
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      matches.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage editmatch
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');


/**
 * sportsmanagementControllermatches
 * 
 * @package 
 * @author Dieter Pl�ger
 * @copyright 2018
 * @version $Id$
 * @access public
 */
class sportsmanagementControllermatches extends JControllerLegacy
{

/**
     * sportsmanagementControllermatches::__construct()
     * 
     * @return void
     */
    function __construct()
	{
		parent::__construct();

	}

    /**
	 * Returns a reference to the global {@link JoomlaTuneAjaxResponse} object,
	 * only creating it if it doesn't already exist.
	 *
	 * @return JoomlaTuneAjaxResponse
	 */
	public static function getAjaxResponse()
	{
		static $instance = null;

		if (!is_object($instance)) {
			$instance = new JoomlaTuneAjaxResponse('utf-8');
		}

		return $instance;
	}
    
    /**
     * sportsmanagementControllermatches::savesubst()
     * 
     * @return void
     */
    function savesubst()
	{
		$data = array();
		$data['in'] 					= JFactory::getApplication()->input->getInt('in');
		$data['out'] 					= JFactory::getApplication()->input->getInt('out');
		$data['matchid'] 				= JFactory::getApplication()->input->getInt('matchid');
		$data['in_out_time'] 			= JFactory::getApplication()->input->getVar('in_out_time','');
		$data['project_position_id'] 	= JFactory::getApplication()->input->getInt('project_position_id');
        // diddipoeler
        $data['projecttime']			= JFactory::getApplication()->input->getVar('projecttime','');
        $model = $this->getModel();
		if (!$result = $model->savesubstitution($data)){
			$result = "0"."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVED_SUBST').': '.$model->getError();
		} else {
            $result = $model->getDbo()->insertid()."&".JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_SUBST');
		}
		echo json_encode($result);
		JFactory::getApplication()->close();
	}
    
    /**
     * sportsmanagementControllermatches::savecomment()
     * 
     * @return void
     */
    function savecomment()
    {
		$data = array();
		$data['event_time']		= JFactory::getApplication()->input->getVar('event_time','');
		$data['match_id']		= JFactory::getApplication()->input->getInt('matchid');
		$data['type']		= JFactory::getApplication()->input->getVar('type', '');
		$data['notes']			= JFactory::getApplication()->input->getVar('notes', '');
        
        // diddipoeler
        $data['projecttime']			= JFactory::getApplication()->input->getVar('projecttime','');
        
        $model = $this->getModel();
		if (!$result = $model->savecomment($data)) {
            $result = '0&'.JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_ERROR_SAVED_COMMENT').': '.$model->getError();
        } else {
            $result = $result.'&'.JText::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_CTRL_SAVED_COMMENT');
		}    
		echo json_encode($result);
		JFactory::getApplication()->close();
    }

}
