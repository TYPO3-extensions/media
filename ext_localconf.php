<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

# Hook for secure download for Frontend
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/naw_securedl/class.tx_nawsecuredl_output.php']['preOutput'][] = 'EXT:media/Classes/Hooks/NawSecuredl.php:TYPO3\CMS\Media\Hooks\NawSecuredl->preOutput';

# Configuration for RTE
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker'] = array();
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['objectReference'] = 'EXT:' . $_EXTKEY . '/Resources/HtmlArea/LinkMaker/class.tx_rtehtmlarea_linkmaker.php:&tx_rtehtmlarea_linkmaker';
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['addIconsToSkin'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['LinkMaker']['disableInFE'] = 1;

$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker'] = array();
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['objectReference'] = 'EXT:' . $_EXTKEY . '/Resources/HtmlArea/ImageMaker/class.tx_rtehtmlarea_imagemaker.php:&tx_rtehtmlarea_imagemaker';
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['addIconsToSkin'] = 1;
$TYPO3_CONF_VARS['EXTCONF']['rtehtmlarea']['plugins']['ImageMaker']['disableInFE'] = 1;

// Override classes for the Object Manager
// @todo remove me when http://forge.typo3.org/issues/47211 is resolved
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Core\Resource\ProcessedFile'] = array(
	'className' => 'TYPO3\CMS\Media\Override\Core\Resource\ProcessedFile'
);

?>