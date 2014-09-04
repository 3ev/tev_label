<?php

return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels',
        'label' => 'label_key',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
	'searchFields' => 'title,label_key,label_value',
        'enablecolumns' => array('disabled' => 'hidden'),
        'default_sortby' => 'ORDER BY label_key',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tev_label') . 'ext_icon.png',
        'dividers2tabs' => 2
    ),
    'interface' => array(
        'showRecordFieldList' => 'hidden, label_key, label_value, front_end'
    ),
    'columns' => array(
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        ),
        'label_key' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.label_key',
            'config' => array(
                'type' => 'input',
                'size' => '30'
            )
        ),
        'label_value' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.label_value',
            'config' => array(
                'type' => 'text',
                'size' => '1000'
            )
        ),
        'front_end' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.front_end',
            'config' => array(
                'type' => 'check',
                'default' => '0'
            )
        )
    ),
    'types' => array(
        '0' => array('showitem' => '
            hidden,
            label_key,
            label_value,
            front_end
            '
        )
    )
);
