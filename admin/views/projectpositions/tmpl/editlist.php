<?php 
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
?>




<form  action="<?php echo JRoute::_('index.php?option=com_sportsmanagement');?>" id='component-form' method='post' style='display:inline' name='adminform' >
	<div class="col50">

    <fieldset>
		<div class="fltrt">
			<button type="button" onclick="jQuery('select#project_positionslist > option').prop('selected', 'selected');Joomla.submitform('projectpositions.store', this.form)">
				<?php echo JText::_('JSAVE');?></button>
			<button id="cancel" type="button" onclick="<?php echo JRequest::getBool('refresh', 0) ? 'window.parent.location.href=window.parent.location.href;' : '';?>  window.parent.SqueezeBox.close();">
				<?php echo JText::_('JCANCEL');?></button>
		</div>
	</fieldset>
    
		<fieldset class="adminform">
			<legend><?php echo JText::sprintf('COM_SPORTSMANAGEMENT_ADMIN_P_POSITION_EDIT_LEGEND','<i>'.$this->project->name.'</i>');?></legend>
			<table class="adminlist">
			<thead>
				<tr>
					<th><?php echo JText::_('COM_SPORTSMANAGEMENT_ADMIN_P_POSITION_EDIT_AVAILABLE'); ?></th>
					<th width="20"></th>
					<th><?php echo JText::_('COM_SPORTSMANAGEMENT_ADMIN_P_POSITION_EDIT_ASSIGNED'); ?></th>
					
				</tr>
			</thead>
				<tr>		
					<td><?php echo $this->lists['positions']; ?></td>				
					<td style="text-align:center;">
<input id="moveright" type="button" value="Move Right" onclick="move_list_items('positionslist','project_positionslist');" />
<input id="moverightall" type="button" value="Move Right All" onclick="move_list_items_all('positionslist','project_positionslist');" />
<input id="moveleft" type="button" value="Move Left" onclick="move_list_items('project_positionslist','positionslist');" />
<input id="moveleftall" type="button" value="Move Left All" onclick="move_list_items_all('project_positionslist','positionslist');" />

					</td>
					<td><?php echo $this->lists['project_positions']; ?></td>
				</tr>
			</table>
		</fieldset>
		<div class="clr"></div>
		<input type="hidden" name="positionschanges_check" value="0" id="positionschanges_check" />
		<input type="hidden" name="pid" value="<?php echo $this->project->id; ?>" />
		<input type="hidden" name="task" value="" />
        <input type='hidden' name='project_id' value='<?php echo $this->project->id; ?>' />
            <input type="hidden" name="component" value="com_sportsmanagement" />
	</div>
	<?php echo JHTML::_('form.token')."\n"; ?>
</form>