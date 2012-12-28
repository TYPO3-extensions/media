TCA Service API
=================

This API enables to fetch info related to TCA in a programmatic way. Since TCA covers a very large set of data, the service is divided in types.
Currently, there are are three main parts implemented: table, field and grid. The "grid" part extends the TCA for the need of media. Find below some code example.

Instantiate a TCA service dealing with fields::

	$tableName = 'sys_file';
	$serviceType = 'field';

	/** @var $fieldService \TYPO3\CMS\Media\Tca\FieldService */
	$fieldService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal method of the class.
	$fieldService->getFields();

Instantiate a TCA service dealing with table::

	$tableName = 'sys_file';
	$serviceType = 'table';

	/** @var $tableService \TYPO3\CMS\Media\Tca\TableService */
	$tableService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal method of the class.
	$tableService->getLabel();


Instantiate a TCA service dealing with a grid (introduce for Media)::

	$tableName = 'sys_file';
	$serviceType = 'table';

	/** @var $tableService \TYPO3\CMS\Media\Tca\GridService */
	$gridService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal method of the class.
	$gridService->getFields();

Form API
===========

This is low level API to render a form in a programmatic way. The API introduces two "elements", (1) form widgets (e.g. textfield, textarea, ...)
and (2) panels which acts as container for form widgets. Let illustrate with examples.

Render a text field::

	$fieldName = 'title';
	$value = 'foo';

	/** @var $fieldObject \TYPO3\CMS\Media\Form\TextField */
	$fieldObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Form\TextField');
	$fieldObject->setName($fieldName)
		->setLabel($label)
		->setValue($value)
		->addAttribute(array('class' => 'span6'))
		->render();

This will output the following HTML::

	@todo

Render a tab panel::

	/** @var $tabPanel \TYPO3\CMS\Media\Panel\TabPanel */
	$tabPanel = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Panel\TabPanel');

	$tabPanel->createPanel($panelTitle)
		->render();

This will output the following HTML::

	@todo

Render a panel with one text field::

	/** @var $fieldObject \TYPO3\CMS\Media\Form\TextField */
	$fieldObject = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Form\TextField');
	$fieldObject->setName($fieldName)
		->setLabel($label)
		->setValue($value)
		->setPrefix($this->getPrefix())
		->addAttribute(array('class' => 'span6'));

	/** @var $tabPanel \TYPO3\CMS\Media\Panel\TabPanel */
	$tabPanel = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\Panel\TabPanel');

	$tabPanel->createPanel($panelTitle)
		->addItem($fieldObject)
		->render();

This will output the following HTML::

	@todo


Form factory API
=================

The form factory API is useful for instantiating and returning Form object (cf Form API above). In that sense, it control the final output and make the bridge with TYPO3.

Limitation:

* no support yet for palette, radio button (should be easy) and inline editing,
* no language handling,
* no version handling.