<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */

class history_Controller extends global_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_controller = "history";
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
        if($_GET['param1']){
            $date = $_GET['param1'];
        }
        else{
            $date = date("Y-m-d");
        }
        $historique = historique_Model::getDailyHistorique($date,FOURNISSEUR_ID,PAYS_ID,false);
        $packageIdArray = array();
        foreach($historique as $key => $value){
            if($value["type"]!=='INSERT'){
                unset($historique[$key]);
            }else{
                if($value["fournisseur_colis_preparation_id"])
                    array_push($packageIdArray,$value["fournisseur_colis_preparation_id"]);
            }
        }
        $packageIdArray = array_unique($packageIdArray);
        $detailArray = array();
        if(count($packageIdArray)> 0){
            $detailArray = tyre_Model::getDetailsFromPackage($packageIdArray,PAYS_ID);
            foreach($detailArray as $detailakey => $detail){
                if(!is_array($detailArray[$detailakey]["packageList"])) {
                    $detailArray[$detailakey]["packageList"] = array();
                }
                foreach($historique as $keyHisto => $package){
                    if($package["sku"] == $detail["sku"]){

                        $info = tyre_Model::getPackageAdresseInfo($package["commandeProduitId"]);
                        $adresse["civilite"] =  ucfirst(strtolower($info["Livraison_Civilite"]))." ".
                            ucfirst(strtolower($info["Livraison_Nom"]))." ".
                            ucfirst(strtolower($info["Livraison_Prenom"]));
                        $adresse["adresse"] = strtolower($info["Livraison_Adresse"]);
                        $adresse["ville"] =     $info["Livraison_CodePostal"]." ". $info["Livraison_Ville"];

                        $packageDetail = array("TyreNumber" => $package["qte_pneus"],"Adresse" => $adresse, "id"=>$package["id"] );
                        foreach($info as $keyinfo => $value){
                            $packageDetail[$keyinfo] = $value;
                        }
                        array_push($detailArray[$detailakey]["packageList"],$packageDetail);
                    }
                }
            }
        }
        $this->_templatesParameters["history"] = $detailArray;
        $this->_templatesParameters["today"] = $date;

    }

    public function  bydateAction()
    {
        $historique = historique_Model::getDailyHistorique(date("Y-m-d"),FOURNISSEUR_ID,PAYS_ID,false);
        $packageIdArray = array();
        foreach($historique as $key => $value){
            if($value["type"]!=='INSERT'){
                unset($historique[$key]);
            }else{
                if($value["fournisseur_colis_preparation_id"])
                    array_push($packageIdArray,$value["fournisseur_colis_preparation_id"]);
            }
        }

        if(count($packageIdArray)> 0) {
            foreach ($historique as $keyHisto => $package) {
                $tyreInfo = explode(" - ",$package["message"]);
                $info = tyre_Model::getPackageAdresseInfo($package["commandeProduitId"]);
                if($package["multiple_commande_preparation_id"] != null){
                    $package["Fournisseur_Reference"] = "";
                    $package["EAN"] = "";
                    $supp = historique_Model::getDetailForRegroupedOrder($package["fournisseur_colis_preparation_id"],$package["multiple_commande_preparation_id"]);
                    foreach ($supp["results"] as $produit)
                    {
                        $package["ref1001pneus"].=$produit[commandeProduitId]. " / ";
                        $package["Fournisseur_Reference"].= $produit[Fournisseur_Reference]. " / ";
                        $package["EAN"].= $produit[EAN]. " / ";
                        $package["tyreDef"] .=$produit[Marque]." ".$produit[Profil]." ".$produit[Largeur]."/".$produit[Hauteur]."R".$produit[Diametre]." ".$produit[Indice_Charge]."".$produit[Indice_Vitesse]."<br/>";

                    }
                    $package["EAN"] = substr($package["EAN"],0,-2);
                    $package["ref1001pneus"] = substr($package["ref1001pneus"],0,-2);
                    $package["Fournisseur_Reference"] = substr($package["Fournisseur_Reference"],0,-2);
                    $package["tyreNumber"] = $package['qte_pneus']." Pneus de 2 commandes diff&eacute;rentes";
                    //var_dump($supp);
                }else{
                    $package["tyreNumber"] = $tyreInfo[0];
                    $package["tyreDef"] = $tyreInfo[1];
                    $package["ref1001pneus"] = $package["commandeProduitId"];
                }


                $adresse["societe"] =  $info['Livraison_Societe'];
                $adresse["civilite"] = ucfirst(strtolower($info["Livraison_Civilite"])) . " " . ucfirst(strtolower($info["Livraison_Nom"])) . " " . ucfirst(strtolower($info["Livraison_Prenom"]));
                $adresse["adresse"] = strtolower($info["Livraison_Adresse"]);
                $adresse["ville"] = $info["Livraison_CodePostal"] . " " . $info["Livraison_Ville"];
                $package["Adresse"] = $adresse;
                $historique[$keyHisto] = $package;
            }
        }

        $this->_templatesParameters["history"] = $historique;
        $this->_templatesParameters["today"] = date('Y-m-d');
    }
}