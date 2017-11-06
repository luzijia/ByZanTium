<?php
namespace Component\Router;

class Router implements \Component\Router\RouterInterface
{
    public $moduleName     = '';
    public $controllerName = '';
    public $actionName     = '';
    public $Params         = [];

    public function setModuleName($moduleName)
    {
        $this->moduleName = $moduleName;
    }

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

    public function route(\Component\Http\Request $request,\Component\Router\Route $route)
    {
        $info = $route->ruleRoute($request);

        $this->setModuleName($info['m']);
        $this->setController($info['c']);
        $this->setActionName($info['a']);
        $this->setParams($info['p']);

        return $this;
    }
}

