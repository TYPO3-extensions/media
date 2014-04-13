/*
 * Media link creator
 *
 * Load the proper panel whenever an image is selected in the editor.
 * Info: window.opener is the variable for exchanging data with parent window
 */
(function ($) {
	$(function () {

		/**
		 * Bind handler against RTE image editor buttons in the grid.
		 */
		$(document).on('click', '.dataTable tbody .btn-filePicker', function (e) {
			var identifier = $(this).data('uid');
			var closeWindow = false;
			importElement(identifier, closeWindow);
			e.preventDefault();
		});

		/**
		 * Bind handler against image preview buttons in the grid.
		 */
		$(document).on('click', '.dataTable tbody .preview a', function (e) {
			var identifier = $(this).data('uid');
			var closeWindow = true;
			importElement(identifier, closeWindow);
			e.preventDefault();
		});

		/**
		 * Bind handler against image preview buttons in the grid.
		 */
		$(document).on('click', '.mass-file-picker', function (e) {

			e.preventDefault();
			var fieldName, objectId, table, type, uidArray, selectedRows, fieldValue, identifier, properties;

			table = 'sys_file';
			type = 'file';
			objectId = getObjectId();
			fieldName = getFieldName();

			// Get selected rows
			selectedRows = [];
			$('#content-list')
				.find('.checkbox-row')
				.filter(':checked')
				.each(function (index) {
					identifier = $(this).data('uid');
					if (fieldName || (objectId && parent.window.opener.inline.checkUniqueElement(objectId, table, identifier, type))) {
						selectedRows.push(identifier);
					}
				});

			// Check how many rows were selected.
			if(fieldName && !objectId) {
				properties = getRowProperties(selectedRows);
				$.each(properties, function(index, row) {
					parent.window.opener.setFormValueFromBrowseWin(fieldName, row['value'], row['label']);
				});
			} else {
				if (selectedRows.length === 1) {
					parent.window.opener.inline.importElement(objectId, table, selectedRows[0], type);
				} else if (selectedRows.length > 1) {
					parent.window.opener.inline.importElementMultiple(objectId, table, selectedRows, type);
				}
			}
			window.close();
		});

		/**
		 * Check whether an object Id can be found in the parameterss
		 *
		 * @returns {void}
		 */
		function importElement(identifier, close) {

			var fieldName, objectId, table, type;

			table = 'sys_file';
			type = 'file';
			objectId = getObjectId();
			fieldName = getFieldName();
			if (objectId && parent.window.opener.inline.checkUniqueElement(objectId, table, identifier, type)) {
				parent.window.opener.inline.importElement(objectId, table, identifier, type);
			} else if(!objectId && fieldName) {
				properties = getRowProperties([identifier]);
				parent.window.opener.setFormValueFromBrowseWin(fieldName, properties[0]['value'], properties[0]['label']);
			}
			if (close) {
				window.close();
			}
		}

		/**
		 * Check whether an object Id can be found in the parameters
		 *
		 * @returns {string}
		 */
		function getObjectId() {
			var result;

			result = '';

			var uri = new Uri(window.location.href);
			if (uri.getQueryParamValue('params')) {

				var params = uri.getQueryParamValue('params');

				paramsParts = params.split('|');
				$.each(paramsParts, function (index, paramsPart) {

					var regularExpression = new RegExp(/^data-/g);

					if (regularExpression.test(paramsPart)) {
						result = paramsPart;
					}
				});
			}
			return result;
		}

		/**
		 * Check whether an fieldname can be found in the parameters
		 *
		 * @returns {string}
		 */
		function getFieldName() {
			var result;

			result = '';

			var uri = new Uri(window.location.href);
			if (uri.getQueryParamValue('params')) {
				var params = uri.getQueryParamValue('params');
				paramsParts = params.split('|');
				$.each(paramsParts, function (index, paramsPart) {
					var regularExpression = new RegExp(/^data\[/g);

					if (regularExpression.test(paramsPart)) {
						result = paramsPart;
					}
				});
			}
			return result;
		}

		function getRowProperties(selectedRows) {
			var properties = [];
			$.each(selectedRows, function (index, identifier) {
				var value, label, row;
				value = $("#content-list [data-url][data-uid='"+identifier+"']").first().data('url');
				var row = [];
				row['value'] = value;
				row['label'] = value.replace(/\\/g,'/').replace( /.*\//, '' );
				properties.push(row);
			});
			return properties;
		}

	});
})(jQuery);


/**
 * Extend array capability
 */
if (!Array.prototype.each) {
	Array.prototype.each = function (fn, scope) {
		'use strict';
		var i, len;
		for (i = 0, len = this.length; i < len; ++i) {
			if (i in this) {
				fn.call(scope, this[i], i, this);
			}
		}
	};
}
