<?php

class Cs_Database
{
	
	public function conBase() {
		require "../../db.inc";	// Information for database connection
		$con = mysql_connect($dbplace,$dbuser,$dbpass);
		mysql_select_db("cmsbase",$con);
	}

	public function getCategories() {
		$query = mysql_query("SELECT * FROM categories") or die("Custom error!");
		while($q = mysql_fetch_array($query)) {
			return $q;
		}
	}

	public function userCheck($userid) {
		$query = mysql_query("SELECT * FROM usernames WHERE usernames.UserID LIKE '" .$userid. "' AND usernames.Admin LIKE 1") or die("Custom error!");
		(mysql_num_rows($query) == 0) ? header("Location: index.php") : ''; 
	}

	public function getUsers() {
		$query = mysql_query("SELECT * FROM usernames ORDER BY usernames.UserID DESC") or die("Custom error!");
		echo "<h1>Manage users</h1>";

		while($q = mysql_fetch_array($query)) {
			if($q['UserID'] == $_SESSION['userid']) {
				echo "<div class=\"m_info\">";
					echo "<a href=\"profile.php?u=" .$q['Username']. " \">" .$q['RName']. " " .$q['RSurname']. "</a>&nbsp; (" .$q['Username'].")";
					echo "<div class=\"right_side\">";
						
					echo "</div>"; 
				echo "</div>";
			}
			else {
				echo "<div class=\"m_info\">";
					echo "<a href=\"profile.php?u=" .$q['Username']. " \">" .$q['RName']. " " .$q['RSurname']. "</a>&nbsp; (" .$q['Username'].")";
					echo "<div class=\"right_side\">";
						echo "<a href=\"?rid=" .$q['UserID']. "\"><img src=\"Images/remove.png\" alt=\"remove\" /> Remove</a>";
					echo "</div>"; 
				echo "</div>";
			}
			
		}

	}

	public function removeUser($userid) {
		$clean_uid = mysql_real_escape_string($userid);
		$query = mysql_query("SELECT * FROM usernames,commenting,comments WHERE usernames.UserID LIKE commenting.UserID AND commenting.CommentID LIKE comments.CommentID AND usernames.UserID LIKE '" .$clean_uid. "'") or die("Cu1stom error!");
		while($q = mysql_fetch_array($query)) {
			$remove_comments = mysql_query("DELETE FROM comments WHERE comments.CommentID LIKE '" .$q['CommentID']. "'") or die("Cust2om error!");
		}
		$remove_commenting = mysql_query("DELETE FROM commenting WHERE commenting.UserID LIKE '" .$clean_uid. "'") or die("Custo3m error!");
		$remove_post = mysql_query("DELETE FROM post WHERE post.UserID LIKE '" .$clean_uid. "'") or die("Cu4stom error!");
		$remove_pass = mysql_query("DELETE FROM password WHERE password.UserID LIKE '" .$clean_uid. "'") or die("Custom error!");
		$remove_user = mysql_query("DELETE FROM usernames WHERE usernames.UserID LIKE '" .$clean_uid. "'") or die("Cu5stom error!");
	}

}

?>
