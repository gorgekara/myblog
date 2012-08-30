<?php

session_start();

require_once "Cs/Session.php";
require_once "Cs/HTML.php";
require_once "Cs/Database.php";
require_once "Cs/Post.php";
require_once "Cs/Forms.php";
require_once "Cs/Error.php";

// OBJECT FACTORY

$ht = new Cs_HTML;	// Object for working with HTML tags
$con = new Cs_Database;	// Create new object for connecting to database
$scheck = new Cs_Session;	// Object for working with session variables
$post = new Cs_Post;	// What is required to work with posts
$error = new Cs_Error;

// -- END OF OBJECT FACTORY

$scheck->sesCheck('username');	// Check if session variable 'username' is set
$ht->htmlStart("Admin page - Successful log in!");	// Start HTML tags and set <title>
$con->conBase();	// Connect to database

$ht->htmlAdminMenu();

// Check of post is beeing posted
if(isset($_POST['post_title'])) {
	$post->publishPost();
	echo "Your post <b>" .$_POST['post_title']. "</b> has been published!";
}

// Check if post is set for removal
if(isset($_GET['rid'])) {
	$post->removePost($_GET['rid']);
	echo "The post was removed!";
}

// Check if post is set for modification
(isset($_GET['mid'])) ?	$post->modifyPost($_GET['mid']) : "";

// Check post mod (create, modify)
(isset($_GET['s'])) ? $post->postMod($_GET['s']) : "";	

$ht->htmlEnd("Blogd 2012 &copy;");

?>