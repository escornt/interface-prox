<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */

class home_Controller extends global_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_controller = "home";
    }

    public function loadAction($actionName)
    {
        $this->_action = $actionName;
        $action = $this->_action . "Action";
        $this->$action();
    }

    public function indexAction()
    {

    }

    public function startAction()
    {
        $message = LANG_DEBUT_COLISAGE;
        $_SESSION["PackageCount"] = 0;
        historique_Model::insertHistoLine($message,"INFO",FOURNISSEUR_ID);
        header("Location:".BASEURL."/scan/"); /* Redirection du navigateur */
    }
    public function logoutAction()
    {
        $_SESSION = array();
        header("Location:".BASEURL);
    }

}