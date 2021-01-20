<?php



// Define some constants

define("RECIPIENT_NAME", "Estelle Rose");
define("RECIPIENT_EMAIL", "contact.aranea@gmail.com");



// Read the form values

$success = false;
$name = isset($_POST['nom']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['nom']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$objet = isset($_POST['objet']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['objet']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Objet:|Content-Type:)/", "", $_POST['message']) : "";

$mail_objet = 'Un message de  ' . $name;
$body = 'Name: ' . $name .  "\r\n";
$body .= 'Email: ' . $senderEmail . "\r\n";

if ($objet) {
  $body .= 'objet: ' . $objet . "\r\n";
}


$body .= 'message: ' . "\r\n" . $message;

// If all values exist, send the email

if ($name  && $senderEmail && $message) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $name . " <" . $senderEmail . ">";
  $success = mail($recipient, $mail_objet, $body, $headers);
  echo "<div class='inner success '><p class='success'>Merci de nous avoir contacter, nous vous répondrons très bientôt !</p></div><!-- /.inner -->";

} else {
  echo "<div class='inner error'><p class='error'>Something went wrong. Please try again.</p></div><!-- /.inner -->";

}

