<?php

if (!defined ('TYPO3_MODE')) die ('Access denied.');

// Register label import command
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'Tev\\TevLabel\\Command\\LabelCommandController';
