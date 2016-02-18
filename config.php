<?php
// Configuration file

//MySQL connection
$DB_username = ""; //	username for database here
$DB_password = ""; //	password for database here
$DB_name =  "";	   //	name of database here

$mysql_link = mysql_pconnect( "localhost", "$DB_username", "$DB_password")
	or die( "Unable to connect to MySQL server");
mysql_select_db( "$DB_name") 
	or die( "It's connecting to the MySQL server, but unable to select database");
?>