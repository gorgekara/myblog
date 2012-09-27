<?php

require_once 'Error.php';
require_once 'HTML.php';
require_once 'Forms.php';

class Cs_Post
{
	// Gets all posts and has two inputs min and max number for limiting number of posts per page
	public function getPosts() {
		?>

		<div id='container'>
			<ol class="timeline" id="updates">
			<?php
				$sql = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID ORDER BY post.PostID Desc LIMIT 0,10") or die("Custom error!");
				while($q = mysql_fetch_array($sql))
				{
					$msg_id=$q['PostID'];
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
			</ol>
			<div id="more<?php echo $msg_id; ?>" class="morebox">
				<a href="#" class="more" id="<?php echo $msg_id; ?>">Load more posts</a>
			</div>
		</div>

		<?php

		/* $query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID ORDER BY post.PostID Desc LIMIT 0,10") or die("Custom error!");
		if(mysql_num_rows($query) == 0) {
			echo "<div class=\"note_text\">There are no posts!</div>";
		}
		while($q = mysql_fetch_array($query)) {
			$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
			$comments_num = mysql_num_rows($cnum);
			$ht = new Cs_HTML;
			echo "<div class=\"single_post\">";
				echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
				echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
				echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\"><img src=\"Images/comment.png\" class=\"com_pic\" alt=\"comment\"> " .$comments_num. "</div></div>";
				echo "<div class=\"cleaner\"></div>";
			echo "</div>";
		} */

	}

	public function getPostsBy($min,$max) {
		$query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND usernames.UserID LIKE '" .$_SESSION['userid']. "' ORDER BY PostID Desc LIMIT $min,$max") or die("Custom error!");
		if(mysql_num_rows($query) == 0) {
			echo "<div class=\"note_text\">There are no posts by you!</div>";
		}
		else {
			$num = mysql_num_rows($query);
			echo "<h1><img class=\"option_img\" src=\"Images/post.png\" alt=\"options\" /> Posts by me (" .$num. ")</h1>";
			while($q = mysql_fetch_array($query)) {
				$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
				$comments_num = mysql_num_rows($cnum);
				$ht = new Cs_HTML;
				echo "<div class=\"single_post\">";
					echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
					echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
					echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\">" .$comments_num. "</div></div>";
					echo "<div class=\"cleaner\"></div>";
				echo "</div>";
			}
		}
	}

	// Gets all posts in this category
	public function getCategoryPost($value,$min,$max) {
		$clean_id = mysql_real_escape_string($value);
		$query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND post.CategoryID LIKE $clean_id ORDER BY PostID Desc LIMIT $min,$max") or die("Custom error!");
		if(mysql_num_rows($query) == 0) {
			echo "<div class=\"note_text\">There are no posts in this category!</div>";
		}
		while($q = mysql_fetch_array($query)) {
			$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
			$comments_num = mysql_num_rows($cnum);
			$ht = new Cs_HTML;
			echo "<div class=\"single_post\">";
				echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
				echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
				echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\">" .$comments_num. "</div></div>";
				echo "<div class=\"cleaner\"></div>";
			echo "</div>";
		}
	}

	public function getSinglePost($value) {
		$clean_value = mysql_real_escape_string($value);
		$query = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
		$q = mysql_fetch_array($query);

		$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
		$comments_num = mysql_num_rows($cnum);

		$ht = new Cs_HTML;
		$postContent = "
			<div class=\"single_post\">
				<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>
				<div class=\"post_content\">
					<img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a>
					<div class=\"just_content\">" .html_entity_decode($q['PostContent']). "</div>
				</div>
				<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\">" .$comments_num. "</div></div>
			</div>
		";
		$error = new Cs_Error;
		if (isset($_SESSION['userid']) && $_SESSION['userid'] == $q['UserID']) {
			echo "<div class=\"admin_bar\">
						<a href=\"publish.php?mid=" .$q['PostID']. "\"><img src=\"Images/cog.png\" alt=\"edit\" /> Modify</a> 
						<a href=\"publish.php?rid=" .$q['PostID']. "\"><img src=\"Images/remove.png\" alt=\"remove\" /> Remove</a>
					</div>";
		}
		else if(isset($_SESSION['userid'])) {
			$check_admin = mysql_query("SELECT * FROM usernames WHERE usernames.UserID LIKE '".$_SESSION['userid']."' AND usernames.Admin LIKE 1") or die("Custom error!");			
			if(mysql_num_rows($check_admin) != 0) {
				echo "<div class=\"admin_bar\">
						<a href=\"publish.php?mid=" .$q['PostID']. "\"><img src=\"Images/cog.png\" alt=\"edit\" /> Modify</a> 
						<a href=\"publish.php?rid=" .$q['PostID']. "\"><img src=\"Images/remove.png\" alt=\"remove\" /> Remove</a>
					</div>";
			}
		}

		echo (mysql_num_rows($query) == 0) ? $error->er404() : $postContent;
	}

	public function searchQuery($query) {
		$query = mysql_real_escape_string($query);
		$search_one = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND post.PostTitle LIKE '%" .$query. "%' ORDER BY post.PostID") or die("Custom error!");
		if(mysql_num_rows($search_one) != 0) {
			while($q = mysql_fetch_array($search_one)) {
				$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
				$comments_num = mysql_num_rows($cnum);
				$ht = new Cs_HTML;
				echo "<div class=\"single_post\">";
					echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
					echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
					echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp; <a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a> &nbsp; <a href=\"profile.php?u=" .$q['Username']. "\">" .$q['RName']. " " .$q['RSurname']. "</a><div class=\"right_side\">" .$comments_num. "</div></div>";
					echo "<div class=\"cleaner\"></div>";
				echo "</div>";
			}
		}
		else {
			$search_two = mysql_query("SELECT * FROM post, usernames, category WHERE category.CategoryID LIKE post.CategoryID AND post.UserID LIKE usernames.UserID AND post.Tags LIKE '%" .$query. "%' ORDER BY post.PostID") or die("Custom error!");
			if(mysql_num_rows($search_two) != 0) {
				while($q = mysql_fetch_array($search_two)) {
					$cnum = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$q['PostID']. "'") or die("Custom error!");
					$comments_num = mysql_num_rows($cnum);
					$ht = new Cs_HTML;
					echo "<div class=\"single_post\">";
						echo "<div class=\"post_title\"><a href=\"post.php?pid=" .$q['PostID']. "\">" .$q['PostTitle']. "</div>";
						echo "<div class=\"post_content\"><img class=\"post_image\" src=\"" .$q['PostImage']. "\" alt=\"post_img\" /></a></div>";
						echo "<div class=\"post_info\">" .$ht->timeNow($q['Time'],$q['Date']). " | " .$q['Categories']. " | " .$q['RName']. " " .$q['RSurname']. "<div class=\"right_side\">" .$comments_num. "</div></div>";
						echo "<div class=\"cleaner\"></div>";
					echo "</div>";
				}	
			}
			else {
				echo "<div class=\"note_text_space\">Sorry, we couldn't find anything with <b>" .stripslashes($query). "</b></div>";
			}
		}
		
	}

