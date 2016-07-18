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


class goodies_Model extends global_Model{

    public function __construct()
    {

    }

    public static function isGoodiesEligible($currentProduct)
    {

        $skuGoodiesArray = array(
            "162725","162767","164452","167219","167276","167278","168513","168514","181054","181056",
            "181057","181085","181155","181156","181387","181639","181667","181873","182196","183697",
            "183798","183953","185259","185988","187122","187160","187281","190352","190602","14473969",
            "16195001","21277843","23636305","23636306","23639026","23639027","23645481","23698992","23759850","23759851",
            "23779567","23790698","23790699"
        );
        $datesOp = array("debut" => "2016-05-30 00:00:00", "fin" => "2016-06-13 00:00:00");

        $return = false;

        $dateStart = new DateTime($datesOp["debut"]);
        $dateEnd = new DateTime($datesOp["fin"]);
        $dateAchat = new DateTime($currentProduct['Date_Commande']);


        if (in_array($currentProduct['Sku'],$skuGoodiesArray)) {
            if($dateAchat > $dateStart && $dateAchat < $dateEnd){
                $return =  true;
            }
        }
        return $return;
    }
}


