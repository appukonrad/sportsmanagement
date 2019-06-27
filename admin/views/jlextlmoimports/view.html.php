<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage jlextlmoimports
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;

/**
 * sportsmanagementViewjlextlmoimports
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2013
 * @access public
 */
class sportsmanagementViewjlextlmoimports extends sportsmanagementView
{

	/**
	 * sportsmanagementViewjlextlmoimports::init()
	 * 
	 * @return void
	 */
	public function init ()
	{
		$lang = Factory::getLanguage();

		$config = ComponentHelper::getParams('com_media');
		$post = $this->jinput->post->getArray(array());
		$files = $this->jinput->getArray(array('files'));

		//$this->request_url	= $uri->toString();
		$this->config	= $config;
		$teile = explode("-",$lang->getTag());
		$country = JSMCountries::convertIso2to3($teile[1]);
		$this->country	= $country;
		$countries = JSMCountries::getCountryOptions();
		$lists['countries'] = HTMLHelper::_('select.genericlist', $countries, 'country', 'class="inputbox" size="1"', 'value', 'text', $country);
		$this->countries	= $lists['countries'];
   
	}
    
    /**
     * sportsmanagementViewjlextlmoimports::addToolbar()
     * 
     * @return void
     */
    protected function addToolbar() 
    {
        ToolbarHelper::back('JPREV','index.php?option=com_sportsmanagement&view=extensions');
        parent::addToolbar();
	}
    



  
}
?>
