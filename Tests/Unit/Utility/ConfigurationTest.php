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
 * Test case for class \TYPO3\CMS\Media\Utility\Configuration.
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class ConfigurationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	public function setUp() {
	}

	public function tearDown() {
	}

	/**
	 * @test
	 */
	public function getSettingsReturnNotEmptyArrayByDefault() {
		$actual = \TYPO3\CMS\Media\Utility\Configuration::getSettings();
		$this->assertTrue(is_array($actual));
		$this->assertNotEmpty($actual);
	}

	/**
	 * @test
	 */
	public function thumbnailSizeSettingReturnsNotEmpty() {
		$actual = \TYPO3\CMS\Media\Utility\Configuration::get('image_thumbnail');
		$this->assertTrue($actual > 1);
	}

	/**
	 * @test
	 */
	public function getFooValueReturnsEmpty() {
		$expected = '';
		$actual = \TYPO3\CMS\Media\Utility\Configuration::get(uniqid('foo'));
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @test
	 */
	public function configurationArrayNotEmptyAfterGetARandomValue() {
		\TYPO3\CMS\Media\Utility\Configuration::get(uniqid('foo'));

		$actual = \TYPO3\CMS\Media\Utility\Configuration::getSettings();
		$this->assertTrue(count($actual) > 0);
	}

	/**
	 * @test
	 */
	public function getStorageValueIsNotEmpty() {
		$actual = \TYPO3\CMS\Media\Utility\Configuration::get('storage');
		$this->assertNotEmpty($actual);
	}


}
?>