<?php
/**
 * Position for custom profile fields.
 *
 * @package		Airlines
 * @subpackage	DataFields
 * @author		Matthias Mohr
 * @since 		1.0
 */

class AirlinesFlightPosition extends CustomDataPosition {

	public function getDbTable() {
		return 'evaluations';
	}
	public function getPrimaryKey() {
		return 'id';
	}
	public function getName() {
		return 'Bewertungen';
	}
	public function getClassPath() {
		return 'Airlines.DataFields.Positions.AirlinesFlightPosition';
	}

}
?>