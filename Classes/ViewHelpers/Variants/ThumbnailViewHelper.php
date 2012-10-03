<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Steffen Ritter <steffen.ritter@typo3.org>
*
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
 * Simple page browser that splits all results to only show the
 * ones from the current page, and then sets additional variables
 * that can be used to create next/previous links
 *
 * @author	Steffen Ritter <steffen.ritter@typo3.org>
 *
 */
class Tx_Media_ViewHelpers_Variants_ThumbnailViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * main render function
	 *
	 * @param t3lib_file_FileInterface $file
	 * @return t3lib_file_File
	 */
	public function render(t3lib_file_FileInterface $file) {
		if ($file instanceof t3lib_file_FileReference) {
			$file = $file->getOriginalFile();
		}
		/** @var Tx_Media_Service_Variants $variantsService */
		$variantsService = t3lib_div::makeInstance('Tx_Media_Service_Variants');
		return $variantsService->getThumbnailForFile($file);
	}

}

?>