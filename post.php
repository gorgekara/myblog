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
	$ht->htmlMenu();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
				echo "<div class=\"small_content\">";
					$post->getSinglePost($_GET['pid']);	// Get all posts

					// If comment is being removed
					(isset($_GET['rcid'])) ? $post->removeComment($_GET['rcid']) : '';

					// If comContent is set publish comment
					(isset($_POST['comContent'])) ? $post->publishComment($_POST['comContent'],$_SESSION['userid'],$_GET['pid']) : '';
					
					// If session variable username is set show comment box else show text
					echo (isset($_SESSION['username'])) ? $post->comBox() : '<div class=\'note_text\'><a href=\'register.php\'>Log in</a> to comment!</div>';
					$post->getCom($_GET['pid']);

				echo "</div>";
				echo "<div class=\"sidebar2\">";

					// Elements in left sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
					$elements2 = array('register',$_GET['pid'],'twitter');
					$ht->sidebar($elements2);

				echo "</div>";
				$ht->cleaner();
			echo "</div>";
			echo "<div class=\"sidebar\">";

				// Elements in right sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
				$elements = array('search','popular','recent_posts','recent_comments','tag_cloud');
				$ht->sidebar($elements);
			
			echo "</div>";
			$ht->cleaner();
		echo "</div>";
	echo "</div>";
$ht->htmlEnd();

?>
