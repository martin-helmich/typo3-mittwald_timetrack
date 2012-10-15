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

if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin ( $_EXTKEY, 'Pi1', ' A timetracking extension' );
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Timetracking');

If ( TYPO3_MODE === 'BE' )
    Tx_Extbase_Utility_Extension::registerModule ( $_EXTKEY,
	                                            'web',
	                                            'tx_mittwaldtimetrack_m1',
	                                            '',
	                                            Array ( 'Backend' => 'index' ),
	                                            Array ( 'access' => 'user,group',
	                                                    'icon'   => 'EXT:mittwald_timetrack/ext_icon.gif',
	                                                    'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml' ) );

t3lib_extMgm::addLLrefForTCAdescr       ( 'tx_mittwaldtimetrack_domain_model_project',
                                          'EXT:mittwald_timetrack/Resources/Private/Language/locallang_csh_tx_mittwaldtimetrack_domain_model_project.xml' );
t3lib_extMgm::allowTableOnStandardPages ( 'tx_mittwaldtimetrack_domain_model_project');
$TCA['tx_mittwaldtimetrack_domain_model_project'] = array (
	'ctrl' => array (
		'title'                    => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project',
		'label'                    => 'name',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete'                   => 'deleted',
		'enablecolumns'            => array ( 'disabled' => 'hidden' ),
		'dynamicConfigFile'        => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Project.php',
		'iconfile'                 => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_project.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr       ( 'tx_mittwaldtimetrack_domain_model_role',
                                          'EXT:mittwald_timetrack/Resources/Private/Language/locallang_csh_tx_mittwaldtimetrack_domain_model_role.xml');
t3lib_extMgm::allowTableOnStandardPages ( 'tx_mittwaldtimetrack_domain_model_role' );
$TCA['tx_mittwaldtimetrack_domain_model_role'] = array (
	'ctrl' => array (
		'title'                    => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_role',
		'label'                    => 'name',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'delete'                   => 'deleted',
		'enablecolumns'            => array ( 'disabled' => 'hidden' ),
		'dynamicConfigFile'        => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Role.php',
		'iconfile'                 => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_role.gif'
	)
);


t3lib_extMgm::addLLrefForTCAdescr       ( 'tx_mittwaldtimetrack_domain_model_assignment',
                                          'EXT:mittwald_timetrack/Resources/Private/Language/locallang_csh_tx_mittwaldtimetrack_domain_model_assignment.xml' );
t3lib_extMgm::allowTableOnStandardPages ( 'tx_mittwaldtimetrack_domain_model_assignment' );
$TCA['tx_mittwaldtimetrack_domain_model_assignment'] = array (
	'ctrl' => array (
		'title'                    => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment',
		'label'                    => 'role',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'delete'                   => 'deleted',
		'enablecolumns'            => array ( 'disabled' => 'hidden' ),
		'dynamicConfigFile'        => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Assignment.php',
		'iconfile'                 => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_assignment.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr       ( 'tx_mittwaldtimetrack_domain_model_timeset',
                                          'EXT:mittwald_timetrack/Resources/Private/Language/locallang_csh_tx_mittwaldtimetrack_domain_model_timeset.xml' );
t3lib_extMgm::allowTableOnStandardPages ( 'tx_mittwaldtimetrack_domain_model_timeset' );
$TCA['tx_mittwaldtimetrack_domain_model_timeset'] = array (
	'ctrl' => array (
		'title'                    => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_timeset',
		'label'                    => 'tx_mittwaldtimetrack_starttime',
		'tstamp'                   => 'tstamp',
		'crdate'                   => 'crdate',
		'versioningWS'             => 2,
		'versioning_followPages'   => TRUE,
		'origUid'                  => 't3_origuid',
		'delete'                   => 'deleted',
		'enablecolumns'            => array( 'disabled' => 'hidden' ),
		'dynamicConfigFile'        => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Timeset.php',
		'iconfile'                 => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_mittwaldtimetrack_domain_model_timeset.gif'
	)
);

?>
