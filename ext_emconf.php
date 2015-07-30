<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '3ev Label',
    'description' => 'Manage functional copy labels through the database',
    'category' => 'frontend',
    'author' => 'Ben Constable',
    'author_email' => 'benconstable@3ev.com',
    'author_email' => '3ev',
    'shy' => 0,
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '7.0.0-0.0.0',
            'php' => '5.5.0-0.0.0',
            'tev' => '2.0.0-0.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
