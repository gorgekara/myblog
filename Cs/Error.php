<?php

class Cs_Error
{
	
	public function er404() {
		echo "Error 404! Page not found!";
	}

	public function erMod($value) {
		echo ($value == 'password_match') ? 'Passwords don\'t match! <br />' : '';
		echo ($value == 'email_fail') ? 'Incorrect format for email! <br />' : '';
	}


}

?>