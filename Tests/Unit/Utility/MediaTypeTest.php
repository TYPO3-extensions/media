<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Media development team <typo3-project-media@lists.typo3.org>
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
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \TYPO3\CMS\Media\Utility\MediaType.
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class MediaTypeTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	public function setUp() {
	}

	public function tearDown() {
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsTextForMimeTypeOne() {
		$expected = 'text';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(1);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsImageForMimeTypeTwo() {
		$expected = 'image';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(2);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsAudioForMimeTypeThree() {
		$expected = 'audio';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(3);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsVideoForMimeTypeFor() {
		$expected = 'video';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(4);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsSoftwareForMimeTypeFive() {
		$expected = 'software';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(5);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function mimeTypeReturnsUnknownForMimeTypeRandom() {
		$expected = 'unknown';
		$actual = \TYPO3\CMS\Media\Utility\MediaType::getLabel(rand(10000, 100000));
		$this->assertEquals($expected, $actual);
	}

}
?>