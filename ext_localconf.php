<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// register special TCE tx_media processing
#$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:media/Classes/Hooks/TCE.php:&Tx_Media_Hooks_TCE';

$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecodocuments'] = array();
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecodocuments']['objectReference'] = 'EXT:' . $_EXTKEY . '/extensions/Ecodocuments/class.tx_rtehtmlarea_ecodocuments.php:&tx_rtehtmlarea_ecodocuments';
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecodocuments']['addIconsToSkin'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecodocuments']['disableInFE'] = 1;

//$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecoimages'] = array();
//$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecoimages']['objectReference'] = 'EXT:' . $_EXTKEY . '/extensions/Ecoimages/class.tx_rtehtmlarea_ecoimages.php:&tx_rtehtmlarea_ecoimages';
//$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecoimages']['addIconsToSkin'] = 1;
//$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['Ecoimages']['disableInFE'] = 1;

?>
