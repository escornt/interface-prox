<?php
session_start();
require_once(__DIR__ . "/../pve2_api.class.php");
$template = "ct_template-1.4.tar.gz";
$hostname = "10.100.1.19";
$user = "VM_DEPLOY";
$realm = "pve";
$password = "VKqdVZNHKyQD";

$_SESSION['ok-pass'] = 0;
$_SESSION['ok-log'] = 0;
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
$pve2 = new PVE2_API($hostname, $user, $realm, $password);
if ($pve2->login()) {
    $_SESSION['ok-log'] = 0;
    $nodes = $pve2->get_node_list();
    $first_node = $nodes[0];
    unset($nodes);
    /*$test = ($pve2->get_next_vmid());
    var_dump($test);*/
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
    $pve2->post("/nodes/".$first_node."/openvz", $new_container_settings);
    $current_status = ($pve2->get_vm_status($first_node, $_POST['ID']));
    var_dump($current_status['status']);*/
    $current_status = ($pve2->get_vm_status($first_node, "first".$_POST['ID']));
    $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/start");
    $current_status = ($pve2->get_vm_status($first_node, $_POST['ID']));
    $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/stop");
    $current_status = ($pve2->get_vm_status($first_node, $_POST['ID']));
    var_dump($current_status['status']);
} else {
    $_SESSION['ok-log'] = 1;
    header('Location: http://interface-prox.www.1001pneus.fr/view/config_vm.php');
    die();
}

//header('Location: http://interface-prox.www.1001pneus.fr/view/endconf.php');
?>
