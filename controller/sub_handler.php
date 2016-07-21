<?php
session_start();

/*Start connection LDAP*/
/*Do Authentication*/
/*Test Result*/
/*if (strcmp($_POST["user"], "OK") != 0  || strcmp($_POST["pswd"], "OK") != 0)
{
  $_SESSION['logstate'] = 1;
}
else {
  $_SESSION['logstate'] = 0;
}*/
$ds=ldap_connect("10.100.1lol.18:389");
$r=ldap_bind($ds);
if ($r == false){
  $_SESSION['reach_serv'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
}
else {
  echo 'coucou';
}
?>
