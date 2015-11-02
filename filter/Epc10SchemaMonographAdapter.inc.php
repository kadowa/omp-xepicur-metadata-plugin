<?php

/**
 * @file plugins/metadata/epc10/filter/Epc10SchemaMonographAdapter.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2000-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Epc10SchemaMonographAdapter
 * @ingroup plugins_metadata_epc10_filter
 * @see Monograph
 *
 * @brief Adapter that injects/extracts Epicur schema compliant meta-data
 * into/from a monograph object.
 */


import('lib.pkp.classes.metadata.MetadataDataObjectAdapter');

class Epc10SchemaMonographAdapter extends MetadataDataObjectAdapter {
	/**
	 * Constructor
	 * @param $filterGroup FilterGroup
	 */
	function Epc10SchemaMonographAdapter(&$filterGroup) {
		parent::MetadataDataObjectAdapter($filterGroup);
	}


	//
	// Implement template methods from Filter
	//
	/**
	 * @see Filter::getClassName()
	 */
	function getClassName() {
		return 'plugins.metadata.epc10.filter.Epc10SchemaMonographAdapter';
	}


	//
	// Implement template methods from MetadataDataObjectAdapter
	//
	/**
	 * @see MetadataDataObjectAdapter::injectMetadataIntoDataObject()
	 * @param $description MetadataDescription
	 * @param $monograph Monograph
	 * @param $authorClassName string the application specific author class name
	 */
	function &injectMetadataIntoDataObject(&$description, &$monograph, $authorClassName) {
		// Not implemented
		assert(false);
	}

	/**
	 * @see MetadataDataObjectAdapter::extractMetadataFromDataObject()
	 * @param $monograph Monograph
	 * @return MetadataDescription
	 */
	function extractMetadataFromDataObject($monograph) {
		assert(is_a($monograph, 'Monograph'));

		AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON);

		// Retrieve data that belongs to the publication format.
		$oaiDao = DAORegistry::getDAO('OAIDAO'); /* @var $oaiDao OAIDAO */
		$publishedMonographDao = DAORegistry::getDAO('PublishedMonographDAO');
		$chapterDao = DAORegistry::getDAO('ChapterDAO');
		
		$monograph = $publishedMonographDao->getById($monograph->getId());
		$press = $oaiDao->getPress($monograph->getPressId());
		
		$description = $this->instantiateMetadataDescription();
		
		// Update status
		// Is communicated via an attribute, so property value is empty
		$description->addStatement('administrative_data/delivery/update_status[@type="urn_new"]', "");
		
		$urn = "";
		$scheme = "";
		$pubIdPlugins = PluginRegistry::loadCategory('pubIds');
		if ( isset($pubIdPlugins) && array_key_exists('URNDNBPubIdPlugin', $pubIdPlugins) && $pubIdPlugins['URNDNBPubIdPlugin']->getEnabled() == true) {
			$urn = $pubIdPlugins['URNDNBPubIdPlugin']->getPubId($monograph);
			$namespaces = explode(':', $urn);
			$numberOfNamespaces = min(sizeof($namespaces), 3);
			$scheme = implode(":", array_slice($namespaces, 0, $numberOfNamespaces));
		}
		
		// URN
		$description->addStatement('record/identifier', $urn . ' [@scheme="' . $scheme . '"]');
		
		// URL
		$url = Request::url($press->getPath(), 'catalog', 'book', array($monograph->getId()));
		$description->addStatement('record/resource/identifier[@scheme="url", @type="frontpage", @role="primary"]', $url);
		
		// URL Mime type
		$description->addStatement('record/resource/format[@scheme="imt"]', "text/html");

 		return $description;
	}

	/**
	 * @see MetadataDataObjectAdapter::getDataObjectMetadataFieldNames()
	 * @param $translated boolean
	 */
	function getDataObjectMetadataFieldNames($translated = true) {
		return array();
	}


	//
	// Private helper methods
	//
	/**
	 * Add an array of localized values to the given description.
	 * @param $description MetadataDescription
	 * @param $propertyName string
	 * @param $localizedValues array
	 */
	function _addLocalizedElements(&$description, $propertyName, $localizedValues) {
		foreach(stripAssocArray((array) $localizedValues) as $locale => $values) {
			if (is_scalar($values)) $values = array($values);
			foreach($values as $value) {
					if ($value) {
						$description->addStatement($propertyName, $value, $locale);
					}
				unset($value);
			}
		}
	}
	
	function _checkForContentAndAddElement(&$description, $propertyName, $value) {
		if ($value) {
			$description->addStatement($propertyName, $value);
		}
	}
}


if(false === function_exists('lcfirst'))
{
	/**
	 * Make a string's first character lowercase
	 *
	 * @param string $str
	 * @return string the resulting string.
	 */
	function lcfirst( $str ) {
		$str[0] = strtolower($str[0]);
		return (string)$str;
	}
}

?>
