<?php

session_start();

require_once "Cs/Login.php";

// OBJECT FACTORY

$usrlog = new Cs_Login;	// Create new object for handling logins

// -- END OF OBJECT FACTORY

$usrlog->logOut('username','index.php');	// Log out if session variable 'username' is started (if session is started) - redirect to 'index.php'

?>