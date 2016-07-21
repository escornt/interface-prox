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
$ds=ldap_connect("10.100.1.18:389");
$r=ldap_bind($ds, $_POST['user'] ."@1001PNEUS.LOCAL", $_POST['pswd']);
if ($r == false || empty($_POST['user']) || empty($_POST['pswd'])){
  $_SESSION['substate'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
}
else {
  $_SESSION['logstate'] = 0;

  print_r(InitializeDroitsFromDom($ds));
}

function InitializeDroitsFromDom($ds) {
  $droits = array();
  $dn = "DC=1001pneus,DC=local";
  $filter = "(&(&(&(objectClass=group))))";
  $search = @ldap_search($ds, $dn, $filter) or die("ldap search failed");
  $entries = ldap_get_entries($ds, $search);
  foreach ($entries as $e) {
    if (preg_match("/intranet_(.*)/", $e[cn][0], $m)) {
      $droits[$m[1]] = 0;
    }
  }
  return($droits);
}

?>
