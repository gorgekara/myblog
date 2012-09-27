<?php

require_once "Cs/Post.php";
require_once "Cs/Database.php";
require_once "Cs/HTML.php";

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$post = new Cs_Post;	// What is required to work with posts

// -- END OF OBJECT FACTORY

$base->conBase();	// Connect to database


if(isSet($_POST['lastmsg']))
{
$lastmsg=$_POST['lastmsg'];
$sql = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND post.PostID<'$lastmsg' ORDER BY post.PostID Desc LIMIT 0,10") or die("Custom error!");
		while($q = mysql_fetch_array($sql))
			{
			$msg_id = $q['PostID'];
			echo "<li>";
				$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
				$comments_num = mysql_num_rows($cnum);
				$ht = new Cs_HTML;
				echo "<div class=\"single_post\">";
				echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
				echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
				echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\"><img src=\"Images/comment.png\" class=\"com_pic\" alt=\"comment\"> " .$comments_num. "</div></div>";
				echo "<div class=\"cleaner\"></div>";
				echo "</div>";
			echo "</li>";
		} 
	?>
<div id="more<?php echo $msg_id; ?>" class="morebox">
<a href="#" id="<?php echo $msg_id; ?>" class="more">Load more posts</a>
</div>

<?php
}
?>