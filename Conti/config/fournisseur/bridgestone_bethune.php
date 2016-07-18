<?php
switch(ENVIRONMENT){
    case "development":
        define("BASEURL","http://ovh.bridge.1001pneus.fr/");
        define("BASE1001URL","http://ovh.bridge.1001pneus.fr/");
        define("FTP_HOST","ftp.supplier.1001pneus.fr");
        define("FTP_LOGIN","mrautoTest");
        define("FTP_PASSWORD","mrauto");
        define("FTP_PORT","21");
        break;
    case "prod":
        define("BASE1001URL","http://bridge.1001pneus.fr/");
        define("BASEURL","http://bridge.1001pneus.fr/");
        define("FTP_HOST","ftp.supplier.1001pneus.fr");
        define("FTP_LOGIN","packing.bridge.bethune");
        define("FTP_PASSWORD","UvEbQ3Ky");
        define("FTP_PORT","21");
        break;
}
define("FTP_BASE_DIR","/labels/");
define("FOURNISSEUR_ID","85");
define("PAYS_ID","1");
define("LABEL_LIST_SIZE","1");

define ("TRANSPORTEUR_SUFFIX","Gls");
define ("COMPTE_TRANSPORTEUR","2504844601");
