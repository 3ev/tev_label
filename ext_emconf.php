<?php

$EM_CONF[$_EXTKEY] = array(
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
    'version' => '1.1.2',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.1.0-0.0.0',
            'php' => '5.3.7-0.0.0',
            'tev' => '',
            'extbase' => '6.1.0-0.0.0',
            'fluid' => '6.1.0-0.0.0',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    )
);