	public function getCom($postID) {
		$clean_pid = mysql_real_escape_string($postID);
		$query = mysql_query("SELECT * FROM post,commenting,comments,usernames WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND commenting.UserID LIKE usernames.UserID AND post.PostID LIKE '" .$clean_pid. "' ORDER BY comments.CommentID DESC") or die("Custom error!");
		if(mysql_num_rows($query) == 0) {
			echo "<div class=\"note_text_space\">Be the first one to comment here!</div>";
		}
		else {
			while($q = mysql_fetch_array($query)) {
				$ht = new Cs_HTML;
				echo "
					<div class=\"comment_box\">
						<div class=\"single_comment\">
							<div class=\"comment_title\">" .$q['RName']. " " .$q['RSurname']. " 
								<div class=\"right_side\">
									" .$ht->timeNow($q['Time'],$q['Date']). " &nbsp;";
								if(isset($_SESSION['userid'])) {
									if($q['UserID'] == $_SESSION['userid']) {
										echo "<a href=\"?pid=" .$_GET['pid']. "&rcid=" .$q['CommentID']. "\"><img src=\"Images/remove.png\" alt=\"remove\" /> Remove</a>";
									}
								}

				echo "			</div>
							</div>
							<div class=\"comment_content\">" .html_entity_decode($q['Comment']). "</div>
						</div>
					</div>
				";
			}
		}
	}

	public function comBox() {
		$form = new Cs_Forms;
		$form->addFormStart('','post','comBox');
			$form->addInput('textarea','comContent');
			$form->addInput('submit','Comment');
		$form->addFormEnd();
	}

	public function publishComment($content,$userid,$postid) {
		$clean_content = $content;
		$clean_pid = mysql_real_escape_string($postid);
		$time = date('H:i');
		$date = date('d-m-Y');
		$timedate = $time. "|" .$date;

		// Prevent posting empty comment
		if($clean_content != "<br>") {
			// Prevent recommenting same comment
			$check = mysql_query("SELECT * FROM comments WHERE comments.Comment LIKE '" .$clean_content. "'") or die("Custom error!");
			if(mysql_num_rows($check) == 0) {
				$query = mysql_query("INSERT INTO comments VALUES('','" .$clean_content. "')") or die("Custom error!");
				$cid = mysql_insert_id();
				$query_two = mysql_query("INSERT INTO commenting VALUES ('" .$clean_pid. "','" .$cid. "','" .$timedate. "','','" .$userid. "')") or die("Custom error!");
			}
			else {
				echo "<div class=\"note_text_space\">This comment has already been published. <br /> Are you spamming us?</div>";
			}
		}
		else {
			echo "<div class=\"note_text_space\">Please enter text in the comment field!</div>"; 
		}

	}

