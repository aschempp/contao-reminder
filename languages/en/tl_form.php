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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_form']['reminder']			= array('Erinnerungsmail', 'Ein Erinnerungsmail für dieses Formular versenden.');
$GLOBALS['TL_LANG']['tl_form']['reminderCheck']		= array('Erinnerungs-Freigabe (optional)', 'Wählen Sie ein Formularfeld zur Freigabe. Nur wenn dieses Feld einen Wert enthält, wird die Erinnerung aktiviert.');
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']		= array('Verzögerung', 'Geben Sie eine Verzögerung ein, nach der die Erinnerung gesendet werden soll.');
$GLOBALS['TL_LANG']['tl_form']['reminderTemplate']	= array('E-Mail Vorlage', 'Bitte wählen Sie eine E-Mail Vorlage.');
$GLOBALS['TL_LANG']['tl_form']['reminderRecipient']	= array('Empfänger', 'Wählen Sie ein Eingabefeld, welches als Quelle der Empfängeradresse dient.');


/**
 * Palettes
 */
$GLOBALS['TL_LANG']['tl_form']['reminder_legend'] = 'Erinnerungsmail';


/**
 * References
 */
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['minutes']	= 'Minuten';
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['hours']	= 'Stunden';
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['days']		= 'Tage';
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['weeks']	= 'Wochen';
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['months']	= 'Monate';
$GLOBALS['TL_LANG']['tl_form']['reminderDelay']['years']	= 'Jahre';

