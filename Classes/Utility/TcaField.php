<?php
namespace TYPO3\CMS\Media\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * A class to handle TCA field configuration
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class TcaField implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var array
	 */
	protected $tca;

	/**
	 * Returns a class instance
	 *
	 * @return \TYPO3\CMS\Media\Utility\TcaField
	 */
	static public function getInstance() {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Utility\TcaField');
	}

	/**
	 * __construct
	 *
	 * @return \TYPO3\CMS\Media\Utility\TcaField
	 */
	public function __construct() {
		\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('sys_file');
		$this->tca = $GLOBALS['TCA']['sys_file'];
	}

	/**
	 * Returns an array containing column names
	 *
	 * @return array
	 */
	public function getFields() {
		return $this->tca['columns'];
	}

	/**
	 * Returns the searchable fields
	 *
	 * @return string
	 */
	public function getSearchableFields() {
		return $this->tca['ctrl']['searchFields'];
	}

	/**
	 * Returns the configuration for a $field
	 *
	 * @param string $fieldName
	 * @return array
	 */
	public function getConfiguration($fieldName) {
		$fields = $this->getFields();
		return $fields[$fieldName]['config'];
	}

	/**
	 * Returns the configuration for a $field
	 *
	 * @param string $fieldName
	 * @return string
	 */
	public function getFieldType($fieldName) {
		$config = $this->getConfiguration($fieldName);
		return $config['type'];
	}

	/**
	 * Get the translation of a label given a column
	 *
	 * @param string $fieldName the name of the column
	 * @return string
	 */
	public function getLabel($fieldName) {
		$result = '';
		if ($this->hasLabel($fieldName)) {
			$field = $this->getField($fieldName);
			$result = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($field['label'], '');
		}
		return $result;
	}

	/**
	 * Returns whether the column has a label
	 *
	 * @param string $fieldName the name of the column
	 * @return bool
	 */
	public function hasLabel($fieldName) {
		$field = $this->getField($fieldName);
		return empty($field['label']) ? FALSE : TRUE;
	}

	/**
	 * Returns an array containing the configuration of an column
	 *
	 * @param string $fieldName the name of the column
	 * @return array
	 */
	public function getField($fieldName) {
		return $this->tca['columns'][$fieldName];
	}

	/**
	 * Returns a list of fields. If type is not given, return the first one found.
	 *
	 * @throws \TYPO3\CMS\Media\Exception\InvalidKeyInArrayException
	 * @param int $type
	 * @return string
	 */
	public function getFieldsForRecordType($type = NULL) {
		if ($type === NULL) {
			reset($this->tca['types']);
			$type = key($this->tca['types']);
		}

		if (empty($this->tca['types'][$type]['showitem'])) {
			throw new \TYPO3\CMS\Media\Exception\InvalidKeyInArrayException('There is not such TCA for type :' . $type, 1356028574);
		}
		return $this->tca['types'][$type]['showitem'];
	}

	/**
	 * Returns structured fields for a possible given type.
	 *
	 * @param int $type
	 * @return array
	 */
	public function getFieldStructureForRecordType($type = NULL) {
		$fields = $this->getFieldsForRecordType($type);

		$structure = array();
		$tabName = 'LLL:EXT:cms/locallang_ttc.xml:palette.general';
		$tabMarker = '--div--;';
		$items = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $fields);

		foreach ($items as $item) {
			if (strpos($item, $tabMarker) !== FALSE) {
				$tabName = str_replace($tabMarker, '', $item);
			} else {
				$structure[$tabName][] = $item;
			}
		}
		return $structure;
	}
}
?>