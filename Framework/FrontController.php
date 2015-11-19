<?php

namespace Framework;

class FrontController
{
    private static $_instance = null;
    private $ns = null;
    private $controller = null;
    private $method = null;

    private function __construct(){

    }

    public function dispatch()
    {
        $a = new \Framework\Routers\DefaultRouter();
        $_uri = $a->getURI();
        $routes = \Framework\App::getInstance()->getConfig()->routes;
        $_rc = null;
        if (is_array($routes) && count($routes) > 0) {
            foreach ($routes as $k => $v) {
                if (stripos($_uri, $k) === 0 && ($_uri == $k || stripos($_uri, $k . '/') === 0) && $v['namespace']) {
                    $this->ns = $v['namespace'];
                    $_uri = substr($_uri, strlen($k) + 1);
                    $_rc = $v;
                    break;
                }
            }
        } else {
            throw new \Exception('Default route missing', 500);
        }

        if ($this->ns == null && $routes['*']['namespace']) {
            $this->ns = $routes['*']['namespace'];
            $_rc = $routes['*'];
        } else if ($this->ns == null && !$routes['*']['namespace']) {
            throw new \Exception('Default route missing', 500);
        }

        $_params = explode('/', $_uri);
        if ($_params[0]) {
            $this->controller = $_params[0];

            if ($_params[1]) {
                $this->method = $_params[1];
            } else {
                $this->method = $this->getDefaultMethod();
             }
        } else {
            $this->controller = $this->getDefaultController();
            $this->method = $this->getDefaultMethod();
        }
        if(is_array($_rc) && $_rc['controllers'] && $_rc['controllers'][$this->controller]['to']) {
            if($_rc['controllers'][$this->controller]['methods'][$this->method]){
                $this->method = $_rc['controllers'][$this->controller]['methods'][$this->method];
            }
            $this->controller = $_rc['controllers'][$this->controller]['to'];
        }
        //TODO: This work stinks... Find another method for testing
        //echo $this->ns . '<br>';
        //echo $this->controller . "<br>";
        //echo $this->method;

        $f = $this->ns . '\\' . $this->controller;
        $newController = new $f();
        var_dump($newController);
        $newController->($this->method);
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