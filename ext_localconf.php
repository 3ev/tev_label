<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Register label import command
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tev\\TevLabel\\Command\\LabelCommandController';

// Register label cache
if (!is_array($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache'] = array();
}

if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['frontend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['frontend'] = 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend';
}

if (!isset($TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['backend'])) {
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['backend'] = 'TYPO3\\CMS\\Core\\Cache\\Backend\\MemcachedBackend';
    $TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['tev_label_label_cache']['options'] = array(
        'defaultLifetime' => 86400,
        'servers' => array('localhost')
    );
}

// Register label cache clearing
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'Tev\\TevLabel\\Cache->clear';
