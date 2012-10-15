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
	 * The class for the user role domain model. The user role is a value object and is
	 * characterized by its name attribute.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Model
	 * @version    $Id: Role.php 7 2010-02-22 12:10:02Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 * @entity
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Model_Role Extends Tx_Extbase_DomainObject_AbstractValueObject {

		/**
		 *
		 * The role name
		 * @var string
		 *
		 */
	Protected $name;


	
		/**
		 *
		 * Gets the role name
		 * @return string The role name
		 *
		 */
	Public Function getName() { Return $this->name; }

}

?>
