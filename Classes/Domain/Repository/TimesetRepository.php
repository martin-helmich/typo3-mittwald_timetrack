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
	 * The timeset repository class. Provides methods for accessing the timeset table.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MittwaldTimetrack
	 * @subpackage Domain_Repository
	 * @version    $Id: TimesetRepository.php 27 2010-09-15 07:58:06Z helmich $
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MittwaldTimetrack_Domain_Repository_TimesetRepository Extends Tx_Extbase_Persistence_Repository {



		/**
		 *
		 * Returns a container with all timesets for a specific project, ordered by their
		 * start time. This method does NOT use Extbase's Query Object Model, but rather
		 * a hardcoded SQL query. Althrough we lose DMBS portability by doing so, this is
		 * a good example on how to use this method.
		 *
		 * @param Tx_MittwaldTimetrack_Domain_Model_Project $project
		 * @return Array<Tx_MittwaldTimetrack_Domain_Model_Timeset>
		 *
		 */

	Public Function getTimesetsForProject(Tx_MittwaldTimetrack_Domain_Model_Project $project) {

		$extbaseFrameworkConfiguration = Tx_Extbase_Dispatcher::getExtbaseFrameworkConfiguration();
		$pidList = implode(', ', t3lib_div::intExplode(',', $extbaseFrameworkConfiguration['persistence']['storagePid']));

		$sql = "SELECT t.*
		        FROM        tx_mittwaldtimetrack_domain_model_timeset    t
		               JOIN tx_mittwaldtimetrack_domain_model_assignment a ON t.assignment = a.uid
		               JOIN tx_mittwaldtimetrack_domain_model_project    p ON a.project = p.uid
		        WHERE      p.uid={$project->getUid()}
				       AND p.deleted=0 AND p.pid IN ($pidList)
				       AND a.deleted=0 AND a.pid IN ($pidList)
				       AND t.deleted=0 AND t.pid IN ($pidList)
				ORDER BY t.starttime DESC";

		$query = $this->createQuery();
		$query->statement($sql);
		Return $query->execute();
		
	}

}

?>
