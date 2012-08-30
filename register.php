<?php

require_once "Cs/Login.php";
require_once "Cs/Database.php";
require_once "Cs/HTML.php";
require_once "Cs/Forms.php";
require_once('Cs/External/recaptchalib.php');
$publickey = "6LdlNtMSAAAAAGy-XT20VWC5szY-ETJs_piK9lwG"; // you got this from the signup page

// OBJECT FACTORY

$base = new Cs_Database;
$ht = new Cs_HTML;	// Object for working with HTML tags
$login = new Cs_Login;	// What is required to work with posts
$form = new Cs_Forms;

// -- END OF OBJECT FACTORY

$base->conBase();	// Connect to database

$ht->htmlStart();
	$ht->htmlHead();
	$ht->htmlMenu();
	echo "<div class=\"main\">";
		echo "<div class=\"content\">";
		$form->addFormStart('','post','registration_form');
			echo "<table>";				
				echo "<tr>";
					echo "<td>";
						echo "Username:";
					echo "</td>";
					echo "<td>";
						$form->addInput('text','username');
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td>";
					echo "Email:";
				echo "</td>";
				echo "<td>";
					$form->addInput('text','email');
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
						echo recaptcha_get_html($publickey);
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "&nbsp;";
					echo "</td>";
					echo "<td>";
						$form->addInput('submit','Register');
					echo "</td>";
				echo "</tr>";	
			echo "</table>";
		$form->addFormEnd();
		echo "</div>";
		echo "<div class=\"sidebar\">";
			echo "<img class=\"register_img\" src=\"Images/register.png\" alt=\"register\" />";
			echo (isset($_POST['username'])) ? $login->regUser($_POST['username'],$_POST['password'],$_POST['confirm_password'],$_POST['email']) : '';
		echo "</div>";
		$ht->cleaner();
	echo "</div>";
$ht->htmlEnd();

?>
