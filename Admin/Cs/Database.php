<?php

class Cs_Database
{
	
	public function conBase() {
		require "../../../db.inc";	// Information for database connection
		$con = mysql_connect($dbplace,$dbuser,$dbpass);
		mysql_select_db("cmsbase",$con);
	}

	public function getCategories() {
		$query = mysql_query("SELECT * FROM categories") or die("Custom error!");
		while($q = mysql_fetch_array($query)) {
			return $q;
		}
	}

}

?>
