<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      season.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage season
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

/**
 * sportsmanagementModelseason
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModelseason extends JSMModelAdmin
{

	/**
	 * Override parent constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     BaseDatabaseModel
	 * @since   3.2
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
   
	}	
    
    /**
     * sportsmanagementModelseason::saveshortpersons()
     * 
     * @return void
     */
    function saveshortpersons()
    {
        // Reference global application object
        //$app = Factory::getApplication();
        // JInput object
        //$jinput = $app->input;
        //$option = $jinput->getCmd('option');
        //$db = sportsmanagementHelper::getDBConnection();
        
        //$date = Factory::getDate();
//	   $user = Factory::getUser();
       $modified = $this->jsmdate->toSql();
	   $modified_by = $this->jsmuser->get('id');
       
        //$post = Factory::getApplication()->input->post->getArray(array());
        //$post = $jinput->post;
        $pks = $this->jsmjinput->getVar('cid', null, 'post', 'array');
        $teams = $this->jsmjinput->getVar('team_id', null, 'post', 'array');
        $season_id = $this->jsmjinput->getVar('season_id', 0, 'post', 'array');
	$project_id = $this->jsmjinput->getVar('project_id', 0, 'post', 'array');    
        $persontype = $this->jsmjinput->getVar('persontype', 0, 'post', 'array');
        

        
        foreach ( $pks as $key => $value )
        {
        // Create a new query object.
        //$query = $db->getQuery(true);
	$this->jsmquery->clear();	
        // Insert columns.
        $columns = array('person_id','season_id','modified','modified_by');
        // Insert values.
        $values = array($value,$season_id,$this->jsmdb->Quote(''.$modified.''),$modified_by);
        // Prepare the insert query.
        $this->jsmquery
            ->insert($this->jsmdb->quoteName('#__sportsmanagement_season_person_id'))
            ->columns($this->jsmdb->quoteName($columns))
            ->values(implode(',', $values));
            try{
        // Set the query using our newly populated query object and execute it.
        $this->jsmdb->setQuery($this->jsmquery);
	$this->jsmdb->execute();
        }
catch (Exception $e) {
//$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
//$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  

$row = Table::getInstance('season', 'sportsmanagementTable');
$row->load($season_id);
$this->jsmapp->enqueueMessage('Saisonzuordnung : '.$row->name.' schon vorhanden.','notice');	
	
if ( $persontype == 3 )
{
$this->jsmquery->clear();
$this->jsmquery->select('id');
// From table
$this->jsmquery->from('#__sportsmanagement_season_person_id');
$this->jsmquery->where('season_id = '.$season_id);
$this->jsmquery->where('person_id = '.$value);
$this->jsmdb->setQuery($this->jsmquery);
$new_id = $this->jsmdb->loadResult();

$modified = $this->jsmdate->toSql();	
$mdlTable = new stdClass();
$mdlTable->id = $new_id;
$mdlTable->modified = $this->jsmdb->Quote(''.$modified.'');
$mdlTable->modified_by = $modified_by;
$mdlTable->persontype = 3;
$mdlTable->published = 1;	
try {
    $resultupdate = $this->jsmdb->updateObject('#__sportsmanagement_season_person_id', $mdlTable, 'id');
}
catch (Exception $e){
 
}
	
//$this->jsmapp->enqueueMessage('SaisonPersonId : '.$new_id.' ','notice');
// Create and populate an object.
$profile = new stdClass();
$profile->project_id = $project_id;
$profile->person_id = $new_id;
$profile->published = 1;
$profile->modified = $this->jsmdb->Quote(''.$modified.'');
$profile->modified_by = $modified_by;
try{
// Insert the object into the user profile table.
$resultproref = $this->jsmdb->insertObject('#__sportsmanagement_project_referee', $profile);
}
catch (Exception $e){
 
}	
	
}
	
}

        if ( isset($teams) && $persontype != 3 )
        {
        $this->jsmquery->clear();
        // Insert columns.
        $columns = array('person_id','season_id','team_id','published','persontype','modified','modified_by'   );
        // Insert values.
        $values = array($value,$season_id,$teams,'1',$persontype,$this->jsmdb->Quote(''.$modified.''),$modified_by);
        // Prepare the insert query.
        $this->jsmquery
            ->insert($this->jsmdb->quoteName('#__sportsmanagement_season_team_person_id'))
            ->columns($this->jsmdb->quoteName($columns))
            ->values(implode(',', $values));
            try{
        // Set the query using our newly populated query object and execute it.
        $this->jsmdb->setQuery($this->jsmquery);
$this->jsmdb->execute();
        }
catch (Exception $e) {
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  
}
		
        
        }
             
        }
        
    }
    
    /**
     * sportsmanagementModelseason::saveshortteams()
     * 
     * @return void
     */
    function saveshortteams()
    {
        // Reference global application object
        //$app = Factory::getApplication();
        // JInput object
        //$jinput = $app->input;
        //$option = $jinput->getCmd('option');
        //$db = sportsmanagementHelper::getDBConnection();
        //$post = Factory::getApplication()->input->post->getArray(array());
        //$post = $jinput->post;
        $pks = $this->jsmjinput->getVar('cid', null, 'post', 'array');
        $season_id = $this->jsmjinput->getVar('season_id', 0, 'post', 'array');
        

        
        foreach ( $pks as $key => $value )
        {
            // Create a new query object.
        //$query = $db->getQuery(true);
	$this->jsmquery->clear();
        // Insert columns.
        $columns = array('team_id','season_id');
        // Insert values.
        $values = array($value,$season_id);
        // Prepare the insert query.
        $this->jsmquery
            ->insert($this->jsmdb->quoteName('#__sportsmanagement_season_team_id'))
            ->columns($this->jsmdb->quoteName($columns))
            ->values(implode(',', $values));
        try{
        // Set the query using our newly populated query object and execute it.
        $this->jsmdb->setQuery($this->jsmquery);
	$this->jsmdb->execute();
        }
catch (Exception $e) {
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  
} 
        
        }
        
    }
	
}
