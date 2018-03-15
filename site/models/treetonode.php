<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version    1.0.05
* @file                
* @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
* @copyright  Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license    This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

/**
 * sportsmanagementModelTreetonode
 * 
 * @package 
 * @author Dieter Pl�ger
 * @copyright 2017
 * @version $Id$
 * @access public
 */
class sportsmanagementModelTreetonode extends JSMModelLegacy
{

	var $projectid = 0;
	var $treetoid = 0;

	/**
	 * sportsmanagementModelTreetonode::__construct()
	 * 
	 * @return void
	 */
	function __construct( )
	{
		parent::__construct( );
		
		$this->projectid = $this->jsmjinput->getInt('p',0);
		$this->treetoid = $this->jsmjinput->getInt('tnid',0);
                
	}

	/**
	 * sportsmanagementModelTreetonode::getTreetonode()
	 * 
	 * @return
	 */
	function getTreetonode()
	{
		if (!$this->projectid) 
        {
			$this->setError(JText::_('COM_SPORTSMANAGEMENT_ADMIN_DFBKEYS_ERROR_1'));
			return false;
		}
        if ( !$this->treetoid )
        {
        $this->treetoid = $this->getTreeNodeID($this->projectid);    
        }
        $this->jsmquery->clear();
        
		$this->jsmquery->select('ttn.* ');
		$this->jsmquery->select('ttn.id AS ttnid');
		$this->jsmquery->select('c.country AS country');
		$this->jsmquery->select('c.logo_small AS logo_small');
        $this->jsmquery->select('c.logo_middle AS logo_middle');
        $this->jsmquery->select('c.logo_big AS logo_big');
		$this->jsmquery->select('t.name AS team_name ');
		$this->jsmquery->select('t.middle_name AS middle_name ');
		$this->jsmquery->select('t.short_name AS short_name ');
		$this->jsmquery->select('t.id AS tid ');
		$this->jsmquery->select('ttn.title AS title ');
		$this->jsmquery->select('ttn.content AS content ');
		$this->jsmquery->select('tt.tree_i AS tree_i ');
		$this->jsmquery->select('tt.hide AS hide ');
        $this->jsmquery->from('#__sportsmanagement_treeto_node AS ttn ');   
        
		$this->jsmquery->join('LEFT','#__sportsmanagement_project_team AS pt ON pt.id = ttn.team_id ');
        $this->jsmquery->join('LEFT','#__sportsmanagement_season_team_id AS st on pt.team_id = st.id ');
		$this->jsmquery->join('LEFT','#__sportsmanagement_team AS t ON t.id = st.team_id ');
		$this->jsmquery->join('LEFT','#__sportsmanagement_club AS c ON c.id = t.club_id ');
		$this->jsmquery->join('LEFT','#__sportsmanagement_treeto AS tt ON tt.id = ttn.treeto_id ');
        $this->jsmquery->where('ttn.treeto_id = ' .  (int) $this->treetoid );
        $this->jsmquery->order('ttn.row');
        
		$this->jsmdb->setQuery( $this->jsmquery );
		$result = $this->jsmdb->loadObjectList();
		
		return $result;
	}
	
    
    /**
     * sportsmanagementModelTreetonode::getTreeNodeID()
     * 
     * @param integer $projectid
     * @return void
     */
    function getTreeNodeID($projectid=0)
    {
    $this->jsmquery->clear();    
    $this->jsmquery->select('id');    
    $this->jsmquery->from('#__sportsmanagement_treeto');
    $this->jsmquery->where('project_id = ' .  (int) $projectid ); 
    $this->jsmdb->setQuery( $this->jsmquery );
	$result = $this->jsmdb->loadResult();
	return $result;    
    }
    
    
	/**
	 * sportsmanagementModelTreetonode::getNodeMatches()
	 * 
	 * @param integer $ttnid
	 * @return
	 */
	function getNodeMatches($ttnid=0)
	{
	   $this->jsmquery->clear();
       $this->jsmquery->select('mc.id AS value ');
       $this->jsmquery->select('CONCAT(t1.name, \'_vs_\', t2.name, \' [round:\',r.roundcode,\']\') AS text');
       $this->jsmquery->from('#__sportsmanagement_match AS mc ');   
       $this->jsmquery->join('LEFT','#__sportsmanagement_project_team AS pt1 ON pt1.id = mc.projectteam1_id');
       $this->jsmquery->join('LEFT','#__sportsmanagement_project_team AS pt2 ON pt2.id = mc.projectteam2_id');
       
       $this->jsmquery->join('LEFT','#__sportsmanagement_season_team_id AS st1 on pt1.team_id = st1.id');  
       $this->jsmquery->join('LEFT','#__sportsmanagement_season_team_id AS st2 on pt2.team_id = st2.id');  
       
       $this->jsmquery->join('LEFT','#__sportsmanagement_team AS t1 ON t1.id = st1.team_id');
       $this->jsmquery->join('LEFT','#__sportsmanagement_team AS t2 ON t2.id = st2.team_id');
       $this->jsmquery->join('LEFT','#__sportsmanagement_round AS r ON r.id = mc.round_id');
       $this->jsmquery->join('LEFT','#__sportsmanagement_treeto_match AS ttm ON mc.id = ttm.match_id ');
        
       $this->jsmquery->where('ttm.node_id = ' . (int) $ttnid );
       $this->jsmquery->order('mc.id');
       $this->jsmdb->setQuery($this->jsmquery);
	$result = $this->_db->loadObjectList();
			return $result;

	}
	
	/**
	 * sportsmanagementModelTreetonode::showNodeMatches()
	 * 
	 * @param mixed $nodes
	 * @return void
	 */
	function showNodeMatches(&$nodes)
	{
		//TODO
		$matches = $this->model->getNodeMatches($nodes);
		$lineinover = '';
		foreach ($matches as $mat)
		{
			$lineinover .= $mat->text.'<br/>';
		}
		echo $lineinover;
	}
	
	/**
	 * sportsmanagementModelTreetonode::getRoundName()
	 * 
	 * @return
	 */
	function getRoundName()
	{
		$this->jsmquery->clear();
        $this->jsmquery->select('*');
        $this->jsmquery->from('#__sportsmanagement_round AS r');   
        $this->jsmquery->where('r.project_id = ' . (int) $this->projectid );
        $this->jsmquery->order('r.roundcode');
		$this->jsmdb->setQuery( $this->jsmquery );
		$result = $this->jsmdb->loadObjectList();

		return $result;
	}
}
