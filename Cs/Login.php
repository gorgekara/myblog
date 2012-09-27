<?php

require_once "Error.php";
require_once "Forms.php";
require_once('Cs/External/recaptchalib.php');

class Cs_Login
{
	
	public function logUsr($username,$password,$endlocation) {

		if(isset($_SESSION['username'])) {
			header("Location: " .$endlocation. "");
		}

		$hack = hash('md5',$password);	// Hash the user inputed password
		$clean_user = mysql_real_escape_string($username);	// Clean the user inputed username for database safety
	
		$check = mysql_query("SELECT * FROM usernames, password WHERE usernames.UserID LIKE password.UserID AND usernames.Username LIKE '".$clean_user."'") or die("Custom err12or!");
		while($checks = mysql_fetch_array($check)) {

			if($hack == $checks['Passwords']) {	// Check if password matches

				// Session variables 	----------------
				$_SESSION['username'] = $clean_user;
				$_SESSION['userid'] = $checks['UserID'];

				header("Location: " .$endlocation. "");
			}

			else {
				echo "<div class=\"note_text\">Login failed. Please try again!</div>";
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

	public function regUser($username,$password,$confirm_password,$email) {
		$clean_user = mysql_real_escape_string($username);
		$clean_password = mysql_real_escape_string($password);
		$clean_confirm = mysql_real_escape_string($confirm_password);
		$clean_email = mysql_real_escape_string($email);

		$judge = 0;
		$error = new Cs_Error;
		($clean_password != $clean_confirm) ? $error->erMod('password_match') : $judge += 1;
		(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',$clean_email)) ? $error->erMod('email_fail') : $judge += 1;
		(!preg_match('/^[a-zA-Z0-9_]+$/',$clean_user)) ? $error->erMod('user_fail') : $judge += 1;

		$privatekey = "6LdlNtMSAAAAAIr2_qu861X5TL_EBS48DZksQvJq";
		$resp = recaptcha_check_answer ($privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_POST["recaptcha_challenge_field"],
		                                $_POST["recaptcha_response_field"]);

		if (!$resp->is_valid) {
		    // What happens when the CAPTCHA was entered incorrectly
		    echo "The reCAPTCHA wasn't entered correctly. Go back and try it again.";	
		  } 
		  else {
		    $judge += 1;
		  }


		if($judge == 4) {
			$user = mysql_query("INSERT INTO usernames VALUES('','" .$clean_user. "','" .$clean_email. "','Anon','Anonymous','Here should stand description of the user','0')") or die("Custom error!");
			$userid = mysql_insert_id();
			$hash = hash('md5',$clean_password);
			$password = mysql_query("INSERT INTO password VALUES('','" .$hash. "','" .$userid. "')") or die("Custom error!");

			echo (isset($user) && isset($password)) ? '<div class=\'note_text\'>You have been successfully registered!</div>' : '<div class=\'note_text\'>Something terible has happened!</div>';
		}

	}

	public function usrOptions($userid) {
		$query = mysql_query("SELECT * FROM usernames WHERE usernames.UserID LIKE '" .$userid. "'") or die("Custom error!");
		$q = mysql_fetch_array($query);
		
		$form = new Cs_Forms;
		$html = new Cs_HTML;

		echo "<h1><img class=\"option_img\" src=\"Images/cog.png\" alt=\"options\" /> Options</h1>";
		echo "<div class=\"option_tabs\">";
			echo "<ul>";
				echo "<li><a href=\"#tabs-1\">Profile Options</a></li>";
				if($q['Admin'] == 1) {
					echo "<li><a href=\"#tabs-2\">Blog Options</a></li>";
				}
			echo "</ul>";
		echo "<div id=\"tabs-1\">";
		$form->addFormStart('','post','registration_form');
			$form->addInputValue('hidden','userid',$_SESSION['userid']);
			echo "<table>";				
				echo "<tr>";
					echo "<td>";
						echo "Username:";
					echo "</td>";
					echo "<td>";
						$form->addInputValue('text','username',$q['Username']);
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>";
					echo "Email:";
				echo "</td>";
				echo "<td>";
					$form->addInputValue('text','email',$q['Email']);
				echo "</td>";	
				echo "</tr>";

				echo "<tr>";
				echo "<td>";
					echo "Name:";
				echo "</td>";
				echo "<td>";
					$form->addInputValue('text','name',$q['RName']);
				echo "</td>";	
				echo "</tr>";

				echo "<tr>";
				echo "<td>";
					echo "Surname:";
				echo "</td>";
				echo "<td>";
					$form->addInputValue('text','surname',$q['RSurname']);
				echo "</td>";	
				echo "</tr>";

				echo "<tr>";
				echo "<td>";
					echo "About:";
				echo "</td>";
				echo "<td>";
					$form->addInputValue('textarea','about',$q['About']);
				echo "</td>";	
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "Password:";
					echo "</td>";
					echo "<td>";
						$form->addInput('password','password');
					echo "</td>";
				echo "</tr>";	
					
				echo "<tr>";
					echo "<td>";
						echo "Confirm password:";
					echo "</td>";
					echo "<td>";
						$form->addInput('password','confirm_password');
					echo "</td>";
				echo "</tr>";	

				echo "<tr>";
					echo "<td>";
						echo "&nbsp;";
					echo "</td>";
					echo "<td>";
						$form->addInput('submit','Update');
					echo "</td>";
				echo "</tr>";	
			echo "</table>";
		$form->addFormEnd();
		echo "</div>";
		if($q['Admin'] == 1) {
			echo "<div id=\"tabs-2\">";
				$html->getOptionsForm();
			echo "</div>";
		}
		echo "</div>";
	}

	public function updateUser($username,$password,$confirm,$email,$about,$name,$surname,$userid) {
		$clean_username = mysql_real_escape_string($username);
		$clean_email = mysql_real_escape_string($email);
		$clean_about = mysql_real_escape_string($about);
		$clean_name = mysql_real_escape_string($name);
		$clean_surname = mysql_real_escape_string($surname);

		if($password == "") {
			// Check if same user is changing his settings
			($_SESSION['username'] == $username) ? $bool = 1 : $bool = 0;

			if($bool == 1) {
				$query = mysql_query("UPDATE usernames SET usernames.Username = '" .$clean_username. "',usernames.Email = '" .$clean_email. "',usernames.RName = '" .$clean_name. "',usernames.RSurname = '" .$clean_surname. "',usernames.About = '" .$clean_about. "' WHERE usernames.UserID LIKE '" .$userid. "'") or die("Custom error!");
			} 
		}
		else {

			$error = new Cs_Error;

			// Check if same user is changing his settings
			($_SESSION['username'] == $username) ? $bool = 1 : $bool = 0;

			// Check if password match
			($password == $confirm) ? $bool += 1: $bool -= 1;

			if($bool == 2) {
				$query = mysql_query("UPDATE usernames SET usernames.Username = '" .$clean_username. "',usernames.Email = '" .$clean_email. "',usernames.RName = '" .$clean_name. "',usernames.RSurname = '" .$clean_surname. "',usernames.About = '" .$clean_about. "' WHERE usernames.UserID LIKE '" .$userid. "'") or die("Custom error!");
				$hash = hash('md5',mysql_real_escape_string($password));
				$password = mysql_query("UPDATE password SET password.Passwords = '" .$hash. "' WHERE password.UserID LIKE '" .$userid. "'") or die("Custom error!");
			} 
			else {
				$error->erMod('password_match');
			}
		}
	}

	public function getUser($user) {
		$clean_user = mysql_real_escape_string($user);
		$query = mysql_query("SELECT * FROM usernames WHERE usernames.Username LIKE '" .$user. "'") or die("Custom error!");
		$q = mysql_fetch_array($query);

		$num_posts = mysql_query("SELECT * FROM post,usernames WHERE post.UserID LIKE usernames.UserID AND usernames.UserID LIKE '" .$q['UserID']. "'") or die("Custom error!");
		$np = mysql_num_rows($num_posts);

		$num_comments = mysql_query("SELECT * FROM usernames,commenting,comments WHERE usernames.UserID LIKE commenting.UserID AND commenting.CommentID LIKE comments.CommentID AND usernames.UserID LIKE '" .$q['UserID']. "'") or die("Custom erroR!");
		$nc = mysql_num_rows($num_comments);

		echo "<h1><img class=\"option_img\" src=\"Images/profile.png\" alt=\"options\" /> " .$q['RName']. " " .$q['RSurname']. "</h1>";
		echo "<div class=\"profile_box\">";

			echo "<div class=\"profile_title\">Personal Information</div>";
			echo "
				<div class=\"profile_content\">
					<b>Username:</b> " .$q['Username']. " &nbsp; &nbsp; &nbsp;
					<b>Email:</b> " .$q['Email']. " &nbsp; &nbsp; &nbsp;
				</div>";	

			echo "<br /><div class=\"profile_title\">About</div>";
			echo "<div class=\"profile_content\">" .$q['About']. "</div>";

			echo "
				<div class=\"profile_content\">
					<b>Post published:</b> " .$np. " &nbsp; &nbsp; &nbsp;
					<b>Comments:</b> " .$nc. " &nbsp; &nbsp; &nbsp;
				</div>";

		echo "</div>";
	}

	public function updateOptions($title, $footer, $tagline, $image) {
		$clean_title = mysql_real_escape_string($title);
		$clean_footer = mysql_real_escape_string($footer);
		$clean_tagline = mysql_real_escape_string($tagline);
		$clean_image = mysql_real_escape_string($image);
		
		$query_title = mysql_query("UPDATE options SET Value = '" .$clean_title. "' WHERE OptionName LIKE 'Site Title'") or die("Custom error!");
		$query_footer = mysql_query("UPDATE options SET Value = '" .$clean_footer. "' WHERE OptionName LIKE 'Footer text'") or die("Custom error!");
		$query_tagline = mysql_query("UPDATE options SET Value = '" .$clean_tagline. "' WHERE OptionName LIKE 'Blog tagline'") or die("Custom error!");
		$query_image = mysql_query("UPDATE options SET Value = '" .$clean_image. "' WHERE OptionName LIKE 'Blog image'") or die("Custom error!");
		
		header("Location: options.php");
	}

}

?>