<?php
namespace TYPO3\CMS\Media\Hooks;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013
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
 * ************************************************************* */

class NawSecuredl {

	/**
	 * @param mixed $params array('pObj' => $pObj)
	 * @param tx_nawsecuredl_output $nawsecuredl_output
	 */
	public function preOutput($params, $nawsecuredl_output) {

		// skip processed files (we have no relation atm with the original file)
		if(strpos($nawsecuredl_output->file, '_processed_') !== FALSE) {
			return;
		}

		// @ todo: find desent way to determin fileobject based on url/path
		/** @var $fileObject \TYPO3\CMS\Core\Resource\File */
		$fileObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->retrieveFileOrFolderObject(preg_replace('/^fileadmin/', '1:', $nawsecuredl_output->file));

		// only proceed checks if file is indexed
		// else leave access check to naw_securedl
		if($fileObject->isIndexed()) {

			// @todo: make next part easier. Now you can't get a asset trough the asset repository if it isn't in the default storage
			/** @var $asset \TYPO3\CMS\Media\Domain\Model\Asset */
			$asset = NULL;

			$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

			/** @var $match \TYPO3\CMS\Media\QueryElement\Match */
			$match = $objectManager->get('TYPO3\CMS\Media\QueryElement\Match');

			/** @var $query \TYPO3\CMS\Media\QueryElement\Query */
			$query = $objectManager->get('TYPO3\CMS\Media\QueryElement\Query');

			$result = $query->setRespectStorage(FALSE)
				->setObjectType('TYPO3\CMS\Media\Domain\Model\Asset')
				->setMatch($match->setMatches(array('uid' => $fileObject->getUid())))
				->execute();

			if(is_array($result)) {
				$asset = reset($result);
			}

			// asset found then proceed
			if($asset) {

				$assetGroups = array();
				foreach($asset->getFrontendUserGroups() as $group) {
					$assetGroups[] = $group;
				}

				// asset FE group(s) set then check permisions
				if(count($assetGroups)) {
					$hasAccess = FALSE;
					$feUser = $params['pObj']->feUserObj->user;

					// Makes sure has been logged in
					if ($feUser && $feUser['usergroup'] != '') {

						// @toto make group compare aware of subgroups
						$groups = explode(',', $feUser['usergroup']);
						foreach($assetGroups as $group) {
							if(in_array($group->getUid(), $groups)) {
								$hasAccess = TRUE;
								break;
							}
						}
					}

					// No access
					if (!$hasAccess) {
						die("Accessing the resource is forbidden!");
					}
				}
			}
		}
	}
}