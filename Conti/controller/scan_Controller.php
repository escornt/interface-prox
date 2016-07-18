<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */

class scan_Controller extends global_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_controller = "scan";
    }

    public function loadAction($actionName)
    {
        $this->_action = $actionName;
        $action = $this->_action . "Action";
        $this->$action();
    }

    public function indexAction()
    {
        $list = tyre_Model::getWaitedTyres(FOURNISSEUR_ID,PAYS_ID);
        $this->_templatesParameters["Tyres"] = $list;
        $historique = historique_Model::getDailyHistorique(date("Y-m-d"),FOURNISSEUR_ID,PAYS_ID);

        $this->_templatesParameters["history"] = $historique;
        if($_SESSION["critical-message"]){
            $this->_templatesParameters["critical-message"] = $_SESSION["critical-message"];
            unset($_SESSION["critical-message"]);
        }
        unset($_SESSION["currentProduct"]);
    }

    public function pauseAction(){

        $message = LANG_PAUSE_COLISAGE;
        historique_Model::insertHistoLine($message,"INFO",FOURNISSEUR_ID);

        $printingResult = print_Helper::managePrintingElement(true);
        if($printingResult["critical-message"])
        {
            $_SESSION["critical-message"] = $printingResult["critical-message"];
        }

        unset($_SESSION["currentProduct"]);
        header("Location:".BASEURL."scan/"); /* Redirection du navigateur */
    }

    public function cancelAction()
    {
        $order = $_SESSION["currentProduct"]["order"];
        $message = "Rejet du colissge sur le produit : ".$order["Marque"].' '.$order["Profil"].' '.$order["Largeur"].'/'.$order["Hauteur"].' R'.$order["Diametre"].' '.$order["Indice_Charge"].$order["Indice_Vitesse"];
        historique_Model::insertHistoLine($message,"WARNING",FOURNISSEUR_ID);

        unset($_SESSION["currentProduct"]);

        header("Location:".BASEURL."/scan/"); /* Redirection du navigateur */
    }

    public function endAction()
    {

        $printingResult = print_Helper::managePrintingElement(true);

        if($printingResult["critical-message"]) {
            $this->_templatesParameters["critical-message"] = $printingResult["critical-message"];
        }
        $message = "Fin du colisage";
        historique_Model::insertHistoLine($message,"INFO",FOURNISSEUR_ID);

        unset($_SESSION["currentProduct"]);

    }
}