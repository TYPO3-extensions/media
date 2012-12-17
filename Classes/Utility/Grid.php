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
 * A class to handle TCA grid configuration
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class Grid implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var array
	 */
	protected $tca;

	/**
	 * Returns a class instance
	 *
	 * @return \TYPO3\CMS\Media\Utility\Grid
	 */
	static public function getInstance() {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Utility\Grid');
	}

	/**
	 * __construct
	 *
	 * @return \TYPO3\CMS\Media\Utility\Grid
	 */
	public function __construct() {

		\TYPO3\CMS\Core\Utility\GeneralUtility::loadTCA('sys_file');
		$this->tca = $GLOBALS['TCA']['sys_file']['grid'];

		$this->validateConfiguration();
	}

	/**
	 * Check that the configuration is valid
	 *
	 * @throw \TYPO3\CMS\Media\Exception\MissingTcaConfigurationException
	 * @return void
	 */
	public function validateConfiguration() {
		// Index "columns" is required
		if (empty($this->tca['columns'])) {
			throw new \TYPO3\CMS\Media\Exception\MissingTcaConfigurationException('Missing TCA key "sys_file/grid/columns"', 1351865723);
		}

		// Mandatory field is field
		foreach ($this->tca['columns'] as $column) {
			if (empty($column['field'])) {
				throw new \TYPO3\CMS\Media\Exception\MissingTcaConfigurationException('Missing field name in ' . var_export($column), 1351865723);
			}
		}
	}

	/**
	 * Returns an array containing column names
	 *
	 * @return array
	 */
	public function getListOfColumns() {
		$result = array();
		foreach ($this->tca['columns'] as $column) {
			$result[] = $column['field'];
		}
		return $result;
	}

	/**
	 * Returns an array containing column names
	 *
	 * @return array
	 */
	public function getColumns() {
		return $this->tca['columns'];
	}

}
?>