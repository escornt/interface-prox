<?php
session_start();
if ($_POST['password'] != $_POST['conf-password']) {
  $_SESSION['ok-pass'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
  die();
}
$_SESSION['ok-pass'] = 0;
echo 'bon pass';
// header('Location: http://interface-prox.www.1001pneus.fr/view/endconf.php');
?>
