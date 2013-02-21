<?php
namespace TYPO3\CMS\Media\Domain\Model;

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
 * Media representation in the file abstraction layer.
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @author Lorenz Ulrich <lorenz.ulrich@visol.ch>
 * @package TYPO3
 * @subpackage media
 */
class Asset extends \TYPO3\CMS\Core\Resource\File {

	/**
	 * Constructor for a Media object.
	 *
	 * @param array $assetData
	 * @param \TYPO3\CMS\Core\Resource\ResourceStorage $storage
	 * @return \TYPO3\CMS\Media\Domain\Model\Asset
	 */
	public function __construct(array $assetData = array(), $storage = NULL) {
		parent::__construct($assetData, $storage);
	}

	/**
	 * Initializes all Tx_Extbase_Persistence_ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		// TODO categories, variants
	}

	/**
	 * Alternative title
	 *
	 * @var string
	 */
	protected $alternative;

	/**
	 * Caption
	 *
	 * @var string
	 */
	protected $caption;

	/* TODO categories */

	/**
	 * Color Space
	 *
	 * @var string
	 */
	protected $colorSpace;

	/**
	 * Content creation date
	 *
	 * @var \DateTime
	 */
	protected $creationDate;

	/**
	 * Content modification date
	 *
	 * @var \DateTime
	 */
	protected $modificationDate;

	/**
	 * Creator
	 *
	 * @var string
	 */
	protected $creator;

	/**
	 * Creator tool
	 *
	 * @var string
	 */
	protected $creatorTool;

	/**
	 * Description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Download name
	 *
	 * @var string
	 */
	protected $downloadName;

	/**
	 * Duration
	 *
	 * @var string
	 */
	protected $duration;

	/**
	 * Height
	 *
	 * @var integer
	 */
	protected $height;

	/**
	 * Horizontal resolution
	 *
	 * @var integer
	 */
	protected $horizontalResolution;

	/**
	 * Keywords
	 *
	 * @var string
	 */
	protected $keywords;

	/**
	 * Language
	 *
	 * @var string
	 */
	protected $language;

	/**
	 * Latitude
	 *
	 * @var float
	 */
	protected $latitude;

	/**
	 * Location City
	 *
	 * @var string
	 */
	protected $locationCity;

	/**
	 * Location Country
	 *
	 * @var string
	 */
	protected $locationCountry;

	/**
	 * Location Region
	 *
	 * @var string
	 */
	protected $locationRegion;

	/**
	 * Longitude
	 *
	 * @var float
	 */
	protected $longitude;

	/**
	 * Mime Type
	 *
	 * @var string
	 */
	protected $mimeType;

	/**
	 * Note
	 *
	 * @var string
	 */
	protected $note;

	/**
	 * Pages
	 *
	 * @var string
	 */
	protected $pages;

	/**
	 * Publisher
	 *
	 * @var string
	 */
	protected $publisher;

	/**
	 * Ranking
	 *
	 * @var int
	 */
	protected $ranking;

	/**
	 * Source
	 *
	 * @var string
	 */
	protected $source;

	/**
	 * Status
	 *
	 * @var string
	 */
	protected $status;

	/**
	 * Title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Unit
	 *
	 * @var string
	 */
	protected $unit;

	/* TODO variants */

	/**
	 * Vertical resolution
	 *
	 * @var integer
	 */
	protected $verticalResolution;

	/**
	 * Width
	 *
	 * @var integer
	 */
	protected $width;

	/**
	 * Returns the alternative
	 *
	 * @return string $alternative
	 */
	public function getAlternative() {
		return $this->getProperty('alternative');
	}

	/**
	 * Sets the alternative
	 *
	 * @param string $alternative
	 * @return void
	 */
	public function setAlternative($alternative) {
		$this->properties['alternative'] = $alternative;
	}

	/**
	 * Returns the caption
	 *
	 * @return string $caption
	 */
	public function getCaption() {
		return $this->getProperty('caption');
	}

	/**
	 * Sets the caption
	 *
	 * @param string $caption
	 * @return void
	 */
	public function setCaption($caption) {
		$this->properties['caption'] = $caption;
	}

	/* TODO categories */

	/**
	 * Returns the color space
	 *
	 * @return string $colorSpace
	 */
	public function getColorSpace() {
		return $this->getProperty('color_space');
	}

	/**
	 * Sets the color space
	 *
	 * @param string $colorSpace
	 * @return void
	 */
	public function setColorSpace($colorSpace) {
		$this->properties['color_space'] = $colorSpace;
	}

	/**
	 * Returns the creationDate
	 *
	 * @return \DateTime $creationDate
	 */
	public function getCreationDate() {
		return $this->getProperty('creation_date');
	}

	/**
	 * Sets the creationDate
	 *
	 * @param \DateTime $creationDate
	 * @return void
	 */
	public function setCreationDate($creationDate) {
		$this->properties['creation_date'] = $creationDate;
	}

