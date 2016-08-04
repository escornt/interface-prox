<?php
session_start();

$_SESSION['ip'] = "10.100.4.".$_POST['ID'];
$_SESSION['nom_vm'] = $_POST['nom_vm'];
$_SESSION['ID'] = $_POST['ID'];

require_once(__DIR__ . "/../pve2_api.class.php");
require_once("./sendMail.php");
if ($_POST['template'] == 'par defaut') {
  $template = "ct_template-defaut-1.10.tar.gz";
} else {
  $template = "ct_template-mobile-1.1.tar.gz";
}
$tables = "Commandes_Suivi_Client Commandes_Suivis Affacturage_DemandeFinancement Affacturage Affacturage_Files Affacturage_Reincrement Commandes_Infos Suivi_Colis Suivi_Details Configuration_Transporteurs Fournisseur_Transporteurs station_montage_account Account Account_Addresses SuiviPrixConcurents Configuration_Marges Configuration_Marges_Prix_Fixes Configuration_Marges_Folders Configuration_Fournisseurs_Port  Configuration_Poids_Pneus Notation_Profil Notation_Profil_Commentaire SuiviPrixConcurents Catalogue_Vente Catalogue_Vente_Prix Catalogue_Prix_Revient Catalogue_Fournisseurs Catalogue_Vente_Flat Commandes Commandes_Produits i18n_values i18n_keys Catalogue_Sku Catalogue_Reference_EAN Catalogue_Fournisseurs_Jantes Stock EmplacementStock EmailingUsers Dedoublonnage_EAN";
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
    $new_container_settings = array();
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
      sleep(10);
      $current_status = ($pve2->get_vm_task_status($first_node, $task));
  }
  if ($current_status['exitstatus'] == 'OK') {
    $_SESSION['ok-creat'] = 0;

    // Demarage de la VM
    $task = $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/start");
    $current_status = ($pve2->get_vm_task_status($first_node, $task));
    while ($current_status['status'] == 'running') {
      sleep(10);
      $current_status = ($pve2->get_vm_task_status($first_node, $task));
    }

    $_SESSION['ID'] = $_POST['ID'];

    // Connection ssh, edit pour enable le NFS
    $connect = ssh2_connect($hostname, 22);
    ssh2_auth_password($connect, 'root', 'bbrother');
    $stream = ssh2_exec($connect, 'sh nfs.sh '.$_POST['ID']);
    $stream = ssh2_exec($connect, 'vzctl set '.$_POST['ID'].' --netif_add eth0,,,,vmbr0 --save');
    sleep(3);
    // reboot vm pour valider le NFS
    $task = $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/stop");
    $current_status = ($pve2->get_vm_task_status($first_node, $task));
    while ($current_status['status'] == 'running') {
      sleep(10);
      $current_status = ($pve2->get_vm_task_status($first_node, $task));
    }
    $task = $pve2->post("/nodes/".$first_node."/openvz/".$_POST['ID']."/status/start");
    $current_status = ($pve2->get_vm_task_status($first_node, $task));
    while ($current_status['status'] == 'running') {
      sleep(10);
      $current_status = ($pve2->get_vm_task_status($first_node, $task));
    }
    // Lancement du script de config dans la vm

    $stream = ssh2_exec($connect, 'vzctl exec '.$_POST['ID'].' sh /go.sh '.$_POST['ID'].' '.$_POST['nom_vm']);
    $stream = ssh2_exec($connect, 'vzctl exec '.$_POST['ID'].' update_dev.sh ' .$tables. '&');
    sendmail();
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
