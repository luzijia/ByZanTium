<?php
namespace FrameWork;
final class CLI extends \FrameWork\Base
{
    protected $argv = array();

    protected $defaultController = 'TaskDefaultIndex';

    protected $defaultActionName = 'doHelloWorld';

    public function __construct($appName='')
    {
        parent::__construct($appName);

        $this->argv     = $_SERVER['argv'];

        $this->setRouter(new \Component\Router\Router());

        $controllerName = isset($this->argv[1])?$this->argv[1]:$this->defaultController;

        $actionName     = isset($this->argv[2])?$this->argv[2]:$this->defaultActionName;

        $this->router->setController($controllerName);

        $this->router->setActionName($actionName);

        if(isset($this->argv[3]))
        {
            $params = $this->parseParamArg($this->argv[3]);

            $this->router->setParams($params);
        }
    }

    private function parseParamArg($argv)
    {
        //todo safe check
        parse_str($argv,$params);

        return $params;
    }

    public function run()
    {
        echo $this->appName." is running...\n";
        $controllerName = $this->getController();
        $actionName     = $this->getActionName();

        if(!method_exists($controllerName,$actionName))
        {
            throw new CLIException("actionName:{$actionName} IS WRONG!",1002);
        }

        $controllerName->setParams($this->router->Params);

        $controllerName->beforeAction();

        call_user_func_array(array($controllerName, $actionName), $this->router->Params);

        $controllerName->afterAction();
    }
}
