<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage editclub
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;


class sportsmanagementViewEditprojectteam extends sportsmanagementView
{

	
	/**
	 * sportsmanagementViewEditClub::init()
	 * 
	 * @return void
	 */
	function init()
	{
	
$this->item = $this->model->getData();
		$lists = array();

		$this->form = $this->get('Form');	
		$extended = sportsmanagementHelper::getExtended($this->item->extended, 'projectteam');
		$this->extended = $extended;
        $this->lists = $lists;

        $this->cfg_which_media_tool = ComponentHelper::getParams($this->option)->get('cfg_which_media_tool',0);
	
	}

	
}
?>

