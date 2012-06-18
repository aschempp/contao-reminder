<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2012
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'reminder';
$GLOBALS['TL_DCA']['tl_form']['palettes']['default'] = str_replace('{expert_legend:hide}', '{reminder_legend:hide},reminder;{expert_legend:hide}', $GLOBALS['TL_DCA']['tl_form']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['reminder'] = 'reminderDelay,reminderTemplate,reminderRecipient,reminderCheck';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form']['fields']['reminder'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['reminder'],
	'inputType'			=> 'checkbox',
	'eval'				=> array('submitOnChange'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_form']['fields']['reminderDelay'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['reminderDelay'],
	'inputType'			=> 'timePeriod',
	'options'			=> array('minutes', 'hours', 'days', 'weeks', 'months', 'years'),
	'reference'			=> &$GLOBALS['TL_LANG']['tl_form']['reminderDelay'],
	'eval'				=> array('mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'clr w50'),
);

$GLOBALS['TL_DCA']['tl_form']['fields']['reminderTemplate'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['reminderTemplate'],
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_form_reminder', 'getMailTemplates'),
	'eval'				=> array('mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_form']['fields']['reminderRecipient'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['reminderRecipient'],
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_form_reminder', 'getFormFields'),
	'eval'				=> array('multiple'=>true, 'size'=>3, 'chosen'=>true, 'tl_class'=>'clr w50'),
);

$GLOBALS['TL_DCA']['tl_form']['fields']['reminderCheck'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_form']['reminderCheck'],
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_form_reminder', 'getFormFields'),
	'eval'				=> array('includeBlankOption'=>true, 'tl_class'=>'w50'),
);



class tl_form_reminder extends Backend
{
	
	/**
	 * Get array of available mail templates
	 * @return array
	 */
	public function getMailTemplates()
	{
		$arrTemplates = array();
		$objTemplates = $this->Database->execute("SELECT id,name,category FROM tl_mail_templates ORDER BY category, name");
		
		while( $objTemplates->next() )
		{
			if ($objTemplates->category == '')
			{
				$arrTemplates[$objTemplates->id] = $objTemplates->name;
			}
			else
			{
				$arrTemplates[$objTemplates->category][$objTemplates->id] = $objTemplates->name;
			}
		}
		
		return $arrTemplates;
	}
	
	
	/**
	 * Get a list of fields for this form
	 * @param
	 * @return array
	 */
	public function getFormFields($dc)
	{
		$arrFields = array();
		$objFields = $this->Database->execute("SELECT id,label,name FROM tl_form_field WHERE name!='' AND pid=" . (int) $dc->id . " ORDER BY sorting");

		while( $objFields->next() )
		{
			$strLabel = $objFields->label == '' ? $objFields->name : $objFields->label . ' (' . $objFields->name . ')';
			$arrFields[$objFields->id] = $strLabel;
		}

		return $arrFields;
	}
}

