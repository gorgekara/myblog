<?php

class Cs_Login
{
	
	public function logUsr($username,$password,$endlocation) {

		session_start();
		if(isset($_SESSION['username'])) {
			header("Location: " .$endlocation. "");
		}

		$hack = hash('md5',$password);	// Hash the user inputed password
		$clean_user = mysql_real_escape_string($username);	// Clean the user inputed username for database safety
		$check = mysql_query("SELECT * FROM usernames, password WHERE usernames.UserID LIKE password.UserID AND usernames.Username LIKE '".$clean_user."'") or die("Custom error!");
		while($checks = mysql_fetch_array($check)) {

			if($hack == $checks['Passwords']) {	// Check if password matches
				
				session_start();
				// Session variables 	----------------
				$_SESSION['username'] = $clean_user;
				$_SESSION['userid'] = $checks['UserID'];

				header("Location: " .$endlocation. "");
			}

			else {
				echo "Login Failed!";
			}

		}
	}

	public function logOut($value,$location) {
		if(isset($_SESSION[$value])) {
			session_destroy();
			header("Location: " .$location. "");
		}
		else {
			header("Location: index.php");
		}
	}

}

?>