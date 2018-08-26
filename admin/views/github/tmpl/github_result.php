<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
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
* OHNE JEDE GEW�HRLEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;

// Include the component HTML helpers.
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers/html');


// welche joomla version ?
if(version_compare(JVERSION,'3.0.0','ge')) 
        {
HTMLHelper::_('jquery.framework');
}

HTMLHelper::_('behavior.tooltip');

HTMLHelper::_('behavior.formvalidation');
HTMLHelper::_('behavior.keepalive');




JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "github.cancel" )
		{
			' . '

			if (window.opener && task == "github.cancel" )
			{
				window.opener.document.closeEditWindow = self;
				window.opener.setTimeout("window.document.closeEditWindow.close()", 1000);
			}

			Joomla.submitform(task, document.getElementById("addissue-formresult"));
		}
	};
');

?>

<div class="container-popup">

<div class="pull-right">
	<button class="btn" type="button" onclick="Joomla.submitbutton('github.cancel', this.form);"><?php echo JText::_('JCANCEL') ?></button>
</div>
<div class="clearfix"></div>

<form  action="<?php echo JRoute::_('index.php?option=com_sportsmanagement');?>" id='addissue-formresult' method='post' style='display:inline' name='adminform' >
<input type="hidden" name="component" value="<?PHP echo $this->option; ?>" />
            <input type='hidden' name='task' value='' />
            <input type="hidden" name="close" id="close" value="0" />
            <input type="hidden" name="gh.token" value="<?PHP echo $this->gh_token; ?>" />
            <input type="hidden" name="api.username" value="<?PHP echo $this->api_username; ?>" />
            <input type="hidden" name="api.password" value="<?PHP echo $this->api_password; ?>" />
</form>

</div>