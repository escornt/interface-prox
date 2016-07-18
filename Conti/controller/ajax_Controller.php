<?php

/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */
class ajax_Controller extends global_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_controller = "ajax";
    }

    public function loadAction($actionName)
    {
        $this->_action = $actionName;
        $action = $this->_action . "Action";

        $this->$action();
    }

    public function submitAction()
    {
        $return = array();
        $return["critical-message"] = null;

        if ($_SESSION["currentProduct"]["order"]) {
            $printingResult = print_Helper::managePrintingElement();
            if ($printingResult["critical-message"]) {
                $return["critical-message"] = $printingResult["critical-message"];
            }
            unset($_SESSION["currentProduct"]);
        }

        if ($_POST["sku"]) {
            $sku = $_POST["sku"];
            $order = tyre_Model::getOrderInformations($sku, FOURNISSEUR_ID, PAYS_ID);
        } else if ($_POST["ean"]) {
            $ean = $_POST["ean"];
            $order = tyre_Model::getOrderInformationsByEan($ean, FOURNISSEUR_ID, PAYS_ID);
        }

        if ($order && count($return["critical-message"]) == 0) {
            $fournisseur = mEUPTools::getFournisseurByCountry(FOURNISSEUR_ID, PAYS_ID);

            preg_match("/^(2R-)(.*)/", $order[0]['Type'], $typeMatch);
            /* Gestion du colisage - Cas ou la taille des colis est defini pour le fournisseur */
            if (defined('FORCED_COLIS_SIZE')) {
                $pneusDansColis = FORCED_COLIS_SIZE;
                /* Gestion du colisage - Cas ou il s'agit de pneu moto*/
            } else if (count($typeMatch) == 3 && ($order[0]["pneusAColiser"] - $order[0]["pneusColises"]) == 1) {
                /*1 - Je cherche si il y à d'autres pneus moto du même fournisseurs dans la commande*/
                $query = "SELECT fcpl.*
                FROM Commandes_Produits cp
                JOIN Catalogue_Vente_Flat cvf ON cvf.Sku =cp.sku
                JOIN Commandes c ON c.Commande_Id = cp.Commande_Id
                JOIN Fournisseur_Colis_Preparation_List fcpl ON fcpl.commandeProduitId = cp.Commande_Produits_Id
                WHERE cp.Commande_Id = '" . $order[0]["Commande_Id"] . "'
                AND cp.Fournisseur_Id ='" . FOURNISSEUR_ID . "'
                AND cvf.Pays_Id = c.Pays_Id
                AND cp.Commande_Produits_Id !='" . $order[0]["commandeProduitId"] . "'
                AND cp.Etat_Commande_Fournisseur = 'EFFECTUEE'";
                $resultOtherColis = mEUPSql2::Query($query);

                /*2 - Si il y en à je vérifie que je ne l'ai pas déja flaggé*/
                if ($resultOtherColis['count'] > 0) {
                    $toflag = false;
                    $tosendAlone = true;
                    foreach ($resultOtherColis[results] as $otherProduct) {
                        if (($otherProduct[pneusAColiser] - $otherProduct[pneusColises])%2 == 1) {
                            $tosendAlone = false;
                            $query = "SELECT * FROM Fournisseur_Colis_Preparation_Labels fcpla
                            JOIN Fournisseur_Colis_Preparation_List fcpl ON fcpla.CommandeProduitId = fcpl.commandeProduitId
                            WHERE fcpla.CommandeProduitId =" .$otherProduct[commandeProduitId];
                            $resultLabel = mEUPSql2::Query($query);
                            /* 6 - Si je l'ai déja flaggé*/
                            if ($resultLabel['count'] > 0) {
                                $labelNumber = $resultLabel[results][0][LabelNumber];
                                $this->_templatesParameters["labelToGet"] = $labelNumber;
                                $_SESSION["currentProduct"]["labelToGet"] = $labelNumber;
                                $_SESSION["currentProduct"]["labelcmdlinked"] = $resultLabel[results][0][CommandeProduitId];
                                $pneusDansColis = (($order[0]["pneusAColiser"] - $order[0]["pneusColises"]) + ($otherProduct[pneusAColiser] - $otherProduct[pneusColises]));
                                if ($pneusDansColis == 2 && goodies_Model::isGoodiesEligible($order[0]) && goodies_Model::isGoodiesEligible($resultLabel[results][0])){
                                    $this->_templatesParameters["goodies"] = true;
                                }

                                $toflag = false;
                                break;
                            } else { /*3 - Si je ne l'ai pas flagué*/
                                $toflag = true;
                            }
                        }
                    }
                    if($toflag == true){
                        $labelNumber = tyre_Model::getNewInsertedLabelNumber();
                        $query = "INSERT INTO Fournisseur_Colis_Preparation_Labels(CommandeProduitId,LabelNumber) VALUES (" . $order[0]["commandeProduitId"] . "," . $labelNumber . ")";
                        mEUPSql2::Query($query);
                        $pneusDansColis = 0;
                        $this->_templatesParameters["labelToStick"] = $labelNumber;
                        $_SESSION["currentProduct"]["labelToStick"] = $labelNumber;
                    }
                    if ($tosendAlone == true) {
                        $pneusDansColis = tyre_Model::getColisage($fournisseur, $order);
                        if ($pneusDansColis == 2 && goodies_Model::isGoodiesEligible($order[0])){
                            $this->_templatesParameters["goodies"] = true;
                        }
                    }

                }else {/*9 - Si il n'y en à pas  PROCESS STANDARD*/
                    $pneusDansColis = tyre_Model::getColisage($fournisseur, $order);
                    if ($pneusDansColis == 2 && goodies_Model::isGoodiesEligible($order[0])){
                        $this->_templatesParameters["goodies"] = true;
                    }
                }
            } else if (count($typeMatch) == 3) {
                $pneusDansColis = tyre_Model::getColisage($fournisseur, $order);
                if ($pneusDansColis == 2 && goodies_Model::isGoodiesEligible($order[0])){
                    $this->_templatesParameters["goodies"] = true;
                }
            } /* Gestion du colisage - Cas ou il s'agit de pneu Tournisme */
            else {
                $pneusDansColis = tyre_Model::getColisage($fournisseur, $order);
            }

            if ($order[0]['toPrint'] == '0') {
                tyre_Model::updateToPrintpackageLine($order[0], $pneusDansColis);
            }

            $_SESSION["currentProduct"]["nbPneus"] = $pneusDansColis;
            $_SESSION["currentProduct"]["order"] = $order[0];

            /*Récupération du résultat du scan*/
            $this->_templatesParameters["order"] = $order;
            $this->_templatesParameters["pneusDansColis"] = $pneusDansColis;
            $return["scan-result"] = $this->loadView("ajax/scanResultSuccess");
        } else {
            $this->_templatesParameters["labelToStick"] = 2;
            $return["scan-result"] = $this->loadView("ajax/scanResultFailure");
        }

        /*Récupération des pneus en attente*/
        $list = tyre_Model::getWaitedTyres(FOURNISSEUR_ID, PAYS_ID);
        $this->_templatesParameters["ListTyres"] = $list;
        $return["waited-tyres"] = $this->loadView("ajax/waitedTyres");

        /*Récupération de l'historique*/
        $this->_templatesParameters["history"] = historique_Model::getDailyHistorique(date("Y-m-d"), FOURNISSEUR_ID, PAYS_ID);
        $return["historique"] = $this->loadView("scan/historyView");

        echo json_encode($return);
        die();

    }

    public function loginAction()
    {
        $Infos = array();
        $InfosDroits = array();
        $valid = true;
        $result = Connect($_POST["userName"], $_POST["password"], $Infos, $InfosDroits);

        if ($result) {
            SetDroitsFromDomInfos($Infos["memberof"], $InfosDroits);
            $_SESSION["User"]["Id"] = $Infos["User"]["Id"];
            $_SESSION["User"]["Droits"] = array_filter($InfosDroits);
            $_SESSION["User"]["NomVisible"] = $Infos["cn"]["0"];
            $_SESSION["User"]["Logged"] = "true";
        } else {
            $q = "SELECT * FROM Configuration_AdminUsers WHERE Username='" . $_POST["userName"] . "' AND Password='" . $_POST["password"] . "'";
            $res = query($q);
            if (!mysql_num_rows($res["res"])) {
                $valid = false;
            } else {
                $r = mysql_fetch_object($res["res"]);
                $_SESSION["User"]["Id"] = $r->Id;
                $_SESSION["User"]["NomVisible"] = $r->NomVisible;
                $_SESSION["User"]["Droits"] = SetDroits($r->Droits);
                $_SESSION["User"]["Logged"] = "true";
            }
        }
        if ($valid) {
            if ($_SESSION["User"]["Droits"]['ExtranetFournisseur']) {
                /* Redirection du navigateur */
                $connexion["status"] = "OK";
                $connexion["url"] = "http://" . $_SERVER["HTTP_HOST"];
            } else {
                $connexion["status"] = "KO";
                $connexion["message"] = LANG_DROITS;
            }
        } else {
            $connexion["status"] = "KO";
            $connexion["message"] = LANG_MAUVAIS_IDENTIFIANTS;
        }
        echo json_encode($connexion);
        die();

    }

    public function printAction()
    {
        if ($_POST["histoId"]) {
            $histoId = $_POST["histoId"];
        }
        $historyInfo = historique_Model::getHistoLineById($histoId);


        $packageInfo = tyre_Model::getPackageById($historyInfo['fournisseur_colis_preparation_id']);
        $singlePrintResult = file_Model::printSingleEtiquette($packageInfo['commandeProduitId'], $historyInfo['qte_pneus']);

        if ($singlePrintResult) {
            $message = LANG_REIMPRESSION_POUR . $historyInfo["message"];
        } else {

        }

        historique_Model::insertHistoLine($message, "INFO", FOURNISSEUR_ID);

        /* Récupération de l'historique */
        $this->_templatesParameters["history"] = historique_Model::getDailyHistorique(date("Y-m-d"), FOURNISSEUR_ID, PAYS_ID);
        $return["historique"] = $this->loadView("scan/historyView");
        //echo json_encode($return);
        die();
    }

    public function seeAdressAction()
    {
        if ($_POST["histoId"]) {
            $histoId = $_POST["histoId"];
        }
        $historyInfo = historique_Model::getHistoLineById($histoId);
        $packageInfo = tyre_Model::getPackageById($historyInfo['fournisseur_colis_preparation_id']);

        $adressInfo = tyre_Model::getPackageAdresseInfo($packageInfo["commandeProduitId"]);


        $this->_templatesParameters["adressInfo"] = $adressInfo;
        $return["adressInfo"] = $this->loadView("ajax/adressInfo");

        /*Récupération de l'historique*/
        $this->_templatesParameters["history"] = historique_Model::getDailyHistorique(date("Y-m-d"), FOURNISSEUR_ID, PAYS_ID);
        $return["historique"] = $this->loadView("scan/historyView");

        echo json_encode($return);
        die();
    }
}