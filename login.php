<?php

session_start();

require_once "Cs/Post.php";
require_once "Cs/HTML.php";
require_once "Cs/Login.php";
require_once "Cs/Database.php";

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$post = new Cs_Post;	// What is required to work with posts
$login = new Cs_Login;

// -- END OF OBJECT FACTORY

$base->conBase();

$ht->htmlStart();
	$ht->htmlHead();
	$ht->htmlMenu();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
			echo "<div class=\"small_content\">";
				(isset($_POST['username'])) ? $login->logUsr($_POST['username'],$_POST['password'],'#') : header("Location: index.php");
				(isset($_POST['logout'])) ? $login->logOut('username',$_SERVER['REQUEST_URI']) : '';
			echo "</div>";
			echo "<div class=\"sidebar2\">";

				// Elements in left sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
				$elements2 = array('register','twitter');
				$ht->sidebar($elements2);

			echo "</div>";
			$ht->cleaner();
		echo "</div>";
		echo "<div class=\"sidebar\">";

			// Elements in right sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
			$elements = array('search','recent_posts','recent_comments','tag_cloud');	
			$ht->sidebar($elements);
		
		echo "</div>";
		$ht->cleaner();
	echo "</div>";
$ht->htmlEnd();

?>