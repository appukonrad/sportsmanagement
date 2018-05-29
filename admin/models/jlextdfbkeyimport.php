<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      jlextdfbkeyimport.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage models
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

//require_once( JPATH_COMPONENT_SITE . DS. 'extensions' . DS. 'jlextdfbkey' . DS. 'admin' . DS. 'helpers' . DS . 'helper.php' );

$maxImportTime=480;

if ((int)ini_get('max_execution_time') < $maxImportTime){@set_time_limit($maxImportTime);}

/**
 * sportsmanagementModeljlextDfbkeyimport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModeljlextDfbkeyimport extends JSMModelAdmin
{

function _loadData()
	{
  /*
  global $app, $option;
  echo '_loadData projekt -> '.$app->getUserState( $option . 'project', 0 ).'<br>';
  $this->_data =  $app->getUserState( $option . 'project', 0 );
  return $this->_data;
  */
	}

function _initData()
	{
	/*
	global $app, $option;
  echo '_initData projekt -> '.$app->getUserState( $option . 'project', 0 ).'<br>';
  $this->_data =  $app->getUserState( $option . 'project', 0 );
  return $this->_data;
  */
	}


function getCountry($projectid)
{
$query = "SELECT l.country
from #__".COM_SPORTSMANAGEMENT_TABLE."_league as l
inner join #__".COM_SPORTSMANAGEMENT_TABLE."_project as p
on p.league_id = l.id
where p.id = '$projectid'
";

$this->_db->setQuery( $query );
$country = $this->_db->loadResult();
return $country;
}

/**
	* Method to return the project teams array (id, name)
	*
	* @access  public
	* @return  array
	* @since 0.1
	*/
	function getProjectteams($project_id)
	{
		$option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication ();

		$this->jsmquery->clear();
    $this->jsmquery->select('pt.id AS value');
            $this->jsmquery->select('t.name AS text,t.notes');
            $this->jsmquery->from('#__sportsmanagement_team AS t');
            $this->jsmquery->join('LEFT', '#__sportsmanagement_season_team_id AS st on st.team_id = t.id');
            $this->jsmquery->join('LEFT', '#__sportsmanagement_project_team AS pt ON pt.team_id = st.id');
        $this->jsmquery->where('pt.project_id = ' . $project_id);

		$this->jsmdb->setQuery( $this->jsmquery );
		if ( !$result = $this->jsmdb->loadObjectList() )
		{
			//$this->setError( $this->_db->getErrorMsg() );
            //$app->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($this->_db->getErrorMsg(),true).'</pre>'),'Error');
			return false;
		}
		else
		{
		//$this->_db->execute();
		$number = $this->jsmdb->getNumRows();		
		
		if ( $number > 0 )
		{
/*	
    if ($zahl % 2 != 0) {
echo "Die Zahl $zahl ist ungerade";
} else {
echo "Die Zahl $zahl ist gerade";
}
*/
    return $result;
    }
    else
    {
    return false;
    }
			
		}
	}

