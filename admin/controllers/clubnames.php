<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      clubnames.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage controllers
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 


/**
 * sportsmanagementControllerclubnames
 * 
 * @package 
 * @author Dieter Plöger
 * @copyright 2016
 * @version $Id$
 * @access public
 */
class sportsmanagementControllerclubnames extends JControllerAdmin
{
    
  
  
  
  /**
   * sportsmanagementControllerclubnames::import()
   * 
   * @return void
   */
  public function import()
    {
    // Reference global application object
        $app = JFactory::getApplication();
        // JInput object
        $jinput = $app->input;    
        
      $model = $this->getModel();
       $model->import();  
      $this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));  
        
    } 
    
  /**
	 * Save the manual order inputs from the list page.
	 *
	 * @return	void
	 * @since	1.6
	 */
	/*
    public function saveorder()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get the arrays from the Request
		$order	= JFactory::getApplication()->input->getVar('order',	null, 'post', 'array');
		$originalOrder = explode(',', JFactory::getApplication()->input->getString('original_order_values'));

		// Make sure something has changed
		if (!($order === $originalOrder)) {
			parent::saveorder();
		} else {
			// Nothing to reorder
			$this->setRedirect(JRoute::_('index.php?option='.$this->option.'&view='.$this->view_list, false));
			return true;
		}
	}
    */
    
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'clubname', $prefix = 'sportsmanagementModel', $config = Array() ) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}