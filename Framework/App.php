<?php

/**
 * Created by PhpStorm.
 * User: Gabo
 * Date: 11/15/2015
 * Time: 4:38 PM
 */
namespace Framework;
include_once "Loader.php";

class App{

    private static $_instance = null;
    private $_config = null;
    private $_frontController = null;

    private function __construct()
    {
        \Framework\Loader::registerNamespace("Framework", dirname(__FILE__).DIRECTORY_SEPARATOR);
        \Framework\Loader::registerAutoLoad();
        $this->_config = \Framework\Config::getInstance();
        if($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder("../config");
        }
    }

    public function setConfigFolder($path) {
        $this->_config->setConfigFolder($path);
    }

    public function getConfigFolder(){
        return $this->_configFolder;
    }

    /**
     * @return \Framework\Config
     */
    public function getConfig(){
        return $this->_config;
    }

    public function run() {
        if($this->_config->getConfigFolder() == null) {
            $this->setConfigFolder("../config");
        }

        $this->_frontController = \Framework\FrontController::getInstance();
        $this->_frontController->dispatch();
    }

    /**
     *
     * @return \Framework\App
     */
    public static function getInstance(){
        if(self::$_instance == null) {
            self::$_instance = new \Framework\App();
        }

        return self::$_instance;
    }
}