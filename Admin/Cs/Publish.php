<?php

class Cs_Publish
{

	public function publishPost() {
		$clean_post = mysql_real_escape_string($_POST['post_title']);
		$clean_content = mysql_real_escape_string($_POST['post_content']);
		$category = $_POST['category'];
		$tags = mysql_real_escape_string($_POST['post_tags']);
		$img = mysql_real_escape_string($_POST['post_img']);
		$time = date('h:i');
		$date = date('d-m-Y');

		$query = mysql_query("INSERT INTO post VALUES('','" .$clean_post. "','" .$clean_content. "','" .$tags. "','" .$category. "','" .$_SESSION['userid']. "','" .$time. "','" .$date. "')") or die("Custom error!");

	}

}

?>