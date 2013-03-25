"use strict";

/** @namespace Media */

/**
 * Object for handling Data Table
 *
 * @type {Object}
 */
Media.Table = {

	/**
	 * @var {object}
	 */
	settings: null,


	/**
	 * Return the search term.
	 *
	 * @param {string} key
	 * @return mixed
	 */
	getSetting: function (key) {
		var result;
		result = '';
		$.each(this.getSettings(), function () {
			if (typeof(this) == 'object' && this['name'] == key) {
				result = this['value'];
				return; // stop loop
			}
		});
		return result;
	},

	/**
	 * @return object
	 */
	getSettings: function () {
		if (this.settings == null) {
			this.settings = JSON.parse(Media.Session.get('aoData'));
		}
		return this.settings;
	}
};

