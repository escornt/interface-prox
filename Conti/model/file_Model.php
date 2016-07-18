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
require_once(BASEDIR . "../BackOfficev2/include/shared/class/ExpeditionChargerAdapter/class/EtiquettePneu.class.php");

class file_Model extends global_Model{

    public function __construct()
    {

    }

    public static function printEtiquette($listToPrint)
    {
        if(count($listToPrint)>0) {

            $ftp_arr['Host'] = FTP_HOST;
            $ftp_arr['Login'] = FTP_LOGIN;
            $ftp_arr['Passwd'] = FTP_PASSWORD;
            $ftp_arr['Port'] = FTP_PORT;

            $etiquette = new EtiquettePneu(TRANSPORTEUR_SUFFIX);
            $etiquette->setNumeroCompteTransporteur(COMPTE_TRANSPORTEUR);

            $expediteurInfo = array(
                'Nom_Expediteur' => '1001Pneus - Point Service',
                'Rue_Expediteur' => '11 rue des montagnes de Lans',
                'CP_Expediteur' => '38130',
                'Ville_Expediteur' => "Echirolles",
                'CodePays_Expediteur' => '1',
                'Tel_Expediteur' => '05 35 54 14 86',
                'Email_Expediteur' => 'contact@1001pneus.fr'

            );

            $etiquette->setExpediteur($expediteurInfo);
            $output = $etiquette->getHeaderContent();

            foreach($listToPrint as  $key => $commandeArray){

                $cmdPrdId = $commandeArray['cmdPrdId'];
                $qtePneus = $commandeArray['tyreInPackage'];
                $output .= $etiquette->getLineContent($cmdPrdId, $qtePneus);
            }
            $filename = date('Ymdhis').".txt";
            $localFile = "/tmp/".$filename;
            $remoteFile = "/". FTP_BASE_DIR."/".$filename;
            $handler = fopen($localFile,"w");

            fwrite($handler,$output);
            fclose($handler);

            $return = mEUPScriptTools::pushFileToFtp($ftp_arr, $remoteFile, $localFile);
            if($return == true){
                return true;
            }else{
                return $listToPrint;
            }
        }
        else{
            return true;
        }
    }

    public static function printSingleEtiquette($cmdPrdId,$qtePneus)
    {
        $ftp_arr['Host'] = FTP_HOST;
        $ftp_arr['Login'] = FTP_LOGIN;
        $ftp_arr['Passwd'] = FTP_PASSWORD;
        $ftp_arr['Port'] = FTP_PORT;

        $etiquette = new EtiquettePneu(TRANSPORTEUR_SUFFIX);
        $etiquette->setNumeroCompteTransporteur(COMPTE_TRANSPORTEUR);


        $expediteurInfo = array(
            'Nom_Expediteur' => '1001Pneus - Point Service',
            'Rue_Expediteur' => '11 rue des montagnes de Lans',
            'CP_Expediteur' => '38130',
            'Ville_Expediteur' => "Echirolles",
            'CodePays_Expediteur' => '1', // France
            'Tel_Expediteur' => '05 35 54 14 86Echirolles',
            'Email_Expediteur' => 'contact@1001pneus.fr'
        );

        $etiquette->setExpediteur($expediteurInfo);
        $output = $etiquette->getHeaderContent();
        $output .= $etiquette->getLineContent($cmdPrdId, $qtePneus);

        $filename = date('Ymdhis').".txt";
        $localFile = "/tmp/".$filename;
        $remoteFile = "/".FTP_BASE_DIR."/". $filename;
        $handler = fopen($localFile,"w");


        fwrite($handler,$output);
        fclose($handler);
        $return = mEUPScriptTools::pushFileToFtp($ftp_arr, $remoteFile, $localFile);
        if($return == true){
            return true;
        }else{
            return false;
        }

    }
}
