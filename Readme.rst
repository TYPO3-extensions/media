Form usage
===========

::

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


Old Markup
============

::

	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
			<li><a href="#tab2" data-toggle="tab">Category</a></li>
		</ul>
		<div class="tab-content" >

			<div class="tab-pane active" id="tab1">
				<div class="control-group">
					<label class="control-label" for="media-title">
						<f:translate key="tx_media.title"/>
						<span class="required">(required)</span>
					</label>

					<div class="controls">
						<f:form.textfield property="title" id="media-title" class="span6"/>
					</div>
				</div>


				<div class="control-group">
					<label class="control-label" for="media-description">
						<f:translate key="tx_media.description"/>
					</label>

					<div class="controls">
						<f:form.textarea property="description" cols="40" rows="5" id="media-description" class="span6"/>
					</div>
				</div>

				<f:form.hidden property="uid"/>

			</div>
			<div class="tab-pane" id="tab2">
				<p>Howdy, I'm in Section 2.</p>
			</div>
		</div>
	</div>

