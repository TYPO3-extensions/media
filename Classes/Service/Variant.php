<?php
namespace TYPO3\CMS\Media\Service;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Steffen Ritter <steffen.ritter@typo3.org>
 *  (c) 2013 Fabien Udriot <fabien.udriot@typo3.org>
 *
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
 * @package media
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Variant implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Core\Resource\FileRepository
	 */
	protected $fileRepository = NULL;

	/**
	 * @return \TYPO3\CMS\Media\Service\Variant
	 */
	public function __construct() {
		$this->fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Resource\FileRepository');
	}

	/**
	 * Get meta information from a file using a metaExtract service
	 *
	 * @param \TYPO3\CMS\Core\Resource\File $file
	 * @param int|null $restrictToVariantType
	 * @return \TYPO3\CMS\Core\Resource\File[]
	 */
	public function getVariants(\TYPO3\CMS\Core\Resource\File $file, $restrictToVariantType = NULL) {
		$file = $this->findOriginal($file);
		$variants = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'variant',
			'sys_file_variants',
			'original=' . $file->getUid() .
			($restrictToVariantType == NULL ?: ' AND role = ' . intval($restrictToVariantType))
		);
		$variantsArray = array();
		foreach ($variants AS $rawVariant) {
			$object = $this->fileRepository->findByUid($rawVariant['variant']);
			if ($object instanceof \TYPO3\CMS\Core\Resource\File) {
				$variantsArray[] = $object;
			}
		}
		$variantsArray[] = $file;

		return $variantsArray;
	}

	/**
	 * Retrieves thumbnail for file placed in record
	 *
	 * @param \TYPO3\CMS\Core\Resource\File $file
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function getThumbnail(\TYPO3\CMS\Core\Resource\File $file) {
		return current($this->getVariants($file, 4));
	}

	/**
	 * @param \TYPO3\CMS\Core\Resource\File $file
	 * @param null $restrictToFileExtensions
	 * @return array|\TYPO3\CMS\Core\Resource\File[]
	 */
	public function getAlternateFiles(\TYPO3\CMS\Core\Resource\File $file, $restrictToFileExtensions = NULL) {
		$files = $this->getVariants($file, 1);

		if ($restrictToFileExtensions !== NULL) {
			$filteredFiles = array();
			foreach ($files AS $file) {
				if (\TYPO3\CMS\Core\Utility\GeneralUtility::inList($restrictToFileExtensions, $file->getExtension())) {
					$filteredFiles[] = $file;
				}
			}
			$files = $filteredFiles;
		}
		return $files;
	}

	/**
	 * Checks whether the given file is used as variant and returns the original file due to metadata
	 *
	 * @param \TYPO3\CMS\Core\Resource\File $file
	 * @return \TYPO3\CMS\Core\Resource\File
	 */
	public function findOriginal(\TYPO3\CMS\Core\Resource\File $file) {
		$variants = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
			'original',
			'sys_file_variants',
			'variant = ' . $file->getUid()
		);
		if (count($variants)) {
			$orig = $this->fileRepository->findByUid($variants[0]['original']);
			if ($orig !== NULL)  {
				$file = $orig;
			}
		}
		return $file;
	}

}
?>