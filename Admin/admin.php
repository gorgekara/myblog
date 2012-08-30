<?php

session_start();

require_once "Cs/Session.php";
require_once "Cs/HTML.php";
require_once "Cs/Database.php";
require_once "Cs/Post.php";

// OBJECT FACTORY

$ht = new Cs_HTML;	// Object for working with HTML tags
$con = new Cs_Database;	// Create new object for connecting to database
$scheck = new Cs_Session;	// Object for working with session variables
$post = new Cs_Post;	// What is required to work with posts

// -- END OF OBJECT FACTORY

$scheck->sesCheck('username');	// Check if session variable 'username' is set
$ht->htmlStart("Admin page - Successful log in!");	// Start HTML tags and set <title>
$con->conBase();	// Connect to database
if(isset($_GET['s'])) {
	$post->comStat($_GET['s'],$_GET['cid']);	
}


// Check if post is set for removal
if(isset($_GET['rid'])) {
	$post->removePost($_GET['rid']);
	echo "The post was removed!";
}

// Check if post is set for modification
if(isset($_GET['mid'])) {
	header("Location: post.php?mid=" .$_GET['mid']. "");
}

$ht->htmlAdminMenu();

$post->getPosts(0,5);	// Get posts for notification front page (default: 5)
$post->getComments(0,5);	//	Get comments for notification front page (default: 5)

$ht->htmlEnd("Blogd 2012 &copy;");

?>