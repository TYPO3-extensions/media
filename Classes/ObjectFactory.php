<?php
namespace TYPO3\CMS\Media;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Factory class for Media objects.
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage t3lib
 */
class ObjectFactory implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	protected $databaseHandler;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->databaseHandler = $GLOBALS['TYPO3_DB'];
	}

	/**
	 * Gets a singleton instance of this class.
	 *
	 * @return \TYPO3\CMS\Media\ObjectFactory
	 */
	static public function getInstance() {
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Media\\ObjectFactory');
	}

	/**
	 * Creates a media object from an array of file data. Requires a database
	 * row to be fetched.
	 *
	 * @param array $fileData
	 * @param string $objectType
	 * @return object
	 */
	public function createObject(array $fileData, $objectType = 'TYPO3\CMS\Media\Domain\Model\Asset') {
		/** @var $object \TYPO3\CMS\Core\Resource\FileInterface */
		$object = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($objectType, $fileData);

		if (is_numeric($fileData['storage'])) {
			$resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
			$storageObject = $resourceFactory->getStorageObject($fileData['storage']);
			$object->setStorage($storageObject);
		}
		return $object;
	}

	/**
	 * Return the current storage
	 *
	 * @return \TYPO3\CMS\Core\Resource\ResourceStorage
	 */
	public function getCurrentStorage() {
		$storageUid = (int) \TYPO3\CMS\Media\Utility\Setting::getInstance()->get('storage');
		return \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getStorageObject($storageUid);
	}

	/**
	 * Return a folder object
	 *
	 * @param \TYPO3\CMS\Core\Resource\File|\TYPO3\CMS\Media\FileUpload\UploadedFileInterface  $fileObject
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getContainingFolder($fileObject = NULL) {

		$storageObject = $this->getCurrentStorage();

		// default is the root level
		$folderObject = $storageObject->getRootLevelFolder(); // get the root folder by default
		if ($fileObject instanceof \TYPO3\CMS\Core\Resource\File) {
			$folderObject = $storageObject->getFolder(dirname($fileObject->getIdentifier()));
		} elseif ($fileObject instanceof \TYPO3\CMS\Media\FileUpload\UploadedFileInterface) {
			// Get a possible mount point within the storage
			$mountPointUid = \TYPO3\CMS\Media\Utility\Setting::getInstance()->get('mount_point_for_file_type_' . $fileObject->getType());
			if ($mountPointUid > 0) {
				// since we don't have a Mount Point repository in FAL, query the database directly.
				$record = $this->databaseHandler->exec_SELECTgetSingleRow('path', 'sys_filemounts', 'deleted = 0 AND uid = ' . $mountPointUid);
				if (!empty($record['path'])) {
					$folderObject = $storageObject->getFolder($record['path']);
				}
			}
		}
		return $folderObject;
	}

	/**
	 * Return a folder object
	 *
	 * @return \TYPO3\CMS\Core\Resource\Folder
	 */
	public function getVariantFolder() {

		$storageObject = $this->getCurrentStorage();

		// default is the root level
		$folderObject = $storageObject->getRootLevelFolder();

		// Get a possible mount point within the storage
		$mountPointUid = \TYPO3\CMS\Media\Utility\Setting::getInstance()->get('mount_point_for_variants');
		if ($mountPointUid > 0) {

			// since we don't have a Mount Point repository in FAL, query the database directly.
			$record = $this->databaseHandler->exec_SELECTgetSingleRow('path', 'sys_filemounts', 'deleted = 0 AND uid = ' . $mountPointUid);
			if (!empty($record['path'])) {
				$folderObject = $storageObject->getFolder($record['path']);
			}
		}
		return $folderObject;
	}
}


?>