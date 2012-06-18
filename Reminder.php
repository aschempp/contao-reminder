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


class Reminder extends System
{

	public function __construct()
	{
		parent::__construct();
		
		$this->import('Database');
	}


	/**
	 * Create a reminder for the cancellation date
	 * @param array
	 * @param array
	 * @param array
	 */
	public function processFormData($arrPost, $arrForm, $arrFiles)
	{
		$arrFields = deserialize($arrForm['reminderRecipient']);
		
		if ($arrForm['reminder'] && $arrForm['reminderTemplate'] > 0 && is_array($arrFields) && !empty($arrFields))
		{
			$arrDelay = deserialize($arrForm['reminderDelay']);
			
			if (!is_array($arrDelay) || $arrDelay['value'] < 1 || $arrDelay['unit'] == '')
			{
				return;
			}
			
			$arrRecipients = array();
			$objFields = $this->Database->execute("SELECT * FROM tl_form_field WHERE id IN (" . implode(',', array_map('intval', $arrFields)) . ")");
			
			while ($objFields->next())
			{
				if ($arrPost[$objFields->name] != '' && $this->isValidEmailAddress($arrPost[$objFields->name]))
				{
					$arrRecipients[] = $arrPost[$objFields->name];
				}
			}

			if (empty($arrRecipients))
			{
				return;
			}

			$arrSet = array
			(
				'tstamp'		=> time(),
				'recipients'	=> implode(', ', $arrRecipients),
				'data'			=> serialize($arrPost),
				'start'			=> time(),
				'stop'			=> strtotime('+' . $arrDelay['value'] . ' ' . $arrDelay['unit']),
				'language'		=> $GLOBALS['TL_LANGUAGE'],
				'mail_template'	=> $arrForm['reminderTemplate'],
			);
			
			$this->Database->prepare("INSERT INTO tl_reminder %s")->set($arrSet)->execute();
		}
	}
	
	
	/**
	 * Send email reminders once per day
	 */
	public function sendMails()
	{
		$start = mktime(0,0,0);
		$objLock = $this->Database->execute("SELECT tstamp FROM tl_lock WHERE name='formreminder'");
		
		if ($objLock->numRows == 0 || $objLock->tstamp != $start)
		{
			$stop = mktime(23,59,59);
			
			$objReminder = $this->Database->execute("SELECT * FROM tl_reminder WHERE stop>=$start AND stop<=$stop");
			
			while ($objReminder->next())
			{
				$arrData = deserialize($objReminder->data, true);
				$arrRecipients = trimsplit(',', $objReminder->recipients);
				
				$objEmail = new EmailTemplate($objReminder->mail_template, $objReminder->language);
				
				foreach ($arrRecipients as $strRecipient)
				{
					$objEmail->send($strRecipient, $arrData);
				}
			}
			
			if ($objLock->numRows)
			{
				$this->Database->execute("UPDATE tl_lock SET tstamp=$start WHERE name='formreminder'");
			}
			else
			{
				$this->Database->execute("INSERT INTO tl_lock SET name='formreminder', tstamp=$start");
			}
		}
	}
}

");
			}
		}
	}
}

