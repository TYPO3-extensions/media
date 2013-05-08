<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

# Activate hook for secure download for Frontend. But only if EXT:naw_securedl is loaded
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('naw_securedl')) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/naw_securedl/class.tx_nawsecuredl_output.php']['preOutput'][] = 'EXT:media/Classes/Hooks/NawSecuredl.php:TYPO3\CMS\Media\Hooks\NawSecuredl->preOutput';
}

# Configuration for RTE
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker'] = array();
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['objectReference'] = 'EXT:' . $_EXTKEY . '/Resources/HtmlArea/LinkMaker/class.tx_rtehtmlarea_linkmaker.php:&tx_rtehtmlarea_linkmaker';
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['addIconsToSkin'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['disableInFE'] = 1;

$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker'] = array();
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['objectReference'] = 'EXT:' . $_EXTKEY . '/Resources/HtmlArea/ImageMaker/class.tx_rtehtmlarea_imagemaker.php:&tx_rtehtmlarea_imagemaker';
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['addIconsToSkin'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['disableInFE'] = 1;

?>
