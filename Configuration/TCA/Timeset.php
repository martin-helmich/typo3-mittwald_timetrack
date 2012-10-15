<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_mittwaldtimetrack_domain_model_timeset'] = array(
	'ctrl' => $TCA['tx_mittwaldtimetrack_domain_model_timeset']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'tx_mittwaldtimetrack_starttime,stoptime,comment,assignment'
	),
	'types' => array(
		'1' => array('showitem' => 'tx_mittwaldtimetrack_starttime,stoptime,comment,assignment')
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
		'starttime' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_timeset.starttime',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'stoptime' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_timeset.stoptime',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'comment' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_timeset.comment',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'assignment' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_assignment',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_MittwaldTimetrack_Domain_Model_Assignment',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_assignment',
				'maxitems' => 1
			)
		),
	),
);
?>
