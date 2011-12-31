<?php
Core::loadInterface('Cms.DataFields.Positions.CustomDataPosition');

/**
 * Position for custom profile fields.
 *
 * @package		Cms
 * @author		Matthias Mohr
 * @since 		1.0
 */

class PersonalProfileFields implements CustomDataPosition {

	public function getDbTable() {
		return 'user';
	}
	public function getName() {
		return 'Pers�nliche Daten';
	}
	public function getClassPath() {
		return 'Cms.DataFields.Positions.PersonalProfileFields';
	}

}
?>