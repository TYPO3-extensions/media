========================
Media for TYPO3 CMS
========================

Media Management (media) is a tool for organizing Media files and retrieve them by categories, mime-types etc.
and is a `replacement of the DAM`_ built on the top of FAL for TYPO3 CMS 6 branch. This document will describe the various API
introduced by Media for its needs along to its configuration.

Development happens: https://forge.typo3.org/projects/extension-media/
Issue tracker: https://forge.typo3.org/projects/extension-media/issues
Mailing list: http://lists.typo3.org/cgi-bin/mailman/listinfo/typo3-dev Make sure to mention the word "media" in the subject.

.. _replacement of the DAM: http://buzz.typo3.org/teams/dam/article/new-features-in-dam-13-and-the-future-of-dam/


Installation
=================

Download the source code either from the `Git repository`_ to get the latest branch or from the TER for the stables releases. Install the extension as normal in the Extension Manager.

.. _Git repository: https://git.typo3.org/TYPO3v4/Extensions/media.git

Configuration
=================

Configuration is mainly provided in the Extension Manager and is pretty much self-explanatory. Check possible options there.

Besides the basic settings, you can configure possible mount points per file type. A mount point can be considered as a sub folder within the storage where the files are going to be stored. This is useful if one wants the file to be stored elsewhere than at the root of the storage.


RTE integration
=================

The extension is shipping two buttons that can be added into the RTE for (1) linking a document and (2) inserting images from the Media module.
The button name references are ``linkmaker`` and ``imagemaker`` respectively which can be added by TypoScript in TSConfig with the following line::

	# key where to define the visible buttons in the RTE
	toolbarOrder = bar, linkmaker, bar, imagemaker, ...

	-> Refer to the documentation of extension HtmlArea for more details.

Image Optimizer
=================

When a image get uploaded, there is a post-processing step where the image get the chance to be "optimized".
By default there are two optimizations run against the image: **resize** and **rotate**. The `resize` processing enables 
to reduce the size of an image if a User uploads a too big image. The maximum size can be configured in the Extension Manager.
The `rotate` optimizer read the `exif`_ metadata and automatically rotate the image.

If needed, it is possible to add additional custom optimizers. Notice that the class must implement an interface ``\TYPO3\CMS\Media\FileUpload\ImageOptimizerInterface`` and can be added with following code::

	$uploadedFile = \TYPO3\CMS\Media\FileUpload\ImageOptimizer::getInstance()->add('TYPO3\CMS\Media\FileUpload\Optimizer\Resize');


.. _exif: http://en.wikipedia.org/wiki/Exchangeable_image_file_format

Domain Model and Repository
=============================

The extension is shipping a few repositories that you can take advantage in a third-party extension such a photo gallery. The fundamental one,
is the Asset Repository which is the "four-wheel" repository. It can query any kind of media types. Consider the snippet::

	$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
	$assetRepository = $objectManager->get('TYPO3\CMS\Media\Domain\Repository\AssetRepository');

	$assetRepository->findAll()
	$assetRepository->findByUid($uid)
	$assetRepository->findBy*($value)  e.g findByType
	$assetRepository->findOneBy*($value)  e.g findOneByType
	$assetRepository->countBy*($value)  e.g countBy

There is also an option that can be passed whether you want to be returned objects (the default) or arrays::

	# Will return an array of array instead of an array of object
	$assetRepository->setRawResult(TRUE)->findAll();

Besides the Asset repository, it comes a few repositories for "specialized" media type. As instance, for an image gallery you are likely to use the Image repository
which apply an implicit filter on Image. But there is more than that:

* Text repository for plain text files (txt, html, ...)
* Image repository
* Audio repository
* Video repository
* Application repository (pdf, odt, doc, ...)

We are following the recommendation of the Iana_ entity available here_ for the media types.

.. _Iana: http://en.wikipedia.org/wiki/Internet_Assigned_Numbers_Authority
.. _here: http://www.iana.org/assignments/media-types

Thumbnail API
======================

