<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      view.html.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage rounds
 */


defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * sportsmanagementViewRounds
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementViewRounds extends sportsmanagementView {

    /**
     * sportsmanagementViewRounds::init()
     * 
     * @return
     */
    public function init() {
        $app = Factory::getApplication();
        $this->massadd = 0;
        $this->populate = 0;
        $tpl = NULL;
        /**
         * dadurch werden die spaltenbreiten optimiert
         */
        $this->document->addStyleSheet(Uri::root() . 'administrator/components/com_sportsmanagement/assets/css/form_control.css', 'text/css');

        if ($this->getLayout() == 'default' || $this->getLayout() == 'default_3' || $this->getLayout() == 'default_4') {
            $this->_displayDefault($tpl);
            return;
        } else if ($this->getLayout() == 'populate' || $this->getLayout() == 'populate_3' || $this->getLayout() == 'populate_4') {
            $this->_displayPopulate($tpl);
            return;
        } else if ($this->getLayout() == 'massadd' || $this->getLayout() == 'massadd_3' || $this->getLayout() == 'massadd_4') {
            $this->_displayMassadd($tpl);
            return;
        }
    }

    /**
     * sportsmanagementViewRounds::_displayMassadd()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayMassadd($tpl) {

        $this->project_id = $this->app->getUserState("$this->option.pid", '0');

        $mdlProject = BaseDatabaseModel::getInstance("Project", "sportsmanagementModel");
        $project = $mdlProject->getProject($this->project_id);
        $this->project = $project;
        $this->setLayout('massadd');
    }

    /**
     * sportsmanagementViewRounds::_displayDefault()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayDefault($tpl) {


        $matchday = $this->get('Items');

        $this->table = Table::getInstance('round', 'sportsmanagementTable');

        $this->project_id = $this->app->getUserState("$this->option.pid", '0');

        $mdlProject = BaseDatabaseModel::getInstance('Project', 'sportsmanagementModel');
        $project = $mdlProject->getProject($this->project_id);
        $myoptions = array();
        $myoptions[] = HTMLHelper::_('select.option', '0', Text::_('JNO'));
        $myoptions[] = HTMLHelper::_('select.option', '1', Text::_('JYES'));
        $lists['tournementround'] = $myoptions;

        $this->lists = $lists;
        $this->matchday = $this->items;
        $this->project = $project;
    }

    /**
     * sportsmanagementViewRounds::_displayPopulate()
     * 
     * @param mixed $tpl
     * @return void
     */
    function _displayPopulate($tpl) {

        $this->document->setTitle(Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_POPULATE_TITLE'));
        $lists = array();

        $options = array(HTMLHelper::_('select.option', 0, Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_POPULATE_TYPE_SINGLE_ROUND_ROBIN')),
            HTMLHelper::_('select.option', 1, Text::_('COM_SPORTSMANAGEMENTADMIN_ROUNDS_POPULATE_TYPE_DOUBLE_ROUND_ROBIN')),
            HTMLHelper::_('select.option', 2, Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_POPULATE_TYPE_TOURNAMENT_ROUND_ROBIN'))
        );
        $lists['scheduling'] = HTMLHelper::_('select.genericlist', $options, 'scheduling', '', 'value', 'text');

        //TODO-add error message - what if there are no teams assigned to the project
        $this->project_id = $this->app->getUserState("$this->option.pid", '0');
        $mdlProject = BaseDatabaseModel::getInstance("Project", "sportsmanagementModel");
        $teams = $mdlProject->getProjectTeamsOptions($this->project_id);
        $projectws = $mdlProject->getProject($this->project_id);

        $options = array();
        foreach ($teams as $t) {
            $options[] = HTMLHelper::_('select.option', $t->value, $t->text);
        }
        $lists['teamsorder'] = HTMLHelper::_('select.genericlist', $options, 'teamsorder[]', 'multiple="multiple" size="20"');

        $this->projectws = $projectws;
        $this->lists = $lists;
$this->populate = 1;
        $this->setLayout('populate');
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        // Set toolbar items for the page
        $this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_TITLE');

        if (!$this->massadd) {

if ( $this->populate ) {
        $this->title = Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_POPULATE_TITLE');
ToolbarHelper::apply('round.startpopulate');
        ToolbarHelper::back();
        parent::addToolbar();
}
else
{
            //JLToolBarHelper::custom('round.roundrobin','purge.png','purge_f2.png',Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUND_ROBIN_MASSADD_BUTTON'),false);
            ToolbarHelper::publishList('rounds.publish');
            ToolbarHelper::unpublishList('rounds.unpublish');
            ToolbarHelper::divider();
            ToolbarHelper::custom('rounds.populate', 'purge.png', 'purge_f2.png', Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_POPULATE_BUTTON'), false);
            ToolbarHelper::divider();
            ToolbarHelper::apply('rounds.saveshort');
            ToolbarHelper::divider();

            sportsmanagementHelper::ToolbarButton('massadd', 'new', Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_MASSADD_BUTTON'));

            ToolbarHelper::addNew('round.save');
            ToolbarHelper::divider();

            ToolbarHelper::deleteList('', 'rounds.deleteroundmatches', Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_MASSDEL_BUTTON'));
            parent::addToolbar();
            }
        } else {
            ToolbarHelper::custom('round.cancelmassadd', 'cancel.png', 'cancel_f2.png', Text::_('COM_SPORTSMANAGEMENT_ADMIN_ROUNDS_MASSADD_CANCEL'), false);
            
        }

    }

   

}

?>