	public function postForm() {
		$form = new Cs_Forms;
		echo "<h1><img class=\"option_img\" src=\"Images/post.png\" alt=\"options\" /> Publish post</h1>";
		$form->addFormStart('','post','registration_form');
			echo "<div class=\"new_post\">";
				$form->addInputPlace('text','post_title','Post title..');
				$form->addInputPlace('textarea','post_content','Post content goes here..');

				$form->addSelectStart('category','category_select');

				$get_categories = mysql_query("SELECT * FROM category") or die("Custom error!");
				while($gc = mysql_fetch_array($get_categories)) {
					$form->addSelectOption($gc['CategoryID'],$gc['Categories'],'false');
				}
					
				$form->addSelectEnd();
				
				$form->addInputPlace('text','post_tags','Please seperate tags with space');
				$form->addInputPlace('text','post_img','Post image link goes here..');
				$form->addInput('submit','Update');
			echo "</div>";
		$form->addFormEnd();
		echo "<br />";
	}

	public function publishPost() {
		$clean_post = mysql_real_escape_string($_POST['post_title']);
		$clean_content = addslashes($_POST['post_content']);
		$category = $_POST['category'];
		$tags = mysql_real_escape_string($_POST['post_tags']);
		$clean_image = mysql_real_escape_string($_POST['post_img']);
		$time = date('H:i');
		$date = date('d-m-Y');

		echo ($clean_post == "") ? "<div class=\"note_text\">Please enter post title!</div>" : $judge = 1;
		echo ($clean_content == "") ? "<div class=\"note_text\">Please enter post content!</div>" : $judge += 1;
		echo ($clean_image == "") ? "<div class=\"note_text\">Please enter post image link!</div>" : $judge += 1;

		if($judge == 3) {
			$query = mysql_query("INSERT INTO post VALUES('','" .$clean_post. "','" .$clean_content. "','" .$clean_image. "','" .$tags. "','" .$category. "','" .$_SESSION['userid']. "','" .$time. "','" .$date. "')") or die("Custom error!");			
		}
	}

