<?php

session_start();

require_once "Cs/Database.php";
require_once "Cs/Login.php";
require_once "Cs/Forms.php";
require_once "Cs/HTML.php";

// OBJECT FACTORY

$ht = new Cs_HTML;	// Object for working with HTML tags
$con = new Cs_Database;	// Create new object for connecting to database
$formtag = new Cs_Forms;	// Create new object for working with forms
$usrlog = new Cs_Login;	// Create new object for handling logins

// -- END OF OBJECT FACTORY

$ht->htmlStart("Log in to Blogd");	// Start HTML tags and set <title>
$con->conBase();	// Connect to database

if(!isset($_POST['username'])) {
	$formtag->addFormStart('index.php','post','loginform');
		$formtag->addInput('text','username');
		$formtag->addInput('password','password');
		$formtag->addInput('submit','Log In');
	$formtag->addFormEnd();
}

else {
	$clean_username = mysql_real_escape_string($_POST['username']);	// Clean username from dangerous characters for database
	$password = $_POST['password'];
	$usrlog->logUsr($clean_username,$password,'admin.php');	// Check username and password and move to admin.php
}

$ht->htmlEnd("Blogd 2012 &copy;")

?>