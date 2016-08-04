<?php
session_start();

function sendmail () {
  $destination = $_SESSION['umail']."@1001pneus.fr";
  $sujet = "Création de CT terminée avec succès";

  if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
	   $passage_ligne = "\r\n";
  } else {
	   $passage_ligne = "\n";
  }

  $header = "From: \"ct-noreply\"<ct-noreply@1001pneus.fr>".$passage_ligne;
  $header .= "Reply-to: \"ct-noreply\" <ct-noreply@1001pneus.fr>".$passage_ligne;
  $header .= "MIME-Version: 1.0".$passage_ligne;
  $header .= "Delivered-to: ".$destination.$passage_ligne;

  $message = "La ct ".$_SESSION['ID']." est maintenant utilisable.";

  mail($destination,$sujet,$message,$header);

}

?>
