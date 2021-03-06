<?php

session_start();

require_once "Cs/Post.php";
require_once "Cs/Database.php";
require_once "Cs/HTML.php";
require_once "Cs/Login.php";

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$post = new Cs_Post;	// What is required to work with posts
$login = new Cs_Login;

// -- END OF OBJECT FACTORY

$base->conBase();	// Connect to database

$ht->htmlStart();
	$ht->htmlHead();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
			echo "<div class=\"small_content\">";
				$login->usrOptions($_SESSION['userid']);
				(isset($_POST['username'])) ? $login->updateUser($_POST['username'],$_POST['password'],$_POST['confirm_password'],$_POST['email'],$_POST['about'],$_POST['name'],$_POST['surname'],$_POST['userid']) : '';
				(isset($_POST['option_change'])) ? $login->updateOptions($_POST['Site+Title'],$_POST['Footer+text'],$_POST['Blog+tagline'],$_POST['Blog+image']) : '';
			echo "</div>";
			echo "<div class=\"sidebar2\">";

				// Elements in left sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
				$elements2 = array('register','search');
				$ht->sidebar($elements2);

			echo "</div>";
			$ht->cleaner();
		echo "</div>";
		echo "<div class=\"sidebar\">";

			// Elements in right sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
			$elements = array('popular','recent_posts','recent_comments','tag_cloud');	
			$ht->sidebar($elements);
		
		echo "</div>";
		$ht->cleaner();
	echo "</div>";
$ht->htmlEnd();

?>
