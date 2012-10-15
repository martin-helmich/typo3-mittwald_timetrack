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
	 * An assignment. Models an association between users, projects and roles.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Model
	 * @version    $Id: Assignment.php 27 2010-09-15 07:58:06Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 * @entity
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Model_Assignment Extends Tx_Extbase_DomainObject_AbstractEntity {





		/*
		 * ATTRIBUTES
		 */





		/**
		 * The user of this assignment.
		 * @var Tx_Extbase_Domain_Model_FrontendUser
		 * @lazy
		 */
	Protected $user;

		/**
		 * The project
		 * @var Tx_MittwaldTimetrack_Domain_Model_Project
		 * @lazy
		 */
	Protected $project;

		/**
		 * The user role
		 * @var Tx_MittwaldTimetrack_Domain_Model_Role
		 * @lazy
		 */
	Protected $role;

		/**
		 * All timesets that are assigned to this project assignment
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Timeset>
		 * @lazy
		 * @cascade remove
		 */
	Protected $timesets;





		/*
		 * CONSTRUCTOR
		 */





		 /**
		  *
		  * Creates a new assignment. All arguments are optional, since every model class
		  * has to implement an empty constructor.
		  *
		  * @param Tx_Extbase_Domain_Model_FrontendUser      $user    The user
		  * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project
		  * @param Tx_MittwaldTimetrack_Domain_Model_Role    $role    The user role
		  *
		  */

	Public Function __construct ( Tx_Extbase_Domain_Model_FrontendUser      $user    = NULL,
	                              Tx_MittwaldTimetrack_Domain_Model_Project $project = NULL,
	                              Tx_MittwaldTimetrack_Domain_Model_Role    $role    = NULL) {
		$this->timesets = New Tx_Extbase_Persistence_ObjectStorage();
		If($user)    $this->setUser($user);
		If($project) $this->setProject($project);
		If($role)    $this->role = $role;
	}





		/*
		 * GETTERS
		 */





		/**
		 *
		 * Gets the user.
		 * @return Tx_Extbase_Domain_Model_FrontendUser The user
		 *
		 */

	Public Function getUser() { Return $this->user; }



		/**
		 *
		 * Gets the project.
		 * @return Tx_MittwaldTimetrack_Domain_Model_Project The project
		 *
		 */

	Public Function getProject() {
		If($this->project InstanceOf Tx_Extbase_Persistence_LazyLoadingProxy)
			$this->project->_loadRealInstance();
		Return $this->project;
	}



		/**
		 *
		 * Gets all timesets for this assignment.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Timeset> All timesets
		 *
		 */

	Public Function getTimesets() { Return $this->timesets; }



		/**
		 *
		 * Gets the user role.
		 * @return Tx_MittwaldTimetrack_Domain_Model_Role The user role
		 *
		 */

	Public Function getRole() { Return $this->role; }



		/**
		 *
		 * Gets the worked time as sum of all timesets.
		 * @return int The worked time
		 *
		 */

	Public Function getWorkedTime() {
		$time = 0;
		ForEach($this->getTimesets() As $timeset) $time += $timeset->getWorkedTime();
		Return $time;
	}





		/*
		 * SETTERS
		 */





		 /**
		  *
		  * Sets the user.
		  * @param Tx_Extbase_Domain_Model_FrontendUser $user The user
		  * @return void
		  *
		  */

	Public Function setUser(Tx_Extbase_Domain_Model_FrontendUser $user) { $this->user = $user; }



		/**
		 *
		 * Sets the project.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project
		 * @return void
		 *
		 */

	Public Function setProject(Tx_MittwaldTimetrack_Domain_Model_Project $project) { $this->project = $project; }



		/**
		 *
		 * Sets the user role for this assignment.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Role $role The user role
		 * @return void
		 *
		 */

	Public Function setRole(Tx_MittwaldTimetrack_Domain_Model_Role $role) { $this->role = $role; }



		/**
		 *
		 * Adds another timeset.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset A timeset
		 * @return void
		 *
		 */
	
	Public Function addTimeset(Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset) {
		$timeset->setAssignment($this);
		$this->timesets->attach($timeset);
	}

}

?>
