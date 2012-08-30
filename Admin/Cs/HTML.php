<?php

class Cs_HTML
{
	
	public function htmlStart($title) {

		ob_start();
		
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\">";
		echo "<head>";
			echo "<title>" .$title. "</title>";
			echo "<link rel=\"stylesheet\" href=\"Styles/main.css\" />";
		echo "</head>";
		echo "<body>";
	}

	public function htmlEnd($footer) {
			echo "<div class=\"footer\">" .$footer. "</div>";
		echo "</body>";
		echo "</html>";
	}

	//	Menu for blog
	public function htmlMenu() {
		echo "<div class=\"menu\">";
			$query = mysql_query("SELECT * FROM category") or die("Database error!");
			while($q = mysql_fetch_array($query)) {
				echo "<div class=\"menu_item\"><a href=\"category.php?id=" .$q['CategoryID']. "\">" .$q['Categories']. "</a></div>";
			}
		echo "</div>";
	}

	//	Menu for admin
	public function htmlAdminMenu() {
		echo "<div class=\"admin_menu\">";
			// Set menu items - on the left is the title and on the right is the link
			$admin_menu = array(
					'Home' => 'admin.php',
					'Add post' => 'post.php?s=create',
					'Edit/Remove posts' => 'post.php?s=modify',
					'Options' => 'options.php',
					'Log out' => 'logout.php'
				);		
			foreach($admin_menu as $item => $link) {
				echo "<div class=\"admin_menu_item\"><a href=\"" .$link. "\">" .$item. "</a></div>";	
			}
		echo "</div>";
	}


}

?>