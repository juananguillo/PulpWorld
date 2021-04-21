<?php 
$usu="Juan";
$email="juananguillo@gmail.com";
$contra="123456";
$hash="1234";
$to      = $email; 
$subject = 'Activar cuenta en PulpWorld'; 
$message = '
 
Gracias por registrarte!
Tu cuenta ha sido creada con exito, para activarla haz click en el enlace.
 
------------------------
Usuario: '.$usu.'
Contraseña: '.$contra.'
------------------------
 
Activar cuenta:
http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'
 
'; 
$headers = 'From:pulpworld@gmail.com' . "\r\n"; // Set from headers
mail($to, $subject, $message, $headers); // Send our email
?>