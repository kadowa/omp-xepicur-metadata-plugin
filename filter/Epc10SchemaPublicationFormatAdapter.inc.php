<?php

/**
 * @file plugins/metadata/dc11/filter/Epc10SchemaPublicationFormatAdapter.inc.php
 *
 * Copyright (c) 2015 Heidelberg University
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Epc10SchemaPublicationFormatAdapter
 * @ingroup plugins_metadata_epc10_filter
 * @see PublicationFormat
 *
 * @brief Adapter that injects/extracts XMetaDissPlus schema compliant meta-data
 * into/from a PublicationFormat object.
 */


import('lib.pkp.classes.metadata.MetadataDataObjectAdapter');

class Epc10SchemaPublicationFormatAdapter extends MetadataDataObjectAdapter {
	/**
	 * Constructor
	 * @param $filterGroup FilterGroup
	 */
	function Epc10SchemaPublicationFormatAdapter(&$filterGroup) {
		parent::MetadataDataObjectAdapter($filterGroup);
	}


	//
	// Implement template methods from Filter
	//
	/**
	 * @see Filter::getClassName()
	 */
	function getClassName() {
		return 'plugins.metadata.epc10.filter.Epc10SchemaPublicationFormatAdapter';
	}


	//
	// Implement template methods from MetadataDataObjectAdapter
	//
	/**
	 * @see MetadataDataObjectAdapter::injectMetadataIntoDataObject()
	 * @param $description MetadataDescription
	 * @param $publicationFormat PublicationFormat
	 * @param $authorClassName string the application specific author class name
	 */
	function &injectMetadataIntoDataObject(&$description, &$publicationFormat, $authorClassName) {
		// Not implemented
		assert(false);
	}

	/**
	 * @see MetadataDataObjectAdapter::extractMetadataFromDataObject()
	 * @param $publicationFormat PublicationFormat
	 * @return MetadataDescription
	 */
	function extractMetadataFromDataObject($publicationFormat) {
		assert(is_a($publicationFormat, 'PublicationFormat'));

		AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON);

		// Retrieve data that belongs to the publication format.
		$oaiDao = DAORegistry::getDAO('OAIDAO'); /* @var $oaiDao OAIDAO */
		$publishedMonographDao = DAORegistry::getDAO('PublishedMonographDAO');
		$chapterDao = DAORegistry::getDAO('ChapterDAO');
		$monograph = $publishedMonographDao->getById($publicationFormat->getMonographId());
		$chapters = $chapterDao->getChapters($monograph->getId());
		$series = $oaiDao->getSeries($monograph->getSeriesId()); /* @var $series Series */
		$press = $oaiDao->getPress($monograph->getPressId());
		
		$description = $this->instantiateMetadataDescription();

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
