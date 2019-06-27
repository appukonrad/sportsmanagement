<?php 
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 * @version   1.0.05
 * @file      edit_matchdetails.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 * @package   sportsmanagement
 * @subpackage match
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
use Joomla\CMS\Language\Text;
?>	
<script type="text/javascript">
<!--
window.addEvent('domready', function() {
	// altered decision fields management
	toggle_altdecision();
	$('alt_decision').addEvent('change', toggle_altdecision);
});

function toggle_altdecision() {
	if ($('alt_decision').value == 0) {
	$('alt_decision_enter').style.display='none';
	$('team1_result_decision').disabled=true;
	$('team2_result_decision').disabled=true;
	$('decision_info').disabled=true;
	}
	else {
	$('alt_decision_enter').style.display='block';
	$('team1_result_decision').disabled=false;
	$('team2_result_decision').disabled=false;
	$('decision_info').disabled=false;
	}
}

//-->
</script>
	
<fieldset class="adminform">
	<legend><?php echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_MD'); ?>
	</legend>
	<table class="admintable">
			<?php 
                    
                    foreach ($this->form->getFieldset('matchdetails') as $field):
                    ?>
					<tr>
						<td class="key"><?php echo $field->label; ?></td>
						<td><?php echo $field->input; ?></td>
					</tr>					
					<?php endforeach; ?>	
	</table>
</fieldset>	

		<!-- Alt decision table START -->
			<fieldset class="adminform">
				<legend><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD' );?>
				</legend>
				<table class='admintable'>
					<tr>
						<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_INCL' );?></td>
						<td colspan="3"><?php echo $this->lists['count_result'];?></td>
					</tr>
					<tr>
						<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_SUB_DEC' );?></td>
						<td colspan="3">
							<select	name="alt_decision" id="alt_decision" class="radio btn-group btn-group-yesno"		>
								<option	value="0"<?php if ( $this->match->alt_decision == 0 ){echo ' selected="selected"'; } ?>>
									<?php echo Text::_('JNO');?>
								</option>
								<option	value="1"<?php if ($this->match->alt_decision==1) echo ' selected="selected"' ?>>
									<?php echo Text::_('JYES');?>
								</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="4">
							<div id="alt_decision_enter" style="display:<?php echo ( $this->match->alt_decision == 0 ) ? 'none' : 'block'; ?>">
								<table class='adminForm' cellpadding='0' cellspacing='7' border='0'>
									<tr>
										<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_NEW_SCORE' ).' ' .$this->match->hometeam; ?></td>
										<td>
											<input	type="text" class="inputbox" id="team1_result_decision" name="team1_result_decision"
													size="4"
													value="<?php if ($this->match->alt_decision == 1) if (isset($this->match->team1_result_decision)) echo $this->match->team1_result_decision; else echo 'X'; ?>" <?php if ($this->match->alt_decision == 0) echo 'DISABLED '; ?>/>
										</td>
									</tr>
									<tr>
										<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_NEW_SCORE' ).' ' .$this->match->awayteam;?></td>
										<td>
											<input	type="text" class="inputbox" id="team2_result_decision" name="team2_result_decision"
													size="4" value="<?php
													if ( $this->match->alt_decision == 1 ) if ( isset( $this->match->team2_result_decision ) ) echo $this->match->team2_result_decision; else echo 'X'; ?>" <?php
													if ( $this->match->alt_decision == 0 ) echo 'DISABLED '; ?>/>
										</td>
									</tr>
									<tr>
										<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_REASON_NEW_SCORE' );?></td>
										<?php
										if ( is_null( $this->match->team1_result ) or ( $this->match->alt_decision == 0 ) )
										{
											$disinfo = 'DISABLED ';
										}
										?>
										<td>
											<input	type="text" class="inputbox" id="decision_info" name="decision_info" size="30"
													value="<?php if ( $this->match->alt_decision == 1 ){echo $this->match->decision_info;}?>" <?php
													if ( $this->match->alt_decision == 0 ){echo 'DISABLED ';} ?>/>
										</td>
									</tr>
									<tr>
										<td class="key"><?php echo Text::_( 'COM_SPORTSMANAGEMENT_ADMIN_MATCH_F_AD_TEAM_WON' );?></td>
										<td><?php echo $this->lists['team_won']; ?></td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</fieldset>	