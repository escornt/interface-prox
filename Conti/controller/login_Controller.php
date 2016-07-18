<?php
/**
 * Created by PhpStorm.
 * User: julien.pons
 * Date: 03/07/2015
 * Time: 14:20
 */

class login_Controller extends global_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->_controller = "login";
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


}