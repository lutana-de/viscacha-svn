<?php
/**
 * POP3 Class - PHPMailer 5.1 - PHP email class
 *
 * Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.
 * Copyright (c) 2001-2003, Brent R. Matzelle
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * Software: PHPMailer - PHP email class<br>
 * Version: 5.1<br>
 * Contact: via sourceforge.net support pages (also www.codeworxtech.com)<br>
 * Info: http://phpmailer.sourceforge.net<br>
 * Support: http://sourceforge.net/projects/phpmailer/<br>
 * Admin: Andy Prevost (project admininistrator)<br>
 * Author: Andy Prevost (codeworxtech) codeworxtech@users.sourceforge.net<br>
 * Author: Marcus Bointon (coolbru) coolbru@users.sourceforge.net<br>
 * Founder: Brent R. Matzelle (original founder)
 *
 * @package		Core
 * @subpackage	Net
 * @author		Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author		Marcus Bointon (coolbru) <coolbru@users.sourceforge.net>
 * @author		Brent R. Matzelle (original founder)
 * @copyright	Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.
 * @copyright	Copyright (c) 2001-2003, Brent R. Matzelle
 * @version		5.1
 * @link		http://phpmailer.sourceforge.net
 * @license		http://www.gnu.org/licenses/lgpl-2.1.txt GNU Lesser General Public License
 */

/**
 * PHPMailer - POP Before SMTP Authentication Class
 *
 * Specifically for PHPMailer to allow POP before SMTP authentication.
 * Does not yet work with APOP - if you have an APOP account, contact Richard Davey
 * and we can test changes to this script.
 *
 * This class is based on the structure of the SMTP class originally authored by Chris Ryan
 *
 * This class is rfc 1939 compliant and implements all the commands
 * required for POP3 connection, authentication and disconnection.
 *
 * @package		Core
 * @subpackage	Net
 * @author		Richard Davey <rich@corephp.co.uk>
 * @author		Andy Prevost
 * @author		Marcus Bointon
 * @copyright	2004 - 2009 Andy Prevost
 * @since		0.8
 * @version		$Id: class.pop3.php 444 2009-05-05 11:22:26Z coolbru $
 * @version		5.0.0
 */
class POP3 {
	/**
	 * Default POP3 port
	 * @var int
	 */
	public $POP3_PORT = 110;

	/**
	 * Default Timeout
	 * @var int
	 */
	public $POP3_TIMEOUT = 30;

	/**
	 * POP3 Carriage Return + Line Feed
	 * @var string
	 */
	public $CRLF = "\r\n";

	/**
	 * Displaying Debug warnings? (0 = now, 1+ = yes)
	 * @var int
	 */
	public $do_debug = 2;

	/**
	 * POP3 Mail Server
	 * @var string
	 */
	public $host;

	/**
	 * POP3 Port
	 * @var int
	 */
	public $port;

	/**
	 * POP3 Timeout Value
	 * @var int
	 */
	public $tval;

	/**
	 * POP3 Username
	 * @var string
	 */
	public $username;

	/**
	 * POP3 Password
	 * @var string
	 */
	public $password;

	private $pop_conn;
	private $connected;
	private $error; //  Error log array

	/**
	 * Constructor, sets the initial values
	 * @access public
	 * @return POP3
	 */
	public function __construct() {
		$this->pop_conn = 0;
		$this->connected = false;
		$this->error = null;
	}

	/**
	 * Combination of public events - connect, login, disconnect
	 * @access public
	 * @param string $host
	 * @param integer $port
	 * @param integer $tval
	 * @param string $username
	 * @param string $password
	 */
	public function Authorise($host, $port = false, $tval = false, $username, $password, $debug_level = 0) {
		$this->host = $host;

		//  If no port value is passed, retrieve it
		if ($port == false) {
			$this->port = $this->POP3_PORT;
		}
		else {
			$this->port = $port;
		}

		//  If no port value is passed, retrieve it
		if ($tval == false) {
			$this->tval = $this->POP3_TIMEOUT;
		}
		else {
			$this->tval = $tval;
		}

		$this->do_debug = $debug_level;
		$this->username = $username;
		$this->password = $password;

		//  Refresh the error log
		$this->error = null;

		//  Connect
		$result = $this->Connect($this->host, $this->port, $this->tval);

		if ($result) {
			$login_result = $this->Login($this->username, $this->password);

			if ($login_result) {
				$this->Disconnect();

				return true;
			}

		}

		//  We need to disconnect regardless if the login succeeded
		$this->Disconnect();

		return false;
	}

