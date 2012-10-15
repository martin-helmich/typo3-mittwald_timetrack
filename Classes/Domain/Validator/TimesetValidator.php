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
	 * The timeset validator class. This class is a service class for validating timeset
	 * domain objects.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Validator
	 * @version    $Id: TimesetValidator.php 27 2010-09-15 07:58:06Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Validator_TimesetValidator Extends Tx_Extbase_Validation_Validator_AbstractValidator {



		/**
		 *
		 * Determines if a timeset object is valid.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset The timeset object that
		 *                                                           is to be validated.
		 * @return boolean TRUE, if the timeset object is valid, otherwise FALSE.
		 *
		 */
	
	Public Function isValid($timeset) {

		If(!$timeset InstanceOf Tx_MittwaldTimetrack_Domain_Model_Timeset)
			$this->addError(Tx_Extbase_Utility_Localization::translate('Timeset_Error_Invalid', 'MittwaldTimetrack'), 1265721022);
		If($timeset->getStarttime() >= $timeset->getStoptime())
			$this->addError(Tx_Extbase_Utility_Localization::translate('Timeset_Error_1265721025', 'MittwaldTimetrack'), 1265721025);

		Return count($this->getErrors()) === 0;

	}

}

?>
