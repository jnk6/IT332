<?php

include (	"account.php"	);
include (	"functions_inc.php"	);

($_GET["password"] == "SuperSecretPassword") or die ("Incorrect password. Please try again.");

( $dbh = mysql_connect ( $hostname, $username, $password ) )
	        or die ( "Unable to connect to MySQL database" );
//print "Connected to MySQL<br>";
mysql_select_db( $project );


$email = mysql_real_escape_string ($_GET["email"]);
echo "email is $email<br>";

$q="INSERT INTO emailList VALUES('$email')";
if (EMAIL_number($email) >0 )
{
	if (isset($_GET["removeMe"]))
	{
		$q = "DELETE FROM emailList WHERE email = '$email'";
		mysql_query($q);
		echo "email successfully deleted.";
	}
	
}
else
{
	mysql_query($q);
	echo "email successfully added.";
}

echo (mysql_error());
function EMAIL_number($e)
{
	
	$s ="select * from emailList where email = '$e'";
	return mysql_num_rows(mysql_query ($s));
	echo (mysql_error());
}