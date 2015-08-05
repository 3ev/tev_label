<?php

$EM_CONF[$_EXTKEY] = [
    'title' => '3ev Label',
    'description' => 'Manage functional copy labels through the database',
    'category' => 'fe',
    'version' => '2.0.1',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Ben Constable',
    'author_email' => 'benconstable@3ev.com',
    'author_company' => '3ev',
    'constraints' => [
        'depends' => [
            'typo3' => '7.0.0-7.999.999',
            'php' => '5.5.0-5.5.999'
        ],
        'conflicts' => [],
        'suggests' => [],
    ]
];
