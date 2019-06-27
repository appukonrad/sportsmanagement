<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version   1.0.05
 * @file      view.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage libraries
 */

defined('_JEXEC') or die();
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Log\Log;

// welche joomla version ?
if(version_compare(JVERSION,'3.0.0','ge')) 
{
HTMLHelper::_('jquery.framework');
HTMLHelper::_('behavior.framework', true);

}
elseif(version_compare(JVERSION,'2.5.0','ge')) 
{
// Joomla! 2.5 code here
HTMLHelper::_('behavior.mootools');  
} 
elseif(version_compare(JVERSION,'1.7.0','ge')) 
{
// Joomla! 1.7 code here

} 
elseif(version_compare(JVERSION,'1.6.0','ge')) 
{
// Joomla! 1.6 code here

} 
else 
{
// Joomla! 1.5 code here

}
?>

<?PHP        
/**
 * sportsmanagementView
 * 
 * @package 
 * @author diddi
 * @copyright 2014
 * @version $Id$
 * @access public
 */
class sportsmanagementView extends HtmlView
{

	protected $icon = '';
	protected $title = '';
    protected $layout = '';
    protected $tmpl = '';
    protected $table_data_class = '';
    protected $table_data_div = '';

	/**
	 * sportsmanagementView::display()
	 * 
	 * @param mixed $tpl
	 * @return
	 */
	public function display ($tpl = null)
	{
/**
 * alle fehlermeldungen online ausgeben
 * mit der kategorie: jsmerror       
 */ 
Log::addLogger(array('logger' => 'messagequeue'), Log::ALL, array('jsmerror'));
/**
 * fehlermeldungen datenbankabfragen
 */
Log::addLogger(array('logger' => 'database','db_table' => '#__sportsmanagement_log_entries'), Log::ALL, array('dblog'));
/**
 * laufzeit datenbankabfragen
 */
Log::addLogger(array('logger' => 'database','db_table' => '#__sportsmanagement_log_entries'), Log::ALL, array('dbperformance'));
	   
        $this->app = Factory::getApplication();
        $this->starttime = microtime(); 
        /**
         * Check for errors.
         */
		if (count($errors = $this->get('Errors')))
		{
			$this->app->enqueueMessage(implode("\n",$errors));
			return false;
		}
        
        $this->layout = $this->getLayout();
        
    if(version_compare(JVERSION,'3.0.0','ge')) 
    {
    $this->uri = Uri::getInstance();
    }
    else
    {
    $this->uri = Factory::getURI();
    }
/**
 * alles aufrufen was für die views benötigt wird
 */
        
$this->document	= Factory::getDocument();
$this->document->addStyleSheet(Uri::root() .'components/com_sportsmanagement/assets/css/flex.css', 'text/css');
$this->document->addScript(Uri::root() . '/components/com_sportsmanagement/assets/js/sm_functions.js');
$this->jinput = $this->app->input;
$this->option = $this->jinput->getCmd('option');
$this->format = $this->jinput->getCmd('format');
$this->view = $this->jinput->getCmd('view', 'cpanel');
$this->tmpl = $this->jinput->getCmd('tmpl', '');
$this->modalheight = ComponentHelper::getParams($this->jinput->getCmd('option'))->get('modal_popup_height', 600);
$this->modalwidth = ComponentHelper::getParams($this->jinput->getCmd('option'))->get('modal_popup_width', 900);
$this->project_id = $this->jinput->get('pid');
$this->jsmmessage = '';
$this->jsmmessagetype = 'notice';
$this->state = $this->get('State');
if(isset($this->state)) {
$this->sortDirection = $this->state->get('list.direction');
$this->sortColumn = $this->state->get('list.ordering');
}

if ( ComponentHelper::getParams($this->option)->get('cfg_which_database') )
{
$this->jsmmessage = 'Sie haben Zugriff auf die externe Datenbank';
}
		
	if ( !$this->project_id )	
	{
	$this->project_id = $this->app->getUserState( "$this->option.pid", '0' );	
	}	
        $this->user = Factory::getUser();
        $this->request_url	= $this->uri->toString();
        
        switch ( $this->view )
            {
            case 'predictions';
            case 'extensions';
            //case 'github';
            break;
            default:
        $this->model = $this->getModel();    
            break;    
            }  
        

//$this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' layout<br><pre>'.print_r($this->layout,true).'</pre>'),'Notice');

/**
 * bei der einzelverarbeitung
*/        
        if ( $this->layout == 'edit' 
        || $this->layout == 'edit_3' 
        || $this->layout == 'edit_4')
        {

switch ( $this->view )
            {
            case 'match';
            case 'predictionproject';
	//case 'jsmgcalendar':
            break;
            default:
$this->addTemplatePath( JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $this->option . DS . 'views' . DS . 'fieldsets' . DS . 'tmpl' );        
		// get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');    
        
        $this->document->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == '".$this->view.".cancel' || document.formvalidator.isValid(document.getElementById('adminForm')))
		{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	};

");

break;
}
        }
/**
 * in der listansicht
*/        
        else
        {    

         


if ( $this->format != 'json' )        	
{
/**
* dadurch werden die spaltenbreiten optimiert
*/
$this->document->addStyleSheet(Uri::root() .'administrator/components/com_sportsmanagement/assets/css/form_control.css', 'text/css');	
}


        switch ( $this->view )
            {
            case 'predictions';
            case 'extensions';
            case 'jlxmlexports';
            case 'treeto';
            case 'jlextdfbkeyimport';
	case 'transifex';
            break;
            default:
            $this->items = $this->get('Items');
            $this->total = $this->get('Total');
		    $this->pagination = $this->get('Pagination');    
            break;    
            }    
            $this->user	= Factory::getUser();
		    $this->config = Factory::getConfig();
            $this->request_url = $this->uri->toString();
        }
        
