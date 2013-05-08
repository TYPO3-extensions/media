<?php
namespace TYPO3\CMS\Media\Domain\Repository;

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


class ProcessedFileRepository extends \TYPO3\CMS\Core\Resource\ProcessedFileRepository {

	/**
	 * Gets an processed file object from an identifier [storage]:[fileId]
	 *
	 * @param string $identifier
	 * @return ProcessedFile
	 */
	public function getFileObjectFromCombinedIdentifier($identifier) {

		$processedFile = FALSE;

		$parts = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(':', $identifier);
		if (count($parts) === 2) {
			$storageUid = $parts[0];
			$fileIdentifier = $parts[1];
		} else {
			// We only got a path: Go into backwards compatibility mode and
			// use virtual Storage (uid=0)
			$storageUid = 0;
			$fileIdentifier = $parts[0];
		}

		$databaseRow = $this->databaseConnection->exec_SELECTgetSingleRow(
			'*',
			$this->table,
			'storage=' . intval($storageUid) .
				' AND identifier=' . $this->databaseConnection->fullQuoteStr($fileIdentifier, $this->table)
		);

		if (is_array($databaseRow)) {
			$processedFile = $this->createDomainObject($databaseRow);
		}

		return $processedFile;
	}
}