<?php

/*                                                                      *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2010 Martin Helmich <m.helmich@mittwald.de>                     *
 *           Mittwald CM Service GmbH & Co KG                           *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General Public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General Public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General Public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



	/**
	 *
	 * A ViewHelper for formatting time amounts. In dependence of the time amount, the
	 * time amount if formatted with a different unit (seconds, minutes, hours, days).
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage ViewHelpers
	 * @version    $Id: TimeFormatViewHelper.php 8 2010-02-22 12:11:02Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_ViewHelpers_TimeFormatViewHelper Extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {



		/**
		 *
		 * Renders the time amount.
		 *
		 * @param  int    $amount The time amount in seconds
		 * @return string         The formatted output
		 * 
		 */

	Public Function render($amount) {
		$unit = 'Seconds';

		If($amount == 0) {
			$unit = 'Hours';
		} ElseIf($amount >= 604800) {
			$unit = 'Days';
			$amount /= 86400.00;
		} ElseIf($amount >= 3600) {
			$unit = 'Hours';
			$amount /= 3600;
		} ElseIf($amount >= 60) {
			$unit = 'Minutes';
			$amount /= 60.00;
		}

		Return number_format($amount, 2, ',', '').' '.Tx_Extbase_Utility_Localization::translate('ViewHelper_Unit_'.$unit, 'MittwaldTimetrack');
	}

}

?>
