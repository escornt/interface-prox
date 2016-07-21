<?php
session_start();

/*Start connection LDAP*/
/*Do Authentication*/
/*Test Result*/
if (strcmp($_POST["user"], "OK") != 0  || strcmp($_POST["pswd"], "OK") != 0)
{
  $_SESSION['logstate'] = 1;
}
else {
  $_SESSION['logstate'] = 0;
}
$file = $_SERVER['DOCUMENT_ROOT']."/view/login.html";
$doc = new DOMDocument();
$doc->loadHTMLFile($file);
?>