        if ( ComponentHelper::getParams($this->option)->get('show_debug_info_backend') )
        {
        $this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' state -> <br><pre>'.print_r($this->state,true).'</pre>'),'');
        if(isset($this->sortDirection)) {
            $this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' sortDirection -> <br><pre>'.print_r($this->sortDirection,true).'</pre>'),'');
        }
        if(isset($this->sortColumn)) {
            $this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' sortColumn -> <br><pre>'.print_r($this->sortColumn,true).'</pre>'),'');
        }
        $this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' request_url -> <br><pre>'.print_r($this->request_url,true).'</pre>'),'');
        }
        
        if( version_compare(JSM_JVERSION,'4','eq') ) 
{
            
            //if ( $this->layout == 'edit' )
            //{
            //$this->setLayout($this->getLayout() . '_3');
            //}
            //else
            //{
            $this->setLayout($this->getLayout() . '_4');    
            //}
            
            $this->table_data_class = 'table table-striped';
            $this->table_data_div = '</div>';
}
elseif( version_compare(JSM_JVERSION,'3','eq') ) 
{
            $this->setLayout($this->getLayout() . '_3');
            $this->table_data_class = 'table table-striped';
            $this->table_data_div = '</div>';
}
else
{
// wir lassen das layout so wie es ist, dann müssen
            // nicht so viele dateien umbenannt werden
            $this->setLayout($this->getLayout() );
            $this->table_data_class = 'adminlist';
            $this->table_data_div = '';   
}

        
        
        //$this->app->enqueueMessage(sprintf(Text::_('COM_SPORTSMANAGEMENT_JOOMLA_VERSION'), COM_SPORTSMANAGEMENT_JOOMLAVERSION),'');

		$this->init();

		$this->addToolbar();
        
        //$this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' joomla version -> <br><pre>'.print_r(COM_SPORTSMANAGEMENT_JOOMLAVERSION,true).'</pre>'),'');
        
        // hier wird gesteuert, welcher menüeintrag aktiv ist.
        if(version_compare(JVERSION,'3.0.0','ge')) 
        {
            switch ( $this->view )
            {
                case 'projects';
                case 'projectteams';
                case 'rounds';
                case 'teampersons';
                case 'templates';
                case 'projectreferees';
                case 'projectpositions';
                case 'treetos';
                case 'divisions';
                case 'githubinstall';
                sportsmanagementHelper::addSubmenu('projects');
                break;
                case 'predictions';
                case 'predictiongames';
                case 'predictiongroups';
                case 'predictionmembers';
                case 'predictiontemplates';
                sportsmanagementHelper::addSubmenu('predictions');
                break;
                default:
                sportsmanagementHelper::addSubmenu('cpanel');
                break;
            }
            
        if ( $this->layout == 'edit' 
        || $this->layout == 'edit_3' 
        || $this->layout == 'edit_4' )
        {}
        else
        {    
        $this->sidebar = JHtmlSidebar::render();
        }
        
        }
        
		parent::display($tpl);
	}

	/**
	 * sportsmanagementView::addToolbar()
	 * 
	 * @return void
	 */
	protected function addToolbar ()
	{
	   //$option = Factory::getApplication()->input->getCmd('option');
		//$app = Factory::getApplication();
        //$view = Factory::getApplication()->input->getCmd('view', 'cpanel');
		$canDo = sportsmanagementHelper::getActions();
        
        // in der joomla 3 version kann man die filter setzen
        if(version_compare(JVERSION,'3.0.0','ge')) 
        {
        JHtmlSidebar::setAction('index.php?option=com_sportsmanagement');   
        
        switch ($this->view)
        {
        case 'projects':
        case 'persons':
        case 'predictiongames':
        case 'jlextfederations':
        case 'jlextassociations':
        case 'jlextcountries':
        case 'agegroups':
        case 'eventtypes':
        case 'leagues':
        case 'seasons':
        case 'sportstypes':
        case 'positions':
	case 'clubnames':
	//case 'clubs':
	case 'teams':
	case 'playgrounds':
    case 'rounds':	
    case 'divisions':
    case 'extrafields':				
case 'teampersons':				
        JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);
        break; 
         case 'clubs':
        JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);

$myoptions[] = HTMLHelper::_( 'select.option', '1', Text::_( 'JNO' ) );
$myoptions[] = HTMLHelper::_( 'select.option', '2', Text::_( 'JYES' ) ); 

	JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_GEO_DATEN'),
			'filter_geo_daten',
			HTMLHelper::_('select.options', $myoptions, 'value', 'text', $this->state->get('filter.geo_daten'), true)
		);
			
	if ( isset($this->search_nation) && is_object($this->association) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_ASSOCIATION'),
			'filter_association',
			HTMLHelper::_('select.options', $this->association, 'value', 'text', $this->state->get('filter.association'), true)
		);
        }
			
        break;    
        case 'smquotes':
        JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_PUBLISHED'),
			'filter_state',
			HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
		);
        JHtmlSidebar::addFilter(
			Text::_('JOPTION_SELECT_CATEGORY'),
			'filter_category_id',
			HTMLHelper::_('select.options', HTMLHelper::_('category.options', 'com_sportsmanagement'), 'value', 'text', $this->state->get('filter.category_id'))
		);        
        break;
        }
        
        if ( isset($this->search_nation) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_COUNTRY'),
			'filter_search_nation',
			HTMLHelper::_('select.options', $this->search_nation, 'value', 'text', $this->state->get('filter.search_nation'), true)
		);
        }
		
        if ( isset($this->federation) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_FEDERATION'),
			'filter_federation',
			HTMLHelper::_('select.options', $this->federation, 'value', 'text', $this->state->get('filter.federation'), true)
		);
        }
        
	if ( isset($this->unique_id) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_UNIQUE_ID'),
			'filter_unique_id',
			HTMLHelper::_('select.options', $this->unique_id, 'value', 'text', $this->state->get('filter.unique_id'), true)
		);
        }
	
        
        
        if ( isset($this->userfields) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_USERFIELD_FILTER'),
			'filter_userfields',
			HTMLHelper::_('select.options', $this->userfields, 'id', 'name', $this->state->get('filter.userfields'), true)
		);
        }
        if ( isset($this->league) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_LEAGUES_FILTER'),
			'filter_league',
			HTMLHelper::_('select.options', $this->league, 'id', 'name', $this->state->get('filter.league'), true)
		);
        }
        if ( isset($this->sports_type) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_SPORTSTYPE_FILTER'),
			'filter_sports_type',
			HTMLHelper::_('select.options', $this->sports_type, 'id', 'name', $this->state->get('filter.sports_type'), true)
		);
        }
        if ( isset($this->season) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_SEASON_FILTER'),
			'filter_season',
			HTMLHelper::_('select.options', $this->season, 'id', 'name', $this->state->get('filter.season'), true)
		);
        }
        
        if ( isset($this->prediction_ids) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT_PRED_GAME'),
			'filter_prediction_id',
			HTMLHelper::_('select.options', $this->prediction_ids, 'value', 'text', $this->state->get('filter.prediction_id'), true)
		);
        }
       
        if ( isset($this->project_position_id) )
        {
        JHtmlSidebar::addFilter(
			Text::_('COM_SPORTSMANAGEMENT_D_MENU_POSITIONS'),
			'filter_project_position_id',
			HTMLHelper::_('select.options', $this->project_position_id, 'value', 'text', $this->state->get('filter.project_position_id'), true)
		);
        }

        if ( isset($this->search_agegroup) ) {
            JHtmlSidebar::addFilter(
                Text::_('COM_SPORTSMANAGEMENT_ADMIN_PROJECTS_AGEGROUP_FILTER'),
                'filter_search_agegroup',
                HTMLHelper::_('select.options', $this->search_agegroup, 'value', 'text', $this->state->get('filter.search_agegroup'), true)
            );
        }
         
        }    
        
