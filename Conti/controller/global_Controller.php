<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */

class global_Controller{

    protected $_templatesParameters;
    protected $_controller;
    protected $_action;
    protected $_rollbackArray;
    protected $_template;

    public function __construct()
    {
        session_start();

        $fournissseurArray = array(
            207 => "bridgestone_torija.php",
            212 => "bridgestone_bethune.php",
            181 => "continental_mer.php"
        );

        if($_SESSION["User"]["Logged"] == "true"){
            require_once("config/fournisseur/".$fournissseurArray[$_SESSION[User][Id]]);
        }

        if(
            (!isset($_SESSION["User"]["Id"]) && $_GET["controller"] !== "login")
            &&
            (!isset($_SESSION["User"]["Id"]) && $_GET["controller"] !== "ajax")
        ){

            switch (ENVIRONMENT)
            {
                case 'development':
                    header("Location: http://".$_SERVER["HTTP_HOST"]."/login/"); /* Redirection du navigateur */
                    exit;
                case 'testing':
                    header("Location: http://".$_SERVER["HTTP_HOST"]."/login/"); /* Redirection du navigateur */
                    exit;
                case 'production':
                    header("Location: http://".$_SERVER["HTTP_HOST"]."/login/"); /* Redirection du navigateur */
                    exit;
                default:
                    header("Location: http://".$_SERVER["HTTP_HOST"]."/login/"); /* Redirection du navigateur */
                    exit;
            }
        }
        $this->_template = true;
    }

    public function load()
    {
        $this->_controller = "home";
        $this->_action = "index";

        /*Récuperation du controller*/
        if($_GET["controller"]){
            $this->_controller = $_GET["controller"];
        }
        /*Récuperation de l'action*/
        if($_GET["action"]){
            $this->_action = $_GET["action"];
        }

        /*Instantiation du controller*/
        $controller = $this->_controller."_Controller";
        $mainController = new $controller();

        /*Chargement du haut de page avec test d'une valeur du controler (Gestion de l'ajax renvoyant du JSSON*/
        if( $mainController->getTemplate() == true) {
            $mainController->loadHeader();
        }

        /*Chargement du contenu de la page*/
        $mainController->loadAction($this->_action);

        /*Chargement du bas de page avec test d'une valeur du controller (Gestion de l'ajax renvoyant du JSON)*/
        if($mainController->getTemplate() == true) {
            $mainController->loadView();
            $mainController->loadFooter();
        }

    }

    public function loadView($view = null)
    {
        if(!$view){
            require_once(BASEDIR."view/".$this->_controller."/".$this->_action."View.php");
        }else{
            ob_start();
            include_once BASEDIR."view/".$view.".php";
            return ltrim(ob_get_clean());
        }

    }

    public function loadHeader()
    {
        if($this->_controller != "login"){
            if($this->_controller !== "ajax" && $this->_controller != "login"){
                require_once(BASEDIR."view/global/header.php");
            }else {
                require_once(BASEDIR."view/global/ajax_header.php");
            }
        }else{
            require_once(BASEDIR . "view/global/headerLogin.php");
        }
    }

    public function loadFooter()
    {
        if($this->_controller != "login") {
            if ($this->_controller !== "ajax" && $this->_controller != "login") {
                require_once(BASEDIR . "view/global/footer.php");
            } else {
                require_once(BASEDIR . "view/global/ajax_footer.php");
            }
        }else{
            require_once(BASEDIR . "view/global/footerLogin.php");
        }
    }

    public function getTemplate(){
        return $this->_template;
    }
}