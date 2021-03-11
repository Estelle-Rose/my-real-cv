<?php



// Define some constants


$from = 'info@estelle-rose.fr';
$sendTo = 'contact.aranea@gmail.com';


// message that will be displayed when everything is OK :)
$okMessage = 'Votre pigeon voyageur est en chemin, à bientôt';

// If something goes wrong, we will display this message.
$errorMessage = 'Il y a eu une erreur lors de l\'envol du pigeon voyageur, merci de réessayer ultérieurement';

// Read the form values


$name = isset($_POST['nom']) ? preg_replace("/[^\.\-\' A-zÀ-ú0-9]/", "", $_POST['nom']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$objet = isset($_POST['objet']) ? preg_replace("/[^\.\-\' A-zÀ-ú0-9]/", "", $_POST['objet']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Objet:|Content-Type:)/", "", $_POST['message']) : "";

$mail_objet = 'Un message de  ' . $name;
$body = 'Nom: ' . $name .  "\r\n";
$body .= 'Email: ' . $senderEmail . "\r\n";

if ($objet) {
  $body .= 'Objet: ' . $objet . "\r\n";
}


$body .= 'Message: ' . "\r\n" . $message;

// If all values exist, send the email
try {
  if ($name  && $senderEmail && $message) {
  
  // All the necessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from ,
        'Reply-To: ' . $senderEmail,        
        'Return-Path: ' . $from,
    );

  // send email
  mail($sendTo, $mail_objet, $body, implode("\n", $headers));
  $responseArray = array('type' => 'success', 'message' => $okMessage);
  //echo "<div class='inner success '><p class='success'>Merci de nous avoir contacter, nous vous répondrons très bientôt !</p></div><!-- /.inner -->";

} 
}
catch (\Exception $e) {
  $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}



// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}