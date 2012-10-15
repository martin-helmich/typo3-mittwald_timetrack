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
	 * Controller class for the backend module. Provides actions for listing all projects
	 * in the TYPO3 backend.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Controller
	 * @version    $Id: BackendController.php 17 2010-03-03 09:26:45Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_Controller_BackendController Extends Tx_Extbase_MVC_Controller_ActionController {





		/*
		 * ATTRIBUTES
		 */





		 /**
		  * A project repository.
		  * @var Tx_MittwaldTimetrack_Domain_Repository_ProjectRepository
		  */
	Protected $projectRepository;





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
	}



		/**
		 *
		 * The index action. Displays a list of all available projects.
		 *
		 * @return void
		 *
		 */

	Public Function indexAction() {
		$this->view->assign('projects', $this->projectRepository->findAll());
	}

}

?>
