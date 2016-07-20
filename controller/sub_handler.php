<?php
if (strcmp($_POST["user"], "OK") == 0  && strcmp($_POST["pswd"], "OK") == 0)
{
print("Coucou");
}
else {
  print("Pas coucou");
}
  die;
  header('Location: http://google.fr');
?>