As a first place, a thumbnail can be generated from the Asset object, like::

	# Get a thumbnail of the file.
	{asset.thumbnail}

	# Get a thumbnail of the file wrapped within a link pointing to the original file.
	{asset.thumbnailWrapped}


If the default thumbnail is not "sufficient", a View Helper can be used enabling to configure the thumbnail to be generated::

	# The minimum
	<m:thumbnail object="{asset}"/>

	# Pass more settings to the thumbnail to be rendered.
	<m:thumbnail object="{asset}" configuration="{width: 800, height: 800}" attributes="{class: 'file-variant'}" wrap="true"/>

	# Pass some preset as for the dimension. Values can be:
	# - image_thumbnail => '100x100'  (where maximum width is 100 and maximum height is 100)
    # - image_mini => '120x120'
    # - image_small => '320x320'
    # - image_medium => '760x760'
    # - image_large => '1200x1200'
    # - image_original => '1920x1920'
	<m:thumbnail object="{asset}" preset="image_medium"/>

	{namespace m=TYPO3\CMS\Media\ViewHelpers}

File Upload API
=================

File upload is handled by `Fine Uploader`_ which is a Javascript plugin aiming to bring a user-friendly file-uploading experience over the web.
The plugin relies on HTML5 technology which enables Drag & Drop from the Desktop. File transfer is achieved by Ajax if supported. If not,
a fall back method with classical file upload is used by posting the file. (Though, the legacy approach still need to be tested more thoroughly).

On the server side, there is an API for file upload which handles transparently whether the file come from an XHR request or a Post request.

::

		# Notice code is simplified from the real implementation.
		# For more detail check EXT:media/Classes/Controller/AssetController.php @ uploadAction

		/** @var $uploadManager \TYPO3\CMS\Media\FileUpload\UploadManager */
		$uploadManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Media\FileUpload\UploadManager');
		try {
			/** @var $uploadedFileObject \TYPO3\CMS\Media\FileUpload\UploadedFileInterface */
			$uploadedFileObject = $uploadManager->handleUpload();
		} catch (\Exception $e) {
			$response = array('error' => $e->getMessage());
		}

		$targetFolderObject = \TYPO3\CMS\Media\ObjectFactory::getInstance()->getContainingFolder();
		$newFileObject = $targetFolderObject->addFile($uploadedFileObject->getFileWithAbsolutePath(), $uploadedFileObject->getName());

.. _Fine Uploader: http://fineuploader.com/


TCA Service API
=================

This API enables to fetch info related to TCA in a programmatic way. Since TCA covers a very large set of data, the service is divided in types.
There are are four parts being addressed: table, field, grid and form. The "grid" part extends the TCA and is introduced for the need of the BE module of media.

* table: deal with the "ctrl" part of the TCA. Typical info is what is the label of the table name, what is the default sorting, etc...
* field: deal with the "columns" part of the TCA. Typical info is what configuration, label, ... has a field name.
* grid: deal with the "grid" part of the TCA.
* form: deal with the "types" (and possible "palette") part of the TCA. Get what field compose a record type.

The API is meant to be generic and can be re-use for every record type within TYPO3. Find below some code example making use of the service factory.

Instantiate a TCA service related to **fields**::

	$tableName = 'sys_file';
	$serviceType = 'field';

	/** @var $fieldService \TYPO3\CMS\Media\Tca\FieldService */
	$fieldService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal methods of the class.
	$fieldService->getFields();

Instantiate a TCA service related to **table**::

	$tableName = 'sys_file';
	$serviceType = 'table';

	/** @var $tableService \TYPO3\CMS\Media\Tca\TableService */
	$tableService = \TYPO3\CMS\Media\Tca\ServiceFactory::getService($tableName, $serviceType);

	// Refer to internal methods of the class.
	$tableService->getLabel();

The same would apply for the other part: form and grid.

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
				'renderer' => 'TYPO3\CMS\Media\Renderer\Grid\Preview',
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

Columns
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

There a few columns that are considered as "system" which means they don't correspond to a field but must be display to control the     GUI. By convention, theses columns are prefixed
with a double underscore e.g "__":

* __number: display a row number
* __buttons: display "edit", "deleted", ... buttons to control the row