//$this->app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' layout<br><pre>'.print_r($this->layout,true).'</pre>'),'Notice');
        
        if ( $this->layout == 'edit' 
        || $this->layout == 'edit_3' 
        || $this->layout == 'edit_4' )
        {
        $isNew = $this->item->id == 0;
        $canDo = sportsmanagementHelper::getActions($this->item->id);
        //$view = Factory::getApplication()->input->getCmd('view', 'edit');
            if (empty($this->title))
		    {
            if ( $isNew )
            {
            $this->title = 'COM_SPORTSMANAGEMENT_' . strtoupper($this->getName()).'_NEW';    
            }
            else
            {
            $this->title = 'COM_SPORTSMANAGEMENT_' . strtoupper($this->getName()).'_EDIT';    
            }
            }
        // Built the actions for new and existing records.
        // projectteam
        $search_tmpl_array = array('projectteam' => null, 'treetonode' => null );
		if ($isNew) 
		{
			// For new records, check the create permission.
			if ($canDo->get('core.create')) 
			{
			if( version_compare(JSM_JVERSION,'3','eq') ) 
			{
				ToolbarHelper::apply($this->view.'.apply', 'JTOOLBAR_APPLY');
				ToolbarHelper::save($this->view.'.save', 'JTOOLBAR_SAVE');
                if ( !array_key_exists($this->view, $search_tmpl_array) )
			{
				ToolbarHelper::custom($this->view.'.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
                }
			}
			elseif( version_compare(JSM_JVERSION,'4','eq') ) 
			{
			$toolbarButtons[] = ['apply', $this->view.'.apply'];
			$toolbarButtons[] = ['save', $this->view.'.save'];
            if ( !array_key_exists($this->view, $search_tmpl_array) )
			{
            $toolbarButtons[] = ['save2new', $this->view.'.save2new'];
            }	
			}
				
			}
			ToolbarHelper::cancel($this->view.'.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ( $canDo->get('core.edit') )
			{
				if( version_compare(JSM_JVERSION,'3','eq') ) 
				{
				// We can save the new record
				ToolbarHelper::apply($this->view.'.apply', 'JTOOLBAR_APPLY');
				ToolbarHelper::save($this->view.'.save', 'JTOOLBAR_SAVE');
				}
				elseif( version_compare(JSM_JVERSION,'4','eq') ) 
				{
				$toolbarButtons[] = ['apply', $this->view.'.apply'];
				$toolbarButtons[] = ['save', $this->view.'.save'];		
				}
				// We can save this record, but check the create permission to see if we can return to make a new one.
				if ( $canDo->get('core.create') && !array_key_exists($this->view, $search_tmpl_array) ) 
				{
					if( version_compare(JSM_JVERSION,'3','eq') ) 
					{
					ToolbarHelper::custom($this->view.'.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
					elseif( version_compare(JSM_JVERSION,'4','eq') ) 
					{
					$toolbarButtons[] = ['save2new', $this->view.'.save2new'];	
					}
				}
			}
			if ( $canDo->get('core.create')  && !array_key_exists($this->view, $search_tmpl_array) ) 
			{
				if( version_compare(JSM_JVERSION,'3','eq') ) 
				{
				ToolbarHelper::custom($this->view.'.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				elseif( version_compare(JSM_JVERSION,'4','eq') ) 
				{
				$toolbarButtons[] = ['save2copy', $this->view.'.save2copy'];		
				}
				
				
			}
			ToolbarHelper::cancel($this->view.'.cancel', 'JTOOLBAR_CLOSE');
		}
		
		if( version_compare(JSM_JVERSION,'4','eq') ) 
		{
		ToolbarHelper::saveGroup(
			$toolbarButtons,
			'btn-success'
		);
		}
		
            
        }
        else
        {

		if (empty($this->title))
		{
			$this->title = 'COM_SPORTSMANAGEMENT_' . strtoupper($this->getName());
		}
        
        }
		
        
        
        if (empty($this->icon))
		{
			$this->icon = strtolower($this->getName());
		}
		
        //$app->enqueueMessage(Text::_(__METHOD__.' '.__LINE__.' icon -> '.$this->icon.''),'Notice');
        
        //ToolbarHelper::title(Text::_($this->title), $this->icon);
		$document = Factory::getDocument();
        $document->addScript(Uri::root() . "administrator/components/com_sportsmanagement/views/sportsmanagement/submitbutton.js");
        if(version_compare(JVERSION,'4.0.0-dev','ge')) 
        {
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'administrator/components/com_sportsmanagement/assets/css/jlextusericons4.css'.'" type="text/css" />' ."\n";
        $document->addCustomTag($stylelink);
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'components/com_sportsmanagement/libraries/flag-icon/css/flag-icon.css'.'" type="text/css" />' ."\n";
        $document->addCustomTag($stylelink);
        }
        elseif (version_compare(JVERSION,'3.0.0','ge')) 
        {
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'administrator/components/com_sportsmanagement/assets/css/layout.css'.'" type="text/css" />' ."\n";    
        $document->addCustomTag($stylelink);
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'administrator/components/com_sportsmanagement/assets/css/jlextusericons.css'.'" type="text/css" />' ."\n";
        $document->addCustomTag($stylelink);
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'components/com_sportsmanagement/libraries/flag-icon/css/flag-icon.css'.'" type="text/css" />' ."\n";
        $document->addCustomTag($stylelink);
        }
        else
        {    
        $stylelink = '<link rel="stylesheet" href="'.Uri::root().'administrator/components/com_sportsmanagement/assets/css/jlextusericons.css'.'" type="text/css" />' ."\n";
        $document->addCustomTag($stylelink);
        }
        
		if ( $this->layout == 'edit' 
        || $this->layout == 'edit_3' 
        || $this->layout == 'edit_4' )
        {
        if ($isNew) 
		{
        ToolbarHelper::title(Text::_($this->title), $this->icon);
        }
        else
        {
        ToolbarHelper::title( sprintf(Text::_($this->title),$this->item->name), $this->icon);    
        }
        }
        else
        {
            if(version_compare(JVERSION,'3.0.0','ge')) 
            {
            ToolbarHelper::title(Text::_($this->title) );    
            }
            else
            {
            ToolbarHelper::title(Text::_($this->title), $this->icon);
            }

/**
 * zwischen den views unterscheiden 
 */            
            switch ($this->view)
            { 
            case 'joomleagueimports':
            case 'githubinstall':
            case 'extensions':
	case 'projectteams':
		case 'cpanel':	    
	case 'jlxmlimports':	
		    case 'projectpositions':
            case 'predictionmembers':
	case 'templates':
            case 'predictiongroups':
            case 'jlextdfbkeyimport':
	case 'transifex';
            break;    
            default:    
/**
 * es gibt nur noch die ablage in den papierkorb
 * dadurch sind wir in der lage, fehlerhaft gelöschte einträge
 * wieder herzustellen um eine fehlerursache besser zu finden 
 */
        if ($canDo->get('core.delete')) 
		{
        ToolbarHelper::deleteList('', $this->view.'.delete');
        ToolbarHelper::trash($this->view.'.trash');
        }
        ToolbarHelper::checkin($this->view.'.checkin');  
        break;
        }
        
        }
        
        //sportsmanagementHelper::ToolbarButton('addissue','jsm-issue',Text::_('COM_SPORTSMANAGEMENT_ADMIN_GITHUB_ADD_ISSUE'),'github',0,$this->view,$this->layout);
        //ToolbarHelper::preview('index.php?option=com_sportsmanagement&view=github&layout='.$this->layout.'&tmpl=component'.'&issueview='.$this->view,'github',false);
        //sportsmanagementHelper::ToolbarButtonOnlineHelp();
		
		$cfg_help_server = ComponentHelper::getParams($this->option)->get('cfg_help_server', '');
		$layout = $this->jinput->get('layout');
        $view = ucfirst(strtolower($this->view));
        $layout = ucfirst(strtolower($layout));
		
        if ($canDo->get('core.admin'))
		{
			ToolbarHelper::preferences('com_sportsmanagement');
            //ToolbarHelper::help('JHELP_COMPONENTS_SPORTSMANAGEMENT_CPANEL',false,$cfg_help_server . 'SM-Backend:'. $view . '-' . $layout);
			ToolbarHelper::help('JHELP_COMPONENTS_SPORTSMANAGEMENT_CPANEL',false,$cfg_help_server . 'SM-Backend:'. $view);
			ToolbarHelper::divider();
		}
/**
 * test
 * 
 * 
 */        
$title = Text::_('JTOOLBAR_BATCH');
$layout = new JLayoutFile('newissue', JPATH_ROOT.'/components/com_sportsmanagement/layouts');
$html = $layout->render();        
Toolbar::getInstance('toolbar')->appendButton('Custom', $html , 'batch');         

$modal_params = array(); 
$modal_params['url'] = 'index.php?option=com_sportsmanagement&view=github&layout=addissue&tmpl=component&issuelayout='.$this->layout.'&issueview='.$this->view  ;
$modal_params['height'] = $this->modalheight;
$modal_params['width'] = $this->modalwidth;	
echo HTMLHelper::_('bootstrap.renderModal', 'collapseModal', $modal_params);
		
		
		
	}

	/**
	 * sportsmanagementView::init()
	 * 
	 * @return void
	 */
	protected function init ()
	{
	}
}
