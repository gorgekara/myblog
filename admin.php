<?php

session_start();

require_once "Cs/Post.php";
require_once "Cs/Database.php";
require_once "Cs/HTML.php";

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$post = new Cs_Post;	// What is required to work with posts

// -- END OF OBJECT FACTORY

$base->conBase();	// Connect to database

$ht->htmlStart();
	$ht->htmlHead();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
				echo "<div class=\"small_content\">";
					$base->userCheck($_SESSION['userid']);
					$base->getUsers();

					// Check if user is being removed
					(isset($_GET['rid'])) ? $base->removeUser($_GET['rid']) : '';

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
	echo "</div>";
$ht->htmlEnd();

?>