	// Removal of posts by PostID
	public function removePost($value) {
		$clean_value = mysql_real_escape_string($value);
		$cp = 0;
		
		$query = mysql_query("SELECT * FROM usernames,post WHERE usernames.UserID LIKE post.UserID AND post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
		
		if(mysql_num_rows($query) != 0) {
			$q = mysql_fetch_array($query);
			(isset($_SESSION['userid']) && $_SESSION['userid'] == $q['UserID']) ? '' : header("Location: index.php");
			$check_post = mysql_query("SELECT * FROM post WHERE post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
			(mysql_num_rows($check_post) == 0) ? "<div class=\"note_text\">The post you are trying to remove doesn't exist!</div>" : $cp = mysql_fetch_array($check_post);
			$post_title = $cp['PostTitle'];

			$view_commenting = mysql_query("SELECT * FROM post,commenting,comments WHERE post.PostID LIKE commenting.PostID AND commenting.CommentID LIKE comments.CommentID AND post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
			while($vc = mysql_fetch_array($view_commenting)) {
				$remove_commenting = mysql_query("DELETE FROM commenting WHERE commenting.PostID LIKE '" .$vc['PostID']. "'") or die("Custom error!");
				$remove_comments = mysql_query("DELETE FROM comments WHERE comments.CommentID LIKE '" .$vc['CommentID']. "'") or die("Custom error!");
			}

			$query = ($cp != 0) ? mysql_query("DELETE FROM post WHERE post.PostID LIKE '" .$clean_value. "'") or die("Custom error!") : '';

			$check_removed = mysql_query("SELECT * FROM post WHERE post.PostID LIKE '" .$clean_value. "'") or die("Custom error!");
			echo (mysql_num_rows($check_removed) == 0) ? "<div class=\"note_text\">The post <b>" .$post_title. "</b> was successfully removed!</div>" : '';
		}
		else {
			echo "<div class=\"note_text_space\">The post you tried to delete does not exist or you are not authorized to remove it!</div>";
		}

		
	}

	// Modification of selected post by PostID
	public function modifyPost($value) {
		$form = new Cs_Forms;
		$clean_modify = mysql_real_escape_string($value);
		$query = mysql_query("SELECT * FROM post WHERE post.PostID LIKE '" .$clean_modify. "'") or die("Custom error!");
		while($q = mysql_fetch_array($query)) {
			echo "<h1><img class=\"option_img\" src=\"Images/post.png\" alt=\"options\" /> Modify post</h1>";
			$form->addFormStart('','post','registration_form');
				echo "<div class=\"new_post\">";
					$form->addInputValue('hidden','pid',$q['PostID']);
					$form->addInputValue('text','update_title',$q['PostTitle']);
					$form->addInputValue('textarea','update_content',$q['PostContent']);

					$form->addSelectStart('category','category_select');

					$get_categories = mysql_query("SELECT * FROM category") or die("Custom error!");
					while($gc = mysql_fetch_array($get_categories)) {
						if($gc['CategoryID'] == $q['CategoryID']) {
							$form->addSelectOption($gc['CategoryID'],$gc['Categories'],'true');
						}
						else {
							$form->addSelectOption($gc['CategoryID'],$gc['Categories'],'false');	
						}			
					}
						
					$form->addSelectEnd();
					
					$form->addInputValue('text','post_tags',$q['Tags']);
					$form->addInputValue('text','post_img',$q['PostImage']);
					$form->addInput('submit','Update');
				echo "</div>";
			$form->addFormEnd();
		}
	}

	public function publishUpdate() {
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

	public function removeComment($cid) {
		$clean_cid = mysql_real_escape_string($cid);
		$removal = mysql_query("DELETE FROM commenting WHERE commenting.CommentID LIKE '" .$clean_cid. "'") or die("Custom error!");
		if(isset($removal)) {
			$removal_comment = mysql_query("DELETE FROM comments WHERE comments.CommentID LIKE '" .$clean_cid. "'") or die("Custom error!");				
		}
	}

	public function getCategories() {
		$query_cat = mysql_query("SELECT * FROM category") or die("Custom error!");
		while($q = mysql_fetch_array($query_cat)) {
			$get_num = mysql_query("SELECT * FROM post WHERE post.CategoryID LIKE '" .$q['CategoryID']. "'") or die("Custom error!");
			$num = mysql_num_rows($get_num);
			echo "<div class=\"m_info\">";
				echo "<a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. " (" .$num. ")</a>";
				if($q['CategoryID'] != 1) {
					echo "<div class=\"right_side\">";
						echo "<a href=\"admin_category.php?rcid=" .$q['CategoryID']. "\"><img src=\"Images/remove.png\" alt=\"remove\" /> remove</a>&nbsp;&nbsp;&nbsp;<a href=\"admin_category.php?mcid=" .$q['CategoryID']. "\"><img src=\"Images/cog.png\" alt=\"remove\" /> modify</a>";
					echo "</div>"; 
				}
			echo "</div>";
		}
	}
	
	public function addCat($value) {
		$check_cat = mysql_query("SELECT * FROM category WHERE category.Categories LIKE '" .$value. "'") or die("Custom error!");
		if(mysql_num_rows($check_cat) == 0) {
			$add_cat = mysql_query("INSERT INTO category VALUES('','" .$value. "')") or die("Custom error!");
			header("Location: admin_category.php");
		}
	}
	
	public function removeCat($value) {
		if($value != 1) {
			$check_cat = mysql_query("SELECT * FROM category, post WHERE category.CategoryID LIKE post.CategoryID AND category.CategoryID LIKE '" .$value. "'") or die("Custom error! 1");
			if(mysql_num_rows($check_cat) == 0) {
				$rem_cat = mysql_query("DELETE FROM category WHERE category.CategoryID LIKE '" .$value. "'") or die("Custom error! 2");
			}
			else {
				while($q = mysql_fetch_array($check_cat)) {
					$update_post = mysql_query("UPDATE post SET CategoryID = 1 WHERE CategoryID LIKE '" .$q['CategoryID']. "'") or die("Custom error! 3");
					$rem_cat = mysql_query("DELETE FROM category WHERE category.CategoryID LIKE '" .$q['CategoryID']. "'") or die("Custom error! 4");
				}
			}
			header("Location: admin_category.php");
		}
	}
	
	public function modifyCatForm($value) {
		$form = new Cs_Forms;
		$get_category = mysql_query("SELECT * FROM category WHERE category.CategoryID LIKE '" .$value. "'") or die("Custom error!");
		$q = mysql_fetch_array($get_category);
		$form->addFormStart("admin_category.php", "post", "modify_category");
			$form->addInputValue("admin_category.php", "cat_name", $q['Categories']);
			$form->addInputValue("hidden", "cat_id", $q['CategoryID']);
			$form->addInput("submit", "Modify");
		$form->addFormEnd();
	}
	
	public function modifyCat($catid,$catname) {
		$update_cat = mysql_query("UPDATE category SET category.Categories = '" .$catname. "' WHERE category.CategoryID LIKE '" .$catid. "'") or die("Custom error!");
		header("Location: admin_category.php");
	}
	
}

?>
