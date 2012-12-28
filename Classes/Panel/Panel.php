<?php
namespace TYPO3\CMS\Media\Panel;

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
 * A class to render a panel
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class Panel implements \TYPO3\CMS\Media\Form\FormInterface {

	/**
	 * @var string
	 */
	protected $title = '';

	/**
	 * @var string
	 */
	protected $template = '';

	/**
	 * @return
	 */
	public function __constructor() {
		$this->template = <<<EOF

EOF;

	}

	/**
	 * Returns structured fields for a possible given type.
	 *
	 * @return void
	 */
	public function wrap() {

	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return \TYPO3\CMS\Media\Form\Panel
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @param string $template
	 * @return \TYPO3\CMS\Media\Form\FormInterface
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}

	/**
	 * @return string
	 */
	public function render() {
		// TODO: Implement render() method.
	}

	/**
	 * \TYPO3\CMS\Media\Form\FormInterface $element
	 *
	 * @return \TYPO3\CMS\Media\Form\FormInterface
	 */
	public function addItem(\TYPO3\CMS\Media\Form\FormInterface $element) {
		// TODO: Implement addItem() method.
	}}
?>