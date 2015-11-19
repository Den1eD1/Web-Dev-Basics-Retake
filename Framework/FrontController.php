<?php

namespace Framework;

class FrontController
{
    private static $_instance = null;

    private function __construct(){

    }

    public function dispatch(){
        $a = new \Framework\Routers\DefaultRouter();
        $_uri = $a->getURI();
        $routes = \Framework\App::getInstance()->getConfig()->routes;
    }

    public function getDefaultController() {
        $controller = \Framework\App::getInstance()->getConfig()->app['default_controller'];
        if($controller) {
            return $controller;
        }
        return 'Index';
    }

    public function getDefaultMethod() {
        $method = \Framework\App::getInstance()->getConfig()->app['default_method'];
        if($method) {
            return $method;
        }
        return 'Index';
    }

    /*
     * @return \Framework\FrontController
     */
    public static function  getInstance(){
        if(self::$_instance == null) {
            self::$_instance = new \Framework\FrontController();
        }
        return self::$_instance;
    }

}