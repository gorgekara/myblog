<?php

require_once 'Forms.php';
require_once 'Database.php';

class Cs_Post
{
	// Gets all posts and has two inputs min and max number for limiting number of posts per page
	public function getPosts($min,$max) {
		$query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID ORDER BY PostID Desc LIMIT $min,$max") or die("Custom error!");
		if(mysql_num_rows($query) != 0) {
			echo "Latest posts:";
		}
		while($q = mysql_fetch_array($query)) {
			echo "<div class=\"single_post\">";
				echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</a></div>";
				echo "<div class=\"post_info\">" .$q['Time']. " | " .$q['Date']. " | " .$q['Categories']. " | " .$q['RName']. " " .$q['RSurname']. "<div class=\"right_side\"><a href=\"?mid=" .$q['PostID']. "\">Edit</a> | <a href=\"?rid=" .$q['PostID']. "\">Remove</a></div></div>";
				echo "<div class=\"cleaner\"></div>";
			echo "</div>";
		}
	}

	// Gets all comments and has two inputs min and max
	public function getComments($min,$max) {
		$query = mysql_query("SELECT * FROM post, commenting, comments, usernames WHERE commenting.UserID LIKE usernames.UserID AND post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID ORDER BY comments.CommentID Desc LIMIT $min,$max") or die("Custom error!");
		if(mysql_num_rows($query) != 0) {
			echo "Latest comments:";
		}
		while($q = mysql_fetch_array($query)) {
			echo "<div class=\"single_post\">";
				echo "<div class=\"post_info\">" .$q['RName']. " " .$q['RSurname']. " commentated in <a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</a><div class=\"right_side\"><a href=\"?cid=" .$q['CommentID']. "&s=approve\">Approve</a> | <a href=\"?cid=" .$q['CommentID']. "&s=remove\">Remove</a></div></div>";
				echo "<div class=\"cleaner\"></div>";
			echo "</div>";
		}
	}

	// Checks comment status - $value is used to determine the action and $cid is the comment id
	public function comStat($value,$cid) {
		if(isset($value) && isset($cid)) {
			switch($value) {
				case 'approve': $query = mysql_query("UPDATE comments SET Approve = 1 WHERE comments.CommentID LIKE '" .$cid. "'") or die("Custom error!"); break;
				case 'remove': $removal_1 = mysql_query("DELETE FROM commenting WHERE commenting.CommentID LIKE '" .$cid. "'") or die("Custom error! 1");
				$removal_2 = mysql_query("DELETE FROM comments WHERE comments.CommentID LIKE '" .$cid. "'") or die("Custom error! 2"); break;
			}
		}
	}

	// Selects which mod is used (create - new post or modify posts)
	public function postMod($mod) {
		if($mod == 'create') {
			$formtag = new Cs_Forms;	// New object formtag is created
			$formtag->addFormStart('','post','publish_post');
				$formtag->addInput('text','post_title');
				$formtag->addInput('textarea','post_content');
				$formtag->addSelectStart('category','category_select');

				$get_categories = mysql_query("SELECT * FROM category") or die("Custom error!");
				while($gc = mysql_fetch_array($get_categories)) {
					$formtag->addSelectOption($gc['CategoryID'],$gc['Categories'],'false');
				}
					
				$formtag->addSelectEnd();
				$formtag->addInput('text','post_tags');
				$formtag->addInput('text','post_img');
				$formtag->addInput('submit','Publish');
			$formtag->addFormEnd();
		}
		if($mod == 'modify') {
			$query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID ORDER BY PostID Desc LIMIT 30") or die("Custom error!");
			while($q = mysql_fetch_array($query)) {
				echo "<div class=\"single_post\">";
					echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</a></div>";
					echo "<div class=\"post_info\">" .$q['Time']. " | " .$q['Date']. " | " .$q['Categories']. " | " .$q['RName']. " " .$q['RSurname']. "<div class=\"right_side\"><a href=\"?mid=" .$q['PostID']. "\">Edit</a> | <a href=\"?rid=" .$q['PostID']. "\">Remove</a></div></div>";
					echo "<div class=\"cleaner\"></div>";
				echo "</div>";
			}
		}
	}

	// Publishes posts
	public function publishPost() {
		$clean_post = mysql_real_escape_string($_POST['post_title']);
		$clean_content = mysql_real_escape_string($_POST['post_content']);
		$category = $_POST['category'];
		$tags = mysql_real_escape_string($_POST['post_tags']);
		$clean_image = mysql_real_escape_string($_POST['post_img']);
		$time = date('H:i');
		$date = date('d-m-Y');
		$query = mysql_query("INSERT INTO post VALUES('','" .$clean_post. "','" .$clean_content. "','" .$clean_image. "','" .$tags. "','" .$category. "','" .$_SESSION['userid']. "','" .$time. "','" .$date. "')") or die("Custom error!");
	}

	// Removal of posts by PostID
	public function removePost($value) {
		$clean_value = mysql_real_escape_string($value);
		$query = mysql_query("DELETE FROM post WHERE post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
	}

	// Modification of selected post by PostID
	public function modifyPost($value) {
		$formtag = new Cs_Forms;
		$clean_modify = mysql_real_escape_string($value);
		$query = mysql_query("SELECT * FROM post WHERE post.PostID LIKE '" .$clean_modify. "'") or die("Custom error!");
		while($q = mysql_fetch_array($query)) {
			$formtag->addFormStart('','post','update_post');
				$formtag->addInputValue('text','update_title',$q['PostTitle']);
				$formtag->addInputValue('textarea','update_content',$q['PostContent']);
				$formtag->addInputValue('hidden','pid',$q['PostID']);
				$formtag->addSelectStart('category','category_select');

				$get_categories = mysql_query("SELECT * FROM category") or die("Custom error!");
				while($gc = mysql_fetch_array($get_categories)) {
					if($gc['CategoryID'] == $q['CategoryID']) {
						$formtag->addSelectOption($gc['CategoryID'],$gc['Categories'],'true');
					}
					else {
						$formtag->addSelectOption($gc['CategoryID'],$gc['Categories'],'false');	
					}			
				}
					
				$formtag->addSelectEnd();
				$formtag->addInputValue('text','post_tags',$q['Tags']);
				$formtag->addInput('text','post_img');
				$formtag->addInput('submit','Publish');
			$formtag->addFormEnd();
		}
		if(isset($_POST['update_title'])) {
			$clean_title = mysql_real_escape_string($_POST['update_title']);
			$clean_content = mysql_real_escape_string($_POST['update_content']);
			$category = $_POST['category'];
			$pid = $_POST['pid'];
			$tags = mysql_real_escape_string($_POST['post_tags']);
			$clean_image = mysql_real_escape_string($_POST['post_img']);
			$time = date('h:i');
			$date = date('d-m-Y');
			$query = mysql_query("UPDATE post SET post.PostTitle = '" .$clean_title. "',post.PostContent = '" .$clean_content. "',post.Tags = '" .$tags. "',post.CategoryID = '" .$category. "',post.UserID = '" .$_SESSION['userid']. "',post.Time = '" .$time. "',post.Date = '" .$date. "',post.PostImage = '" .$clean_image. "' WHERE post.PostID LIKE '" .$pid. "'") or die("Custom error!");
		}
	}

}

?>