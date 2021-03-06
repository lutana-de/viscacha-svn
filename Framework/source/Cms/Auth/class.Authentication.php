<?php
Core::loadClass('Core.Security.Hash');
Core::loadClass('Cms.Auth.User');

/**
 * Authentication (login / logout)
 *
 * @package		Cms
 * @subpackage 	Auth
 * @author		Matthias Mohr
 * @since 		1.0
 */
class Authentication {

	protected function setCookie($email = '', $pw = '') {
		if (empty($email) || empty($pw)) {
			Response::getObject()->sendCookie('udata', "", 0, true);
		}
		else {
			// Cookie-Laufzeit: 365 Tage
			Response::getObject()->sendCookie('udata', "{$email}|{$pw}", 60*60*24*365, true);
		}
	}

	private function loginAsGuest() {
		return new GuestUser();
	}

	public function loginWithCookies() {
		// Try to login with user data from cookie
		$udata = Request::getObject()->getCookie('udata');
		if ($udata != null && strpos($udata, '|') !== false) {
			list($email, $pw) = explode('|', $udata, 2);
			return $this->login($email, $pw, true);
		}
		return $this->loginAsGuest();
	}

	public function loginWithId($uid) {
		if ($uid > 0) {
			$db = Database::getObject();
			$db->query(
				"SELECT * FROM <p>user WHERE id = <uid:int> AND active = '1'",
				compact("uid")
			);
			if ($db->numRows() == 1) {
				$my = $db->fetchAssoc();
				$this->setCookie($my['email'], $my['pw']);
				return new User($my);
			}
		}
		return $this->loginAsGuest();
	}

	public function login($email, $pw, $pwIsHashed = false) {
		if (!$pwIsHashed) {
			$pw = Hash::generate($pw);
		}
		$db = Database::getObject();
		$db->query(
			"SELECT * FROM <p>user WHERE email = <email> AND pw = <pw> AND active = '1'",
			compact("email","pw")
		);
		if ($db->numRows() == 1) {
			$my = $db->fetchAssoc();
			$this->setCookie($email, $pw);
			return new User($my);
		}
		else {
			return $this->loginAsGuest();
		}
	}

	public function logout() {
		$this->setCookie();
		return $this->loginAsGuest();
	}

	public static function getRightName($field) {
		switch ($field) {
			case 'admin':
				return 'Administrator';
			case 'editor':
				return 'Redakteur';
			case 'registered':
				return 'Mitglied';
			default:
				return '';
		}
	}

}
?>