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
	 * The class for the timeset domain model. Models a single timeset with a start and a
	 * stop time. Each timeset is associated with an assignment.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Model
	 * @version    $Id: Timeset.php 28 2010-09-20 12:26:13Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 * @entity
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Model_Timeset Extends Tx_Extbase_DomainObject_AbstractEntity {





		/*
		 * ATTRIBUTES
		 */





		/**
		 * The assignment
		 * @var Tx_MittwaldTimetrack_Domain_Model_Assignment
		 */
	Protected $assignment;

		/**
		 * The start time of this timeset
		 * @var DateTime
		 * @validate NotEmpty
		 */
	Protected $starttime;

		/**
		 * The stop time of this timeset
		 * @var DateTime
		 * @validate NotEmpty
		 */
	Protected $stoptime;

		/**
		 * A comment for this timeset
		 * @var string
		 * @validate NotEmpty
		 */
	Protected $comment;





		/*
		 * GETTERS
		 */





		 /**
		  *
		  * Gets the assignment
		  * @return Tx_MittwaldTimetrack_Domain_Model_Assignment The assignment
		  *
		  */

	Public Function getAssignment() { Return $this->assignment; }



		/**
		 *
		 * Gets the project
		 * @return Tx_MittwaldTimetrack_Domain_Model_Project The project
		 *
		 */

	Public Function getProject() { Return $this->getAssignment()->getProject(); }



		/**
		 *
		 * Gets the user
		 * @return Tx_Extbase_Domain_Model_FrontendUser The user
		 *
		 */

	Public Function getUser() { Return $this->getAssignment()->getUser(); }



		/**
		 *
		 * Gets the start time
		 * @return DateTime The start time
		 *
		 */

	Public Function getStarttime() { Return $this->starttime; }



		/**
		 *
		 * Gets the stop time
		 * @return DateTime The stop time
		 *
		 */

	Public Function getStoptime() { Return $this->stoptime; }



		/**
		 *
		 * Gets the worked time (the difference between start and stop time)
		 * @return int The worked time in seconds
		 *
		 */

	Public Function getWorkedTime() {
		Return intval($this->stoptime->format('U')) - intval($this->starttime->format('U'));
	}



		/**
		 *
		 * Gets the worked time in hours.
		 * @return double The worked time in hours
		 *
		 */

	Public Function getWorkedTimeInHours() { Return $this->getWorkedTime() / 3600; }



		/**
		 *
		 * Gets the comment for this timeset
		 * @return string The comment
		 *
		 */

	Public Function getComment() { Return $this->comment; }





		/*
		 * SETTERS
		 */





		 /**
		  *
		  * Sets the assignment for this timeset.
		  * @param Tx_MittwaldTimetrack_Domain_Model_Assignment $assignment The assignment
		  * @return void
		  *
		  */

	Public Function setAssignment(Tx_MittwaldTimetrack_Domain_Model_Assignment $assignment) { $this->assignment = $assignment; }



		/**
		 *
		 * Sets the start time of this timeset.
		 * @param DateTime $start The start time
		 * @return void
		 *
		 */

	Public Function setStarttime(DateTime $start) { $this->starttime = $start; }



		/**
		 *
		 * Sets the stop time.
		 * @param DateTime $end The stop time
		 * @return void
		 *
		 */

	Public Function setStoptime(DateTime $end) { $this->stoptime = $end; }



		/**
		 *
		 * Sets the timeset comment.
		 * @param string $comment The comment
		 * @return void
		 *
		 */

	Public Function setComment($comment) { $this->comment = $comment; }

}

?>
