# Epicur Metadata Plugin

> The Epicur Metadata plugin for [Open Monograph Press][omp] (OMP) has been developed at UB Heidelberg. It provides a filter to transform an OMP monograph into an XML record according to the [xepicur][xepicur] 1.0 transfer format defined by the [Deutsche Nationalbibliothek][dnb] (DNB).

## Requirements

* A separate plugin is required for assigning URNs to OMP publication objects. To conform with the DNB URN requirements, install and enable the [URN DNB plugin][urn_dnb] for OMP.

## Installation

	git clone https://github.com/ub-heidelberg/epc10 /path/to/your/omp/plugins/metadata
	php omp/tools/upgrade.php upgrade

## Bugs / Issues

You can report issues here: <https://github.com/ub-heidelberg/epc10/issues>

## License

This software is released under the the [GNU General Public License][gpl-licence].

See the [COPYING][gpl-licence] included with OMP for the terms of this license.

[omp]: https://github.com/pkp/omp
[xepicur]: http://www.persistent-identifier.de/?link=210
[urn_dnb]: https://github.com/ub-heidelberg/urn_dnb
[dnb]: http://www.dnb.de
[gpl-licence]: https://github.com/pkp/omp/blob/master/docs/COPYING
