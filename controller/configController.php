<?php
session_start();
require_once 'http://interface-prox.www.1001pneus.fr/pve2_api.class.php';
$hostname = "10.100.1.19";
$user = "VM_DEPLOY";
$realm = "Linux PAM standard authentication";
$password = "VKqdVZNHKyQD";

$_SESSION['ok-pass'] = 0;
if (empty($_POST['password']) || empty($_POST['conf-password']) || empty($_POST['ID']) || empty($_POST['nom_vm']) || empty($_POST['disk_size']) || empty($_POST['CPU']) || empty($_POST['RAM']) || empty($_POST['swap'])) {
  $_SESSION['ok-empty'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
  die();
}
$_SESSION['ok-empty'] = 0;
if ($_POST['password'] != $_POST['conf-password'] || strlen($_POST['password']) < 5) {
  $_SESSION['ok-pass'] = 1;
  header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
  die();
}
$_SESSION['ok-pass'] = 0;
$pve = new PVE2_API($hostname, $user, $realm, $password);
if ($pve2->login()) {
    foreach ($pve2->get_node_list() as $node_name) {
        print_r($pve2->get("/nodes/".$node_name."/status"));
    }
} else {
    print("Login to Proxmox Host failed.\n");
}
//header('Location: http://interface-prox.www.1001pneus.fr/view/endconf.php');
?>
