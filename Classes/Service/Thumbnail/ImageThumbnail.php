<?php
namespace TYPO3\CMS\Media\Service\Thumbnail;

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
 *
 * @package media
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class ImageThumbnail extends \TYPO3\CMS\Media\Service\Thumbnail
	implements \TYPO3\CMS\Media\Service\ThumbnailRenderableInterface {

	/**
	 * Render a thumbnail of a media
	 *
	 * @return string
	 */
	public function create() {
		$steps = $this->getRenderingSteps();

		$result = '';
		while($step = array_shift($steps)) {
			$result = $this->$step($result);
		}

		return $result;
	}

	/**
	 * Render the URI of the thumbnail.
	 *
	 * @return string
	 */
	public function renderUri(){

		// Makes sure the width and the height of the thumbnail is not bigger than the actual file
		$configuration = $this->getConfiguration();
		if (!empty($configuration['width']) && $configuration['width'] > $this->file->getProperty('width')) {
			$configuration['width'] = $this->file->getProperty('width');
		}
		if (!empty($configuration['height']) && $configuration['height'] > $this->file->getProperty('height')) {
			$configuration['height'] = $this->file->getProperty('height');
		}

		$taskType = \TYPO3\CMS\Core\Resource\ProcessedFile::CONTEXT_IMAGEPREVIEW;
		$this->processedFile = $this->file->process($taskType, $configuration);

		return $this->processedFile->getPublicUrl(TRUE);
	}

	/**
	 * Render the tag image which is the main one for a thumbnail.
	 *
	 * @param string $result
	 * @return string
	 */
	public function renderTagImage($result) {
		return sprintf('<img src="%s?%s" title="%s" alt="%s" %s/>',
			$result,
			$this->processedFile->isUpdated() ? time() : $this->processedFile->getProperty('tstamp'),
			htmlspecialchars($this->file->getName()),
			htmlspecialchars($this->file->getName()),
			$this->renderAttributes()
		);
	}

	/**
	 * Render a wrapping anchor around the thumbnail.
	 *
	 * @param string $result
	 * @return string
	 */
	public function renderTagAnchor($result) {
		return sprintf('<a href="%s?%s" target="_blank">%s</a>',
			$this->file->getPublicUrl(TRUE),
			$this->file->getProperty('tstamp'),
			$result
		);
	}
}
?>