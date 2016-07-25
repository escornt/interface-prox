<?php
session_start();

if (empty($_POST['password']) || empty($_POST['conf-password']) || empty($_POST['ID']) || empty($_POST['nom_vm']) || empty($_POST['disk_size']) || empty($_POST['CPU']) || empty($_POST['RAM']) || empty($_POST['swap'])) {
  $_SESSION['ok-empty'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
  die();
}

if ($_POST['password'] != $_POST['conf-password'] || strlen($_POST['password']) < 5) {
  $_SESSION['ok-pass'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
  die();
}


$_SESSION['ok-pass'] = 0;
$_SESSION['ok-empty'] = 0;
header('Location: http://interface-prox.www.1001pneus.fr/view/endconf.php');
?>
