<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels',
        'label' => 'label_key',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'delete' => 'deleted',
        'searchFields' => 'title,label_key,label_value',
        'enablecolumns' => ['disabled' => 'hidden'],
        'default_sortby' => 'ORDER BY label_key',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('tev_label') . 'ext_icon.png',
        'dividers2tabs' => 2
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, label_key, label_value, front_end'
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0'
            ]
        ],
        'label_key' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.label_key',
            'config' => [
                'type' => 'input',
                'size' => '30'
            ]
        ],
        'label_value' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.label_value',
            'config' => [
                'type' => 'text',
                'size' => '1000'
            ]
        ],
        'front_end' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:tev_label/Resources/Private/Language/locallang_tca.xml:tx_tevlabel_labels.front_end',
            'config' => [
                'type' => 'check',
                'default' => '0'
            ]
        ]
    ],
    'types' => [
        '0' => ['showitem' => '
            hidden,
            label_key,
            label_value,
            front_end
            '
        ]
    ]
];