function getDFBKey($number,$matchdays)
	{
	$option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication ();
	$document	= JFactory::getDocument();
  
$project_id	= $app->getUserState( "$option.pid", '0' );
	//$project_id = $app->getUserState( $option . 'project' );
	
	// gibt es zum land der liga schlüssel ?
$query = "SELECT l.country
from #__".COM_SPORTSMANAGEMENT_TABLE."_league as l
inner join #__".COM_SPORTSMANAGEMENT_TABLE."_project as p
on p.league_id = l.id
where p.id = '$project_id'
";

$this->_db->setQuery( $query );
$country = $this->_db->loadResult();

	if ( $number % 2 == 0 )
	{
  }
  else
  {
  $number = $number + 1;
  }
	
	if ( $matchdays == 'ALL' )
	{
  $query = "select *
  from #__".COM_SPORTSMANAGEMENT_TABLE."_dfbkey
  where schluessel = " . (int) $number . " 
  and country like '".$country."' group by spieltag ";
  }
  elseif ( $matchdays == 'FIRST' )
  {
  $query = "select *
  from #__".COM_SPORTSMANAGEMENT_TABLE."_dfbkey
  where schluessel = " . (int) $number . "
  and country like '".$country."' 
  and spieltag = 1 ";
  }
	
	
	$this->_db->setQuery( $query );
	
		if ( !$result = $this->_db->loadObjectList() )
		{
			sportsmanagementModeldatabasetool::writeErrorLog(get_class($this), __FUNCTION__, __FILE__, $this->_db->getErrorMsg(), __LINE__);
			return false;
		}
	  else
	  {
    return $result;

    }
	
	}


  function getMatchdays($projectid)
	{
	$option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication ();
	
	$query = 'select *
  from #__'.COM_SPORTSMANAGEMENT_TABLE.'_round
  where project_id = ' . (int) $projectid . '';
	
	$this->_db->setQuery( $query );
		if ( !$result = $this->_db->loadObjectList() )
		{
			sportsmanagementModeldatabasetool::writeErrorLog(get_class($this), __FUNCTION__, __FILE__, $this->_db->getErrorMsg(), __LINE__);
			return false;
		}
	  else
	  {
    return $result;

    }

	}
	
	function getMatches($projectid)
	{
	   $option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication ();
    $db = sportsmanagementHelper::getDBConnection();
    
  $query = 'select *
  from #__'.COM_SPORTSMANAGEMENT_TABLE.'_round
  where project_id = ' . (int) $projectid . '';
	
	$this->_db->setQuery( $query );
  
   if(version_compare(JVERSION,'3.0.0','ge')) 
{
// Joomla! 3.0 code here
		$result = $db->loadColumn();
}
elseif(version_compare(JVERSION,'2.5.0','ge')) 
{
// Joomla! 2.5 code here
		$result = $db->loadResultArray();
}

	//$result = $this->_db->loadResultArray();
	
	$rounds = implode(",",$result);
	$query = 'select count(*)
  from #__'.COM_SPORTSMANAGEMENT_TABLE.'_match
  where round_id in (' . $rounds . ')';
	
	$this->_db->setQuery( $query );
	
	$count = $this->_db->loadResult();
return $count;
  }
	
	function getSchedule( $post, $projectid )
	{
	$option = JFactory::getApplication()->input->getCmd('option');
		$app = JFactory::getApplication ();

/*	
echo '<pre>';
print_r($post);
echo '</pre>';
*/
 
 //echo 'getSchedule project_id -> '.$projectid.'<br>';
 
//$lfdnummer = 1;
foreach($post as $key => $element)
{
if (substr($key,0,10)=="chooseteam")
{
$tempteams=explode ("_",$key);
$chooseteam[$tempteams[1]][projectteamid] = $element;

$query = 'select team.name
  from #__'.COM_SPORTSMANAGEMENT_TABLE.'_team as team
  inner join #__'.COM_SPORTSMANAGEMENT_TABLE.'_project_team as pteam
  on team.id = pteam.team_id
  where pteam.id = ' . (int) $element . ' ';

  $this->_db->setQuery( $query );
  $chooseteam[$tempteams[1]][teamname] = $this->_db->loadResult();
  
//$lfdnummer++;
}

}

/*
echo '<pre>';
print_r($chooseteam);
echo '</pre>';
*/

$number = count($chooseteam);

//echo 'numbers '.$number.'<br>';

if ( $number % 2 == 0 )
	{
  }
  else
  {
  $number = $number + 1;
  }

$query = 'select dfb.*,jr.id, jr.round_date_first
  from #__'.COM_SPORTSMANAGEMENT_TABLE.'_dfbkey as dfb
  inner join #__'.COM_SPORTSMANAGEMENT_TABLE.'_round as jr
  on dfb.spieltag = jr.roundcode
  where dfb.schluessel = ' . (int) $number . 
  ' and jr.project_id = '. $projectid .' order by dfb.spielnummer ';

  $this->_db->setQuery( $query );
  $dfbresult = $this->_db->loadObjectList();

/*  
echo '<pre>';
print_r($dfbresult);
echo '</pre>';
*/



$result = array();

foreach($dfbresult as $row) 
{

$teile = explode(",", $row->paarung);

if ( $chooseteam[$teile[0]][projectteamid] != 0 && $chooseteam[$teile[1]][projectteamid] != 0 )
{
$temp = new stdClass();
$temp->spieltag = $row->spieltag;
$temp->round_id = $row->id;
$temp->spielnummer = $row->spielnummer;
$temp->match_date = $row->round_date_first;
$temp->projectteam1_id = $chooseteam[$teile[0]][projectteamid];
$temp->projectteam2_id = $chooseteam[$teile[1]][projectteamid];
$temp->projectteam1_name = $chooseteam[$teile[0]][teamname];
$temp->projectteam2_name = $chooseteam[$teile[1]][teamname];

$result[] = $temp;
$result = array_merge($result);

}

}

$this->savedfb = $result ;
//  JFactory::getApplication()->input->setVar( 'savedfb', $result,'post' );
//    JFactory::getApplication()->input->set( $result,'post' );
	return $result;
	}
	
    
    
	function checkTable()
  {
  $app = JFactory::getApplication();
    $option = JFactory::getApplication()->input->getCmd('option');
    require_once( JPATH_ADMINISTRATOR.'/components/'.$option.'/'. 'helpers' . DS . 'jinstallationhelper.php' );    
    $db = sportsmanagementHelper::getDBConnection();
    $db_table = JPATH_ADMINISTRATOR.'/components/'.$option.'/sql/dfbkeys.sql';
    
  $query='SELECT count(*) AS count
		FROM #__'.COM_SPORTSMANAGEMENT_TABLE.'_dfbkey';
		$this->_db->setQuery($query);
		$result = $this->_db->loadResult();
        
        if ( !$result )
        {
        $result = JInstallationHelper::populateDatabase($db, $db_table, $errors);    
            
        }
        


  }
  
  
}

?>
