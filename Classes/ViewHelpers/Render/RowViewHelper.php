<?php
namespace TYPO3\CMS\Media\ViewHelpers\Render;
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * View helper for rendering rows of medias
 *
 * @category    ViewHelpers
 * @package     TYPO3
 * @subpackage  media
 * @author      Fabien Udriot <fabien.udriot@typo3.org>
 */
class RowViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Render rows of medias and output them in JSON formation
	 *
	 * @param \TYPO3\CMS\Media\Domain\Model\Media $media the media to be displayed
	 * @return string
	 */
	public function render(\TYPO3\CMS\Media\Domain\Model\Media $media) {

		$columns = \TYPO3\CMS\Media\Utility\Grid::getInstance()->getColumns();

		// Initialize returned array
		$output = array();
		$output['DT_RowId'] = 'row-' . $media->getUid();
		$output['DT_RowClass'] = 'row-' . $media->getStatus();

		foreach($columns as $fieldName => $configuration) {

			if (\TYPO3\CMS\Media\Utility\Grid::getInstance()->isNotInternal($fieldName)) {

				// Fetch value
				$value = call_user_func(array($media, 'getProperty'), $fieldName);

				if (\TYPO3\CMS\Media\Utility\Grid::getInstance()->hasRenderer($fieldName)) {
					$renderer = \TYPO3\CMS\Media\Utility\Grid::getInstance()->getRenderer($fieldName);

					/** @var $rendererObject \TYPO3\CMS\Media\Renderer\RendererInterface */
					$rendererObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($renderer);
					$value = $rendererObject->render($media);
				}

				if (!empty($configuration['format'])) {
					$formatter = sprintf('TYPO3\CMS\Media\Formatter\%s::format', ucfirst($configuration['format']));
					$value = call_user_func($formatter, $value);
				}

				if (!empty($configuration['wrap'])) {
					$parts = explode('|', $configuration['wrap']);
					$value = implode($value, $parts);
				}
				$output[$fieldName] = $value;
			}
		}

		$output = json_encode($output);

		// remove curly bracket before and after since content is encapsulate with other content.
		return substr($output, 1, -1);
	}
}

?>