	/**
	 * Connect to the POP3 server
	 * @access public
	 * @param string $host
	 * @param integer $port
	 * @param integer $tval
	 * @return boolean
	 */
	public function Connect($host, $port = false, $tval = 30) {
		//  Are we already connected?
		if ($this->connected) {
			return true;
		}

		/*
		 On Windows this will raise a PHP Warning error if the hostname doesn't exist.
		 Rather than supress it with @fsockopen, let's capture it cleanly instead
		 */

		set_error_handler(array(&$this, 'catchWarning'));

		//  Connect to the POP3 server
		$this->pop_conn = fsockopen(
			Networking::encodeIDNA($host), //  POP3 Host
			$port, //  Port #
			$errno, //  Error Number
			$errstr, //  Error Message
			$tval //  Timeout (seconds)
		);

		//  Restore the error handler
		restore_error_handler();

		//  Does the Error Log now contain anything?
		if ($this->error && $this->do_debug >= 1) {
			$this->displayErrors();
		}

		//  Did we connect?
		if ($this->pop_conn == false) {
			//  It would appear not...
			$this->error = array(
				'error' => "Failed to connect to server $host on port $port",
				'errno' => $errno,
				'errstr' => $errstr
			);

			if ($this->do_debug >= 1) {
				$this->displayErrors();
			}

			return false;
		}

		//  Increase the stream time-out
		stream_set_timeout($this->pop_conn, $tval, 0);
		//  Does not work on Windows
		if (System::getOS() != System::WINDOWS) {
			socket_set_timeout($this->pop_conn, $tval, 0);
		}

		//  Get the POP3 server response
		$pop3_response = $this->getResponse();

		//  Check for the +OK
		if ($this->checkResponse($pop3_response)) {
			//  The connection is established and the POP3 server is talking
			$this->connected = true;
			return true;
		}

	}

	/**
	 * Login to the POP3 server (does not support APOP yet)
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function Login($username = '', $password = '') {
		if ($this->connected == false) {
			$this->error = 'Not connected to POP3 server';

			if ($this->do_debug >= 1) {
				$this->displayErrors();
			}
		}

		if (empty($username)) {
			$username = $this->username;
		}

		if (empty($password)) {
			$password = $this->password;
		}

		$pop_username = "USER $username".$this->CRLF;
		$pop_password = "PASS $password".$this->CRLF;

		//  Send the Username
		$this->sendString($pop_username);
		$pop3_response = $this->getResponse();

		if ($this->checkResponse($pop3_response)) {
			//  Send the Password
			$this->sendString($pop_password);
			$pop3_response = $this->getResponse();

			if ($this->checkResponse($pop3_response)) {
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	/**
	 * Disconnect from the POP3 server
	 * @access public
	 */
	public function Disconnect() {
		$this->sendString('QUIT');

		fclose($this->pop_conn);
	}

	/**
	 * Get the socket response back.
	 * $size is the maximum number of bytes to retrieve
	 * @access private
	 * @param integer $size
	 * @return string
	 */
	private function getResponse($size = 128) {
		$pop3_response = fgets($this->pop_conn, $size);

		return $pop3_response;
	}

	/**
	 * Send a string down the open socket connection to the POP3 server
	 * @access private
	 * @param string $string
	 * @return integer
	 */
	private function sendString($string) {
		$bytes_sent = fwrite($this->pop_conn, $string, strlen($string));

		return $bytes_sent;
	}

	/**
	 * Checks the POP3 server response for +OK or -ERR
	 * @access private
	 * @param string $string
	 * @return boolean
	 */
	private function checkResponse($string) {
		if (substr($string, 0, 3) !== '+OK') {
			$this->error = array(
				'error' => "Server reported an error: $string",
				'errno' => 0,
				'errstr' => ''
			);

			if ($this->do_debug >= 1) {
				$this->displayErrors();
			}

			return false;
		}
		else {
			return true;
		}

	}

	/**
	 * If debug is enabled, display the error message array
	 * @access private
	 */
	private function displayErrors() {
		echo '<pre>';

		foreach ($this->error as $single_error) {
			print_r($single_error);
		}

		echo '</pre>';
	}

	/**
	 * Takes over from PHP for the socket warning handler
	 * @access private
	 * @param integer $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param integer $errline
	 */
	private function catchWarning($errno, $errstr, $errfile, $errline) {
		$this->error[] = array(
			'error' => "Connecting to the POP3 server raised a PHP warning: ",
			'errno' => $errno,
			'errstr' => $errstr
		);
	}

}
?>