<?php
namespace Component\Router;

class Router implements \Component\Router\RouterInterface
{
    public $controllerName = '';
    public $actionName     = '';
    public $Params         = [];

    public function setController($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    public function setParams($params)
    {
        $this->Params = $params;
    }

    public function route(\Component\Http\Request $request)
    {
        $uri        = explode("/",$request->uri->getPath());
        //match vs self-router /api/detail/{$id}/
        //match vs self-router /api/list/{$page}/
        $controller = strip_tags(ucfirst($uri[1]));
        $func       = strip_tags(ucfirst($uri[2]));
        return [$controller,$func];
    }

    public function addRouter()
    {

    }

    public function rule()
    {
    }
}

