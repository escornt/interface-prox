<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:25
 */

/*Inclusion des outils 1001Pneus*/
require_once(BASEDIR . "../FrontOffice/current/include/functions.inc.php");
require_once(BASEDIR . "../BackOfficev2/include/shared/mEUPCacheController.class.php");
require_once(BASEDIR . "../BackOfficev2/include/shared/mEUPTools.inc.php");
require_once(BASEDIR . "../BackOfficev2/include/shared/mEUPSql.class.php");
require_once(BASEDIR . "../BackOfficev2/include/shared/class/ExpeditionChargerAdapter/class/EtiquettePneu.class.php");
require_once(BASEDIR . "../BackOfficev2/include/droits.inc.php");
require_once(BASEDIR . "../Scriptsv2/Include/1001pneus/mEUPScriptTools.class.php");



/*Inclusion des controlleurs de l'application*/
require_once(BASEDIR."controller/global_Controller.php");
require_once(BASEDIR."controller/home_Controller.php");
require_once(BASEDIR."controller/login_Controller.php");
require_once(BASEDIR."controller/scan_Controller.php");
require_once(BASEDIR."controller/ajax_Controller.php");
require_once(BASEDIR."controller/history_Controller.php");

/*Inclusion des modèles de l'application*/
require_once(BASEDIR."model/global_Model.php");
require_once(BASEDIR."model/tyre_Model.php");
require_once(BASEDIR."model/historique_Model.php");
require_once(BASEDIR."model/file_Model.php");
require_once(BASEDIR."model/goodies_Model.php");

/*Inclusion des helpers de l'application*/
require_once(BASEDIR."helper/global_Helper.php");
require_once(BASEDIR."helper/print_Helper.php");