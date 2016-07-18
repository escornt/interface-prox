<?php

class historique_Model extends global_Model{

    public function __construct()
    {

    }

    public static function insertHistoLine($message,$type,$fournisseurId,$cmdId = null,$tyreNumber = null,$multipleCommandePreparationId = null)
    {
        if($cmdId){
            $id = tyre_Model::getPackageId($cmdId);
        }
        if($multipleCommandePreparationId){
            $id2 = tyre_Model::getPackageId($multipleCommandePreparationId);
        }

        if($id){
            if($id2){
                $query = "INSERT INTO Fournisseur_Colis_Preparation_Histo (message,fournisseur_colis_preparation_id,type,fournisseur_id,qte_pneus,multiple_commande_preparation_id)
                    VALUES(\"".$message."\",".$id.",'".$type."',".$fournisseurId.",".$tyreNumber.",".$id2.")";
            }else{
                $query = "INSERT INTO Fournisseur_Colis_Preparation_Histo (message,fournisseur_colis_preparation_id,type,fournisseur_id,qte_pneus)
                    VALUES(\"".$message."\",".$id.",'".$type."',".$fournisseurId.",".$tyreNumber.")";
            }
        }else{
            $query = "INSERT INTO Fournisseur_Colis_Preparation_Histo (message,type,fournisseur_id)
                    VALUES(\"".$message."\",'".$type."',".$fournisseurId.")";
        }
        mEUPSql2:Query($query);
    }

    public static function getDailyHistorique($date,$fid,$paysId,$limit = true)
    {
        $returnArray = array();
        if($limit){
            $limit = "LIMIT 10";
        }else{
            $limit ="";
        }
        $query = "SELECT fcph.*, fcpl.sku,fcpl.commandeProduitId,cp.Fournisseur_Reference,cvf.EAN
            FROM Fournisseur_Colis_Preparation_Histo fcph
            LEFT JOIN Fournisseur_Colis_Preparation_List fcpl ON fcpl.id = fcph.fournisseur_colis_preparation_id
            LEFT JOIN Commandes_Produits cp ON cp.Commande_Produits_Id = fcpl.commandeProduitId
            LEFT JOIN Catalogue_Vente_Flat cvf ON cvf.Sku = fcpl.sku
            WHERE fcph.Date LIKE '%".$date."%'
            AND fcph.fournisseur_id =".$fid."
            AND (cvf.Pays_Id =".$paysId." OR cvf.Pays_Id IS NULL)
            ORDER BY fcph.id DESC ".$limit;

        $result = mEUPSql2::Query($query);
        if($result["results"]){
            foreach($result["results"] as $line){
                array_push($returnArray,$line);
            }
        }
        return $returnArray;
    }
    public static function getHistoLineById($id)
    {
        $query = "SELECT fcph.*
            FROM Fournisseur_Colis_Preparation_Histo fcph
            WHERE fcph.id = ".$id;


        $result = mEUPSql2::Query($query);
        if($result["results"]){
            $returnArray = $result["results"][0];
        }
        else{
            $returnArray = false;
        }
        return $returnArray;
    }

    public static function getDetailForRegroupedOrder($cmdId,$cmdId2)
    {
        $returnArray = array();
        $query = "SELECT fcpl.sku,fcpl.commandeProduitId,cp.Fournisseur_Reference,cvf.Marque, cvf.Profil, cvf.Largeur,
        cvf.Hauteur,cvf.Diametre,cvf.Indice_Charge,cvf.Indice_Vitesse,cvf.Type,cvf.EAN
            FROM Fournisseur_Colis_Preparation_List fcpl
            LEFT JOIN Commandes_Produits cp ON cp.Commande_Produits_Id = fcpl.commandeProduitId
            LEFT JOIN Catalogue_Vente_Flat cvf ON cvf.Sku =fcpl.sku
            LEFT JOIN Commandes c ON c.Commande_Id = cp.Commande_Id
            WHERE cvf.Pays_Id  = c.Pays_Id
            AND fcpl.id IN(" . $cmdId.",".$cmdId2.")";
        $result = mEUPSql2::Query($query);
        if ($result["results"]) {
            foreach ($result["results"] as $line) {
                array_push($returnArray, $line);
            }
        }
        return $result;
    }
}

?>