	/**
	 * Returns the modificationDate
	 *
	 * @return \DateTime $modificationDate
	 */
	public function getModificationDate() {
		return $this->getProperty('modification_date');
	}

	/**
	 * Sets the modificationDate
	 *
	 * @param \DateTime $modificationDate
	 * @return void
	 */
	public function setModificationDate($modificationDate) {
		$this->properties['modification_date'] = $modificationDate;
	}

	/**
	 * Returns the creator
	 *
	 * @return string $creator
	 */
	public function getCreator() {
		return $this->getProperty('creator');
	}

	/**
	 * Sets the creator
	 *
	 * @param string $creator
	 * @return void
	 */
	public function setCreator($creator) {
		$this->properties['creator'] = $creator;
	}

	/**
	 * Returns the creatorTool
	 *
	 * @return string $creatorTool
	 */
	public function getCreatorTool() {
		return $this->getProperty('creator_tool');
	}

	/**
	 * Sets the creatorTool
	 *
	 * @param string $creatorTool
	 * @return void
	 */
	public function setCreatorTool($creatorTool) {
		$this->properties['creator_tool'] = $creatorTool;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->getProperty('description');
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->properties['description'] = $description;
	}

	/**
	 * Returns the download name
	 *
	 * @return string $downloadName
	 */
	public function getDownloadName() {
		return $this->getProperty('download_name');
	}

	/**
	 * Sets the download name
	 *
	 * @param string $downloadName
	 * @return void
	 */
	public function setDownloadName($downloadName) {
		$this->properties['download_name'] = $downloadName;
	}

	/**
	 * Returns the duration
	 *
	 * @return string $duration
	 */
	public function getDuration() {
		return $this->getProperty('duration');
	}

	/**
	 * Sets the duration
	 *
	 * @param string $duration
	 * @return void
	 */
	public function setDuration($duration) {
		$this->properties['duration'] = $duration;
	}

	/**
	 * Returns the height
	 *
	 * @return string $height
	 */
	public function getHeight() {
		return $this->getProperty('height');
	}

	/**
	 * Sets the height
	 *
	 * @param string $height
	 * @return void
	 */
	public function setHeight($height) {
		$this->properties['height'] = $height;
	}

	/**
	 * Returns the horizontal resolution
	 *
	 * @return string $horizontalResolution
	 */
	public function getHorizontalResolution() {
		return $this->getProperty('horizontal_resolution');
	}

	/**
	 * Sets the horizontal resolution
	 *
	 * @param string $horizontalResolution
	 * @return void
	 */
	public function setHorizontalResolution($horizontalResolution) {
		$this->properties['horizontal_resolution'] = $horizontalResolution;
	}

	/**
	 * Returns the keywords
	 *
	 * @return string $keywords
	 */
	public function getKeywords() {
		return $this->getProperty('keywords');
	}

	/**
	 * Sets the keywords
	 *
	 * @param string $keywords
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->properties['keywords'] = $keywords;
	}

	/**
	 * Returns the language
	 *
	 * @return string $language
	 */
	public function getLanguage() {
		return $this->getProperty('language');
	}

	/**
	 * Sets the language
	 *
	 * @param string $language
	 * @return void
	 */
	public function setLanguage($language) {
		$this->properties['language'] = $language;
	}

	/**
	 * Returns the latitude
	 *
	 * @return string $latitude
	 */
	public function getLatitude() {
		return $this->getProperty('latitude');
	}

	/**
	 * Sets the latitude
	 *
	 * @param string $latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->properties['latitude'] = $latitude;
	}

	/**
	 * Returns the locationCity
	 *
	 * @return string $locationCity
	 */
	public function getLocationCity() {
		return $this->getProperty('location_city');
	}

	/**
	 * Sets the locationCity
	 *
	 * @param string $locationCity
	 * @return void
	 */
	public function setLocationCity($locationCity) {
		$this->properties['location_city'] = $locationCity;
	}

	/**
	 * Returns the locationCountry
	 *
	 * @return string $locationCountry
	 */
	public function getLocationCountry() {
		return $this->getProperty('location_country');
	}

	/**
	 * Sets the locationCountry
	 *
	 * @param string $locationCountry
	 * @return void
	 */
	public function setLocationCountry($locationCountry) {
		$this->properties['location_country'] = $locationCountry;
	}

	/**
	 * Returns the locationRegion
	 *
	 * @return string $locationRegion
	 */
	public function getLocationRegion() {
		return $this->getProperty('location_region');
	}

	/**
	 * Sets the locationRegion
	 *
	 * @param string $locationRegion
	 * @return void
	 */
	public function setLocationRegion($locationRegion) {
		$this->properties['location_region'] = $locationRegion;
	}

