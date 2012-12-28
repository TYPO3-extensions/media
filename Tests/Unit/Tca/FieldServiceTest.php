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
 * Test case for class \TYPO3\CMS\Media\Tca\FieldService.
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class TcaFieldServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \TYPO3\CMS\Media\Tca\FieldService
	 */
	protected $fixture;

	public function setUp() {
		$tableName = 'sys_file';
		$serviceType = 'field';
		$this->fixture = new \TYPO3\CMS\Media\Tca\FieldService($tableName, $serviceType);
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function fieldsIncludesATitleFieldForTableSysFile() {
		$actual = $this->fixture->getFields();
		$this->assertTrue(is_array($actual));
		$this->assertArrayHasKey('title', $actual);
	}

	/**
	 * @test
	 */
	public function fieldTypeReturnsInputForFieldTitleForTableSysFile() {
		$actual = $this->fixture->getFieldType('title');
		$this->assertEquals('input', $actual);
	}

	/**
	 * @test
	 */
	public function returnFieldsInFormWithNoTypeGivenForTableSysFile() {
		$actual = $this->fixture->getFieldsForRecordType();
		$this->assertEquals('fileinfo, name, title, description, alternative, storage, categories, variants', $actual);
	}

	/**
	 * @test
	 */
	public function fieldsInFormMustBeEqualWithTypeEqualOne() {
		$this->assertEquals($this->fixture->getFieldsForRecordType(), $this->fixture->getFieldsForRecordType(1));
	}

	/**
	 * @test
	 */
	public function fieldNameMustBeRequiredByDefault() {
		$this->assertTrue($this->fixture->isRequired('name'));
	}

	/**
	 * @test
	 */
	public function fieldTitleMustNotBeRequiredByDefault() {
		$this->assertFalse($this->fixture->isRequired('title'));
	}

	/**
	 * @test
	 * @expectedException \TYPO3\CMS\Media\Exception\InvalidKeyInArrayException
	 */
	public function raiseExceptionIfTypeDoesNotExist() {
		$this->fixture->getFieldsForRecordType(uniqid('foo'));
	}

	/**
	 * @test
	 */
	public function fieldStructureContainsTheDefaultTabAndIsBiggerThanOneByDefault() {
		$actual = $this->fixture->getFieldStructureForRecordType('image');
		$this->assertArrayHasKey('LLL:EXT:cms/locallang_ttc.xml:palette.general', $actual);
		$this->assertTrue(count($actual) !== 1);
	}

}
?>