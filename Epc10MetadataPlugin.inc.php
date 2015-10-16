<?php

/**
 * @file plugins/metadata/epc10/Epc10MetadataPlugin.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Epc10MetadataPlugin
 * @ingroup plugins_metadata_epc10
 *
 * @brief epicur 1.0 metadata plugin
 */

import('lib.pkp.classes.plugins.MetadataPlugin');

class Epc10MetadataPlugin extends MetadataPlugin {
	/**
	 * Constructor
	 */
	function Epc10MetadataPlugin() {
		parent::MetadataPlugin();
	}

	//
	// Override protected template methods from Plugin
	//
	/**
	* @copydoc Plugin::getName()
	*/
	function getName() {
		return 'Epc10MetadataPlugin';
	}

	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	function getDisplayName() {
		return __('plugins.metadata.epc10.displayName');
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	function getDescription() {
		return __('plugins.metadata.epc10.description');
	}
	
	/**
	 * @see Plugin::getTemplatePath($inCore)
	 */
	function getTemplatePath($inCore = false) {
		return parent::getTemplatePath($inCore) . 'templates/';
	}
	
	/**
	 * @see PKPPlugin::getManagementVerbs()
	 */
	function getManagementVerbs() {
		return array(array('settings', __('manager.plugins.settings')));
	}
}

?>
