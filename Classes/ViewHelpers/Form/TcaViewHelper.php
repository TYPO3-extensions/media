<?php
namespace TYPO3\CMS\Media\ViewHelpers\Form;

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
 * View helper dealing with form
 *
 * @category    ViewHelpers
 * @package     TYPO3
 * @subpackage  media
 * @author      Fabien Udriot <fabien.udriot@typo3.org>
 */
class TcaViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var string
	 */
	protected $prefix;

	/**
	 * Render a form according to a given object
	 *
	 * @param \TYPO3\CMS\Media\Domain\Model\Media $object Object to use for the form. Use in conjunction with the "property" attribute on the sub tags
	 * @param string $prefix prefix the field name with a namespace
	 * @return string
	 */
	public function render(\TYPO3\CMS\Media\Domain\Model\Media $object = NULL, $prefix = NULL) {

		$this->prefix = $prefix;
		if (empty($this->prefix)) {
			$this->prefix = $this->getObjectType($object);
		}
		// @todo move code into media form factory?

		/** @var $tabPanel \TYPO3\CMS\Media\Panel\TabPanel */
		$tabPanel = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Panel\TabPanel');
//		$panel->setWidth(4);

		$type = \TYPO3\CMS\Media\Utility\MediaType::getLabel($object->getType());
		$fieldStructure = \TYPO3\CMS\Media\Utility\TcaField::getInstance()->getFieldStructureForRecordType($type);

		$panels = array_keys($fieldStructure);

		while ($fields = array_shift($fieldStructure)) {
			$panelTitle = array_shift($panels);

			$tabPanel->createPanel($panelTitle);

			foreach ($fields as $fieldName) {
				$configuration = \TYPO3\CMS\Media\Utility\TcaField::getInstance()->getConfiguration($fieldName);

				if ($configuration['type'] == 'input') {

					/** @var $fieldObject \TYPO3\CMS\Media\Form\TextField */
					$fieldObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Form\TextField');

					$label = \TYPO3\CMS\Media\Utility\TcaField::getInstance()->getLabel($fieldName);

					// Get the value by calling a getter method if existing.
					$value = '';
					$getter = 'get' . ucfirst($fieldName);
					if (method_exists($object, $getter)) {
						$value = call_user_func(array($object, $getter));
					}

					$fieldObject->setName($fieldName)
						->setLabel($label)
						->setValue($value)
						->setPrefix($this->getPrefix())
						->addAttribute(array('class' => 'span6'));
					$tabPanel->addItem($fieldObject);
				}
			}
		}

		// @todo should be a hook added?
		return $tabPanel->render();
	}

	/**
	 * Get object type for TCA
	 *
	 * @param object $object
	 * @return string
	 */
	public function getObjectType($object){
		$parts = explode('\\', get_class($object));
		return strtolower(array_pop($parts));
	}

	/**
	 * Prefixes / namespaces the given name with the form field prefix
	 *
	 * @return string
	 */
	protected function getPrefix() {
		$prefix = (string) $this->viewHelperVariableContainer->get('TYPO3\\CMS\\Fluid\\ViewHelpers\\FormViewHelper', 'fieldNamePrefix');

		if (!empty($this->prefix)) {
			$prefix = sprintf('%s[%s]', $prefix, $this->prefix);
		}
		return $prefix;
	}
}

?>