<?php
namespace TYPO3\CMS\Media\Controller;
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
 * Base Controller which is meant to include all common
 *
 * @author Fabien Udriot <fabien.udriot@typo3.org>
 * @package TYPO3
 * @subpackage media
 */
class BaseController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $frontendUser;

	/**
	 * Instantiate a filter object and feed the object with conditions
	 *
	 * @param array $filter
	 * @return \TYPO3\CMS\Media\QueryElement\Filter
	 */
	protected function createFilterObject(array $filter = NULL) {
		$filterObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\QueryElement\Filter');
		if (!empty($filter)) {
			if ($filter['location'] != '') {
				$filterObject->setLocation($filter['location']);
			}
			if ($filter['country']) {
				$filterObject->setCountry($filter['country']);
			}
			if ($filter['category']) {
				$filterObject->setCategory($filter['category']);
			}
		}
		return $filterObject;
	}

	/**
	 * Instantiate an order object and returns it
	 *
	 * @return \TYPO3\CMS\Media\QueryElement\Order
	 */
	protected function createOrderObject() {

		$order = array();

		$columnId = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('iSortCol_0');
		if ($columnId > 0) {
			$columns = \TYPO3\CMS\Media\Service\Grid::getInstance()->getColumns();
			$field = $columns[$columnId]['field'];

			$direction = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sSortDir_0');
			$order = array(
				$field => $direction
			);
		}
		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\QueryElement\Order', $order);
	}

	/**
	 * Instantiate a pager object and returns its
	 *
	 * @return \TYPO3\CMS\Media\QueryElement\Pager
	 */
	protected function createPagerObject() {

		/** @var $pager \TYPO3\CMS\Media\QueryElement\Pager */
		$pager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\QueryElement\Pager');

		// Set items per page
		// DataTables plugin is not flexible enough - or makes it complicated - to encapsulate
		// parameters like tx_media_pi[page]
		// $this->request->hasArgument('page')
		$itemsPerPage = $this->settings['pageBrowser']['itemsPerPage'];
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('iDisplayLength')) {
			$itemsPerPage = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('iDisplayLength');
		}
		$pager->setItemsPerPage($itemsPerPage);

		// Set offset
		$offset = 0;
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('iDisplayStart')) {
			$offset = (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GET('iDisplayStart');
		}
		$pager->setOffset($offset);

		// set page
		$page = 1;
		if ($pager->getItemsPerPage() > 0) {
			$page = round($pager->getOffset() / $pager->getItemsPerPage());
		}
		$pager->setPage($page);

		return $pager;
	}
}
?>