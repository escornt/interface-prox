<?php

class tyre_Model extends global_Model{

    public function __construct()
    {

    }
   /*
    *  Get the list of expected tyres regardin what
    *  have been ordered on the website
    */
    public static function getWaitedTyres($fid,$paysId)
    {
        $returnArray = array();

        $query = "SELECT distinct(cvf.sku) as sku, cvf.Marque, cvf.Profil, cvf.Largeur, cvf.Hauteur,cvf.Diametre,cvf.Indice_Charge,cvf.Indice_Vitesse,
        fcpl.pneusAColiser,fcpl.pneusColises,fcpl.commandeProduitId
            FROM Fournisseur_Colis_Preparation_List fcpl
            JOIN Catalogue_Vente_Flat cvf ON cvf.Sku =fcpl.sku
            WHERE fcpl.pneusAColiser != fcpl.pneusColises
            AND fcpl.fournisseurId=".$fid."
            AND fcpl.commandeProduitId NOT IN(SELECT CommandeProduitId FROM Fournisseur_Colis_Preparation_Labels)";

        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $line){
                array_push($returnArray,$line);
            }
        }
        return $returnArray;
    }

   /*
    *  Get informations related ton an order based on the sku checked
    */
    public static function getOrderInformations($sku,$fid,$paysId){

        $returnArray = array();

        $query = "SELECT cvf.Marque, 
            cvf.Profil, 
            cvf.Largeur, 
            cvf.Hauteur, 
            cvf.Diametre, 
            cvf.Indice_Charge, 
            cvf.Indice_Vitesse, 
            cvf.Type, 
            cp.Fournisseur_Reference, 
            cvf.EAN, 
            cvf.Sku, 
            fcpl.pneusAColiser, 
            fcpl.pneusColises, 
            fcpl.commandeProduitId, 
            fcpl.id, 
            fcpl.toPrint, 
            fcpl.printed, 
            c.Commande_Id, 
            c.Date_Commande
            FROM Fournisseur_Colis_Preparation_List fcpl
            JOIN Catalogue_Vente_Flat cvf ON cvf.Sku =fcpl.sku
            JOIN Commandes_Produits cp ON cp.Commande_Produits_Id = fcpl.commandeProduitId
            JOIN Commandes  c ON c.Commande_Id = cp.Commande_Id
            WHERE fcpl.pneusAColiser != fcpl.pneusColises
            AND c.Pays_Id = cvf.Pays_Id
            AND fcpl.sku =".$sku."
            AND fcpl.fournisseurId =".$fid."
            AND fcpl.commandeProduitId NOT IN(SELECT commandeProduitId FROM Fournisseur_Colis_Preparation_Labels)
            ORDER BY fcpl.id ASC LIMIT 1";
        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $line){
                array_push($returnArray,$line);
            }
        }
        return $returnArray;
    }

    /*
     *  Get informations related ton an order based on the ean
     */
    public static function getPackageId($cmdPrdId){

        $query = "SELECT fcpl.id
            FROM Fournisseur_Colis_Preparation_List fcpl
            WHERE fcpl.commandeProduitId = ".$cmdPrdId;

        $result = mEUPSql2::Query($query);
        if($result["results"]){
            return  $result["results"][0]["id"];
        }
        else{
            return false;
        }
    }

   /*
    *   Get informations related ton an order based on the EAN scanned
    */
    public static function getOrderInformationsByEan($ean,$fid,$paysId){

        $returnArray = array();

        $query = "SELECT cvf.Marque, 
            cvf.Profil, 
            cvf.Largeur, 
            cvf.Hauteur,
            cvf.Diametre,
            cvf.Indice_Charge,
            cvf.Indice_Vitesse,
            cvf.Type,
            cp.Fournisseur_Reference,
            cvf.EAN,
            cvf.Sku,
            fcpl.pneusAColiser,
            fcpl.pneusColises,
            fcpl.commandeProduitId,
            fcpl.id,
            fcpl.toPrint,
            fcpl.printed,
            c.Commande_Id,
            c.Date_Commande
            FROM Fournisseur_Colis_Preparation_List fcpl
            JOIN Catalogue_Vente_Flat cvf ON cvf.Sku =fcpl.sku
            JOIN Commandes_Produits cp ON cp.Commande_Produits_Id = fcpl.commandeProduitId
            JOIN Commandes  c ON c.Commande_Id = cp.Commande_Id
            WHERE fcpl.pneusAColiser != fcpl.pneusColises
            AND c.Pays_Id = cvf.Pays_Id
            AND cvf.EAN =".$ean."
            AND fcpl.fournisseurId =".$fid."
            AND fcpl.commandeProduitId NOT IN(SELECT commandeProduitId FROM Fournisseur_Colis_Preparation_Labels)
            ORDER BY fcpl.id ASC LIMIT 1";
        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $line){
                array_push($returnArray,$line);
            }
        }
        return $returnArray;
    }

    public static function updateToPrintpackageLine($order,$pneusDansColis)
    {
        if($pneusDansColis !== 0){
            $labelToPrintNumber = $order["pneusAColiser"] / $pneusDansColis;
            if(is_float($labelToPrintNumber)) {
                $labelToPrintNumber = round($labelToPrintNumber, 0,PHP_ROUND_HALF_DOWN) + 1;
            }
        }else{
            $labelToPrintNumber = 0;
        }
        $query = "UPDATE Fournisseur_Colis_Preparation_List SET toPrint=".$labelToPrintNumber." WHERE commandeProduitId =".$order["commandeProduitId"];
        mEUPSql2::Query($query);
    }

    public static function updatePrintedpackageLine($cmdPrdId)
    {
        $query = "SELECT fcpl.pneusAColiser,fcpl.pneusColises,fcpl.printed,fcpl.toPrint
            FROM Fournisseur_Colis_Preparation_List fcpl
            WHERE fcpl.commandeproduitId =  ".$cmdPrdId;


        $result = mEUPSql2::Query($query);
        $order = $result["results"][0];

        $printed = (int)$order["printed"] + 1;

        $query = "UPDATE Fournisseur_Colis_Preparation_List SET printed=".$printed." WHERE commandeProduitId =".$cmdPrdId;
        mEUPSql2::Query($query);

    }

    public static function updateFailedPrintPackageLine($failedList)
    {
        $cmdPrdIdArray = array();
        $in = "(";
        foreach($failedList as $key => $value){
            if(!array_key_exists($value["cmdPrdId"],$cmdPrdIdArray)){
                $in.= $value["cmdPrdId"].",";
            }

            $cmdPrdIdArray[$value["cmdPrdId"]]++;
        }
        $in = substr($in,0,-1).")";
        $query = "SELECT toPrint,failedPrint,commandeProduitId FROM Fournisseur_Colis_Preparation_List WHERE commandeProduitId IN ".$in;

        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $baseContent){
                $failedPrint = $cmdPrdIdArray[$baseContent["commandeProduitId"]];
                $query = "UPDATE Fournisseur_Colis_Preparation_List SET failedprint=".$failedPrint." WHERE commandeProduitId =".$baseContent["commandeProduitId"];
                mEUPSql2::Query($query);
            }
        }
        unset($_SESSION["failedPrint"]);

    }

    public static function  updatePackage()
    {
        $order2 = $_SESSION["currentProduct"]["order"];
        $cmdPrdId = $_SESSION["currentProduct"]["order"]["commandeProduitId"];
        $newValueColisedTyre = $_SESSION["currentProduct"]["nbPneus"];
        if (!is_array($_SESSION["poolPrint"])) {
            $_SESSION["poolPrint"] = array();
        }
        if($_SESSION["currentProduct"]["nbPneus"] !== 0 && !$_SESSION["currentProduct"]["labelcmdlinked"])
        {
            /*Calcul et Maj de la nouvelle valeur des pneus colisés de la commande*/
            $alreadyColisedTyres = $_SESSION["currentProduct"]["order"]["pneusColises"];
            $pneusColises = $alreadyColisedTyres + $newValueColisedTyre;
            $query = "UPDATE Fournisseur_Colis_Preparation_List SET pneusColises=" . $pneusColises . " WHERE commandeProduitId =" . $cmdPrdId;
            mEUPSql2::Query($query);
            /*Maj de l'historique*/
            $message = $newValueColisedTyre . " Pneus - " . $order2["Marque"] . ' ' . $order2["Profil"] . ' ' . $order2["Largeur"] . '/' . $order2["Hauteur"] . ' R' . $order2["Diametre"] . ' ' . $order2["Indice_Charge"] . $order2["Indice_Vitesse"];
            historique_Model::insertHistoLine($message, "INSERT", FOURNISSEUR_ID, $cmdPrdId, $newValueColisedTyre);
            /*Maj de la liste des étiquettes à Imprimer*/
            $dataForPrinting = array("cmdPrdId" => $cmdPrdId, "tyreInPackage" => $newValueColisedTyre);
            array_push($_SESSION["poolPrint"], $dataForPrinting);
            $_SESSION["PackageCount"]++;
        }
        else if ($_SESSION["currentProduct"]["labelToStick"])
        {
            /*Maj de l'historique*/
            $message = "Mise de cot&eacute; du pneu - " . $order2["Marque"] . ' ' . $order2["Profil"] . ' ' . $order2["Largeur"] . '/' . $order2["Hauteur"] . ' R' . $order2["Diametre"] . ' ' . $order2["Indice_Charge"] . $order2["Indice_Vitesse"] ."
             avec l'&eacute;tiquette ".$_SESSION["currentProduct"]["labelToStick"] ;
            historique_Model::insertHistoLine($message, "WARNING", FOURNISSEUR_ID);
            unset($_SESSION["currentProduct"]["labelToStick"]);
        }
        else if ($_SESSION["currentProduct"]["labelToGet"] && $_SESSION["currentProduct"]["labelcmdlinked"])
        {
            $query = "UPDATE Fournisseur_Colis_Preparation_List Set pneusColises = pneusAColiser WHERE commandeproduitId =" .$cmdPrdId;
            mEUPSql2::Query($query);
            $query = "UPDATE Fournisseur_Colis_Preparation_List Set pneusColises = pneusAColiser WHERE commandeproduitId =" . $_SESSION["currentProduct"]["labelcmdlinked"];
            mEUPSql2::Query($query);
            $query = "UPDATE Commandes_Produits SET EtatTracking = 'KO' WHERE Commande_Produits_id =".$_SESSION["currentProduct"]["labelcmdlinked"];
            mEUPSql2::Query($query);
            $message = "Colisage de 2 commandes diff&eacute;rentes ensemble ".$cmdPrdId.' et '.$_SESSION["currentProduct"]["labelcmdlinked"];
            historique_Model::insertHistoLine($message, "INSERT", FOURNISSEUR_ID,$cmdPrdId,$newValueColisedTyre,$_SESSION["currentProduct"]["labelcmdlinked"]);
            $dataForPrinting = array("cmdPrdId" => $cmdPrdId, "tyreInPackage" => $newValueColisedTyre);
            array_push($_SESSION["poolPrint"], $dataForPrinting);
            $_SESSION["PackageCount"]++;
            unset($_SESSION["currentProduct"]["labelToGet"]);
            unset($_SESSION["currentProduct"]["labelcmdlinked"]);
        }
    }

    public static function getPackageById($id){
        $query = "SELECT fcpl.*
            FROM Fournisseur_Colis_Preparation_List fcpl
            WHERE fcpl.id = ".$id;


        $result = mEUPSql2::Query($query);
        if($result["results"]){
            $returnArray = $result["results"][0];
        }
        else{
            $returnArray = false;
        }
        return $returnArray;
    }

    public static function getPackageAdresseInfo($cmdPrdId){
        $query = "SELECT
            c.Livraison_Civilite,
            c.Livraison_Nom,
            c.Livraison_Prenom,
            c.Livraison_Adresse,
            c.Livraison_CodePostal,
            c.Livraison_Ville,
            c.Livraison_Societe
        FROM Commandes_Produits cp JOIN Commandes c ON cp.Commande_Id = c.Commande_Id
        WHERE cp.Commande_Produits_Id =".$cmdPrdId;
        $result = mEUPSql2::Query($query);
        if($result["results"]){
            $returnArray = $result["results"][0];
        }
        else{
            $returnArray = false;
        }
        return $returnArray;
    }

    public static function getDetailsFromPackage($idArray,$paysId){

        $returnArray = array();
        $implodedId = "(".implode(',',$idArray).")";
        $query = "SELECT distinct(cvf.sku) as sku, cvf.Marque, cvf.Profil, cvf.Largeur, cvf.Hauteur,cvf.Diametre,cvf.Indice_Charge,
            cvf.Indice_Vitesse,cvf.EAN,cp.Fournisseur_Reference
            FROM Fournisseur_Colis_Preparation_List fcpl
            JOIN Catalogue_Vente_Flat cvf ON cvf.Sku = fcpl.sku
            JOIN Commandes_Produits cp ON cp.Commande_Produits_Id = fcpl.commandeProduitId
            WHERE fcpl.id IN ".$implodedId."
            AND cvf.Pays_Id = ".$paysId;
        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $line){
                array_push($returnArray,$line);
            }
        }

        return $returnArray;
    }

    public static function getColisage($fournisseur,$order){
        $maxPneuParColis = 2;
        $pneusDansColis = 0;
        $poidColis = 0;
        if ($fournisseur["Colisage"] == "POIDS") {
            $poidsPneu = mEUPTools::getPoidsPneu($order[0]["Largeur"], $order[0]["Hauteur"], $order[0]["Diametre"], $order[0]["Indice_Charge"], $order[0]["Indice_Vitesse"], $order[0]["Type"], $order[0]["Marque"]);

            $poidsMaxColis = $fournisseur["PoidsColis"];
            while ($pneusDansColis < $maxPneuParColis && $poidColis < $poidsMaxColis) {
                $poidColis += $poidsPneu;
                if ($poidColis >= $poidsMaxColis) {
                    break;
                } else {
                    $pneusDansColis++;
                }
            }
        } else if ($fournisseur["Colisage"] == "REGLE") {
            $colisage = mEUPTools::getColissageProduit(FOURNISSEUR_ID, PAYS_ID, $order[0]['Type'], $order[0]['Diametre']);
            $pneusDansColis = $colisage["Nombre"];
        }
        if ((int)$pneusDansColis > ((int)$order[0]["pneusAColiser"] - (int)$order[0]["pneusColises"])) {
            $pneusDansColis = (int)$order[0]["pneusAColiser"] - (int)$order[0]["pneusColises"];
        }
        return $pneusDansColis;
    }

    public static function getNewInsertedLabelNumber(){
        $query = "SELECT LabelNumber FROM Fournisseur_Colis_Preparation_Labels Order BY Id DESC LIMIT 1";
        $resultLabel = mEUPSql2::Query($query);
        if ($resultLabel[count] == 1 ){
            if($resultLabel[results][0][LabelNumber] < 210){
                return (int)$resultLabel[results][0][LabelNumber] + 1;
            }else{
                return  1;
            }
        }else{
            return  1;
        }
    }
}

?>