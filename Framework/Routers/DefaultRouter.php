<?php

namespace Framework\Routers;

class DefaultRouter implements \Framework\Routers\IRouter
{
    public function getURI()
    {
        return substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
    }
}