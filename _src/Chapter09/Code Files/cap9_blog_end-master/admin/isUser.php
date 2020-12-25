<?php

function isUser ( $user, $password, $connection ) {
	
	if ($user=='' || $password=='') return false;

	$query = "SELECT id, username, password, type FROM `users` WHERE username = '$user'";
	$result = mysql_query ($query, $connection);
	$row = mysql_fetch_array ($result);
	$password_from_db = $row ['password'];
	unset($query);
	
	if ( $password_from_db == $password ) {
		return $row;
	} else return false;
}

?>