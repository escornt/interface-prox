<?php
/**
 * ------------------------------------------------------------
 * Copyright (c)(c) 2015 1001pneus.
 * This software is the proprietary information of 1001pneus
 * All Right Reserved.
 * ------------------------------------------------------------
 *
 * SVN revision information:
 * @version
 * @author  julien.pons
 * @date    09/10/2015
 *
 */

class print_Helper extends global_Helper
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function managePrintingElement($force = false)
    {
        if($_SESSION["currentProduct"]["order"])
        {
            tyre_Model::updatePackage();
        }

        $return = array();
        if(count($_SESSION["poolPrint"]) == LABEL_LIST_SIZE || $force == true){
            $printResult = file_Model::printEtiquette($_SESSION["poolPrint"]);
            if($printResult === true || count($printResult) == 0){

                $message = LANG_POOL_VIDE.count($_SESSION["poolPrint"]).LANG_ETIQUETTES_ENVOYEES;
                unset($_SESSION["poolPrint"]);
                historique_Model::insertHistoLine($message, "INFO",FOURNISSEUR_ID);
            }
            else{
                $failedPrint = 0;
                foreach($_SESSION["poolPrint"] as $key => $line){
                    $erase = false;
                    foreach($printResult as $remaing){
                        if($remaing["cmdPrdId"] == $line["cmdPrdId"] && $remaing["tyreInPackage"] == $line["tyreInPackage"] ){
                            $erase = true;
                            break;
                        }
                    }
                    if($erase){
                        $failedPrint++;
                        if(!is_array($_SESSION["failedPrint"])){
                            $_SESSION["failedPrint"] = array();
                        }
                        array_push($_SESSION["failedPrint"],$_SESSION["poolPrint"][$key]);
                    }else{
                        tyre_Model::updatePrintedpackageLine($line["cmdPrdId"]);
                    }
                }
                tyre_Model::updateFailedPrintPackageLine($_SESSION["failedPrint"]);


                unset($_SESSION["poolPrint"]);
                $message = LANG_ATTENTION.$failedPrint.LANG_ETIQUETTES_IMPRIMEES;
                historique_Model::insertHistoLine($message, "CRITICAL",FOURNISSEUR_ID);
                $return["critical-message"] = LANG_ATTENTION.$failedPrint.LANG_ETIQUETTES_IMPRIMEES.LANG_ARRET_COLISAGE;
            }
        }

        return $return;
    }
}