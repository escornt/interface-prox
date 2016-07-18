<?php
switch(ENVIRONMENT){
    case "development":
        define("BASEURL","http://ovh.bridge.1001pneus.es/");
        define("BASE1001URL","http://ovh.bridge.1001pneus.es/");
        define("FTP_HOST","ftp.supplier.1001pneus.fr");
        define("FTP_LOGIN","mrautoTest");
        define("FTP_PASSWORD","mrauto");
        define("FTP_PORT","21");
        break;
    case "prod":
        define("BASE1001URL","http://bridge.1001neumaticos.es/");
        define("BASEURL","http://bridge.1001neumaticos.es/");
        define("FTP_HOST","83.206.19.156");
        define("FTP_LOGIN","1001pneus");
        define("FTP_PASSWORD","5d!eRz87");
        define("FTP_PORT","21");
        break;
}
define("FTP_BASE_DIR","bridgestone_torija");
define("FOURNISSEUR_ID","82");
define("PAYS_ID","4");
define("LABEL_LIST_SIZE","1");
define("FORCED_COLIS_SIZE",1);

define ("TRANSPORTEUR_SUFFIX","Seur");
define ("COMPTE_TRANSPORTEUR","");