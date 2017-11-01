<?php
namespace Component\Router;

interface RouterInterface
{

    public function setController($controllerName);
    public function setActionName($actionName);
    public function setParams($Params);
    public function route(\Component\Http\Request $request);
}
