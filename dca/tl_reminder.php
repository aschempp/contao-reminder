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
 * Table tl_reminder
 */
$GLOBALS['TL_DCA']['tl_reminder'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'					=> 'Table',
		'enableVersioning'				=> true,
		'closed'						=> true,
		'notEditable'					=> true,
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'						=> 1,
			'fields'					=> array('stop'),
			'flag'						=> 6,
			'panelLayout'				=> 'filter;search,limit',
			'filter' => array
			(
//				array('stop>?', mktime(0,0,0)),
			),
		),
		'label' => array
		(
			'fields'					=> array('recipients'),
			'format'					=> '%s',
			'label_callback'			=> array('tl_reminder', 'addIcon'),
		),
		'operations' => array
		(
			'delete' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_reminder']['delete'],
				'href'					=> 'act=delete',
				'icon'					=> 'delete.gif',
				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'					=> &$GLOBALS['TL_LANG']['tl_reminder']['show'],
				'href'					=> 'act=show',
				'icon'					=> 'show.gif'
			),
		)
	),

	// Palettes
	'palettes' => array(),

	// Fields
	'fields' => array
	(
		'firstname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['firstname'],
		),
		'lastname' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['lastname'],
		),
		'recipients' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['recipients'],
		),
		'start' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['start'],
			'eval'						=> array('rgxp'=>'date'),
		),
		'stop' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['stop'],
			'eval'						=> array('rgxp'=>'date'),
		),
		'language' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['language'],
		),
		'mail_template' => array
		(
			'label'						=> &$GLOBALS['TL_LANG']['tl_reminder']['mail_template'],
//			'inputType'					=> 'select',
//			'options_callback'			=> array('tl_reminder', 'getMailTemplates'),
			'foreignKey'				=> 'tl_mail_templates.name',
//			'eval'						=> array('mandatory'=>true, 'includeBlankOption'=>true),
		),
	)
);


class tl_reminder extends Backend
{

	/**
	 * Add an image to each record
	 * @param array
	 * @param string
	 * @return string
	 */
	public function addIcon($row, $label)
	{
		static $time;
		
		if (!$time)
		{
			$time = mktime(23,59,59);
		}

		$image = 'pending';

		// if reminder has been sent today or earlier
		if ($row['stop'] < $time)
		{
			$image = 'complete';
		}

		return sprintf('<div class="list_icon" style="line-height:16px;background-image:url(\'system/modules/reminder/html/%s.png\');">%s</div>', $image, $label);
	}
	
	
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
}

