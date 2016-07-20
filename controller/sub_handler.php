<?php
if ($_POST["user"] == "OK" && $_POST["pswd"] == "OK")
{
print("Coucou");
}
else {
  print("Pas coucou");
}
  die;
  header('Location: http://google.fr');
?>
