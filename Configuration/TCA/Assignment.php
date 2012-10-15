<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_mittwaldtimetrack_domain_model_assignment'] = array(
	'ctrl' => $TCA['tx_mittwaldtimetrack_domain_model_assignment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'role,timesets,project,user'
	),
	'types' => array(
		'1' => array('showitem' => 'role,timesets,project,user')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'role' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment.role',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_role',
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
		'timesets' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment.timesets',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_timeset',
				'foreign_field' => 'assignment',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'project' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment.project',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_MittwaldTimetrack_Domain_Model_Project',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_project',
				'maxitems' => 1
			)
		),
		'user' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'maxitems' => 1
			)
		),
	),
);
?>
