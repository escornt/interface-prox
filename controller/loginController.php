<?php
session_start();

require_once(__DIR__ . "/../pve2_api.class.php");


//variables login proxmox

$hostname = "10.100.1.19";
$user = "VM_DEPLOY";
$realm = "pve";
$password = "VKqdVZNHKyQD";

//variables login ldap

$server = "10.100.1.18:389";
$droit_acces = 'admin_it';
$Infos = array();
$InfosDroits = array();

//connection ldap

$result = Connect($_POST["user"], $_POST["pswd"], $Infos, $InfosDroits, $server);
if ($result == false) {
  $_SESSION['substate'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
  die ();
} else {

  //Connection reussie, check des droits

$_SESSION['substate'] = 0; }
SetDroitsFromDomInfos($Infos["memberof"], $InfosDroits);
foreach ($InfosDroits as $key => $a) {
  if ($key == $droit_acces && $a == true) {
    $_SESSION['droits'] = 0;

    //Droits OK, connexion serveur proxmox

    $pve2 = new PVE2_API($hostname, $user, $realm, $password);
    if ($pve2->login()) {
        $_SESSION['ok-log'] = 0;
      } else {
        $_SESSION['ok-log'] = 1;
        header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
        die ();
      }
    $_SESSION['lastID'] = $pve2->get_next_vmid();
    header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
    die ();
    }
  }
$_SESSION['droits'] = 1;
header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
die ();



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
  if ($r && !empty($_POST['user']) && !empty($_POST['pswd'])) {
    $Infos = LoadInfosFromDomaine($ds, $Login);
    $Infos[TypeConnexion] = "Domaine";
    $InfoDroits = InitializeDroitsFromDom($ds);
    return true;
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
      return $user;
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
  return $droits;
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
