<?php
function array_stripslashes($array) {
	if(is_array($array)) {
		return array_map('stripslashes', $array); 
	}
	else {
		return stripslashes($array);
	}
}
function rmdirr($dirname) {
	global $filesystem;
	if (!file_exists($dirname)) {
		return false;
	}
	if (is_file($dirname)) {
		return $filesystem->unlink($dirname);
	}
	$dir = dir($dirname);
	while (false !== $entry = $dir->read()) {
		if ($entry == '.' || $entry == '..') {
			continue;
		}
		if (is_dir("$dirname/$entry")) {
			rmdirr("$dirname/$entry");
		} 
		else {
			$filesystem->unlink("$dirname/$entry");
		}
	}  
	$dir->close(); 
	return $filesystem->rmdir($dirname);
}

// Variables
@set_magic_quotes_runtime(0);
@ini_set('magic_quotes_gpc',0);
// Start - Thanks to phpBB for this code
if (isset($_POST['GLOBALS']) || isset($_FILES['GLOBALS']) || isset($_GET['GLOBALS']) || isset($_COOKIE['GLOBALS'])) {
	die("Hacking attempt (Globals)");
}
if (isset($_SESSION) && !is_array($_SESSION)) {
	die("Hacking attempt (Session Variable)");
}
if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on') {
	unset($not_used, $input);
	$not_unset = array('_GET', '_POST', '_COOKIE', '_SERVER', '_SESSION', '_ENV', '_FILES');

	$input = array_merge($_GET, $_POST, $_COOKIE, $_ENV, $_FILES);
	if (isset($_SERVER) && is_array($_SERVER)) {
		$input = array_merge($input, $_SERVER);
	}
	if (isset($_SESSION) && is_array($_SESSION)) {
		$input = array_merge($input, $_SESSION);
	}

	unset($input['input'], $input['not_unset']);

	while (list($var,) = @each($input)) {
		if (!in_array($var, $not_unset)) {
			unset($$var);
			// Testen 
			if (isset($GLOBALS[$var])) {
				unset($GLOBALS[$var]);
			}
		}
	}

	unset($input);
}
// End

if (get_magic_quotes_gpc() == 1) {
	while(list($key,$value)=each($_GET)) $_GET[$key]=array_stripslashes($value);
	while(list($key,$value)=each($_POST)) $_POST[$key]=array_stripslashes($value);
	while(list($key,$value)=each($_REQUEST)) $_REQUEST[$key]=array_stripslashes($value);
}

foreach ($_REQUEST as $key => $value) {
	if (is_array($value)) {
		$value = array_map('addslashes', $value);
	}
	else {
		$value = addslashes($value);
	}
	$_REQUEST[$key] = $value;
}
?>
