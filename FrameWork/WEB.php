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

        list($c,$a) = $router->route($request);

        $c          = empty($c)?$this->defaultController:$c;
        $a          = empty($a)?$this->defaultAction:$a;

        $router->setController($c);
        $router->setActionName($a);

        $this->setRouter($router);
    }

    public function run()
    {
        $controllerName = $this->getController();
        $actionName     = $this->getActionName();

        if(!method_exists($controllerName,$actionName))
        {
            throw new CLIException("actionName:{$actionName} IS WRONG!",1002);
        }

        $controllerName->setRequest($this->request);
        $controllerName->setView(new \Component\View\View());

        $controllerName->beforeAction();

        call_user_func_array(array($controllerName, $actionName), $this->router->Params);

        $controllerName->afterAction();

    }

}

