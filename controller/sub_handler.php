<?php
session_start();

/*Start connection LDAP*/
/*Do Authentication*/
/*Test Result*/
if (strcmp($_POST["user"], "OK") != 0  || strcmp($_POST["pswd"], "OK") != 0)
{
  $_SESSION['logstate'] = 1;
  include_once('view/login.php');
}
include_once('view/login');
?>
