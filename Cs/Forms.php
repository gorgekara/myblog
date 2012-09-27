<?php

class Cs_Forms
{
	public function addFormStart($action,$method,$class) {
		echo "<form action=\"" .$action. "\" method=\"" .$method. "\" class=\"" .$class. "\">";
	}

	public function addFormEnd() {
		echo "</form>";
	}

	// Function for adding submit, textarea and text input fields
	public function addInput($type,$iname) {
		if($type == "submit") {
			echo "<input type=\"" .$type. "\" class=\"submit_button\" value=\"" .ucfirst($iname). "\" /> <br />";
		}
		else if($type == "textarea") {
			echo "<textarea name=\"" .$iname. "\"></textarea> <br />";
		}
		else {
			echo "<input type=\"" .$type. "\" name=\"".$iname. "\" /> <br />";
		}
	}

	public function addInputValue($type,$iname,$value) {
		if($type == "submit") {
			echo "<input type=\"" .$type. "\" class=\"submit_button\" value=\"" .ucfirst($iname). "\" /> <br />";
		}
		else if($type == "textarea") {
			echo "<textarea name=\"" .$iname. "\" cols=\"100%\">" .$value. "</textarea> <br />";
		}
		else if($type == "hidden") {
			echo "<input type=\"" .$type. "\" name=\"".$iname. "\" value=\"" .$value. "\"/>";
		}
		else {
			echo "<input type=\"" .$type. "\" name=\"".$iname. "\" value=\"" .$value. "\"/> <br />";
		}
	}

	public function addInputPlace($type,$iname,$place) {
		if($type == "submit") {
			echo "<input type=\"" .$type. "\" class=\"submit_button\" value=\"" .ucfirst($place). "\" /> <br />";
		}
		else if($type == "textarea") {
			echo "<textarea placeholder=\"" .$place. "\" name=\"" .$iname. "\" cols=\"100%\"></textarea> <br />";
		}
		else {
			echo "<input type=\"" .$type. "\" name=\"".$iname. "\" placeholder=\"" .$place. "\"/> <br />";
		}
	}

	// Function for starting Select field
	public function addSelectStart($name,$class) {
		echo "<select name=\"" .$name. "\" class=\"" .$class. "\">";
	}

	// Function for adding options to started Select field
	public function addSelectOption($value,$visible,$bool) {
		if($bool == "true") {
			echo "<option selected=\"true\" value=\"" .$value. "\">" .$visible. "</option>";
		}
		else if($bool == "false") {
			echo "<option value=\"" .$value. "\">" .$visible. "</option>";
		}
		
	}

	// Function for ending Select field
	public function addSelectEnd() {
		echo "</select> <br />";
	}
}

?>