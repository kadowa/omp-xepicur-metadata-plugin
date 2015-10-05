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
	function Epc10Schema($appSpecificAssocType = ASSOC_TYPE_PUBLICATION_FORMAT, $classname = 'plugins.metadata.epc10.schema.Epc10Schema') {
		// Configure the meta-data schema.
		parent::MetadataSchema(
				'epc-1.0',
				'epc',
				$classname,
				$appSpecificAssocType
		);
	}
}
?>
