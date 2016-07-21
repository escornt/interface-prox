<?php
session_start();

$ldap_address = "10.100.1.18:389";


$ds=ldap_connect($ldap_address);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
$r=ldap_bind($ds, $_POST['user'] ."@1001PNEUS.LOCAL", $_POST['pswd']);
if ($r == false || empty($_POST['user']) || empty($_POST['pswd'])){
  $_SESSION['substate'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
}
else {
  $_SESSION['substate'] = 0;

  var_dump(LoadInfosFromDomaine($ds));
}

function LoadInfosFromDomaine($ds) {
  $dn = "DC=1001pneus,DC=local";
  $filter = "(&(&(&(objectCategory=droits)(objectClass=user))))";
  $search = ldap_search($ds, $dn, $filter) or die("ldap search failed");
  $entries = ldap_get_entries($ds, $search);
return ($entries);
}

function InitializeDroitsFromDom($ds) {
  $droits = array();
  $dn = "DC=1001pneus,DC=local";
  $filter = "(&(&(&(objectClass=group))))";
  $search = ldap_search($ds, $dn, $filter) or die("ldap search failed");
  $entries = ldap_get_entries($ds, $search);
  foreach ($entries as $e) {
    if (preg_match("/intranet_(.*)/", $e[cn][0], $m)) {
      $droits[$m[1]] = 0;
    }
  }
  return($droits);
}

?>
