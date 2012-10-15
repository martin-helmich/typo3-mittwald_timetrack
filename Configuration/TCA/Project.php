<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_mittwaldtimetrack_domain_model_project'] = array(
	'ctrl' => $TCA['tx_mittwaldtimetrack_domain_model_project']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,start,end,assignments,children'
	),
	'types' => array(
		'1' => array('showitem' => 'name,start,end,assignments,children')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_project',
				'foreign_table_where' => 'AND tx_mittwaldtimetrack_domain_model_project.uid=###REC_FIELD_l18n_parent### AND tx_mittwaldtimetrack_domain_model_project.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
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
		'name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'start' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project.start',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'end' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project.end',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required',
				'checkbox' => '0',
				'default' => '0'
			)
		),
		'assignments' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project.assignments',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_assignment',
				'foreign_field' => 'project',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'children' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project.children',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_project',
				'foreign_field' => 'project',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'newRecordLinkPosition' => 'bottom',
				),
			)
		),
		'project' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:mittwald_timetrack/Resources/Private/Language/locallang_db.xml:tx_mittwaldtimetrack_domain_model_project',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_MittwaldTimetrack_Domain_Model_Project',
				'foreign_table' => 'tx_mittwaldtimetrack_domain_model_project',
				'maxitems' => 1
			)
		),
	),
);
?>