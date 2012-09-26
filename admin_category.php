<?php

session_start();

require_once "Cs/Post.php";
require_once "Cs/Database.php";
require_once "Cs/HTML.php";
require_once "Cs/Forms.php";

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$post = new Cs_Post;	// What is required to work with posts
$form = new Cs_Forms;

// -- END OF OBJECT FACTORY

$base->conBase();	// Connect to database

$ht->htmlStart();
	$ht->htmlHead();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
				echo "<div class=\"small_content\">";
					$base->userCheck($_SESSION['userid']);
					echo "<h1>Manage categories</h1>";
					
					if(isset($_GET['mcid'])) {
						$post->modifyCatForm($_GET['mcid']);
					}
					else {
						$form->addFormStart("admin_category.php","post","modify_form");
							$form->addInput("text", "acid");
							$form->addInput("submit", "Create");
						$form->addFormEnd();
					}
					
					$post->getCategories();
		
					// Check if category is being removed
					(isset($_GET['rcid'])) ? $post->removeCat($_GET['rcid']) : '';
					
					// Check if category is being added
					(isset($_POST['acid'])) ? $post->addCat($_POST['acid']) : '';
					
					// Check if category is being modified
					(isset($_POST['cat_name'])) ? $post->modifyCat($_POST['cat_id'],$_POST['cat_name']) : '';
					
				echo "</div>";
				echo "<div class=\"sidebar2\">";

					// Elements in left sidebar - existing ones: search, recent_posts, recent_comments, tag_cloud, twitter, register
					$elements2 = array('register',);
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
