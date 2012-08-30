<?php

class Cs_Session
{
	
	public function sesCheck($sesvar) {
		if(isset($_SESSION[$sesvar])) {
			// Do nothing
		}	
		else {
			header("Location: index.php");
		}
	}

}

?>