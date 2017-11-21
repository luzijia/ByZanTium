<?php
namespace FrameWork;
final class WEB extends \FrameWork\Base
{
    protected $defaultController = 'WebDefaultIndex';
    protected $defaultAction     = 'sayHello';
    public function __construct($appName)
    {
        parent::__construct($appName);

        $this->setRoute(new \Component\Router\Route());

        $request = \Component\Http\Request::makeRequest();

        $this->setRequest($request);

        $router  = new \Component\Router\Router();

        $this->setRouter($router->route($request,$this->route));
    }

    public function run()
    {
        $controllerName = $this->getController();
        $actionName     = $this->getActionName();

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
}

