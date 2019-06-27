<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage rankingalltime
 */
 
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

/**
 * sportsmanagementViewRankingAllTime
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementViewRankingAllTime extends sportsmanagementView {

    /**
     * sportsmanagementViewRankingAllTime::display()
     * 
     * @param mixed $tpl
     * @return void
     */
    function init() {
/*     
        // Get a refrence of the page instance in joomla
        $document = Factory::getDocument();

        // Reference global application object
        $app = Factory::getApplication();
        // JInput object
        $jinput = $app->input;
        $option = $jinput->getCmd('option');
        // Get a refrence of the page instance in joomla
        $document = Factory::getDocument();
        if (version_compare(JSM_JVERSION, '4', 'eq')) {
            $uri = Uri::getInstance();
        } else {
            $uri = Factory::getURI();
        }
*/
        $this->document->addScript(Uri::root(true) . '/components/' . $this->option . '/assets/js/smsportsmanagement.js');

        //$model = $this->getModel();

        $this->projectids = $this->model->getAllProject();
        $project_ids = implode(",", $this->projectids);

        $this->project_ids = $project_ids;
        $this->teams = $this->model->getAllTeamsIndexedByPtid($project_ids);

        $this->matches = $this->model->getAllMatches($project_ids);
        $this->ranking = $this->model->getAllTimeRanking();
        $this->tableconfig = $this->model->getAllTimeParams();
        $this->config = $this->model->getAllTimeParams();

        $this->currentRanking = $this->model->getCurrentRanking();

        $this->action = $this->uri->toString();
        $this->colors = $this->model->getColors($this->config['colors']);



        // Set page title
        $pageTitle = Text::_('COM_SPORTSMANAGEMENT_RANKING_PAGE_TITLE');
        $this->document->setTitle($pageTitle);

        //parent::display($tpl);
    }

}

?>
