<?php
session_start();

$Infos = array();
$InfosDroits = array();
$result = Connect($_POST["user"], $_POST["pswd"], $Infos, $InfosDroits);
if ($r == false || empty($_POST['user']) || empty($_POST['pswd'])){
  $_SESSION['substate'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
}
else {
  $_SESSION['substate'] = 0;
  echo "OK";
}
die();

  if (testDroits($droits)) {
      $_SESSION['droits'] = 0;
    echo "OK";
  }
  else {
    $_SESSION['droits'] = 1;
    //header('Location: http://interface-prox.www.1001pneus.fr/view/login.php');
  }
}

function testDroits($droits) {
  $test = false;
//  var_dump($droits);
//  die();
//  if ($droits[admin_it] == 1){
  //  $test = true;
  //}
  foreach ($droits as $key => $d) {
    echo "test";
    if ($d == 1){
      echo $key;
    }
    if (strcmp($key, 'admin_it') == 0) {
      $test = true;
    }
  }
  return ($test);
}

function Connect($Login, $Pass, &$Infos, &$InfosDroits) {

  if (!ConnectToDomain($Login, $Pass, $Infos, $InfosDroits)) {
    // print "Connexion au domaine impossible, tentative locale\n\n";
    //if (!ConnectLocaly($Login, $Pass, &$Infos, &$InfosDroits)) {
    //  return false;
    //}
    // print "Tentative locale OK\n";
    return false;
  }
  $loginInfo=explode('@',$Login);
  $L = trim($loginInfo[0]);
  SaveInfosLocaly($L, $Pass, $Infos, $InfosDroits);
  return true;
}

function ConnectToDomain($_Login, $Pass, &$Infos, &$InfosDroits) {

  /* Initialisation de la connexion */
  $loginInfo=explode('@',$_Login);
  $Login = trim($loginInfo[0]);
  $sm1001 = trim($loginInfo[1]);

  $dn = "DC=1001pneus,DC=local";
  // Recherche du 1er serveur dispo
  foreach(explode(" ",LDAP_SERVERS) as $ldapServer)
  {
      list($serverName, $serverPort) = explode(":",$ldapServer);
      $ds = ldap_connect($serverName,$serverPort);
      ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
      ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      $r = @ldap_bind($ds, "$Login@1001PNEUS.LOCAL", "$Pass");
      // Serveur trouvé
      if($r)
      {
        $Infos = LoadInfosFromDomaine($ds, $Login);
        $Infos[TypeConnexion] = "Domaine";
        $InfosDroits = InitializeDroitsFromDom($ds);
        if ($sm1001){
          $q = "select * from station_montage where Id1001 ='" . $sm1001 . "'";
          $rsm = query($q);
          $_SESSION[User][sm] =  mysql_fetch_array($rsm[res],MYSQLI_ASSOC);
        }
        return true;
      }
  }
  return false;
}

function ConnectLocaly($Login, $Pass,&$Infos, &$InfosDroits) {
  $q = "SELECT * FROM Configuration_AdminUsers WHERE Username='$Login' AND Password='" . md5($Pass) . "'";
  $res = query($q);
  if (!mysql_num_rows($res[res]))
    return false;
  $r = mysql_fetch_array($res[res]);
  $Infos = unserialize(base64_decode($r[InfosDom]));
  $InfosDroits = unserialize(base64_decode($r[InfosDroits]));
  $Infos[TypeConnexion] = "Locale";
  return true;
}

function SaveInfosLocaly($Login, $Pass, &$Infos, &$InfosDroits) {
  $q = "SELECT * FROM Configuration_AdminUsers WHERE Username='$Login' AND Password='" . md5($Pass) . "'";
  $res = query($q);
  if (!mysql_num_rows($res[res])) {
    $q2 = "SELECT * FROM Configuration_AdminUsers WHERE Username='$Login'";
    $res2 = query($q2);
    if (!mysql_num_rows($res2[res])) {
      $q = "INSERT INTO  `Configuration_AdminUsers` (
				`Id` ,`UserName` ,`Password` ,`InfosDom`,`InfosDroits`,`NomVisible`, `SipUser`, `SipNumber`
			) VALUES (
				NULL ,  '$Login',  '" . md5($Pass) . "', '" . base64_encode(serialize($Infos)) . "','" . base64_encode(serialize($InfosDroits)) . "','" . $Infos[cn][0] . "','" . $Infos['pager'][0] . "','" . $Infos[ipphone][0] . "');";
      $res = query($q);
      $Infos[User][Id] = $res[id];
    } else {
      $r2 = mysql_fetch_array($res2[res]);
      $Infos[User][Id] = $r2[Id];
      $_SESSION[User][RemiseMax] = $r2[RemiseMax];
      $_SESSION[User][RemiseMaxPresta] = $r2[RemiseMaxPresta];
    }
  }else{
    $r = mysql_fetch_array($res[res]);
    $_SESSION[User][RemiseMax] = $r[RemiseMax];
    $_SESSION[User][RemiseMaxPresta] = $r[RemiseMaxPresta];
    $Infos[User][Id] = $r[Id];

  }
  $q = "UPDATE `Configuration_AdminUsers` SET Password='" . md5($Pass) . "',InfosDom='" . base64_encode(serialize($Infos)) . "',InfosDroits='" . base64_encode(serialize($InfosDroits)) . "',`NomVisible`='" . $Infos[cn][0] . "',`SipUser`='" . $Infos[pager][0] . "',`SipNumber`='" . $Infos[ipphone][0] . "' WHERE UserName='$Login'";
  query($q);
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
