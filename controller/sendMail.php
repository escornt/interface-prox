<?php
session_start();

function sendmail () {
  $destination = $_SESSION['umail']."@1001pneus.fr";
  $sujet = "Création de CT terminée avec succès";
  $message_txt="Le conteneur a été créé avec succès.";
  $message_html = "<html><head></head><body>Le conteneur a été créé avec succès.</body></html>";

  if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
	   $passage_ligne = "\r\n";
  } else {
	   $passage_ligne = "\n";
  }

  $header = "From: \"ct-noreply\"<ct-noreply@1001pneus.fr>".$passage_ligne;
  $header .= "Reply-to: \"ct-noreply\" <ct-noreply@1001pneus.fr>".$passage_ligne;
  $header .= "MIME-Version: 1.0".$passage_ligne;
  $header .= "multipart/alternative".$passage_ligne;
  $boundary = "-----=".md5(rand());
  $boundary=\"$boundary\"".$passage_ligne;

  $message = $passage_ligne."--".$boundary.$passage_ligne;
  $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
  $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
  $message.= $passage_ligne.$message_txt.$passage_ligne;
  $message.= $passage_ligne."--".$boundary.$passage_ligne;
  $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
  $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
  $message.= $passage_ligne.$message_html.$passage_ligne;
  $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
  $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
  mail($destination,$sujet,$message,$header);

}

?>
