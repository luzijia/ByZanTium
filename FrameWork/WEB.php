<?php
namespace FrameWork;
final class WEB extends \FrameWork\Base
{
    protected $defaultController = 'WebDefaultIndex';
    protected $defaultAction     = 'sayHello';
    public function __construct($appName)
    {
        parent::__construct($appName);

        $request = \Component\Http\Request::makeRequest();

        $this->setRequest($request);

        $router  = new \Component\Router\Router();

        $this->setRouter($router->route($request,$this->route));
    }

    public function run()
    {
        $controllerName = $this->getController();
        $actionName     = $this->getActionName();

        if(!method_exists($controllerName,$actionName))
        {
            throw new CLIException("actionName:{$actionName} IS WRONG!",1002);
        }

        foreach($this->router->Params as $k=>$v)
        {
            $this->request->query->set($k,$v);
        }

        $controllerName->setRequest($this->request);
        $controllerName->setView(new \Component\View\View());

        $controllerName->beforeAction();

        call_user_func_array(array($controllerName, $actionName), $this->router->Params);

        $controllerName->afterAction();

    }

    public function __call($method,$params)
    {
        //if ajax return wrong msg
        //elseif page return wrong page
    }

}

