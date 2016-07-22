<?php
session_start();

$server = "10.100.1.18:389";
$Infos = array();
$InfosDroits = array();
$result = Connect($_POST["user"], $_POST["pswd"], $Infos, $InfosDroits, $server);
if ($result == false || empty($_POST['user']) || empty($_POST['pswd'])){
  $_SESSION['substate'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
}
else {
  $_SESSION['substate'] = 0;
  echo "OK";
}
die();

function Connect($Login, $Pass, &$Infos, &$InfosDroits, $server) {

  if (!ConnectToDomain($Login, $Pass, $Infos, $InfosDroits, $server)) {
    return false;
  }
  return true;
}

function ConnectToDomain($_Login, $Pass, &$Infos, &$InfosDroits, $server) {

  /* Initialisation de la connexion */
  $loginInfo=explode('@',$_Login);
  $Login = trim($loginInfo[0]);
  $sm1001 = trim($loginInfo[1]);

  $dn = "DC=1001pneus,DC=local";
  $ds = ldap_connect($server);
  ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
  ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  $r = @ldap_bind($ds, "$Login@1001PNEUS.LOCAL", "$Pass");
  if ($r) {
    $Infos = LoadInfosFromDomaine($ds, $Login);
    $Infos[TypeConnexion] = "Domaine";
    $InfosDroits = InitializeDroitsFromDom($ds);
    return (true);
  }
  return false;
}

function LoadInfosFromDomaine($ds, $login) {
  $dn = "DC=1001pneus,DC=local";
  $filter = "(&(&(&(objectCategory=person)(objectClass=user))))";
  $search = @ldap_search($ds, $dn, $filter) or die("ldap search failed");
  $entries = ldap_get_entries($ds, $search);

  foreach ($entries as $user) {
    if ($user[samaccountname][0] == $login) {
      return($user);
    }
  }
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

function SetDroitsFromDomInfos($a, &$droits) {


  unset($a[count]);
  foreach ($a as $d) {
    if (preg_match("/CN=intranet_(.*),CN=Users*/", $d, $m)) {
      $droits[$m[1]] = true;
    }
  }


  if ($droits[admin] == true) {
    foreach ($droits as $k => $v)
      $droits[$k] = true;
    unset($droits[root]);
  }
  if ($droits[root] == true) {
    foreach ($droits as $k => $v)
      $droits[$k] = true;
  }
}

function SetDroits($droits) {
  global $_DROITS;
  $droits = unserialize($droits);
  if ($droits[admin] == true) {
    foreach ($_DROITS as $k => $v)
      $droits[$v] = true;
    unset($droits[root]);
  }
  if ($droits[root] == true) {
    foreach ($_DROITS as $k => $v)
      $droits[$v] = true;
  }
  return $droits;
}

?>