	/**
	 * Returns the longitude
	 *
	 * @return string $longitude
	 */
	public function getLongitude() {
		return $this->getProperty('longitude');
	}

	/**
	 * Sets the longitude
	 *
	 * @param string $longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->properties['longitude'] = $longitude;
	}

	/**
	 * Returns the MIME type
	 *
	 * @return string $mimeType
	 */
	public function getMimeType() {
		return $this->getProperty('mime_type');
	}

	/**
	 * Sets the MIME type
	 *
	 * @param string $mimeType
	 * @return void
	 */
	public function setMimeType($mimeType) {
		$this->properties['mime_type'] = $mimeType;
	}

	/**
	 * Returns the note
	 *
	 * @return string $note
	 */
	public function getNote() {
		return $this->getProperty('note');
	}

	/**
	 * Sets the note
	 *
	 * @param string $note
	 * @return void
	 */
	public function setNote($note) {
		$this->properties['note'] = $note;
	}

	/**
	 * Returns the pages
	 *
	 * @return string $pages
	 */
	public function getPages() {
		return $this->getProperty('pages');
	}

	/**
	 * Sets the pages
	 *
	 * @param string $pages
	 * @return void
	 */
	public function setPages($pages) {
		$this->properties['pages'] = $pages;
	}

	/**
	 * Returns the publisher
	 *
	 * @return string $publisher
	 */
	public function getPublisher() {
		return $this->getProperty('publisher');
	}

	/**
	 * Sets the publisher
	 *
	 * @param string $publisher
	 * @return void
	 */
	public function setPublisher($publisher) {
		$this->properties['publisher'] = $publisher;
	}

	/**
	 * Returns the ranking
	 *
	 * @return string $ranking
	 */
	public function getRanking() {
		return $this->getProperty('ranking');
	}

	/**
	 * Sets the ranking
	 *
	 * @param string $ranking
	 * @return void
	 */
	public function setRanking($ranking) {
		$this->properties['ranking'] = $ranking;
	}

	/**
	 * Returns the source
	 *
	 * @return string $source
	 */
	public function getSource() {
		return $this->getProperty('source');
	}

	/**
	 * Sets the source
	 *
	 * @param string $source
	 * @return void
	 */
	public function setSource($source) {
		$this->properties['source'] = $source;
	}

	/**
	 * Returns the status
	 *
	 * @return string $status
	 */
	public function getStatus() {
		return $this->getProperty('status');
	}

	/**
	 * Sets the status
	 *
	 * @param string $status
	 * @return void
	 */
	public function setStatus($status) {
		$this->properties['status'] = $status;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->getProperty('title');
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->properties['title'] = $title;
	}

	/**
	 * Returns the type
	 *
	 * @return string $type
	 */
	public function getType() {
		return $this->getProperty('type') === '' ? 0 : (int) $this->getProperty('type');
	}

	/**
	 * Sets the type
	 *
	 * @param string $type
	 * @return void
	 */
	public function setType($type) {
		$this->properties['type'] = $type;
	}

	/**
	 * Returns the unit
	 *
	 * @return string $unit
	 */
	public function getUnit() {
		return $this->getProperty('unit');
	}

	/**
	 * Sets the unit
	 *
	 * @param string $unit
	 * @return void
	 */
	public function setUnit($unit) {
		$this->properties['unit'] = $unit;
	}

	/* TODO variants */

	/**
	 * Returns the vertical resolution
	 *
	 * @return string $verticalResolution
	 */
	public function getVerticalResolution() {
		return $this->getProperty('vertical_resolution');
	}

	/**
	 * Sets the vertical resolution
	 *
	 * @param string $verticalResolution
	 * @return void
	 */
	public function setVerticalResolution($verticalResolution) {
		$this->properties['vertical_resolution'] = $verticalResolution;
	}

	/**
	 * Returns the width
	 *
	 * @return string $width
	 */
	public function getWidth() {
		return $this->getProperty('width');
	}

	/**
	 * Sets the width
	 *
	 * @param string $width
	 * @return void
	 */
	public function setWidth($width) {
		$this->properties['width'] = $width;
	}

	/**
	 * Sets a custom property name. Useful for unit testing.
	 *
	 * @param string $property
	 * @param string $value
	 * @return void
	 */
	public function setProperty($property, $value) {
		$this->updateProperties(array($property => $value));
	}

	/**
	 * @param boolean $indexIfNotIndexed
	 */
	public function setIndexIfNotIndexed($indexIfNotIndexed) {
		$this->indexed = $indexIfNotIndexed;
	}

	/**
	 * Return a thumbnail corresponding to a Media
	 *
	 * @param array $options
	 * @return string
	 */
	public function getThumbnail(array $options = array()) {
		// @todo implement me
		// @todo make sure the the thumbnail can be wrapped in "a" tag,
		return '';
	}
}
?>