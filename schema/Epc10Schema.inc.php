<?php

/**
 * @file plugins/metadata/epc10/schema/Epc10Schema.inc.php
 *
 * Copyright (c) 2015 Heidelberg University
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Epc10Schema
 * @ingroup plugins_metadata_epc10_schema
 *
 * @brief OMP-specific implementation of the Epc10Schema.
 */

import('lib.pkp.classes.metadata.MetadataSchema');

class Epc10Schema extends MetadataSchema {
	/**
	 * Constructor
	 * @param $appSpecificAssocType integer
	 */
	function Epc10Schema($appSpecificAssocType = ASSOC_TYPE_MONOGRAPH, $classname = 'plugins.metadata.epc10.schema.Epc10Schema') {
		// Configure the meta-data schema.
		parent::MetadataSchema(
				'epc-1.0',
				'epc',
				$classname,
				$appSpecificAssocType
		);
		
		$this->addProperty('administrative_data/delivery/update_status[@type="urn_new"]', METADATA_PROPERTY_TYPE_STRING, false, METADATA_PROPERTY_CARDINALITY_MANY);
		$this->addProperty('record/identifier', METADATA_PROPERTY_TYPE_STRING, false, METADATA_PROPERTY_CARDINALITY_MANY);
		$this->addProperty('record/resource/identifier[@scheme="url", @type="frontpage", @role="primary"]', METADATA_PROPERTY_TYPE_STRING, false, METADATA_PROPERTY_CARDINALITY_MANY);
		$this->addProperty('record/resource/format[@scheme="imt"]', METADATA_PROPERTY_TYPE_STRING, false, METADATA_PROPERTY_CARDINALITY_MANY);
	}
}
?>