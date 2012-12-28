========================
Media for TYPO3 CMS
========================

Media Management (media) is a tool for organizing Media files for storage and retrieval by categories, mimetypes etc.
and is, in this regard a pragmatic replacement to DAM build on the top of FAL. Read more about DAM `history and status`_.

.. _history and status: http://buzz.typo3.org/teams/dam/article/new-features-in-dam-13-and-the-future-of-dam/

Development happens https://forge.typo3.org/projects/extension-media/

Media introduces different API for its needs which are going to be roughly explained below.

Grid TCA
=================

A grid is a list view of records typical of a Backend module. TCA was extended to describe how a grid and its columns columns should be rendered. Example::

	// Grid configuration
	$TCA['sys_file']['grid'] = array(
		'columns' => array(
			'__number' => array(
				'sortable' => FALSE,
				'label' => 'LLL:EXT:media/Resources/Private/Language/locallang.xlf:number',
			),
			'name' => array(
				'sortable' => FALSE,
				'renderer' => 'TYPO3\CMS\Media\Renderer\Preview',
				'label' => 'LLL:EXT:media/Resources/Private/Language/locallang.xlf:preview',
				'wrap' => '<div class="center">|</div>',
			),
			'title' => array(
				'wrap' => '<span class="media-title">|</span>',
			),
			'tstamp' => array(
				'visible' => FALSE,
				'format' => 'date',
				'label' => 'LLL:EXT:media/Resources/Private/Language/locallang.xlf:tx_media.tstamp',
			),
			'keywords' => array(
			),
			'__buttons' => array(
				'sortable' => FALSE,
			),
		)
	);

columns
---------

What attribute can be composed within array cell "columns"?

* sortable - default TRUE - whether the column is sortable or not.
* visible - default TRUE - whether the column is visible by default or hidden. There is a column picker on the GUI side controlling column visibility.
* renderer - default NULL - a class name to pass implementing
* label - default NULL - an optional label overriding the default label of the field - i.e. the label from TCA['tableName']['columns']['fieldName']['label']
* wrap - default NULL - a possible wrapping of the content. Useful in case the content of the cell should be styled in a special manner.
* width - default NULL - a possible width of the column


System columns
-----------------

There a few columns that are considered as "system" which means they don't correspond to a field of the table but make sense for the GUI. By convention, theses columns are prefixed
with a double underscore e.g "__":

* __number: display a row number
* __buttons: display "edit", "deleted", ... buttons to control the row


TCA Service API
=================

This API enables to fetch info related to TCA in a programmatic way. Since TCA covers a very large set of data, the service is divided in types.
Currently, there are are four parts implemented: table, field, grid and form. The "grid" part extends the TCA for the need of media.

* table: deal with the "ctrl" part of the TCA. Typical info is what is the label of the table name, what is the default sorting, etc...
* field: deal with the "columns" part of the TCA. Typical info is what configuration, label, ... has a field name.
* grid: deal with the "grid" part of the TCA.
* form: deal with the "types" (and possible "palette") part of the TCA. Get what field compose a record type.

The API is meant to be generic for every table and a service can be instantiate by the mean of the service factory. Find below some code example.

Instantiate a TCA service dealing with fields::

	$tableName = 'sys_file';
	$serviceType = 'field';

	/** @var $fieldService \TYPO3\CMS\Media\Tca\FieldService */
	$fieldService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal methods of the class.
	$fieldService->getFields();

Instantiate a TCA service dealing with table::

	$tableName = 'sys_file';
	$serviceType = 'table';

	/** @var $tableService \TYPO3\CMS\Media\Tca\TableService */
	$tableService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal methods of the class.
	$tableService->getLabel();

The same would apply for the other part: form and grid.

Form API
===========

TCEforms was unfortunately too monolithic and not enough flexible to be re-use as such for a custom BE module. A slim API was developed enabling to render a form. `Twitter Bootstrap framework`_ is used for the styling giving the advantage to provide a lot of (responsive) widgets out of the box.

The low level API enables to render a form in a programmatic way and provides two interfaces. An interface for (1) form widgets such as textfield, textarea, ... The other interface is for (2) container such as panels for containing form widgets. Let illustrate with examples:

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

	/** @var $tabPanel \TYPO3\CMS\Media\FormContainer\TabPanel */
	$tabPanel = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\FormContainer\TabPanel');

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

	/** @var $tabPanel \TYPO3\CMS\Media\FormContainer\TabPanel */
	$tabPanel = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\FormContainer\TabPanel');

	$tabPanel->createPanel($panelTitle)
		->addItem($fieldObject)
		->render();

This will output the following HTML::

	@todo

.. _Twitter Bootstrap framework: http://twitter.github.com/bootstrap/

Form factory API
=================

The form factory API is useful for instantiating and returning Form object (cf Form API above). In that sense, it control the final output and make the bridge with TYPO3.

Limitation:

* no support yet for palette, radio button (should be easy) and inline editing,
* no language handling,
* no version handling.

Access key
=================

In a web browser, an `access key`_ allows a computer user immediately to jump to a specific part of a web page via the keyboard. Check your browser to acces

* "n" for creating a new media
* "escape" for closing the editing panel
* "s" for saving the form

.. _access key: http://en.wikipedia.org/wiki/Access_key


Todo
=================

@todo

* change icon to use TYPO3 sprite. Current icon set is the one from Twitter Bootstrap (http://twitter.github.com/bootstrap/base-css.html#icons).
* implement duplicate feature

code for file:ListRow.js
--------------------------
<f:link.action action="duplicate" arguments="{media : media.uid}"
class="btn btn-grid btn-duplicate disabled" additionalAttributes="{data-uid: '{media.uid}'}"><i class="icon-tags"></i></f:link.action>
