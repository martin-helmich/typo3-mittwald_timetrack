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
	 * Project controller class for the timetracking extension. Provides actions for
	 * project listing, creating and updating projects and displaying project details.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Controller
	 * @version    $Id: ProjectController.php 27 2010-09-15 07:58:06Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_Controller_ProjectController Extends Tx_MittwaldTimetrack_Controller_AbstractController {





		/*
		 * ATTRIBUTES
		 */





		/**
		 * A project repository instance
		 * @var Tx_MittwaldTimetrack_Domain_Repository_ProjectRepository
		 */
	Protected $projectRepository;

		/**
		 * A user role repository instance
		 * @var Tx_MittwaldTimetrack_Domain_Repository_RoleRepository
		 */
	Protected $roleRepository;

		/**
		 * A frontend user repository instance
		 * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
		 */
	Protected $userRepository;





		/*
		 * ACTION METHODS
		 */




	
		/**
		 *
		 * The initialization action. This methods creates instances of all required
		 * repositories.
		 *
		 * @return void
		 *
		 */

	Protected Function initializeAction() {
		$this->projectRepository =& t3lib_div::makeInstance('Tx_MittwaldTimetrack_Domain_Repository_ProjectRepository');
		$this->roleRepository    =& t3lib_div::makeInstance('Tx_MittwaldTimetrack_Domain_Repository_RoleRepository');
		$this->userRepository    =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
	}



		/**
		 *
		 * The index action. Displays a list of all top-level projects.
		 * @return void
		 *
		 */

	Public Function indexAction() {
		$this->view->assign('projects', $this->projectRepository->findForIndexView() );
	}



		/**
		 *
		 * The show action. Displays details for a specific project.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project that is to be displayed.
		 * @return void
		 *
		 */

	Public Function showAction ( Tx_MittwaldTimetrack_Domain_Model_Project $project ) {
		$this->view->assign('project', $project);
	}



		/**
		 *
		 * The new action. Displays a form for creating a new project.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The new project
		 * @return void
		 * @dontvalidate $project
		 *
		 */

	Public Function newAction ( Tx_MittwaldTimetrack_Domain_Model_Project $project=NULL ) {
		$this->view->assign('project' , $project)
		           ->assign('projects', array_merge(Array(NULL), $this->projectRepository->findAll()))
		           ->assign('users'   , $this->userRepository->findAll())
		           ->assign('roles'   , $this->roleRepository->findAll());
	}



		/**
		 *
		 * The create action. This method creates a new project and stores it into the
		 * database.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The new project
		 * @param array $assignments                                 An array of users and roles that are to be assigned to this project.
		 * @return void
		 * @dontverifyrequesthash
		 *
		 */

	Public Function createAction( Tx_MittwaldTimetrack_Domain_Model_Project $project, $assignments ) {
		$project->removeAllAssignments();
		ForEach($assignments As $userId => $roleId) {
			If($roleId == 0) Continue;
			$project->assignUser ( $this->userRepository->findByUid((int)$userId),
			                       $this->roleRepository->findByUid((int)$roleId) );
		}
		$this->projectRepository->add($project);
		$this->flashMessages->add('Das Projekt '.$project->getName().' wurde erfolgreich angelegt.');

		$this->redirect('index');
	}



		/**
		 *
		 * The edit action. This method displays a form for editing existing projects.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project
		 * @return void
		 * @dontvalidate $project
		 *
		 */

	Public Function editAction( Tx_MittwaldTimetrack_Domain_Model_Project $project ) {
		$this->view->assign('project' , $project)
		           ->assign('projects', array_merge(Array(NULL), $this->projectRepository->findAll()))
		           ->assign('users'   , $this->userRepository->findAll())
		           ->assign('roles'   , $this->roleRepository->findAll());
	}



		/**
		 *
		 * The update action. Updates an existing project in the database.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project
		 * @param array $assignments                                 An array of users and roles that are to be assigned to this project.
		 * @return void
		 * @dontverifyrequesthash
		 *
		 */

	Public Function updateAction( Tx_MittwaldTimetrack_Domain_Model_Project $project, $assignments ) {
		$project->removeAllAssignments();
		ForEach($assignments As $userId => $roleId) {
			If($roleId == 0) Continue;
			$project->assignUser ( $this->userRepository->findByUid((int)$userId),
			                       $this->roleRepository->findByUid((int)$roleId) );
		}
		$this->projectRepository->update($project);
		$this->flashMessages->add("Das Projekt {$project->getName()} wurde erfolgreich bearbeitet.");

		$this->redirect('show', NULL, NULL, Array('project' => $project));
	}



		/**
		 *
		 * The delete action. Deletes an existing project from the database.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project The project that is to be deleted
		 * @return void
		 *
		 */

	Public Function deleteAction( Tx_MittwaldTimetrack_Domain_Model_Project $project ) {
		$this->projectRepository->remove($project);
		$this->flashMessages->add("Das Projekt {$project->getName()} wurde erfolgreich gelöscht.");

		$this->redirect('index');
	}

}

?>
