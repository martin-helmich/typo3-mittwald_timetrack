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
	 * Timeset controller class for the timetracking extension. This controller provides
	 * actiosn for creating new timesets.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Controller
	 * @version    $Id: TimesetController.php 28 2010-09-20 12:26:13Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_Controller_TimesetController Extends Tx_MittwaldTimetrack_Controller_AbstractController {





		/*
		 * ATTRIBUTES
		 */





		/**
		 * A project repository instance
		 * @var Tx_MittwaldTimetrack_Domain_Repository_ProjectRepository
		 */
	Protected $projectRepository;





		/*
		 * ACTION METHODS
		 */





		/**
		 *
		 * The initialization action. Creates instances of all required repositories.
		 * @return void
		 *
		 */

	Public Function initializeAction() {
		$this->projectRepository =& t3lib_div::makeInstance('Tx_MittwaldTimetrack_Domain_Repository_ProjectRepository');
	}



		/**
		 *
		 * The index action. This method displays a list of all timesets for a specific
		 * project.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project for which the timesets are to be
		 *                                                           displayed for.
		 * @return void
		 *
		 */
	Public Function indexAction ( Tx_MittwaldTimetrack_Domain_Model_Project $project ) {
		$timesetRepository =& t3lib_div::makeInstance('Tx_MittwaldTimetrack_Domain_Repository_TimesetRepository');
		$this->view->assign('project' , $project)
		           ->assign('timesets', $timesetRepository->getTimesetsForProject($project));
	}



		/**
		 *
		 * The new action. This method displays a form for creating a new timeset.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project the new timeset is to be assigned to
		 * @param Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset The new timeset
		 * @return void
		 * @dontvalidate $timeset
		 *
		 */

	Public Function newAction ( Tx_MittwaldTimetrack_Domain_Model_Project $project,
	                            Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset=NULL ) {
		$user       = $this->getCurrentFeUser();
		$assignment = $user ? $project->getAssignmentForUser($user) : NULL;
		If($assignment === NULL) Throw New Tx_MittwaldTimetrack_Domain_Exception_NoProjectMemberException();

		$this->view->assign('project'   , $project    )
		           ->assign('timeset'   , $timeset    )
		           ->assign('user'      , $user       )
		           ->assign('assignment', $assignment );
	}

		/**
		 *
		 * The create action. Stores a new timeset into the database.
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project the new timeset is to be assigned to
		 * @param Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset The new timeset
		 * @return void
		 *
		 */

	Public Function createAction ( Tx_MittwaldTimetrack_Domain_Model_Project $project,
	                               Tx_MittwaldTimetrack_Domain_Model_Timeset $timeset ) {

			# Get the user assignment and throw an exception if the current user is not a
			# member of the selected project.
		$user       = $this->getCurrentFeUser();
		$assignment = $user ? $project->getAssignmentForUser($user) : NULL;
		If($assignment === NULL) Throw New Tx_MittwaldTimetrack_Domain_Exception_NoProjectMemberException();

			# Add the new timeset to the project assingment. The $assignment property in
			# the timeset object is set automatically.
		$assignment->addTimeset($timeset);
		$timeset->getProject()->addAssignment($assignment);

			# Since the project is the aggregate root, update only the project to save
			# the new timeset.
		$this->projectRepository->update($timeset->getProject());

			# Print a success message and return to the project detail view.
		$this->flashMessages->add('Zeitbuchung erfolgt.');
		$this->redirect('show', 'Project', NULL, Array('project' => $timeset->getProject() ));
	}





		/*
		 * HELPER METHODS
		 */





		/**
		 *
		 * Gets the currently logged in frontend user.
		 * @return Tx_Extbase_Domain_Model_FrontendUser The currently logged in frontend
		 *                                              user, or NULL if no user is
		 *                                              logged in.
		 *
		 */

	Protected Function getCurrentFeUser() {
		$userRepository = New Tx_Extbase_Domain_Repository_FrontendUserRepository();
		Return intval($GLOBALS['TSFE']->fe_user->user['uid']) > 0
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']) )
			: NULL;
	}

}

?>
