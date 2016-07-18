<?php
switch(ENVIRONMENT){
    case "development":
        define("BASEURL","http://ovh.conti.1001pneus.fr/");
        define("BASE1001URL","http://ovh.conti.1001pneus.fr/");
        define("FTP_HOST","ftp.supplier.1001pneus.fr");
        define("FTP_LOGIN","mrautoTest");
        define("FTP_PASSWORD","mrauto");
        define("FTP_PORT","21");
        break;
    case "prod":
        define("BASEDIR","/filer/sites/1001pneus.fr-dev/Conti/");
        define("BASEURL","http://conti.1001pneus.fr/");
        // define("FTP_HOST","83.206.19.156"); // old
        define("FTP_HOST","ftp.deret.fr"); // new since 1 juillet 2016
        define("FTP_LOGIN","1001pneus");
        define("FTP_PASSWORD","5d!eRz87");
        define("FTP_PORT","21");
        break;
}
define("FTP_BASE_DIR","continental_mer");
define("FOURNISSEUR_ID","73");
define("PAYS_ID","1");
define("LABEL_LIST_SIZE","10");

define ("TRANSPORTEUR_SUFFIX","Gls");
define ("COMPTE_TRANSPORTEUR","2503679203");

?>