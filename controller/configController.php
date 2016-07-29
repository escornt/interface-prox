<?php
session_start();
require_once(__DIR__ . "/../pve2_api.class.php");
$template = "ct_template-1.5.tar.gz";
$hostname = "10.100.1.19";
$user = "VM_DEPLOY";
$realm = "pve";
$password = "VKqdVZNHKyQD";

$_SESSION['ok-pass'] = 0;
$_SESSION['ok-log'] = 0;
// Check des entrees vides
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
// Connection proxmox
$pve2 = new PVE2_API($hostname, $user, $realm, $password);
if ($pve2->login()) {
    $_SESSION['ok-log'] = 0;
    $nodes = $pve2->get_node_list();
    $first_node = $nodes[0];
    unset($nodes);
    // test si la VM existe deja
    $test = $pve2->get_vm_status($first_node, $_POST['ID']);
    if ($test) {
      $_SESSION['ok-exist'] = 1;
      header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
      die();
    }
    $_SESSION['ok-exist'] = 0;
    // Creation de la VM
    /*$new_container_settings = array();
    $new_container_settings['ostemplate'] = "local:vztmpl/" . $template;
    $new_container_settings['vmid'] = $_POST['ID'];
    $new_container_settings['cpus'] = $_POST['CPU'];
    $new_container_settings['description'] = $_POST['description'];
    $new_container_settings['disk'] = $_POST['disk_size'];
    $new_container_settings['hostname'] = $_POST['nom_vm'];
    $new_container_settings['memory'] = $_POST['RAM'];
    $new_container_settings['swap'] = $_POST['swap'];
    $new_container_settings['password'] = $_POST['password'];
    $new_container_settings['storage'] = "NFS";
    $task = $pve2->post("/nodes/".$first_node."/openvz", $new_container_settings);
    $current_status = ($pve2->get_vm_task_status($first_node, $task));
    // Attend la fin de la phase de creation pout continuer et check si fail
    while ($current_status['status'] == 'running') {
      sleep(20);
      $current_status = ($pve2->get_vm_task_status($first_node, $task));
  }
  if ($current_status['exitstatus'] == 'OK') {
    $_SESSION['ok-creat'] = 0;
    // Demarage de la VM
    $task = $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/start");*/
    $_SESSION['ID'] = $_POST['ID'];
    $connect = ssh2_connect($hostname, 22);
    ssh2_auth_password($connect, 'root', 'bbrother');
    $stream = ssh2_exec($connect, 'mkdir testerino');
    header('Location: http://interface-prox.www.1001pneus.fr/view/endconf.php');
    die();
  } else {
    $_SESSION['ok-creat'] = 1;
    header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
    die();
  }
} else {
    $_SESSION['ok-log'] = 1;
    header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
    die();
}

?>
