<?php
/** SportsManagement ein Programm zur Verwaltung f�r Sportarten
 * @version   1.0.05
 * @file      subtitle.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage fields
 */

// no direct access
defined('_JEXEC') or die ;

jimport('joomla.form.formfield');

/**
 * JFormFieldSubtitle
 * 
 * @package 
 * @author Dieter Pl�ger
 * @copyright 2017
 * @version $Id$
 * @access public
 */
class JFormFieldSubtitle extends JFormField
{
	public $type = 'Subtitle';

	/**
	 * JFormFieldSubtitle::getLabel()
	 * 
	 * @return
	 */
	protected function getLabel()
	{
		$value = trim($this->element['title']);

		$color = $this->element['color'];
		if (empty($color)) 
        {
			$color = '#e65100';
		}

		$html = '</div>';

		$style = array();

		$style[] = 'display: inherit; ';
		$style[] = 'position: relative; ';
		$style[] = 'background: '.$color.'; ';
		$style[] = 'background: linear-gradient(to right, '.$color.' 0%, #fff 100%); ';
		$style[] = 'height: 5px; ';

		$html .= '<div style="'.implode($style).'">';

		if ($value) 
        {
				
			$style = array();

			$style[] = 'font-family: "Courier New", Courier, monospace; ';
			$style[] = 'letter-spacing: 2px; ';
			$style[] = 'font-size: 10px; ';
			$style[] = 'font-weight: bold; ';
			$style[] = 'background-color: #fff; ';
			$style[] = 'color: '.$color.'; ';
			$style[] = 'padding: 0 8px 0 10px; ';
			$style[] = 'position: absolute; ';
			$style[] = 'left: 20px; ';
			$style[] = 'top: -6px; ';
				
			$html .= '<div style=\''.implode($style).'\'>'.JText::_($value).'</div>';
		}

		return $html;
	}

	/**
	 * JFormFieldSubtitle::getInput()
	 * 
	 * @return
	 */
	protected function getInput()
	{
		return '';
	}

}
?>