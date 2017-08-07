<?php

$message = "Your password reset link send to your e-mail address.";
$to='007amarpandey@gmail.com';
$subject="Forget Password";
$from = 'safsinfo@digicubesolution.com';
$body='Hi';
$headers = "From: " . strip_tags($from) . "\r\n";
$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
mail($to,$subject,$body,$headers);

?>