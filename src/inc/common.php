<?php
	session_start();
	header('Cache-control: private'); // IE 6 FIX

	if( isSet( $_GET['lang']))
	{
		$lang = $_GET['lang'];
		$_SESSION['lang'] = $lang;
		setcookie( "lang", $lang, time() + ( 3600 * 24 * 30 ));
	}
	else if( isSet( $_SESSION['lang']))
	{
		$lang = $_SESSION['lang'];
	}
	else if( isSet( $_COOKIE['lang']))
	{
		$lang = $_COOKIE['lang'];
		$_SESSION['lang'] = $lang;
	}
	else
	{
		$lang = 'en';
		$_SESSION['lang'] = $lang;
	}
	
	switch( $lang ) 
	{
		case 'en':
			$lang_file = 'en.php';
		break;
		case 'de':
			$lang_file = 'de.php';
		break;
		case 'it':
			$lang_file = 'it.php';
		break;
		default:
			$lang_file = 'en.php';

	}
?>