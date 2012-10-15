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
	 * The class for the project domain model. The project class models the project
	 * object, that is characterized by a name attribute and a start and end date. Each
	 * project may have an infinite number of sub-projects.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Model
	 * @version    $Id: Project.php 32 2010-09-21 13:56:08Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 * @entity
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Model_Project Extends Tx_Extbase_DomainObject_AbstractEntity {





		/*
		 * ATTRIBUTES
		 */





		/**
		 * The project name
		 * @var string
		 * @validate StringLength(minimum = 3, maximum = 255) || EmailAddress
		 */
	Protected $name;

		/**
		 * The parent project. For toplevel projects, this attribute is NULL
		 * @var Tx_MittwaldTimetrack_Domain_Model_Project
		 */
	Protected $project=NULL;

		/**
		 * The start time.
		 * @var DateTime
		 */
	Protected $start;

		/**
		 * The end time
		 * @var DateTime
		 */
	Protected $end;

		/**
		 * The date this project was last edited on.
		 * @var DateTime
		 */
	Protected $tstamp;
	
		/**
		 * The assignments for this project
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Assignment>
		 * @lazy
		 * @cascade remove
		 */
	Protected $assignments;
	
		/**
		 * The sub-projects of this project.
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Project>
		 * @lazy
		 * @cascade remove
		 */
	Protected $children;

		/**
		 * A caching array for the members of this project. This array maps the user role
		 * Uid to all users assigned in this role.
		 * @var array<array<Tx_Extbase_Domain_Model_FrontendUser>>
		 */
	Protected $members = NULL;

		/**
		 * A list of all timesets that are assigned to this project-
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_Timeset>
		 */
	Protected $timesets = NULL;





		/*
		 * CONSTRUCTORS
		 */





		 /**
		  *
		  * Creates a new project.
		  *
		  */

	Public Function __construct() {
		$this->assignments = new Tx_Extbase_Persistence_ObjectStorage();
	}





		/*
		 * GETTERS
		 */





		 /**
		  *
		  * Gets the project name
		  * @return string The project name
		  *
		  */

	Public Function getName() { Return $this->name; }



		/**
		 *
		 * Gets the parent project.
		 * @return Tx_MittwaldTimetrack_Domain_Model_Project The parent project
		 *
		 */

	Public Function getParent() { Return $this->project; }



		/**
		 *
		 * Gets the parent project.
		 * @return Tx_MittwaldTimetrack_Domain_Model_Project The parent project
		 *
		 */

	Public Function getProject() { Return $this->project; }



		/**
		 *
		 * Gets the project start date.
		 * @return DateTime The project start date
		 *
		 */

	Public Function getStart() { Return $this->start; }



		/**
		 *
		 * Gets the project end date.
		 * @return DateTime The project end date
		 *
		 */

	Public Function getEnd() { Return $this->end; }



		/**
		 *
		 * Gets the edit date.
		 * @return DateTime The edit date
		 *
		 */

	Public Function getEditDate() { Return $this->tstamp; }



		/**
		 *
		 * Gets all member assignments for this project.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Assignment>
		 *
		 */

	Public Function getAssignments() { Return $this->assignments; }



		/**
		 *
		 * Gets the total amount of worked time for this project. This methods
		 * accumulates the time amount of all user assignments.
		 *
		 * @return int The total amount of worked time in seconds
		 *
		 */

	Public Function getWorkedTime() {
		$time = 0.0;
		ForEach($this->getTimesets() As $timeset) $time += $timeset->getWorkedTime();
		Return $time;
	}



		/**
		 *
		 * Gets a list of all timesets that were created for this project. The timeset
		 * list is ordered by the project member.
		 *
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_MittwaldTimetrack_Domain_Model_Timeset>
		 *
		 */

	Public Function getTimesets() {
		If($this->timesets === NULL) {
			$this->timesets = New Tx_Extbase_Persistence_ObjectStorage();
			ForEach($this->getAssignments() As $assignment)
				$this->timesets->addAll($assignment->getTimesets());
		} Return $this->timesets;
	}



		/**
		 *
		 * Gets all users that are assigned to this project in a specific user role
		 * @param Tx_MittwaldTimetrack_Domain_Model_Role $role The role for which the users are to be selected
		 * @return array<Tx_Extbase_Domain_Model_FrontendUser> The users assigned to this project in the specified role
		 *
		 */

	Public Function getUsersForRole(Tx_MittwaldTimetrack_Domain_Model_Role $role) {
		If($this->members[$role->getUid()] == NULL) {
			$this->members[$role->getUid()] = Array();
			ForEach($this->getAssignments() As $assignment)
				If($assignment->getRole()->getUid() == $role->getUid())
					array_push($this->members[$role->getUid()], $assignment->getUser());
		} Return $this->members[$role->getUid()];
	}



		/**
		 *
		 * Gets the project assignment for a specific user.
		 * @param  Tx_Extbase_Domain_Model_FrontendUser         $user The user for which the assignment
		 *                                                            is to be retrieved
		 * @return Tx_MittwaldTimetrack_Domain_Model_Assignment       The project assignment for the specified
		 *                                                            user, or NULL if the user is not a member
		 *                                                            of this project
		 *
		 */

	Public Function getAssignmentForUser(Tx_Extbase_Domain_Model_FrontendUser $user) {
		ForEach($this->assignments As $assignment) {
			If($assignment->getUser()->getUID() === $user->getUID()) Return $assignment;
		} Return NULL;
	}



		/**
		 *
		 * Determines whether a specific user is assigned to this project
		 *
		 * @param Tx_Extbase_Domain_Model_FrontendUser $user The user whose assignment is
		 *                                                   to be checked.
		 * @return boolean                                   TRUE, if the user is assigned
		 *                                                   to this project, otherwise
		 *                                                   FALSE.
		 *
		 */

	Public Function getIsAssigned(Tx_Extbase_Domain_Model_FrontendUser $user) {
		Return $this->getAssignmentForUser($user) !== NULL;
	}



		/**
		 *
		 * Gets all sub projects for this project.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_Extbase_Domain_Model_Project>
		 *
		 */

	Public Function getChildren() { Return $this->children; }





		/*
		 * SETTERS
		 */





		 /**
		  *
		  * Sets the project name
		  * @param string $name The project name
		  * @return void
		  *
		  */

	Public Function setName($name) { $this->name = $name; }



		/**
		 *
		 * Sets the parent project
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $parent The parent project
		 * @return void
		 *
		 */

	Public Function setProject(Tx_MittwaldTimetrack_Domain_Model_Project $parent=NULL) { $this->parent = $parent; }



		/**
		 *
		 * Sets the start date.
		 * @param DateTime $start The start date
		 * @return void
		 *
		 */

	Public Function setStart(DateTime $start) { $this->start = $start; }



		/**
		 *
		 * Sets the end date.
		 * @param DateTime $end The end date
		 * @return void
		 *
		 */

	Public Function setEnd(DateTime $end) { $this->end = $end; }



		/**
		 *
		 * Clears all user assignments.
		 * @return void
		 *
		 */

	Public Function removeAllAssignments() {
		$this->assignments = New Tx_Extbase_Persistence_ObjectStorage();
	}



		/**
		 *
		 * Assigns a user to this project using a specified user role.
		 *
		 * @param Tx_Extbase_Domain_Model_FrontendUser   $user The user that is to be assigned
		 *                                                     to this project.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Role $role The role the user is to be
		 *                                                     assigned in.
		 * @return void
		 *
		 */

	Public Function assignUser ( Tx_Extbase_Domain_Model_FrontendUser   $user,
	                             Tx_MittwaldTimetrack_Domain_Model_Role $role ) {
		If(!$this->getIsAssigned($user)) {
			$assignment = New Tx_MittwaldTimetrack_Domain_Model_Assignment($user, $this, $role);
			$this->assignments->attach($assignment);
		}
	}



		/**
		 *
		 * Unassigns a specific user.
		 *
		 * @param Tx_Extbase_Domain_Model_FrontendUser $user The user that is to be unassigned
		 * @return void
		 *
		 */

	Public Function unassignUser(Tx_Extbase_Domain_Model_FrontendUser $user) {
		ForEach($this->getAssignments() As $assignment) {
			If($assignment->getUser()->getUID() === $user->getUID()) $this->assignments->detach($assignment);
		}
	}



		/**
		 *
		 * Adds a new subproject.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The new subproject
		 * @return void
		 *
		 */

	Public Function addChild(Tx_MittwaldTimetrack_Domain_Model_Project $project) {
		$project->setParent($this);
		$this->children->attach($project);
	}

	Public Function addAssignment(Tx_MittwaldTimetrack_Domain_Model_Assignment $assignment) {
		$this->assignments->attach($assignment);
	}

}

?>
